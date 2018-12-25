<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\FileUploadHelpers;

class fileUploadController extends Controller
{
    public function store(Request $request)
    {
        //dd($request); exit;
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return FileUploadHelpers::apiValidationFailResponse($validator);
        }

        try {
            $file = $request->file('file');
            $storagePath = config('fileuploadblog.path.upload.images');
            if (! \File::isDirectory($storagePath)) {
                \Storage::makeDirectory('public/uploads/images');
                \Storage::makeDirectory('public/uploads/images/thumb');
            }

            $imageResult = FileUploadHelpers::saveUploadedImage($file,$storagePath);

            if ($imageResult['name'] != "" && $imageResult['error_msg'] == "") {
                $success_config = config('fileuploadblog.status_codes.success');
                $response_return = FileUploadHelpers::apiJsonResponse([], $success_config, "FileUploaded Successfully");
                return redirect()->back()->with('success', 'FileUploaded Successfully');
            }
            else{
                $normal_error = config('fileuploadblog.status_codes.normal_error');
                $response_return = FileUploadHelpers::apiJsonResponse([], $normal_error, "Sorry, Something went wrong please try again");
                return redirect()->back()->with('error', 'Sorry, Something went wrong please try again');
            }
        } catch (\Exception $e) {
            $normal_error = config('fileuploadblog.status_codes.normal_error');
            $response_return = FileUploadHelpers::apiJsonResponse([], $normal_error, $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
