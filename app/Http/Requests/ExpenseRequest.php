<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
                'amount' => 'required|integer|min:1',
            ];
        } elseif ($this->isMethod('patch')) {
            return [
                'approver_id' => 'required|exists:approvers,id',
            ];
        }

        return [];
    }
}
