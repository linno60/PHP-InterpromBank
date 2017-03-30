<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class AuthController extends Controller
{	

	public function send_code(Request $request)
	{
		
		DB::statement('SET ANSI_NULLS ON SET ANSI_PADDING ON SET ANSI_WARNINGS ON SET ARITHABORT ON SET CONCAT_NULL_YIELDS_NULL ON SET QUOTED_IDENTIFIER ON SET NUMERIC_ROUNDABORT OFF');
		
		$slq = "exec et_lkk_login_json '<root><login>".$request->email."</login><action>ask_email_code</action></root>'";
		$result = DB::select(trim($slq));
		
		$result = (array) $result[0];

		return response()->json($result);
	}

	public function confirm_code(Request $request)
	{
		
		DB::statement('SET ANSI_NULLS ON SET ANSI_PADDING ON SET ANSI_WARNINGS ON SET ARITHABORT ON SET CONCAT_NULL_YIELDS_NULL ON SET QUOTED_IDENTIFIER ON SET NUMERIC_ROUNDABORT OFF');
		
		$slq = "exec et_lkk_login_json '<root><action>login_email_code</action><login>".$request->email."</login><password>".$request->code."</password><hash_id></hash_id></root>'";
		$result = DB::select(trim($slq));
		
		$result = (array) $result[0];

		return response()->json($result);
	}

	public function manage_email(Request $request)
	{
		
		$arResult = array('success' => false);
		$action = ($request->action && $request->action >= 0) ? $request->action : 0; 

		try {			
			$slq = "exec et_lkk_manage_email @szEmailAuth = 'r.kovjogin@gmail.com', @action = ".$action;
			
			if($action > 0) {
				$slq .= ", @szEmail = '".$request->new_email."', ";
				$slq .= "@check_agent_alldeals = '".$request->check_agent_alldeals."', ";
				$slq .= "@check_agent_comis = '".$request->check_agent_comis."', ";
				$slq .= "@descr = '".$request->descr."'; ";
			}

			$result = DB::select(trim($slq));
			
			$arResult['data'] = $result;
			$arResult['success'] = true;			
			
		} catch (QueryException $e) {
	    	$arResult['error'] = $e->getMessage();
	  }

		return response()->json($arResult);
	}

}


// procedure [dbo].[et_lkk_manage_email]
// @szEmailAuth varchar(30)
// ,@action int -- 0 - листинг
// ,@szEmail varchar(50) = null
// ,@check_agent_alldeals bit = null
// ,@check_agent_comis bit = null
// ,@descr varchar(255) = null