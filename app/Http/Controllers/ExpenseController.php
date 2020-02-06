<?php

namespace App\Http\Controllers;

use App\User;
use App\Expense;
use App\ExpenseCategories;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseRequest;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = ExpenseCategories::orderBy('name')->get();
        $expenses = Expense::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('management.expenses.index', compact('cats', 'expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $atts = $this->validate($request, $request->rules(), $request->messages());
        $newData                = new Expense;
        $newData->user_id       = auth()->user()->id;
        $newData->category_id   = $request->category_id;
        $newData->amount        = $request->amount;
        $newData->entry_date    = $request->entry_date;
        $newData->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);
        $atts = $this->validate($request, $request->rules(), $request->messages());
        $expense->user_id       = auth()->user()->id;
        $expense->category_id   = $request->category_id;
        $expense->amount        = $request->amount;
        $expense->entry_date    = $request->entry_date;
        $expense->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();
        return back();
    }
}
