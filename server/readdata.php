<?php
require("config.php");
$db = new mysqli($conf["db_server"],$conf["db_user"], $conf["db_password"], $conf["db_name"] );

$r = $db->query(sprintf("select temp.*, TIMESTAMPDIFF(SECOND, timestamp, NOW()) as age, (timestamp IS NOT NULL AND timestamp >= NOW() - INTERVAL 30 SECOND) as is_online from temp where id > 100 and id < 500"));
$ret_hack = array();
while($data = $r->fetch_object())
{
    $ret_hack[$data->id] = $data;
}


$r = $db->query(sprintf("select temp.*, TIMESTAMPDIFF(SECOND, timestamp, NOW()) as age, (timestamp IS NOT NULL AND timestamp >= NOW() - INTERVAL 30 SECOND) as is_online from temp where id < 100"));
$ret = array();
while($data = $r->fetch_object())
{
	if(isset($ret_hack[$data->id * 10]) && $ret_hack[$data->id * 10]->is_online)
	{
		$h_data = $ret_hack[$data->id * 10];
		$h_data->id = $data->id;
		$h_data->hacked=true;
		$ret[] = $h_data;
	}
	else
	{
		$data->hacked=false;
		$ret[] = $data;
	}
}


$r = $db->query(sprintf("select temp.*, TIMESTAMPDIFF(SECOND, timestamp, NOW()) as age, (timestamp IS NOT NULL AND timestamp >= NOW() - INTERVAL 30 SECOND) as is_online from temp where id > 500"));
$data = $r->fetch_object();
$ret[] = $data;


header('Content-Type: application/json');
echo json_encode($ret);
