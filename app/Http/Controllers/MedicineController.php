<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Support\SimpleSpreadsheetImporter;
use Illuminate\Http\Request;
use RuntimeException;

class MedicineController extends Controller
{
private const MEDICINE_HEADER_ALIASES = [
    'name' => ['name', 'medicine name', 'drug name', 'durg name', 'product name'],
    'mode_of_product' => ['mode_of_product', 'mode of product', 'mode'],
    'pharmaceutical_name' => ['pharmaceutical_name', 'pharmaceutical name', 'manufacturer', 'company'],
    'expiry_date' => ['expiry_date', 'expiry date', 'expiry'],
    'cost_price' => ['cost_price', 'cost price', 'cost'],
    'stock' => ['stock', 'available stock', 'qty', 'quantity'],
];

private function calculateSellingPrice(float $costPrice): float
{
return round($costPrice * 1.20, 2);
}

private function calculateTotalAmount(float $costPrice, int $stock): float
{
return round($costPrice * $stock, 2);
}

public function index()
{
$medicines = Medicine::all();

return view('medicines.index', compact('medicines'));
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
$rows = SimpleSpreadsheetImporter::parse($request->file('file')->getRealPath());
} catch (RuntimeException $exception) {
return redirect('/medicines')->with('error', $exception->getMessage());
}

if (count($rows) < 2) {
return redirect('/medicines')->with('error', 'Upload a file with a header row and at least one medicine row.');
}

$headerRowIndex = $this->findHeaderRowIndex($rows);

if ($headerRowIndex === null) {
return redirect('/medicines')->with('error', 'Could not find a valid medicine header row in the uploaded file.');
}

$headers = $this->normalizeHeaders($rows[$headerRowIndex]);
$imported = 0;

foreach (array_slice($rows, $headerRowIndex + 1) as $row) {
$data = array_combine($headers, array_pad($row, count($headers), null));

if (!isset($data['name']) || trim((string) $data['name']) === '') {
continue;
}

$costPrice = $this->parseDecimal($data['cost_price'] ?? $data['cost'] ?? 0);
$stock = $this->parseInteger($data['stock'] ?? 0);
$doseSummary = $this->buildDoseSummary($data);

$modeOfProduct = trim((string) ($data['mode_of_product'] ?? ''));

if ($modeOfProduct === '' && $doseSummary !== '') {
$modeOfProduct = $doseSummary;
}

Medicine::updateOrCreate(
['name' => trim((string) $data['name'])],
[
'mode_of_product' => $modeOfProduct,
'pharmaceutical_name' => trim((string) ($data['pharmaceutical_name'] ?? '')),
'expiry_date' => !empty($data['expiry_date']) ? $data['expiry_date'] : null,
'cost_price' => $costPrice,
'selling_price' => $this->calculateSellingPrice($costPrice),
'total_amount' => $this->calculateTotalAmount($costPrice, $stock),
'cost' => $costPrice,
'stock' => $stock,
]
);

$imported++;
}

return redirect('/medicines')->with('success', $imported . ' medicine rows imported successfully.');
}

private function findHeaderRowIndex(array $rows): ?int
{
foreach ($rows as $index => $row) {
$normalized = array_map(fn ($value) => $this->normalizeHeaderValue($value), $row);

if (in_array('name', $normalized, true)) {
return $index;
}
}

return null;
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

private function buildDoseSummary(array $data): string
{
$doseColumns = [];

foreach (['1_dose', '100_dose', '200_dose', '300_dose'] as $key) {
$value = trim((string) ($data[$key] ?? ''));

if ($value !== '') {
$doseColumns[] = strtoupper(str_replace('_', ' ', $key)) . ': ' . $value;
}
}

return implode(' | ', $doseColumns);
}

private function parseDecimal(mixed $value): float
{
$cleaned = preg_replace('/[^0-9.\-]/', '', (string) $value);

if ($cleaned === null || $cleaned === '' || $cleaned === '-' || $cleaned === '.') {
return 0.0;
}

return (float) $cleaned;
}

private function parseInteger(mixed $value): int
{
$cleaned = preg_replace('/[^0-9\-]/', '', (string) $value);

if ($cleaned === null || $cleaned === '' || $cleaned === '-') {
return 0;
}

return (int) $cleaned;
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
'stock' => ['required', 'integer', 'min:0'],
'cost_price' => ['required', 'numeric', 'min:0'],
]);

$costPrice = (float) $data['cost_price'];
$stock = (int) $data['stock'];

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
'stock' => ['required', 'integer', 'min:0'],
'cost_price' => ['required', 'numeric', 'min:0'],
]);

$medicine = Medicine::find($id);
$costPrice = (float) $data['cost_price'];
$stock = (int) $data['stock'];

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
