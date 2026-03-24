<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Support\SimpleSpreadsheetImporter;
use Illuminate\Http\Request;
use RuntimeException;

class MedicineController extends Controller
{

public function index()
{
$medicines = Medicine::all();

return view('medicines.index', compact('medicines'));
}

public function import(Request $request)
{
$request->validate([
'file' => ['required', 'file', 'mimes:csv,xlsx']
]);

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
'cost' => (float) ($data['cost'] ?? 0),
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

Medicine::create([
'name' => $request->name,
'cost' => $request->cost,
'stock' => $request->stock
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

$medicine = Medicine::find($id);

$medicine->update([
'name'=>$request->name,
'cost'=>$request->cost,
'stock'=>$request->stock
]);

return redirect('/medicines');

}


public function destroy($id)
{

Medicine::destroy($id);

return redirect('/medicines');

}

}
