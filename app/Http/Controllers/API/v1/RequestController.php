<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
//18785157118189
class RequestController extends Controller
{	

	public function index(Request $request)
	{
		
		$arResult = array(
			'success' => false
		);

		// $request->hash_id = 18785157118189;

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
    	print $e->getMessage();

    }
		
		return response()->json($arResult);
	}


}