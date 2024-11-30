<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Approver;
use App\Models\ApprovalStage;

class ApprovalStageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Atur logika otorisasi sesuai kebutuhan. Mengembalikan true jika user boleh akses.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'approver_id' => 'required|exists:approvers,id|unique:approval_stages,approver_id'
        ];

        // Jika ini adalah request PUT, kita perlu memeriksa apakah approver_id sudah ada di approval_stages lain
        if ($this->isMethod('put')) {
            $rules['approver_id'] = 'required|exists:approvers,id|unique:approval_stages,approver_id,' . $this->route('id');
        }

        return $rules;
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'approver_id.required' => 'Approver ID harus diisi.',
            'approver_id.exists' => 'Approver tidak ditemukan.',
            'approver_id.unique' => 'Approver ini sudah ada di tahap approval lainnya.',
        ];
    }
}
