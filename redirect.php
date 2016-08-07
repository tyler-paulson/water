<html>

<head>

	<title>Redirect</title>

</head>

<body>

<?php

require_once('config.php');

$key = $_REQUEST['code'];

$authorization = base64_encode(CLIENT_ID.":".CLIENT_SECRET);

$opts = array(
  'http'=>array(
    'method'=>"POST",
    'header'=>"Authorization: Basic ".$authorization."\r\n" .
              "Content-Type: application/x-www-form-urlencoded\r\n"
  )
);

$context = stream_context_create($opts);

$uri = file_get_contents(
  'https://api.fitbit.com/oauth2/token?client_id='.CLIENT_ID.'&grant_type=authorization_code&redirect_uri='.REDIRECT_URI.'&code='.$key,
  false,
  $context
);

$obj = json_decode($uri);

$usertoken = $obj->access_token;
$fitbitid = $obj->user_id;

$connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

if (mysqli_connect_errno()) {
	echo '<p>Database connection error.</p>';
	exit();
}

$query = 'INSERT INTO users VALUES (\''.$fitbitid.'\',\''.$usertoken.'\')';

if(mysqli_query($connection, $query)) {
	echo '<p>Success.</p>';
} else {
	echo '<p>Query fail.</p>';
}

mysqli_close($connection);

?>

</body>

</html>
