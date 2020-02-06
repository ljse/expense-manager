<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id'   =>  ['required'],
            'amount'        =>  ['required'],
            'entry_date'    =>  ['required'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required'   =>  'Please select category',
            'amount.required'   =>  'Amount field is required!',
            'entry_date.required'   =>  'Entry date is required!',
        ];
    }
}
