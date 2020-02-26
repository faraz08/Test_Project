<?php

namespace App\Http\Controllers\Cases;

use App\CommonTraits\DropzoneFileUploadTraits;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseStoreRequest;
use App\Http\Requests\CaseStoreValidationRequest;
use App\Models\Cases;
use App\Models\Operator;
use App\Models\Patient;
use App\Models\Permission;
use App\Models\Portal;
use App\Models\Role;
use App\User;
use Carbon\Carbon;
use Faker\Provider\File;
use http\Client\Response;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades;
use Illuminate\View\View;
use PHPUnit\Util\Filesystem;
use Validator;
use Session;
use function Ramsey\Uuid\v1;

class CaseController extends Controller
{
    use DropzoneFileUploadTraits;

    public function __construct()
    {
        $this->middleware('role', ['except' => 'caseUrlView']);

    }

    public function index()
    {
//        if(Facades\Gate::allows('create-case', Auth::user())) {


            $data['portal'] = Portal::all();
            $data['operators'] = Operator::all();

            return view('case', $data);
//        }
//        return abort(404);
    }

//    public function caseSubmit(CaseStoreRequest $request)
//    {
//
//        dd($request->all());
//
//        $validator = $request->validated();
//
//        $portal = $request->input('portal');
//        $case_number = $request->input('case_number');
//        $doctor_name = $request->input('doctor_name');
//        $upper_aligner = $request->input('upper_aligner');
//        $operator_name = $request->input('operator_name');
//        $portal_id = $request->input('portal_id');
//        $patient_name = $request->input('patient_name');
//        $lower_aligner = $request->input('lower_aligner');
//        $iprForm = $request->file('ipr_form');
//
//        $ip_server = $request->getHttpHost();
//
//        $date = date("Y-m-d H:m:s");
//        $user_id = Auth::id();
//
//        $caseifExist = Cases::where('case_number', "$case_number")->first();
//
//        if ($caseifExist != null) {
//            $caseId = $caseifExist->id;
//            $caseNumber = $caseifExist->case_number;
//
//            $number_of_patients = Cases::find($caseId)->patients;
//            $revisions = count($number_of_patients) + 1;
//
//        } elseif ($caseifExist == null) {
//
//            $revisions = 0;
//            $caseInputData = ['patient_name' => $patient_name,
//                'doctor_name' => $doctor_name,
//                'case_number' => $case_number,
//                'created_at' => $date,
//                'user_id' => $user_id,
//                'portal_id' => $portal_id
//            ];
//
//            $case = new Cases();
//
//            $case_data = $case->storePatientCase($caseInputData);
//            $caseId = $case_data->id;
//            $caseNumber = $case_data->case_number;
//        }
//
//        if ($caseId != null && $caseId > 0) {
//
//            /** code for move files before **/
//            $dir_path = public_path() . '/temp/' . $ip_server . '/cases/filesBefore';
//            $temp_dir_name = 'public/temp/' . $ip_server . '/cases/filesBefore/';
//            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/filesBefore/' . $revisions;
//
//            $filesBefore = $this->dropzoneFilesSubmit($dir_path, $temp_dir_name, $pathToStoreFile);
//
//
//            /** end code
//             * code for uploading Files After **/
//
//            $dir_path = public_path() . '/temp/' . $ip_server . '/cases/filesAfter';
//            $temp_dir_name = 'public/temp/' . $ip_server . '/cases/filesAfter/';
//            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/filesAfter/' . $revisions;
//
//            $filesAfter = $this->dropzoneFilesSubmit($dir_path, $temp_dir_name, $pathToStoreFile);
//
//            /** end files after code
//             * code for ipr form image upload **/
//
//            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/ipr_form/' . $revisions;
//
////            \Illuminate\Support\Facades\File::deleteDirectory('public/temp');
//
//            $ipr_form = $this->fileUpload($iprForm, $pathToStoreFile);
//
//            /** end code **/
//
//            $unique_url = URL::to('/') . '/' . $case_number . '/' . uniqid();
//
//            $data_array = [
//
//                'case_id' => $caseId,
//                'operator_id' => $operator_name,
//                'upper_aligner' => $upper_aligner,
//                'lower_aligner' => $lower_aligner,
//                'file_before' => json_encode($filesBefore),
//                'file_after' => json_encode($filesAfter),
//                'ipr_form' => $ipr_form,
//                'updated_at' => null,
//                'created_at' => $date,
//                'revisions' => $revisions,
//                'url' => $unique_url,
//            ];
//
//            $patient = new Patient();
//            $patientId = $patient->storePatient($data_array);
//            if ($patientId) {
//
//                return $patientId;
//            } else {
//                return redirect()->back()->withErrors($validator, 'login');
//            }
//        }
//    }

