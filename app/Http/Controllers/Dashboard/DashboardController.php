<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('role');
    }

    public function index(){

        $user = new User();
        $admin_user = $user->isAdmin();
        $user_id = Auth::id();

        $query = Cases::query();

        $query->when($admin_user == false, function ($q, $user_id) {
            return $q->where('user_id', Auth::id())->get();
        });

        $today_cases = $query->whereDate('created_at', Carbon::today())->get();

        $query->when($admin_user == false, function ($q, $user_id) {
            return $q->where('user_id', Auth::id())->get();
        });
        $cases = $query->get();

        $data['today_cases'] = $today_cases->count();

        $data['total_cases'] = $cases->count();

        return view('dashboard.dashboard', $data) ;
    }

    public function getCasesMonths(){

        $month_array = array();
        $graph_cases = Cases::orderBy('created_at', 'ASC')->pluck('created_at');

        $graph_cases = json_decode($graph_cases);

        if(!empty($graph_cases)){

            foreach($graph_cases as $unformated_dates){

                $date = new \DateTime($unformated_dates);

                $month_name = $date->format('M');
                $month_no = $date->format('m');

                $month_array[$month_no] = $month_name;


            }
            return $month_array;


        }

    }

    public function getMonthlyCasesCount($month){

//        $month = '01';
        $monthlyCaseCount = Cases::whereMonth('created_at', $month)->get()->count();

        return $monthlyCaseCount;
    }

    public function getMonthlyCasesData(){

        $monthly_post_count_array = array();
        $month_array =  $this->getCasesMonths();
        $month_name_array = array();

        if(!empty($month_array)){

            foreach($month_array as $month_no => $month_name){

                $monthly_post_count = $this->getMonthlyCasesCount($month_no);

                array_push($monthly_post_count_array, $monthly_post_count);
                array_push($month_name_array, $month_name);
            }
        }

        $month_array = $this->getCasesMonths();

        $max_no = max($monthly_post_count_array);

        $max = round(($max_no + 10/2) / 10) * 10;

        $monthly_post_data_array = [

            'month' => $month_name_array,
            'cases_count' => $monthly_post_count_array,
            'max' => $max,

        ];

        return $monthly_post_data_array;
    }
}
