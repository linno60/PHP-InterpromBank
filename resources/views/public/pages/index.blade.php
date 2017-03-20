<?php 

$file = file_get_contents(storage_path('app/test.jpg'));

// $slq = "exec test_prc_file @file=".DB::raw(bin2hex($file)).", @id = NULL";
$slq = "exec test_prc_file @file=".DB::raw('0x'.bin2hex($file)).", @id = NULL";
// $slq = "exec test_prc_file NULL, 21";
(array)$result = DB::select(trim($slq));
var_dump($result);

// Storage::disk('local')->put('file.jpg', $result[0]->file);

 ?>