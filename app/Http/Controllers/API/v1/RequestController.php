<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class RequestController extends Controller
{	

	public function index(Request $request)
	{
		
		$arResult = array('success' => false);

		try {
				$result = array();
				if($request->hash_id) {
					$output = array();
					$pdo = DB::connection()->getPdo();
					$stmt = $pdo->prepare("EXEC et_lkk_list_app @hash_id = ".$request->hash_id.", @Errortxt = '', @Succes = '',  @id = NULL;");
					$stmt->execute();

					while ($row = $stmt->fetch(\PDO::FETCH_ASSOC, \PDO::FETCH_ORI_NEXT)) {
					    $result[] = $row;
					  }

					$arResult = ['success' => true, 'data' => (array)$result ];
				}
		} catch (PDOException $e) {
    	$arResult['error'] = $e->getMessage();

    }
		
		return response()->json($arResult);
	}

		public function check_account(Request $request)
		{
			
			$arResult = array('success' => false);

			try {

				$slq = "EXEC et_lkk_check_app ".$request->inn.", NULL, '".$request->account."'";
				$result = DB::select(trim($slq));
				
				$result = (array) $result;

				$arResult = ['success' => true, 'data' => (array)$result[0] ];
			
			} catch (PDOException $e) {
	    	$arResult['error'] = $e->getMessage();

	    }
			
			return response()->json($arResult);
		}


}

// procedure [dbo].[et_lkk_check_app] 
//         @szInn varchar(30)
//         ,@szPrchsnum varchar(50)        

// выходные параметры не стал делать по причине проблем обработки со стороны ЛК
// поэтому на выходе резалтсет с результатом

//         result,
//         result_descr

// result 0(не найдено) or 1(найдено)

// et_lkk_check_app '5038110925','0148300036116000207'