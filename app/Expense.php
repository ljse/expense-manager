<?php

namespace App;

class Expense extends Model
{
    public function users()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function expcats()
    {
    	return $this->belongsTo(ExpenseCategories::class, 'category_id');
    }
}
