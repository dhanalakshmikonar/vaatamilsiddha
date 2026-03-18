<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{

public function index()
{
$patients = Patient::all();
return view('patients.index', compact('patients'));
}

public function create()
{
return view('patients.create');
}

public function store(Request $request)
{
Patient::create($request->all());
return redirect('/patients');
}

public function edit($id)
{
$patient = Patient::find($id);
return view('patients.edit', compact('patient'));
}

public function update(Request $request, $id)
{
$patient = Patient::find($id);
$patient->update($request->all());
return redirect('/patients');
}

public function destroy($id)
{
Patient::destroy($id);
return redirect('/patients');
}

public function show($id)
{

$patient = Patient::find($id);

return view('patients.view',compact('patient'));

}

}