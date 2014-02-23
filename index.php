<?php
if ( isset( $_POST['send'] ) === true ) {
	$username = $_POST['username'];
	header("Location: result.php");
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Twitter User Statistics</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
<div class="container">
	<div class="row">
	    <div class="col-md-4">
	    </div>
	    <div class="col-md-4" style="margin: 50px 0;">
			<form action="result.php" class="form-signin" method="post" role="form">
				<h3 class="form-heading">Please enter a twitter username</h3>
				<input type="text" class="form-control" name="username" placeholder="Username" required>
				<br><br>
				<button class="btn btn-md btn-primary btn-block" type="submit" name="send">Submit</button>
			</form>
		</div>
		<div class="col-md-4">
		</div>
	</div>
</div>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</body>
</html>