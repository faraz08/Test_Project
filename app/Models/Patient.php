<?php

namespace App\Models;

use App\Models\Cases;
use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
    protected $table = 'patients';
//    public $timestamps = false;

    protected $fillable = ['case_id', 'no_of_aligners', 'upper_aligner', 'lower_aligner', 'file_before',
        'file_after', 'operator_id', 'status', 'ipr_form', 'revisions', 'url'];


//    public function cases()
//    {
//        return $this->hasMany('App\Models\Cases', 'patient_id', 'id' );
//    }

    public function cases()
    {
        return $this->belongsTo('App\Models\Cases', 'case_id', 'id');
    }

    public function storePatient($data_array)
    {

        $patient = Patient::create($data_array);

        return $patient;
    }

    public function operator()
    {
        return $this->belongsTo('App\Models\Operator');
    }

    public function deletePatientWithCases($case_id)
    {

        $cases = Patient::where('id', $case_id)->first();
        $result = $cases->delete();

        if ($result == true) {
            return 1;
        } else {

        }
    }


}
