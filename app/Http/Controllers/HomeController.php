<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Return all Expenses by logged in user
        $cats = User::join('expenses', 'users.id', 'expenses.user_id')
                    ->join('expense_categories', 'expense_categories.id', 'expenses.category_id')
                    ->select('expenses.user_id', 'expenses.category_id', 'expenses.amount', 'expenses.created_at', 'expense_categories.name', \DB::raw('(select sum(amount) from expenses as exp where exp.category_id=expenses.category_id and expense_categories.id = exp.category_id and exp.user_id = expenses.user_id) totalAll'))
                    ->groupBy('expenses.user_id', 'expenses.category_id', 'expenses.amount', 'expenses.created_at', 'expense_categories.name', 'expense_categories.id')
                    ->where('expenses.user_id', auth()->user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('home', compact('cats'));
    }
}
