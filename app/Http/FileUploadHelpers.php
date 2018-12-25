<?php

namespace App\Http;

use Request;
use Auth;
use Response;
use Carbon\Carbon;
use Config;
use Storage;
use File;
use Image;

class FileUploadHelpers
{
    public static function saveUploadedImage($file, $storagePath, $fileOldName='', $isCreateThumb="1", $height=200, $width=200) {

        $randomStringTemplate = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle(str_repeat($randomStringTemplate, 5)), 0, 5);

        $timestamp = Carbon::createFromFormat('U.u', microtime(true))->format("YmdHisu");
        $nameWithoutExtension = preg_replace("/[^a-zA-Z0-9]/", "", '') . '' . $timestamp;
        $nameWithoutExtension = $nameWithoutExtension.'-'.$randomString;
        //$fileExtension = $file->getClientOriginalExtension();
        $fileExtension = $file->guessExtension();
        $name = $nameWithoutExtension. '.' . $fileExtension;
        $name = str_replace([' ', ':', '-'], "", $name);

        $deleteFileList = array();
        $thumbName = "";

        try {
            $img = Image::make($file->getRealPath());
            if($img->save($storagePath.$name)) {
                $thumbnailStoragePath = $storagePath."thumb/";
                $imageName = $name;
                if($isCreateThumb == "1") {
                    $thumbName = $name;
                    $img = Image::make($file->getRealPath())->resize($width, $height);
                    $img->save($thumbnailStoragePath.$name, 60);

                }

                if (!empty($fileOldName)) {
                    $deleteFileList[] = $storagePath.$fileOldName;
                    $deleteFileList[] = $storagePath."thumb/".$fileOldName;
                }
            }

            if(count($deleteFileList) > 0) {
                FileUploadHelpers::deleteIfFileExist($deleteFileList);
            }

            $returnArray = array('name' => $imageName, "error_msg" => "");
            return $returnArray;

        } catch (Exception $e) {
            FileUploadHelpers::deleteIfFileExist($deleteFileList);
            $returnArray = array('name' => "", "error_msg" => $e.getMessage());
            return $returnArray;
        }
    }

    public static function uploadFile($file, $storagePath,$fileOldName='') {

        $randomStringTemplate = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle(str_repeat($randomStringTemplate, 5)), 0, 5);

        $timestamp = Carbon::createFromFormat('U.u', microtime(true))->format("YmdHisu");
        $nameWithoutExtension = preg_replace("/[^a-zA-Z0-9]/", "", '') . '' . $timestamp;
        $nameWithoutExtension = $nameWithoutExtension.'-'.$randomString;
        $fileExtension = $file->getClientOriginalExtension();
        $name = $nameWithoutExtension. '.' . $fileExtension;
        $name = str_replace([' ', ':', '-'], "", $name);

        $deleteFileList = array();
        if (!empty($fileOldName)) {
            $deleteFileList[] = $storagePath.$fileOldName;
        }
        if(count($deleteFileList) > 0) {
            FileUploadHelpers::deleteIfFileExist($deleteFileList);
        }

        try {
            $returnArray = array('name' => "", "error_msg" => "Sorry something went wrong please try again");
            if($file->move($storagePath,$name)) {
                $returnArray = array('name' => $name, "error_msg" => "");
            }
            return $returnArray;

        } catch (Exception $e) {
            FileUploadHelpers::deleteIfFileExist($deleteFileList);
            $returnArray = array('name' => "", "error_msg" => $e.getMessage());
            return $returnArray;
        }
    }

	public static function deleteIfFileExist($files){
        if(is_array($files) && count($files)>0) {
    		foreach ($files as $key => $path) {
                if (!empty($path) && File::exists($path)) {
                    unlink($path);
                }
    		}
    	}
    	else {
    		if (!empty($files) && File::exists($files)) {
                unlink($files);
            }
    	}
    }

    public static function copyFile($fileName, $storagePath, $isCreateThumb="1")
    {
        $randomStringTemplate = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle(str_repeat($randomStringTemplate, 5)), 0, 5);

        $timestamp = Carbon::createFromFormat('U.u', microtime(true))->format("YmdHisu");
        $nameWithoutExtension = preg_replace("/[^a-zA-Z0-9]/", "", '') . '' . $timestamp;
        $nameWithoutExtension = $nameWithoutExtension.'-'.$randomString;
        $fileExtension = substr($fileName, strrpos($fileName, '.') + 1);
        $name = $nameWithoutExtension. '.' . $fileExtension;
        $name = str_replace([' ', ':', '-'], "", $name);

        try {
            $returnArray = array('name' => "", "error_msg" => "Sorry something went wrong please try again");
            // if(Storage::exists($storagePath.$fileName)){

            // }
            if(Storage::copy($storagePath.$fileName, $storagePath.$name)) {
                if($isCreateThumb){
                    $thumbnailStoragePath = $storagePath."thumb/";
                    if(Storage::exists($thumbnailStoragePath.$fileName)){
                        Storage::copy($thumbnailStoragePath.$fileName, $thumbnailStoragePath.$name);
                    }
                }
                $returnArray = array('name' => $name, "error_msg" => "");
            }
            return $returnArray;
        } catch (Exception $e) {
            $returnArray = array('name' => "", "error_msg" => $e.getMessage());
            return $returnArray;
        }
    }

    public static function apiValidationFailResponse($validator)
    {
        $statusCodes = config("l2w.status_codes");
        $messages = $validator->errors();
        if (is_object($messages)) {
            $messages = $messages->toArray();
        }
        return FileUploadHelpers::apiJsonResponse($messages, $statusCodes['form_validation'], "Validation Error");
    }

    public static function apiUserNotFoundResponse()
    {
        $statusCodes = config("l2w.status_codes");
        return FileUploadHelpers::apiJsonResponse([], $statusCodes['auth_fail'], "User not found");
    }

    public static function apiJsonResponse($responseData=[], $code='', $message = "")
    {
        $statusCodes = config("l2w.status_codes");
        if($code == '') {
            $code = $statusCodes['success'];
            if(count($responseData) == 0) {
                $code = $statusCodes['success_with_empty'];
            }
        }

        $data = array(
                        'message' => $message,
                        'data' => $responseData,
                        'code' => $code
                    );
        return Response::json($data, $code);
    }

    public static function generateFilename($file_extension = '') {
        //$s = strtoupper(md5(uniqid(rand(),true)));
        $str_1 = md5(uniqid(rand(), true));
        $str_2 = substr($str_1, 0, 8) . '-' .
                substr($str_1, 8, 4) . '-' .
                substr($str_1, 12, 4) . '-' .
//                substr($str_1, 16, 4) . '-' .
                substr($str_1, 20);
        return time() . '-' . $str_2 . ($file_extension ? '.' . $file_extension : '');
    }
}
