<?php session_start(); 
    if(isset($_REQUEST['logout'])) {
        $status = $_REQUEST['logout'];
        if ($_REQUEST['logout']) {
            $olduser = $status;
            unset($_SESSION['logged_user']);
        } else {
            $olduser = false;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Secure</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	<?php include "php_components.php";?>
</head>
<body>
	<?php 
		nav_bar(); 
		get_login_form();
		if(isset($_POST['submit'])){
			$cardnumber = trim(filter_input(INPUT_POST, 'cardnumber', FILTER_SANITIZE_STRING));
            $password = trim(hash('sha256',filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));
            require_once 'config.php';
            $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $result = $mysqli->query("SELECT * FROM Card WHERE card_number = '$cardnumber'");
            if($result->num_rows==0){
            	echo "<div id='fail_login_box'>";
                echo"<p id='fail_login'>The card doesn't exist. Please Try Again.</p>";
                echo "</div>";
                // get_login_form();
            }
            if($row = $result->fetch_assoc()){
            	$pid = $row['pid'];
            	$name = $row['user_name'];
            	$passwordmatching = $row['hashed_password'];
            	if($passwordmatching == $password){
            		$_SESSION['logged_user'] = $name;
            		$logged_user = $_SESSION['logged_user'];
            	}else{
            		// get_login_form();
            		echo "<div class=warn>";
                    echo"<p>Login Failed. Please Try Again.</p>";
                    echo "</div>";
            	}
            }
            $mysqli->close();
		}
	?>

</body>
</html>