    public function caseSubmit(CaseStoreRequest $request)
    {
        $validator = $request->validated();

        $allowedfileExtension = ['stl'];

        $portal = $request->input('portal');
        $case_number = $request->input('case_number');
        $doctor_name = $request->input('doctor_name');
        $upper_aligner = $request->input('upper_aligner');
        $operator_name = $request->input('operator_name');
        $portal_id = $request->input('portal_id');
        $patient_name = $request->input('patient_name');
        $lower_aligner = $request->input('lower_aligner');
        $iprForm = $request->file('ipr_form');
        $file_before = $request->file_before;
        $file_after = $request->file_after;

        $ip_server = $request->getHttpHost();

        $date = date("Y-m-d H:m:s");
        $user_id = Auth::id();

        $caseifExist = Cases::where('case_number', "$case_number")->first();

        if ($caseifExist != null) {
            $caseId = $caseifExist->id;
            $caseNumber = $caseifExist->case_number;

            $number_of_patients = Cases::find($caseId)->patients;
            $revisions = count($number_of_patients) + 1;

        } elseif ($caseifExist == null) {

            $revisions = 0;
            $caseInputData = ['patient_name' => $patient_name,
                'doctor_name' => $doctor_name,
                'case_number' => $case_number,
                'created_at' => $date,
                'user_id' => $user_id,
                'portal_id' => $portal_id
            ];

            $case = new Cases();

            $case_data = $case->storePatientCase($caseInputData);
            $caseId = $case_data->id;
            $caseNumber = $case_data->case_number;
        }

        if ($caseId != null && $caseId > 0) {

            /** code for move files before **/
            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/filesBefore/' . $revisions;
            $filesBefore = $this->multiplefileUpload($pathToStoreFile, $file_before, $allowedfileExtension);

            if($filesBefore == 'false'){
                return response()->json(array('error' => 'File not sup
                ported'), 400);
            }


            /** end code
             * code for uploading Files After **/
            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/filesAfter/' . $revisions;
            $filesAfter = $this->multiplefileUpload($pathToStoreFile, $file_after, $allowedfileExtension);

            if($filesBefore == 'false'){
                return response()->json(array('error' => 'File not supported'), 400);
            }

            /** end files after code
             * code for ipr form image upload **/

            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/ipr_form/' . $revisions;
            $ipr_form = $this->fileUpload($iprForm, $pathToStoreFile);

            /** end code **/

            $unique_url = URL::to('/') . '/' . $case_number . '/' . uniqid();

            $data_array = [

                'case_id' => $caseId,
                'operator_id' => $operator_name,
                'upper_aligner' => $upper_aligner,
                'lower_aligner' => $lower_aligner,
                'file_before' => json_encode($filesBefore),
                'file_after' => json_encode($filesAfter),
                'ipr_form' => $ipr_form,
                'updated_at' => null,
                'created_at' => $date,
                'revisions' => $revisions,
                'url' => $unique_url,
            ];

            $patient = new Patient();
            $patientId = $patient->storePatient($data_array);
            if ($patientId) {

                return $patientId;
            } else {
                return redirect()->back()->withErrors($validator, 'login');
            }
        }
    }

    public function caseList()
    {
        $user = new User();
        $isAdmin = $user->isAdmin();

        $loggedIn = Auth::id();

        $cases = Cases::with('patients', 'portal', 'user')
            ->when(!$isAdmin, function ($query) use ($loggedIn) {
                return $query->where('user_id', $loggedIn);
            })->orderBy('created_at', 'desc')->get();

        $data['cases'] = $cases;

        return view('case_list', $data);
    }

    public function getCaseNumbers(Request $request)
    {
        $search_term = $request->input('query');

        $user_id = Auth::id();

        $data['case_numbers'] = Cases::where('case_number', 'LIKE', '%' . $search_term . '%')
            ->where('user_id', $user_id)->get();

        $returnHTML = view('ajaxViews.cases.case_numbers_list', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function getCaseNumbersForSidebar(Request $request)
    {
        $search_term = $request->input('query');

        $user_id = Auth::id();

        $data['case_numbers'] = Cases::where('case_number', 'LIKE', '%' . $search_term . '%')
            ->where('user_id', $user_id)->get();

        $returnHTML = view('ajaxViews.cases.case_numbers_list', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function getCasesData(Request $request)
    {

        $case_number = $request->input('case_number');

        $data['case'] = Cases::where('case_number', "$case_number")->first();
        $case = $data['case'];

        $data['patient'] = Patient::where('case_id', $case->id)->first();
        $patient = $data['patient'];

        $data['operator_id'] = Operator::where('id', '=', $patient->operator_id)->first();

        if (!$data) {
            return false;
        } else {
            return $data;
        }
    }

    public function getPatientRevisionModal(Request $request)
    {

        $patient_id = $request->input('id');

        $data['patient'] = Patient::with('cases')->where('id', $patient_id)->first();

        $returnHTML = view('ajaxViews.cases.case_revision_edit', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function deleteCase(Request $request)
    {
        $case_id = $request->input('id');
        $revision = $request->input('revision');

        if ($revision != 'revision') {

            $cases = new Cases();

            $cases->deleteCaseWithPatient($case_id);

        } elseif ($revision == 'revision') {

            $patient = new Patient();
            $patient->deletePatientWithCases($case_id);
        }
    }

    public function showPatientModal(Request $request)
    {

        $patient_id = $request->input('id');

        $beforeFiles = array();
        $afterFiles = array();

        $patient = new Patient();

        $data['patient'] = Patient::with('cases', 'operator')->where('id', $patient_id)->first();
        $portal_id = $data['patient']->cases->portal_id;

        $data['get_portal'] = Portal::where('id', $portal_id)->first();

        $caseNumber = $data['patient']->cases->case_number;
        $revisions = $data['patient']->revisions;

        $data['pathToStoreFileBefore'] = 'public/cases/' . $caseNumber . '/filesBefore/' . $revisions;
        $data['pathToStoreFileAfter'] = 'public/cases/' . $caseNumber . '/filesAfter/' . $revisions;

        $data['files_before'] = [$data['patient']->file_before];
        $data['files_after'] = [$data['patient']->file_after];

        $data['beforeFiles'] = $this->getFileNames($data['files_before']);

        $data['afterFiles'] = $this->getFileNames($data['files_after']);

        $returnHTML = view('ajaxViews.cases.case_revision_show', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function showPatientListModal(Request $request)
    {

        $case_id = $request->input('id');
        $data['patients'] = Patient::with('operator')->where('case_id', $case_id)->get();

       $portal_id =  Cases::select('portal_id')->find($case_id);
        $data['portal'] = Portal::find($portal_id)->first();

        $returnHTML = view('ajaxViews.cases.patient_list', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function caseNumberSearch(Request $request)
    {

        $search = $request->input('query');

        $data = Cases::where('case_number', 'LIKE', '%' . $search . '%')->select('case_number')->get();

        return response()->json($data);

    }

    public function searchCaseList(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'case_number',
            2 => 'patient_name',
            3 => 'doctor_name',
        );

        $totalData = Cases::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = Cases::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts = Cases::where('id', 'LIKE', "%{$search}%")
                ->orWhere('patient_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Cases::where('id', 'LIKE', "%{$search}%")
                ->orWhere('patient_name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();

        if (!empty($posts)) {
            foreach ($posts as $post) {

                $nestedData['id'] = $post->id;
                $nestedData['case_number'] = $post->case_number;
                $nestedData['patient_name'] = $post->patient_name;
                $nestedData['doctor_name'] = $post->doctor_name;

                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    private function getMaxOccuringChar()
    {

        $str = "sample string";
        global $ASCII_SIZE;

        // Create array to keep the count
        // of individual characters and
        // initialize the array as 0
        $count = array_fill(0, $ASCII_SIZE, NULL);

        // Construct character count array
        // from the input string.
        $len = strlen($str);
        $max = 0; // Initialize max count

        // Traversing through the string
        // and maintaining the count of
        // each character
        for ($i = 0; $i < ($len); $i++) {
            $count[ord($str[$i])]++;
            if ($max < $count[ord($str[$i])]) {
                $max = $count[ord($str[$i])];
                $result = $str[$i];
            }
        }

        return $result;
    }

    public function searchCaseByNumber()
    {

        $data = DB::table('cases')->select('case_number')->get();

        $case = $data->pluck('case_number');

        return response()->json($case);

    }

    public function getFilteredCases(Request $request)
    {

        $case_number = $request->input('searchTxt1');

        $data['cases'] = Cases::with('patients')->where('case_number', 'LIKE', '%' . $case_number . '%')->get();
        $data['search_term'] = $case_number;


        $returnHTML = view('ajaxViews.searches.case_search', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function caseUrlView($case_id)
    {

        $url = url()->full();

        $data['cases'] = Patient::with('cases', 'operator')->where('url', 'LIKE', '%' . $url . '%')->first();
        $portal_id = $data['cases']->cases->portal_id;

        $data['get_portal'] = Portal::where('id', $portal_id)->first();

        $caseNumber = $data['cases']->cases->case_number;
        $revisions = $data['cases']->revisions;

        $data['pathToStoreFileBefore'] = 'public/cases/' . $caseNumber . '/filesBefore/' . $revisions;
        $data['pathToStoreFileAfter'] = 'public/cases/' . $caseNumber . '/filesAfter/' . $revisions;

        $data['files_before'] = [$data['cases']->file_before];
        $data['files_after'] = [$data['cases']->file_after];

        $data['beforeFiles'] = $this->getFileNames($data['files_before']);

        $data['afterFiles'] = $this->getFileNames($data['files_after']);

        return view('url', $data);
    }

    public function caseEdit($patientId)
    {
        $patient_id = $patientId;

        $data['portal'] = Portal::all();
        $data['operators'] = Operator::all();

        $beforeFiles = array();

        $data['patient'] = Patient::with('cases')->where('id', $patient_id)->first();

        $data['files_before'] = [$data['patient']->file_before];
        $data['filtered_array_beforeFiles'] = $this->getFileNames($data['files_before']);
        $data['files_after'] = [$data['patient']->file_after];
        $data['filtered_array_afterFiles'] = $this->getFileNames($data['files_after']);

        return view('edit_case', $data);
    }

    public function editPatientCaseSubmitOld(Request $request)
    {

        $this->validate($request, [
            'case_number' => 'required|max:8',
            'doctor_name' => 'required|max:30',
            'operator_name' => 'required|max:30',
            'patient_name' => 'required|max:30',
            'lower_aligner' => 'required|between: 1,99|integer',
            'upper_aligner' => 'required|between: 1,99|integer',
            'ipr_form' => 'mimes:jpeg,.jps,png',
        ]);

        $case_number = $request->input('case_number');
        $patient_name = $request->input('patient_name');
        $doctor_name = $request->input('doctor_name');
        $portal_id = $request->input('portal_id');
        $patient_idd = $request->input('patient_id');
        $iprForm = $request->file('ipr_form');
        $revisions = $request->input('revisions');

        $date = date("Y-m-d H:m:s");
        $ip_server = $request->getHttpHost();
        $user_id = Auth::id();

        $caseifExist = Cases::where('case_number', "$case_number")->first();
        $caseId = $caseifExist->id;
        $caseNumber = $caseifExist->case_number;

        $number_of_patients = Cases::find($caseId)->patients;

        $caseifExist->update([
            "patient_name" => $patient_name,
            "doctor_name" => $doctor_name,
            "portal_id" => $portal_id,
        ]);

        $patient_id = $caseifExist->user_id;

        $FileSystem = new \Illuminate\Filesystem\Filesystem();

        if ($caseId != null && $caseId > 0) {

            $dir_path = public_path() . '/temp/' . $ip_server . '/cases/filesBefore';

            if ($FileSystem->exists($dir_path)) {

                $files = $FileSystem->files($dir_path);

                if (!empty($files)) {

                    $temp_dir_name = 'public/temp/' . $ip_server . '/cases/filesBefore/';
                    $listOfFilesUploadUsingDropzone = new \DirectoryIterator($dir_path);
                    $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/filesBefore/' . $revisions;
                    $column_name = 'file_before';

                    $teeth_before_file_names = $this->dropzoneFilesEdit($files, $column_name, $patient_idd, $dir_path, $listOfFilesUploadUsingDropzone, $pathToStoreFile, $temp_dir_name);
                }
            }
        }

        $dir_path = public_path() . '/temp/' . $ip_server . '/cases/filesAfter';

        if ($FileSystem->exists($dir_path)) {

            $files = $FileSystem->files($dir_path);

            if (!empty($files)) {

                $dir_path = public_path() . '/temp/' . $ip_server . '/cases/filesAfter';
                $temp_dir_name = 'public/temp/' . $ip_server . '/cases/filesAfter/';
                $listOfFilesUploadUsingDropzone = new \DirectoryIterator($dir_path);
                $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/filesAfter/' . $revisions;

                $column_name = 'file_after';

                $teeth_after_file_names = $this->dropzoneFilesEdit($files, $column_name, $patient_idd, $dir_path, $listOfFilesUploadUsingDropzone, $pathToStoreFile, $temp_dir_name);
            }
        }

        if ($iprForm != null) {

            $ipr_form = $iprForm->getClientOriginalName();
            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/ipr_form/' . $revisions;

            $iprForm->move($pathToStoreFile, $ipr_form);;
        }

        $array = [

            'operator_id' => $request->input('operator_name'),
            'upper_aligner' => $request->input('upper_aligner'),
            'lower_aligner' => $request->input('lower_aligner'),
            'file_before' => (!empty($teeth_before_file_names)) ? json_encode($teeth_before_file_names) : '',
            'file_after' => (!empty($teeth_after_file_names)) ? json_encode($teeth_after_file_names) : '',
            'ipr_form' => (!empty($ipr_form)) ? $ipr_form : '',
            'updated_at' => $date,
            'revisions' => $revisions,
        ];
        $data_array = array_filter($array);

        $patient_updated_data = Patient::where('id', $patient_idd)->update($data_array);

        if ($patient_updated_data) {
            Session::flash('success', 'Record Updated successfully!');

            return response()->json($patient_updated_data);

        }
    }

    public function editPatientCaseSubmit(CaseStoreRequest $request)
    {
        $validator = $request->validated();

        $allowedfileExtension = ['stl'];

        $case_number = $request->input('case_number');
        $patient_name = $request->input('patient_name');
        $doctor_name = $request->input('doctor_name');
        $portal_id = $request->input('portal_id');
        $patient_idd = $request->input('patient_id');
        $iprForm = $request->file('ipr_form');
        $revisions = $request->input('revisions');
        $file_before = $request->file_before;
        $file_after = $request->file_after;

        $date = date("Y-m-d H:m:s");
        $ip_server = $request->getHttpHost();
        $user_id = Auth::id();

        $caseifExist = Cases::where('case_number', "$case_number")->first();
        $caseId = $caseifExist->id;
        $caseNumber = $caseifExist->case_number;

        $number_of_patients = Cases::find($caseId)->patients;

        $caseifExist->update([
            "patient_name" => $patient_name,
            "doctor_name" => $doctor_name,
            "portal_id" => $portal_id,
        ]);

        $patient_id = $caseifExist->user_id;

        $FileSystem = new \Illuminate\Filesystem\Filesystem();

        if ($caseId != null && $caseId > 0) {

            /** code for move files before **/
            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/filesBefore/' . $revisions;
            $filesBefore = $this->multiplefileUpload($pathToStoreFile, $file_before, $allowedfileExtension);

            if($filesBefore == 'false'){
                return response()->json(array('error' => 'File not sup
                ported'), 400);
            }


            /** end code
             * code for uploading Files After **/
            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/filesAfter/' . $revisions;
            $filesAfter = $this->multiplefileUpload($pathToStoreFile, $file_after, $allowedfileExtension);

            if($filesBefore == 'false'){
                return response()->json(array('error' => 'File not supported'), 400);
            }

            /** end files after code
             * code for ipr form image upload **/

        }

        if ($iprForm != null) {

            $ipr_form = $iprForm->getClientOriginalName();
            $pathToStoreFile = public_path() . '/cases/' . $caseNumber . '/ipr_form/' . $revisions;

            $iprForm->move($pathToStoreFile, $ipr_form);;
        }

        $array = [

            'operator_id' => $request->input('operator_name'),
            'upper_aligner' => $request->input('upper_aligner'),
            'lower_aligner' => $request->input('lower_aligner'),
            'file_before' => (!empty($filesBefore)) ? json_encode($filesBefore) : '',
            'file_after' => (!empty($filesAfter)) ? json_encode($filesAfter) : '',
            'ipr_form' => (!empty($ipr_form)) ? $ipr_form : '',
            'updated_at' => $date,
            'revisions' => $revisions,
        ];
        $data_array = array_filter($array);

        $patient_updated_data = Patient::where('id', $patient_idd)->update($data_array);

        if ($patient_updated_data) {
            Session::flash('success', 'Record Updated successfully!');

            return response()->json($patient_updated_data);

        }
    }

    public function showEditCaseModalAjaxCall(Request $request)
    {

        $case_number = $request->input('updated_case_number');
        $patient_name = $request->input('updated_patient_name');
        $doctor_name = $request->input('updated_doctor_name');

        $case_number_id = Cases::where('case_number', 'LIKE', '%' . $case_number . '%')->first();

        $updated = Cases::where('id', $case_number_id->id)->update([
            'patient_name' => $patient_name,
            'doctor_name' => $doctor_name,
            'case_number' => $case_number,
        ]);

        return $updated;
    }

    public function dropzoneFiles(Request $request)
    {
        $ip_server = $request->getHttpHost();

        $filesAfter = $request->file('file_after');
        $filesBefore = $request->file('file_before');

        $pathToStoreFile = public_path() . '/temp/' . $ip_server . '/cases/filesAfter';

        if ($filesBefore) {
            list($files_array, $pathToStoreFile, $fileName) = $this->submitDropzoneFilestoTempDir($filesBefore, $ip_server, $pathToStoreFile);
        } elseif ($filesAfter) {
            list($files_array, $pathToStoreFile, $fileName) = $this->submitDropzoneFilestoTempDir($filesAfter, $ip_server, $pathToStoreFile);
        }


    }

    public function delDropzoneFileRelatedtoPatient(Request $request)
    {

        $file_before = $request->input('file_before');
        $id = $request->input('id');
        $file_after = $request->input('file_after');

        if ($file_before && $id) {

            $patient = Patient::select('file_before')->where('id', $id)->first();
            $files_before = [$patient->file_before];
            $beforeFiles = array();
            foreach ($files_before as $fileBefore) {
                $beforeFiles = $fileBefore;
            }

            $removed_quotes_beforeFiles = str_replace('"', '', $beforeFiles);

            $data['beforeFiles'] = $this->multiexplode(array(",", "]", "["), $removed_quotes_beforeFiles);

            $filtered_array = array_filter($data['beforeFiles']);

            if (in_array($file_before, $filtered_array)) {
                $value = array_search($file_before, $filtered_array);
                unset($filtered_array[$value]);

                $array = [
                    'file_before' => (!empty($filtered_array)) ? array_values($filtered_array) : '',
                ];

                $patient_updated_data = Patient::where('id', $id)->update($array);

                if ($patient_updated_data) {

                    return $patient_updated_data;
                }
            }
        } elseif ($file_after && $id) {

            $patient = Patient::select('file_after')->where('id', $id)->first();
            $files_after = [$patient->file_after];

            foreach ($files_after as $fileAfter) {
                $AfterFiles = $fileAfter;
            }

            $removed_quotes_afterFiles = str_replace('"', '', $AfterFiles);

            $data['afterFiles'] = $this->multiexplode(array(",", "]", "["), $removed_quotes_afterFiles);

            $filtered_array = array_filter($data['afterFiles']);

            if (in_array($file_after, $filtered_array)) {

                $value = array_search($file_after, $filtered_array);
                unset($filtered_array[$value]);

                $array = [
                    'file_after' => (!empty($filtered_array)) ? array_values($filtered_array) : '',
                ];

                $patient_updated_data = Patient::where('id', $id)->update($array);

                if ($patient_updated_data) {

                    return $patient_updated_data;
                }
            }
        }
    }

    public function getCaseNumberDataAjaxCall(Request $request){

        $search = $request->input('case_number');

        $data['cases'] = Cases::with('patients', 'portal')->where('case_number', 'LIKE', '%' . $search . '%')->first();

        $returnHTML = view('ajaxViews.searches.case_data', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function getRolesAjaxCall(Request $request)
    {
        $role_id = $request->input('query');

        $permissions = Role::with('permissions')->where('id', $role_id)->get();

        return $permissions;
    }

    /** Helper funcitons*/
    private function getFileNames(array $files)
    {
        foreach ($files as $file) {
            $filesList = $file;
        }

        $removed_quotes_filesList = str_replace('"', '', $filesList);

        $data['filesList'] = $this->multiexplode(array(",", "]", "["), $removed_quotes_filesList);

        return array_filter($data['filesList']);

    }

    function multiexplode($delimiters, $string)
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $exploded = explode($delimiters[0], $ready);
        return $exploded;
    }


//    public function delDropzoneFile(Request $request)
//    {
//        $file_before = $request->input('file_before');
//        $id = $request->input('id');
//        $file_after = $request->input('file_after');
//
//        if ($file_before) {
//            $dir = public_path() . '/temp/cases/filesBefore/' . $file_before;
//            $result = unlink($dir);
//
//        } elseif ($file_after) {
//            $dir = public_path() . '/temp/cases/filesAfter/' . $file_after;
//            $result = unlink($dir);
//
//        }
//    }

}

