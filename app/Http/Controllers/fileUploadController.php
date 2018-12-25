<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Storage;
use File;
use Image;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {

            $code = '422';
            $responseData = $validator->errors();
            if (is_object($responseData)) {
                $responseData = $responseData->toArray();
            }
            $data = array(
                            'message' => 'Validation Error',
                            'data' => $responseData,
                            'code' => $code
                        );
            return Response::json($data, $code);
        }

        try {
            $file = $request->file('file');
            $storagePath = storage_path("app/public/uploads/images/");
            if (! \File::isDirectory($storagePath)) {
                \Storage::makeDirectory('public/uploads/images');
            }

            $randomStringTemplate = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = substr(str_shuffle(str_repeat($randomStringTemplate, 5)), 0, 5);

            $timestamp = Carbon::createFromFormat('U.u', microtime(true))->format("YmdHisu");
            $nameWithoutExtension = preg_replace("/[^a-zA-Z0-9]/", "", '') . '' . $timestamp;
            $nameWithoutExtension = $nameWithoutExtension.'-'.$randomString;
            $fileExtension = $file->guessExtension();
            $name = $nameWithoutExtension. '.' . $fileExtension;
            $name = str_replace([' ', ':', '-'], "", $name);

            try {
                $img = Image::make($file->getRealPath());
                if($img->save($storagePath.$name)) {
                    $imageName = $name;
                }



                $imageResult = array('name' => $imageName, "error_msg" => "");

            } catch (Exception $e) {
                $imageResult = array('name' => "", "error_msg" => $e.getMessage());
            }

            if ($imageResult['name'] != "" && $imageResult['error_msg'] == "") {
                $success_msg_code = '200';
                $success_message = 'File Uploaded Successfully.';
                return redirect()->back()->with('success', $success_message);
            }
            else{
                $normal_error = '403';
                return redirect()->back()->with('error', 'Sorry, Something went wrong please try again');
            }
        } catch (\Exception $e) {
            $normal_error = '403';
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
