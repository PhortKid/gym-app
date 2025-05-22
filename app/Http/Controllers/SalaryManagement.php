<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Salary;

use App\Models\User;
class SalaryManagement extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::whereNot('email','middlephortt@gmail.com')->get();
        $salarys=Salary::all();
        return view('workspace.salary_management.index',compact('users','salarys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'basic_salary' => 'required|numeric',
            'loan_deductions' => 'nullable|numeric',
            'other_deduction' => 'nullable|numeric',
            'date' => 'required|date',
        ]);
    
        Salary::create([
            'user_id' => $request->user_id,
            'basic_salary' => $request->basic_salary,
            'loan_deductions' => $request->loan_deductions ?? 0,
            'other_deduction' => $request->other_deduction ?? 0,
            'date' => $request->date,
        ]);
    
        return redirect()->back()->with('success', 'Salary added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $salary=Salary::find($id);
        $salary->basic_salary=$request->basic_salary;
        $salary->loan_deductions=$request->loan_deductions;
        $salary->other_deduction=$request->other_deduction;
        $salary->date=$request->date;
        $salary->save();

       

        return redirect()->back()->with('success', 'Salary Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
    }

    public function salaryReport(Request $request)
{
    // Initialize the query
    $query = Salary::query();

    // Filter by specific date
    if ($request->has('date') && $request->date) {
        $query->whereDate('date', $request->date);
    }

    // Filter by month and year
    if ($request->has('month') && $request->month) {
        $query->whereMonth('date', $request->month);
    }

    if ($request->has('year') && $request->year) {
        $query->whereYear('date', $request->year);
    }

    // Get the filtered salaries
    $salaries = $query->get();

    // Calculate the totals
    $totalBasicSalary = $salaries->sum('basic_salary');
    $totalLoanDeductions = $salaries->sum('loan_deductions');
    $totalOtherDeductions = $salaries->sum('other_deduction');
    $totalNetAmount = $salaries->sum(function($salary) {
        return $salary->basic_salary + $salary->loan_deductions + $salary->other_deduction;
    });

    // Pass the filtered data and the current request to the view
    return view('dashboard.salary_management.report', [
        'salaries' => $salaries,
        'totalBasicSalary' => $totalBasicSalary,
        'totalLoanDeductions' => $totalLoanDeductions,
        'totalOtherDeductions' => $totalOtherDeductions,
        'totalNetAmount' => $totalNetAmount,
        'request' => $request,  // Pass the request for easy access to the filters
    ]);
}

   
}
