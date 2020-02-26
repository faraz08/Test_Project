<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseStoreRequest extends FormRequest
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
            'case_number' => 'required|alpha_dash|max:8',
            'doctor_name' => 'required|max:30',
            'operator_name' => 'required|max:30',
            'patient_name' => 'required|max:30',
            'lower_aligner' => 'required|between: 1,99|integer',
            'upper_aligner' => 'required|between: 1,99|integer',
//            'ipr_form' => 'mimes:jpeg,jps,png|required',
        ];
    }
}
