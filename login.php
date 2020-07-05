<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to logout for while
if(isset($_SESSION["id"])){
	echo "you are log in";
    //header("location:logout.php");
    exit;
}
	$email=$password="";
	$emailError=$passError=$fail="";
	require 'src\includes\connection.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){

    
	$email = trim($_POST["mail"]);
    $password = trim($_POST["pwd"]);

	$hashPassword = md5($password);
    if(empty($email)){
    $emailError="Email is empty";

	}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$emailError = "Invalid email format";
	}

	if (empty($password)) {
	$passError="Password is empty";
	}
	else{
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$hashPassword'"; 
    $result = mysqli_query($conn,$sql);

	   	 if(mysqli_num_rows($result) > 0){
	 		while($row = mysqli_fetch_assoc($result)){
		   	//password correct start new session
		   	//session_start();
		   	//store data in session variable
		    header("Location:index.php");
		    $_SESSION["id"]=$row["user_id"];



		   }
		}
		else{
	   		$fail="Password and email doesn't match";
	   	
	   }


    
     
    }
    if(!empty($_POST["remember-me"])) {
	setcookie ("mail",$_POST["mail"],time()+ 3600);
	setcookie ("pwd",$_POST["pwd"],time()+ 3600);
	//echo "Cookies Set Successfuly";
    } else {
	setcookie("mail","");
	setcookie("pwd","");
	//echo "Cookies Not Set";
}

    

}

?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		.error{
			color: red;
		}
	</style>
</head>
<body>
			<p><span class="error">*Required field</span></p>
		<form method="POST" action="">  
			<input type="text" name="mail" placeholder="Email" value="<?php if(isset($_COOKIE["mail"])) { echo $_COOKIE["mail"]; } ?>"> 
			<span class="error">*<?php echo $emailError;?></span>
			<br>
			<br>
			<input type="text" name="pwd" placeholder="Password" value="<?php if(isset($_COOKIE["pwd"])) { echo $_COOKIE["pwd"]; } ?>">
			<span class="error">*<?php echo $passError;?></span>
			<br>
			<br>
			<span class="error"><?php echo "$fail";?></span>
			<br>
			<br>
	        <input type="checkbox" name="remember-me" id="checkbox">
	        <label for="remember">Remember me</label>
	        <br>
	        <a href="forgotpassword.php" class="forgotPassword" id="forgotPassword">Forgot Password?</a>
	        <br>
	        <br>
	        <button type = "submit" name= "login-submit">Login</button>
			<a href="signup.php">Signup</a>

</body>
</html>


