<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Movie;
use App\User;
use DB;

class UserController extends Controller
{	

		public function im(Request $request)
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
						$stmt = $pdo->prepare("EXEC et_lkk_session_inf @hash = ".$request->hash_id.", @Errortxt = '', @Succes = ''");
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