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
	<?php nav_bar(); 
		echo "<div id='main_content'>";
		if (isset($_SESSION['logged_user'])){
			echo "
            <div class='row'>
                <div class='col-sm-6'>
                    <h3>Personal Information</h3>";
            $name = $_SESSION['logged_user'];
            require_once 'config.php';
            $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      		$result = $mysqli->query("SELECT * FROM Person WHERE name = '$name'");
      		if($row = $result->fetch_assoc()){
      			$age = $row['age'];
      			$photo = $row['photo_url'];
      		}
      		echo "
                    <div class='pi_content'>
                        <img class='photo' src=$photo></img>
                        <h5 class='name'>Name: $name</h5>
                        <h5>Age: $age</h5>
                    </div>
                </div>
                <div class='col-sm-6'>
                    <h3>Add</h3>";
            add_form();
            if (isset($_POST['add'])){
            	$iid = trim(filter_input(INPUT_POST, 'item_id', FILTER_SANITIZE_STRING));
            	$amount = trim(filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING));
            	require_once 'config.php';
        		$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        		$result = $mysqli->query("SELECT * FROM Item INNER JOIN Category on Item.cid = Category.cid WHERE Item.iid = $iid" );
        		if($row = $result->fetch_assoc()){
            		$min_age = $row['minimum_age'];
            		$item_name = $row['item_name'];
            		$result = $mysqli->query("INSERT INTO Item_added(iid, item_name, amount, min_age) VALUES ('$iid', '$item_name', '$amount', '$min_age')");
            		echo "sucessfully added";
        		}
            }
            echo "<h3>Shopping List</h3>";
            	require_once 'config.php';
            	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            	$result = $mysqli->query("SELECT * FROM Item_added");
            	echo "<div id='list'>";
            	while($row = $result->fetch_assoc()){
            		$item_name = $row['item_name'];
            		$amount = $row['amount'];
            		$min_age = $row['min_age'];
            		echo "
            				<div class='item'> 
	            				<h5>Item Name: $item_name</h5>
	            				<h6>Amount: $amount</h6>
            				</div>
            		";
            	}
            	echo "</div>";
            echo "<button type='submit' class='btn btn-default' name='checkout' value='checkout' onclick='myFunction()''>Checkout</button>";
            require_once 'config.php';
            $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            $result = $mysqli->query("SELECT * FROM Item_added Where min_age > $age");
            $myArray = [];
            echo "<div id='no_allow'>";
            echo "<h4 style='color:red'>Items not allowed to purchase</h4>";
            while ($row = $result->fetch_assoc()) {
            	$item = $row['item_name'];
            	$myArray[] = $item;
            	echo "
        				<div class='item_notallowed'> 
            				<h5 style='color:red'>Item Name: $item</h5>
        				</div>
        		";
            }
            echo "</div>";
            echo "
                </div>
            </div>";
		}else{
			echo "<h1>Welcome to Secure!</h1>";
			echo "<h2>A safer, more convenient way to live</h2>";
		}
	?>
	</div>
	<script src="index.js"> </script>
</body>
</html>