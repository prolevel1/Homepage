
		<?php
			$name=$email=$mobileNum=$password=$repassword="";
			$nameError=$emailError=$mblError=$passwordError=$repasswordError="";
			require 'src\includes\connection.php';


			//function 
			function test_input($data) {
			  $data = trim($data); 		//strip unnecessary characters from users input(extra space,tab)
			  $data = stripslashes($data); //remove blackslashes \
			  $data = htmlspecialchars($data); //preventing from hacker
			  return $data;
			}			

			if ($_SERVER["REQUEST_METHOD"] == "POST") {

			  $name = test_input($_POST["full-name"]);
			  $email = test_input($_POST["mail"]);
			  $password = test_input($_POST["pwd"]);
			  $mobileNum = test_input($_POST["num"]);  
			  $repassword= test_input($_POST["pwd-repeat"]);



				//for full name validation
			  if (empty($name)) {
			    $nameError = "Name is required";
			    
			  }
			  elseif (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			     $nameError = "Only letters and white space allowed"; 
			    }
       			 //FOR EMAIL VALIDATION
	          if (empty($email)) {
	           $emailError = "Email is required";
	           } 
	           else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	            $emailError = "Invalid email format";
	           }			  
                  //FOR NUMBER VALIDATION
	           if (empty($mobileNum)) {
		          $mblError = "Phone number is required";
		          
		        }
	          //password
	           if (empty($password)) {
		          $passwordError = "password is required";
		        } 
		        elseif (strlen($_POST["pwd"])<6) {
		        	$passwordError="password must have 6 characters";	
		        }
		        //repassword
		        if (empty($repassword)) {
		          $repasswordError="retype your password";
		        }
		        elseif ($password!== $repassword) {
	          	  $repasswordError="password doesn't match";	          
	        	}
	        	else{
	            $hashedPwd = md5($password); //encryption method
	           
				$result="SELECT email from user where email='$email'";
				$resultuser="SELECT username from user where username='$name'";
		        $checkemail=mysqli_query($conn,$result);
		        $checkusername=mysqli_query($conn,$resultuser);
				if(mysqli_num_rows($checkemail)>0){
					$emailError="Email already taken";
					
					
				}elseif (mysqli_num_rows($checkusername)>0) {
					$nameError="Username is taken";
				}
				else{

		        $query = "INSERT INTO user(user_id,username,email,password,phone_number)VALUES ('','$name','$email','$hashedPwd','$mobileNum')";
				

				if($sql=mysqli_query($conn,$query)){
					header("Location:login.php");
					
				}
				else{
					echo "Error:".mysqli_error($conn);
				}
			  }
		}
		}
		?>


















<!DOCTYPE html>
<html>
<head>
    <title></title>    
</head>
<body>
<main>
	<style>
		.error{
			color: red;
		}
	</style>
	<body>


		<h1>Signup</h1>
		<p><span class="error">*Required field</span></p>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
			<input type="text" name="full-name" placeholder="Full name"> 
			<span class="error">*<?php echo $nameError;?></span>
			<br>
			<br>
			<input type="text" name="mail" placeholder="Email">
			<span class="error">*<?php echo $emailError;?></span>
			<br>
			<br>
            <input type="tel" name="num"placeholder="Mobile Number">
            <span class="error">*<?php echo $mblError;?></span>
            <br>
            <br>
			<input type="password" name="pwd" placeholder="Password">
			<span class="error">*<?php echo $passwordError;?></span>
			<br>
			<br>
			<input type="password" name="pwd-repeat" placeholder="Repeat Password">
			<span class="error">*<?php echo $repasswordError;?></span>
			<br>
			<br>
			<button type = "submit" name= "signup-submit">Signup</button>
			<a href="login.php">Login</a>
		</form>
	</body>
</main>
</head>

</html>
			
