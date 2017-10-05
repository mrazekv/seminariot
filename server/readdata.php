<?php
require("config.php");
$db = new mysqli($conf["db_server"],$conf["db_user"], $conf["db_password"], $conf["db_name"] );

$r = $db->query(sprintf("select temp.*, TIMESTAMPDIFF(SECOND, timestamp, NOW()) as age, (timestamp IS NOT NULL AND timestamp >= NOW() - INTERVAL 30 SECOND) as is_online from temp"));

$ret = array();
while($data = $r->fetch_object())
{
    $ret[] = $data;
}

header('Content-Type: application/json');
echo json_encode($ret);
