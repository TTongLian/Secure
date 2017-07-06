<?php
	function nav_bar(){
		echo "
			<nav class='navbar navbar-inverse' id='nav'>
	            <div class='container-fluid' id='nav_content'>
	                <div class='navbar-header'>
	                    <img src='mastercard_logo.png' id='navLogo' class='grow'> </img>
	                </div>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.php'>SECURE</a></li>
                    </ul>";
        if (isset($_SESSION['logged_user'])){
        	$logged_name=$_SESSION['logged_user'];
            $url = 'index.php?logout=true';
            $click = 'Log-out';
            echo "
	            	<ul class='nav navbar-nav navbar-right'>
	            		<li><a href='#'>$logged_name</a></li>
	 					<li><a href='$url'>$click</a></li>
	    			</ul>
	            </div>
	        </nav>";
        }else{
        	echo "
        			<ul class='nav navbar-nav navbar-right'>
 						<li><a href='login.php''><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
    				</ul>
	            </div>
	        </nav>
        	";
        }
	}

    function get_login_form(){
        echo "<div class='modal-content' id='form_content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='myModalLabel'> Log-In (Inserting Chip card)</h4>
                </div>
                <div class='modal-body'>
                    <form method='POST'>
                        <div>
                            <div class='form-group'>
                                <label for='cardnumber' class='cardnumber'>Card Number: </label>
                                <input type='text' class='cardnumber form-control' name='cardnumber' placeholder='Enter Debit/Credit Card Number'>
                            </div>
                            <div class='form-group' id='password_div'>
                                <label for='password' class='password'>Password: </label>
                                <input type='password' class='password form-control' name='password' placeholder='Enter Password'> <br>
                            </div>
                            <input id='passSubmit' class='btn pull-right' type='submit' name='submit'>
                        </div>
                    </form>
                </div>
            </div>";
    }

    function add_form(){
        echo "<div id='add_form' method='POST'>";
        echo "<form method='POST'>";
        echo "
            <div class='form-group' >
            <label for='sel1'>Item:</label>
            <select class='form-control' id='sel1' name='item_id'>";
        get_item_options();
        echo "</select></div>";
        echo "
        <div class='form-group'>
            <label for='usr'>Amount:</label>
            <input type='text' class='form-control' id='usr' name='amount'>
        </div>";
        echo "<button type='submit' class='btn btn-default' name='add' value='add'>Add</button>";
        echo "</form>";
        echo "</div>";
    }

    function get_item_options(){
        require_once 'config.php';
        $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $result = $mysqli->query("SELECT * FROM Item INNER JOIN Category on Item.cid = Category.cid");
        while($row = $result->fetch_assoc()){
            $iid = $row['iid'];
            $item_name = $row['item_name'];
            echo "<option value=$iid>$item_name</option>";
        }
        
    }  
?>