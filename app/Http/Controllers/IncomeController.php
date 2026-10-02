<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class IncomeController extends Controller
{
    public function daily(Request $request)
    {
        $validated = $request->validate(['date' => ['nullable', 'date_format:Y-m-d']]);
        $date = $validated['date'] ?? now()->toDateString();
        $patients = Patient::whereDate('visit_date', $date)->orderBy('name')->get();
        $totalIncome = (float) $patients->sum('total_amount');

        return view('income.daily', compact('date', 'patients', 'totalIncome'));
    }

    public function monthly(Request $request)
    {
        $validated = $request->validate(['month' => ['nullable', 'date_format:Y-m']]);
        $month = $validated['month'] ?? now()->format('Y-m');
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end = $start->copy()->endOfMonth();
        $patients = Patient::whereBetween('visit_date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('visit_date')->orderBy('name')->get();
        $totalIncome = (float) $patients->sum('total_amount');

        return view('income.monthly', compact('month', 'patients', 'totalIncome'));
    }
}
