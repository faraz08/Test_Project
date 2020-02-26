<?php
namespace App\CommonTraits;

use App\Models\Patient;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait DropzoneFileUploadTraits{



    private function moveDropzoneFiles($dir_path, $listOfFilesUploadUsingDropzone, $pathToStoreFile, $temp_dir_name)
    {
        $files_array = array();

        foreach ($listOfFilesUploadUsingDropzone as $filename) {

            if ($filename != "." && $filename != ".." && file_exists($temp_dir_name . basename($filename))) {

                $files_array[] = basename($filename);
                $oldFilePath = $dir_path . '/' . $filename;

                if (!is_dir($pathToStoreFile)) {
                    mkdir($pathToStoreFile, 0777, true);
                }

                $filesAfterName = basename($filename);

                $files = \Illuminate\Support\Facades\File::allFiles($temp_dir_name);

                foreach ($files as $file) {

                    $full_path_source = Storage::getDriver()->getAdapter()->applyPathPrefix($file);
                    $update_path = explode("public", $full_path_source);
                    $file_path = public_path() . $update_path[2];

                    $full_path_dest = $pathToStoreFile . '/' . basename($file);

                    \Illuminate\Support\Facades\File::move($file_path, $full_path_dest);

                }

            }
        }
        return $files_array;
    }

    public function fileUpload($fileRequest, $pathToStoreFile){

        $file_extension = $fileRequest->getClientOriginalName();

        $fileRequest->move($pathToStoreFile, $file_extension);

        return $file_extension;
    }

    public function multiplefileUpload($pathToStoreFile, $files, $allowedfileExtension){

        $fileArray = array();
        foreach($files as $file) {

            $filename  = $file->getClientOriginalName();
            $fileArray[]  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $check = in_array($extension,$allowedfileExtension);

            if($check) {
                $file->move($pathToStoreFile, $filename);
            }else{

                return "false";
            }
        }

        return $fileArray;
    }

    /**
     * @param array $files
     * @param $patient_idd
     * @param $data
     * @param $dir_path
     * @param \DirectoryIterator $listOfFilesUploadUsingDropzone
     * @param $pathToStoreFile
     * @param $temp_dir_name
     * @param $teeth_after_file_names
     */
    protected function dropzoneFilesEdit(array $files, $column_name, $patient_idd, $dir_path, \DirectoryIterator $listOfFilesUploadUsingDropzone, $pathToStoreFile, $temp_dir_name)
    {
        $filesArray = array();
        $no_of_files_attached = count($files);

        $patient = Patient::select($column_name)->where('id', $patient_idd)->first();
        $filesName = [$patient->$column_name];

        $newFilesArray = array();
        foreach ($filesName as $singleFile) {
            $newFilesArray = $singleFile;
        }

        $removed_quotes_files = str_replace('"', '', $newFilesArray);

        $data['allFiles'] = $this->multiexplode(array(",", "]", "["), $removed_quotes_files);

        $filtered_array = array_filter($data['allFiles']);

        foreach ($files as $file) {

            $filesArray[] = basename($file);
        }

        $this->moveDropzoneFiles($dir_path, $listOfFilesUploadUsingDropzone, $pathToStoreFile, $temp_dir_name);

        $teeth_file_names = array_merge($filtered_array, $filesArray);

        return $teeth_file_names;
    }

    /**
     * @param \Illuminate\Filesystem\Filesystem $FileSystem
     * @param $dir_path
     * @param $ip_server
     * @param $caseNumber
     * @param $revisions
     * @param $files
     * @param $temp_dir_name
     * @param $filesBefore
     * @param $file
     * @param $listOfFilesUploadUsingDropzone
     * @param $pathToStoreFile
     */
    private function dropzoneFilesSubmit($dir_path, $temp_dir_name, $pathToStoreFile)
    {
        $FileSystem = new \Illuminate\Filesystem\Filesystem();

//        dd($FileSystem->exists($dir_path));

        if ($FileSystem->exists($dir_path)) {

            $files = $FileSystem->files($dir_path);


            $filesBefore = array();

            $no_of_files_attached = count($files);

            foreach ($files as $file) {

                $filesBefore[] = basename($file);
            }

            $listOfFilesUploadUsingDropzone = new \DirectoryIterator($dir_path);

            $this->moveDropzoneFiles($dir_path, $listOfFilesUploadUsingDropzone, $pathToStoreFile, $temp_dir_name);

            return $filesBefore;
        }

    }

    /**
     * @param $filesAfter
     * @param $ip_server
     * @return array
     */
    private function submitDropzoneFilestoTempDir($files, $ip_server, $pathToStoreFile)
    {
        $files_array = array();

        if ($files) {

            if (\Illuminate\Support\Facades\File::isDirectory($pathToStoreFile) == false) {

                \Illuminate\Support\Facades\File::makeDirectory($pathToStoreFile, 0777, true, true);

            };

            foreach ($files as $fileAfter) {

                $fileName = $fileAfter->getClientOriginalName();

                $fileAfter->move($pathToStoreFile, $fileName);

                $files_array[] = $fileName;
            }
        }
        return array($files_array, $pathToStoreFile, $fileName);
    }


}
