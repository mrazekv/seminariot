<?php
require("config.php");
$db = new mysqli($conf["db_server"],$conf["db_user"], $conf["db_password"], $conf["db_name"] );

$r = $db->query(sprintf("select * from temp where id = %d", intval($_GET["id"])));

$data = $r->fetch_object();
if(!$data)
{
    echo -1;
    exit(1);
}

echo $data->status;

$db->query(sprintf("update temp set temp=%f, note=\"%s\", timestamp = NOW() where id = %d LIMIT 1",
    $_GET["temp"], $db->real_escape_string($_GET["note"]), intval($_GET["id"])));


