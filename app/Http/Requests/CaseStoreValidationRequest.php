<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseStoreValidationRequest extends FormRequest
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
            'case_number' => 'required',
            'patient_name' => 'required',
            'doctor_name' => 'required',
            'portal' => 'required',
            'file' => 'required',
            'file_after' => 'required',
            'ipr_form' => 'required',
            'operator_name' => 'required',
            'upper_aligner' => 'required',
            'lower_aligner' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'case_number.required' => 'Case number is required!',
//            'case_number.max' => 'Case number max length is 50 characters!',
            'doctor_name.required' => 'Doctor name is required!',
//            'doctor_name.max' => 'Doctor name max length is 50 characters!',
            'patient_name.required' => 'Patient name is required!',
//            'patient_name.max' => 'Patient name max length is 50 characters!',
            'operator_name.required' => 'Operator name is required!',
//            'upper_aligner.required' => 'no.of Upper Aligner is requi red!',
//            'upper_aligner.numeric' => 'no.of Upper Aligner numeric only!',
            'lower_aligner.required' => 'no. of Lower Aligner is required!',
//            'lower_aligner.numeric' => 'no. of Lower Aligner numeric only!',
            'status.required' => 'status is required!',
        ];
    }
}
