<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use DB;

class FileController extends Controller
{	
	// Получение файла по id
	public function listByApp(Request $request, $id)
	{
			
			$arResult = array('success' => false);

			try {

				$slq = "EXEC lkk_apphash_filelist @app_hash = '".$id."'";
				$result = DB::select(trim($slq));
				
				$result = (array) $result;

				if(!empty($result)) {
					$arResult = ['success' => true, 'data' => (array)$result ];
				}

			} catch (QueryException $e) {
	    	$arResult['error'] = $e->getMessage();

	    }
			
			return response()->json($arResult);
		}



}

/*

lkk_apphash_filelist этот параметр на входе
-- exec lkk_apphash_filelist '170915804921238125038911'
процедура возвращает информацию для работы с файлами по заявке
основные:
direction_id - направление файла - загружать в систему или отдавать клиенту 
file_id - идентификатор файла
is_url - если файл должен быть получен по ссылке вместо процедуры (п3)


резалтсет процедуры
direction_id - направление ид
direction_name - направление
c_filestatus - статус файла ид
id scantype_id - тип файла ид
scantype_name - тип название
files_name - имя файла
file_id - глобальный идентификатор файлв
is_url - чек если файл по ссылке
url - адрес ссылки на файл

*/