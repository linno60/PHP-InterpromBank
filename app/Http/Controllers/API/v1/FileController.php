<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use DB;
use Storage;
use File;

class FileController extends Controller
{	
	// Получение файла по id
	public function listByApp(Request $request, $id)
	{
			
			$mimes = new \Mimey\MimeTypes;
			$arResult = array('success' => false);

			try {

				$slq = "EXEC lkk_apphash_filelist @app_hash = '".$id."'";
				$result = (array) DB::select(trim($slq));

				if(!empty($result)) {
					$arFiles = [];

					foreach ($result as $key => $file) {
						$file = (array) $file;
						if(!$file['is_url']) {
							// $file['file_id'] = 32;
							
							$file_sql = "EXEC lkk_apphash_fileprocess @app_hash = '".$id."', @file_id = '".$file['file_id']."', @filename = null,  @filecontent  = null";
							$file['file'] = (array) DB::select(trim($file_sql))[0];
							if($file['file']['file_name']) {
								$file['file']['base64'] = base64_encode($file['file']['file_content']);
								$pathinfo = pathinfo($file['file']['file_name']);
								$file['file']['extension'] = $pathinfo['extension'];
								$file['file']['mime_type'] = $mimes->getMimeType($file['file']['extension']);
								$file['file']['src'] = 'data:'.$file['file']['mime_type'].';base64,'.$file['file']['base64'];
								
							}
		
							unset($file['file']['file_content']);
						}

						$arFiles[] = $file;

					}

					$arResult = ['success' => true, 'data' =>  $arFiles];
				}

			} catch (QueryException $e) {
	    	$arResult['error'] = $e->getMessage();

	    }
			
			return response()->json($arResult);
		}

		public function sendFile(Request $request, $app_id)
		{
				
				$arResult = array('success' => false);

				try {

					$file = File::get($request->file('file_conntent'));

					$slq = "EXEC lkk_apphash_fileprocess @app_hash = '".$app_id."', @file_id = '".$request->file_id."', @filename = '".$request->filename."',  @filecontent  = ".DB::raw('0x'.bin2hex($file));
					$result = (array) DB::select(trim($slq));
					$result = (array) $result[0];

						$arResult = ['success' => ($result['ret'] == 0 ? true : false), 'data' =>  $result, 'error' => $result['ret_descr']];

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