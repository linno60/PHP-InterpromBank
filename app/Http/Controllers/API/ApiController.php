<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    const VER = 1.0;

    protected function checkVer(Request $request)
    {
        $success = false;
        $errorCode = '';
        $errorMsg = '';
        $support = false;

        $validator = Validator::make($request->all(),
            [
                'apiVersion' => 'required|integer',
            ]);

        if ($validator->passes()) {
            if($request->apiVersion == self::VER) {
                $support = true;
            }
            $success = true;
        } else {
            $errorCode = 'SYSTEM_ERROR';
            $errorMsg = $validator->errors()->first();
        }

        return response()->json(['success' => $success, 'errorCode' => $errorCode, 'errorMsg' => $errorMsg, 'support' => $support], 200);
    }
}