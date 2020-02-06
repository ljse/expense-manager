<?php

namespace App\Http\Controllers;

use App\ExpenseCategories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CategoryRequest;

class ExpenseCategoriesController extends Controller
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
        if (Gate::check('isAdmin')) {
            $cats = ExpenseCategories::orderBy('created_at')->paginate(10);
            return view('management.category.index', compact('cats'));
        }else{
            return redirect()->route('home');
        }
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
    public function store(CategoryRequest $request)
    {
        if (Gate::check('isAdmin')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $atts['slug'] = Str::slug($request->name, '-');
            ExpenseCategories::create($atts);
            return back();
        }else{
            return redirect()->route('home');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseCategories  $expenseCategories
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategories $expenseCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenseCategories  $expenseCategories
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategories $expenseCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseCategories  $expenseCategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseCategories $expenseCategories)
    {
        if (Gate::check('isAdmin')) {
            $atts = $request->validate(
                [
                    'name'          =>  ['required', 'unique:expense_categories,name,'.$expenseCategories->id],
                    'description'   =>  ['required']
                ],
                [
                    'name.required'         =>   'Category Name field is required!',
                    'name.unique'           =>   'Category Name already exists!',
                    'description.required'  =>  'Description field is required!'
                ]
            );

            $atts['slug'] = Str::slug($request->name, '-');

            $expenseCategories->update($atts);
            
            return back();
        }else{
            return redirect()->route('home');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseCategories  $expenseCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategories $expenseCategories)
    {
        if (Gate::check('isAdmin')) {
            if ($expenseCategories->expenses->count() > 0) {
                return back()->with('delete_error', 'You cannot delete a category with Expenses');
            }else{
                $expenseCategories->delete();
                return back();
            }
        }else{
            return redirect()->route('home');
        }
    }
}
