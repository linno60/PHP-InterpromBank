<?php 

$slq = "exec prc_test 10";
var_dump(DB::select('exec prc_test 10'));

var_dump(DB::statement('SET ANSI_NULLS ON SET ANSI_PADDING ON SET ANSI_WARNINGS ON SET ARITHABORT ON SET CONCAT_NULL_YIELDS_NULL ON SET QUOTED_IDENTIFIER ON SET NUMERIC_ROUNDABORT OFF'));
var_dump(DB::statement('use inter_lkk_exch'));

$slq = "exec et_lkk_login_json '<root><login>r.kovjogin@open-bs.ru</login><action>ask_email_code</action></root>'";
var_dump(DB::select(trim($slq)));

 ?>