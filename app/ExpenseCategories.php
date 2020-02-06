<?php

namespace App;

class ExpenseCategories extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_expense_categories', 'category_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'category_id');
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
