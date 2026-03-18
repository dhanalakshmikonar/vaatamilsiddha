<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{

public function index()
{
$medicines = Medicine::all();

return view('medicines.index', compact('medicines'));
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