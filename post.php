<?php

header("Content-Type: text/plain");

require_once('config.php');

$id = '32C7FN';

$connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

$id_query = 'SELECT token FROM users WHERE id = \''.$id.'\'';

$id_result = mysqli_fetch_row(mysqli_query($connection, $id_query));

mysqli_close($connection);

$opts = array(
  'http'=>array(
    'method'=>"POST",
    'content'=>"amount=250&date=".date("Y-m-d")."&unit=ml",
    'header'=>"Authorization: Bearer ".$id_result[0]."\r\n".
    "Content-Type: application/x-www-form-urlencoded\r\n"
  )
);

$context = stream_context_create($opts);

$uri = file_get_contents(
  'https://api.fitbit.com/1/user/'.$id.'/foods/log/water.json',
  false,
  $context
);

var_dump($uri);

?>
