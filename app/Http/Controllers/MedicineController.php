<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Support\SimpleSpreadsheetImporter;
use Illuminate\Http\Request;
use RuntimeException;

class MedicineController extends Controller
{
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

$headers = array_map(fn ($header) => strtolower(trim((string) $header)), $rows[0]);
$imported = 0;

foreach (array_slice($rows, 1) as $row) {
$data = array_combine($headers, array_pad($row, count($headers), null));

if (!isset($data['name']) || trim((string) $data['name']) === '') {
continue;
}

Medicine::updateOrCreate(
['name' => trim((string) $data['name'])],
[
'mode_of_product' => trim((string) ($data['mode_of_product'] ?? '')),
'pharmaceutical_name' => trim((string) ($data['pharmaceutical_name'] ?? '')),
'expiry_date' => !empty($data['expiry_date']) ? $data['expiry_date'] : null,
'cost_price' => (float) ($data['cost_price'] ?? $data['cost'] ?? 0),
'selling_price' => $this->calculateSellingPrice((float) ($data['cost_price'] ?? $data['cost'] ?? 0)),
'total_amount' => $this->calculateTotalAmount((float) ($data['cost_price'] ?? $data['cost'] ?? 0), (int) ($data['stock'] ?? 0)),
'cost' => (float) ($data['cost_price'] ?? $data['cost'] ?? 0),
'stock' => (int) ($data['stock'] ?? 0),
]
);

$imported++;
}

return redirect('/medicines')->with('success', $imported . ' medicine rows imported successfully.');
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
