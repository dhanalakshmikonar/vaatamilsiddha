<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Support\SimpleSpreadsheetExporter;
use App\Support\SimpleSpreadsheetImporter;
use Illuminate\Http\Request;
use RuntimeException;

class MedicineController extends Controller
{
private const MEDICINE_HEADER_ALIASES = [
    'name' => ['name', 'medicine name', 'drug name', 'durg name', 'product name'],
    'mode_of_product' => ['mode_of_product', 'mode of product', 'mode', 'mode of the product'],
    'pharmaceutical_name' => ['pharmaceutical_name', 'pharmaceutical name', 'manufacturer', 'company', 'company name'],
    'expiry_date' => ['expiry_date', 'expiry date', 'expiry'],
    'cost_price' => ['cost_price', 'cost price', 'cost', 'mrp'],
    'stock' => ['stock', 'available stock', 'qty', 'quantity', 'count of product', 'count of the product'],
    'total_amount' => ['total_amount', 'total amount', 'total medicine value'],
];

private function calculateSellingPrice(float $costPrice): float
{
return round($costPrice * 1.20, 2);
}

private function calculateTotalAmount(float $costPrice, float $stock): float
{
return round($costPrice * $stock, 2);
}

public function index()
{
$medicines = Medicine::all();

return view('medicines.index', compact('medicines'));
}

public function show($id)
{
$medicine = Medicine::findOrFail($id);

return view('medicines.view', compact('medicine'));
}

public function import(Request $request)
{
$request->validate([
'file' => ['required', 'file']
]);

$extension = strtolower($request->file('file')->getClientOriginalExtension());

if (!in_array($extension, ['csv', 'xlsx'], true)) {
return redirect('/medicines')->with('error', 'Only .csv and .xlsx files are supported.');
}

try {
$sheets = SimpleSpreadsheetImporter::parseSheets($request->file('file')->getRealPath(), $extension);
} catch (RuntimeException $exception) {
return redirect('/medicines')->with('error', $exception->getMessage());
}

[$rows, $headerRowIndex] = $this->selectBestMedicineSheet($sheets);

if ($rows === [] || $headerRowIndex === null) {
return redirect('/medicines')->with('error', 'Could not find a valid medicine inventory header row in the uploaded file.');
}

$headers = $this->normalizeHeaders($rows[$headerRowIndex]);
$imported = 0;

foreach (array_slice($rows, $headerRowIndex + 1) as $row) {
$data = array_combine($headers, array_pad($row, count($headers), null));

if (!isset($data['name']) || trim((string) $data['name']) === '') {
break;
}

if (!$this->isInventoryRow($data)) {
continue;
}

$costPrice = $this->parseDecimal($data['cost_price'] ?? $data['cost'] ?? 0);
$stock = $this->parseDecimal($data['stock'] ?? 0);
$totalAmount = $this->parseDecimal($data['total_amount'] ?? 0);

if ($totalAmount <= 0) {
$totalAmount = $this->calculateTotalAmount($costPrice, $stock);
}

Medicine::updateOrCreate(
[
'name' => trim((string) $data['name']),
'mode_of_product' => trim((string) ($data['mode_of_product'] ?? '')),
'pharmaceutical_name' => trim((string) ($data['pharmaceutical_name'] ?? '')),
'expiry_date' => $this->normalizeExpiryDate($data['expiry_date'] ?? null),
'cost_price' => $costPrice,
],
[
'mode_of_product' => trim((string) ($data['mode_of_product'] ?? '')),
'pharmaceutical_name' => trim((string) ($data['pharmaceutical_name'] ?? '')),
'expiry_date' => $this->normalizeExpiryDate($data['expiry_date'] ?? null),
'cost_price' => $costPrice,
'selling_price' => $this->calculateSellingPrice($costPrice),
'total_amount' => $totalAmount,
'cost' => $costPrice,
'stock' => $stock,
]
);

$imported++;
}

return redirect('/medicines')->with('success', $imported . ' medicine rows imported successfully.');
}

public function clearImported()
{
Medicine::query()->delete();

return redirect('/medicines')->with('success', 'All imported medicine records were deleted successfully.');
}

public function export()
{
$medicines = Medicine::latest()->get();
$rows = [[
'Name',
'Mode of Product',
'Pharmaceutical Name',
'Expiry Date',
'Stock',
'Cost Price',
'Selling Price',
'Total Amount',
]];

foreach ($medicines as $medicine) {
$rows[] = [
$medicine->name,
$medicine->mode_of_product,
$medicine->pharmaceutical_name,
$medicine->expiry_date,
$medicine->stock,
$medicine->cost_price ?: $medicine->cost,
$medicine->selling_price,
$medicine->total_amount,
];
}

return SimpleSpreadsheetExporter::download(
'medicines_export_' . now()->format('Ymd_His') . '.xlsx',
$rows,
'Medicines'
);
}

private function selectBestMedicineSheet(array $sheets): array
{
$bestRows = [];
$bestHeaderIndex = null;
$bestScore = -1;

foreach ($sheets as $rows) {
foreach ($rows as $index => $row) {
$normalized = array_map(fn ($value) => $this->normalizeHeaderValue($value), $row);
$score = count(array_intersect($normalized, [
'name',
'mode_of_product',
'pharmaceutical_name',
'expiry_date',
'cost_price',
'stock',
'total_amount',
]));

if (in_array('name', $normalized, true) && $score > $bestScore) {
$bestRows = $rows;
$bestHeaderIndex = $index;
$bestScore = $score;
}
}
}

return [$bestRows, $bestHeaderIndex];
}

private function isInventoryRow(array $data): bool
{
$signals = 0;

foreach (['pharmaceutical_name', 'cost_price', 'stock', 'total_amount'] as $field) {
if (trim((string) ($data[$field] ?? '')) !== '') {
$signals++;
}
}

return $signals >= 2;
}

private function normalizeHeaders(array $headers): array
{
return array_map(function ($header) {
$normalized = $this->normalizeHeaderValue($header);

return $normalized !== '' ? $normalized : 'column_' . uniqid();
}, $headers);
}

private function normalizeHeaderValue(mixed $header): string
{
$value = strtolower(trim((string) $header));
$value = preg_replace('/\s+/', ' ', $value) ?? $value;

foreach (self::MEDICINE_HEADER_ALIASES as $canonical => $aliases) {
if (in_array($value, $aliases, true)) {
return $canonical;
}
}

return str_replace([' ', '-'], '_', $value);
}

private function normalizeExpiryDate(mixed $value): ?string
{
$raw = trim((string) $value);

if ($raw === '') {
return null;
}

if (is_numeric($raw)) {
$days = (int) floor((float) $raw);
$baseDate = new \DateTime('1899-12-30');
$baseDate->modify('+' . $days . ' days');

return $baseDate->format('Y-m-d');
}

$timestamp = strtotime($raw);

return $timestamp ? date('Y-m-d', $timestamp) : null;
}

private function parseDecimal(mixed $value): float
{
$cleaned = preg_replace('/[^0-9.\-]/', '', (string) $value);

if ($cleaned === null || $cleaned === '' || $cleaned === '-' || $cleaned === '.') {
return 0.0;
}

return (float) $cleaned;
}

public function create()
{
return view('medicines.create');
}

public function store(Request $request)
{
$data = $request->validate([
'name' => ['required', 'string', 'max:255'],
'mode_of_product' => ['nullable', 'string', 'max:255'],
'pharmaceutical_name' => ['nullable', 'string', 'max:255'],
'expiry_date' => ['nullable', 'date'],
'stock' => ['required', 'numeric', 'min:0'],
'cost_price' => ['required', 'numeric', 'min:0'],
]);

$costPrice = (float) $data['cost_price'];
$stock = (float) $data['stock'];

Medicine::create([
'name' => $data['name'],
'mode_of_product' => $data['mode_of_product'] ?? null,
'pharmaceutical_name' => $data['pharmaceutical_name'] ?? null,
'expiry_date' => $data['expiry_date'] ?? null,
'cost_price' => $costPrice,
'selling_price' => $this->calculateSellingPrice($costPrice),
'total_amount' => $this->calculateTotalAmount($costPrice, $stock),
'cost' => $costPrice,
'stock' => $stock
]);

return redirect('/medicines');
}

public function edit($id)
{
$medicine = Medicine::find($id);

return view('medicines.edit', compact('medicine'));
}

public function update(Request $request, $id)
{
$data = $request->validate([
'name' => ['required', 'string', 'max:255'],
'mode_of_product' => ['nullable', 'string', 'max:255'],
'pharmaceutical_name' => ['nullable', 'string', 'max:255'],
'expiry_date' => ['nullable', 'date'],
'stock' => ['required', 'numeric', 'min:0'],
'cost_price' => ['required', 'numeric', 'min:0'],
]);

$medicine = Medicine::find($id);
$costPrice = (float) $data['cost_price'];
$stock = (float) $data['stock'];

$medicine->update([
'name'=>$data['name'],
'mode_of_product'=>$data['mode_of_product'] ?? null,
'pharmaceutical_name'=>$data['pharmaceutical_name'] ?? null,
'expiry_date'=>$data['expiry_date'] ?? null,
'cost_price'=>$costPrice,
'selling_price'=>$this->calculateSellingPrice($costPrice),
'total_amount'=>$this->calculateTotalAmount($costPrice, $stock),
'cost'=>$costPrice,
'stock'=>$stock
]);

return redirect('/medicines');
}

public function destroy($id)
{
Medicine::destroy($id);

return redirect('/medicines');
}
}

