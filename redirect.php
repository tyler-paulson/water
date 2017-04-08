<html>

<head>

	<title>Fitbit Water Bttn | Redirect</title>
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">

</head>

<body>

<?php include('includes/nav.php'); ?>

<div class="container">

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
  'https://api.fitbit.com/oauth2/token?client_id='.CLIENT_ID.'&grant_type=authorization_code&redirect_uri='.REDIRECT_URI.'&code='.$key.'&expires_in=3600',
  false,
  $context
);

$obj = json_decode($uri);

$usertoken = $obj->access_token;
$refreshtoken = $obj->refresh_token;
$fitbitid = $obj->user_id;

$connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

if (mysqli_connect_errno()) {
	echo '<div class="alert alert-danger" role="alert">Database connection error.</div>';
	exit();
}

$query = 'INSERT INTO users VALUES (\''.$fitbitid.'\',\''.$usertoken.'\',\''.$refreshtoken.'\')';

if(mysqli_query($connection, $query)) {
	echo '<div class="alert alert-success" role="alert">Success.</div>';
} else {
	echo '<div class="alert alert-danger" role="alert">Query fail.</div>';
}

mysqli_close($connection);

?>

</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>

</html>
