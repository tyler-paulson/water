<?php

header("Content-Type: text/plain");

require_once('config.php');

$id = '32C7FN';

// We'll use this in both API requests

$authorization = base64_encode(CLIENT_ID.":".CLIENT_SECRET);

// Fetch the refresh token

$connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

$id_query = 'SELECT refresh FROM users WHERE id = \''.$id.'\'';

$id_result = mysqli_fetch_row(mysqli_query($connection, $id_query));

mysqli_close($connection);

// Get a new user (access) token

$opts = array(
  'http'=>array(
    'method'=>"POST",
    'header'=>"Authorization: Basic ".$authorization."\r\n" .
              "Content-Type: application/x-www-form-urlencoded\r\n"
  )
);

$context = stream_context_create($opts);

$uri = file_get_contents(
  'https://api.fitbit.com/oauth2/token?grant_type=refresh_token&refresh_token='.$id_result[0].'&expires_in=3600',
  false,
  $context
);

$obj = json_decode($uri);

$usertoken = $obj->access_token;
$refreshtoken = $obj->refresh_token;

$connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

$token_query = 'UPDATE users SET token = \''.$usertoken.'\', refresh = \''.$refreshtoken.'\' WHERE id = \''.$id.'\'';

mysqli_query($connection, $token_query);

mysqli_close($connection);

// Log the water

date_default_timezone_set('America/New_York');

$opts = array(
  'http'=>array(
    'method'=>"POST",
    'content'=>"amount=250&date=".date("Y-m-d")."&unit=ml",
    'header'=>"Authorization: Bearer ".$usertoken."\r\n".
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
