<?php

namespace App\Models;

use App\Models\Patient;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use function foo\func;

class Cases extends Model
{
    protected $table = 'cases';
//    public $timestamps = false;

    protected $fillable = ['case_number', 'patient_name', 'doctor_name', 'user_id', 'portal_id'];


//    public function patients(){
//        return $this->belongsTo('App\Models\Patient', 'patient_id', 'id' );
//    }

    public function patients()
    {

        return $this->hasMany('App\Models\Patient', 'case_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portal()
    {

        return $this->belongsTo('App\Models\Portal');
    }

    public function storePatientCase($caseInputData)
    {

        $case = Cases::create($caseInputData);
        return $case;
    }

    public function deleteCaseWithPatient($case_id){

        $cases = Cases::with('patients')->where('id', $case_id)->first();
        $deleted_patients = $cases->patients->pluck('case_id');
        $cases->patients()->delete();
        Patient::destroy($deleted_patients);

        $result = $cases->delete();

        if ($result == true) {
            return 1;
        } else {
            return 2;
        }
    }

//    public function getCreatedAtAttribute($date)
//    {
//        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
//    }


}
