<?php require_once('config.php'); ?>

<html>

<head>

	<title>Fitbit Water Bttn</title>
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css">

</head>

<body>

<?php include('includes/nav.php'); ?>

<div class="container">
	<div class="jumbotron">
		<h1>Fitbit Water Bttn</h1>
		<p>A <a href="https://www.fitbit.com/" target="_blank">Fitbit</a> app in development that allows a user to record water consumption using an endpoint called by a <a href="https://bt.tn/" target="_blank">Bttn</a>.</p>
		<p><a class="btn btn-primary btn-lg" href="https://www.fitbit.com/oauth2/authorize?response_type=code&client_id=<?php echo CLIENT_ID; ?>&scope=nutrition" role="button">Authenticate &raquo;</a></p>
	</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>

</html>
