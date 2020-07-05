<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<main>
  <style>
    .error{
      color: red;
    }
  </style>
  <body>
    <?php
      //require 'src\includes\connection.php';
      $name=$email=$mobileNum=$password=$repassword="";
      $nameError=$emailError=$mblError=$passwordError=$repasswordError="";

      //function 
      function test_input($data) {
        $data = trim($data);    //strip unnecessary characters from users input(extra space,tab)
        $data = stripslashes($data); //remove blackslashes \
        $data = htmlspecialchars($data); //preventing from hacker
        return $data;
      }     

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $email = test_input($_POST["mail"]);
        $mobileNum = test_input($_POST["num"]);
        $password = test_input($_POST["pwd"]);
        $repassword= test_input($_POST["pwd-repeat"]);



        //for full name validation
        if (empty($_POST["full-name"])) {
          $nameError = "Name is required";
          exit();
        }
        $name = test_input($_POST["full-name"]); 
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameError = "Only letters and white space allowed";
            exit();
          }
        //FOR EMAIL VALIDATION
         if (empty($_POST["email"])) {
          $emailError = "Email is required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format";
            exit();
          }
          //FOR NUMBER VALIDATION
         if (empty($_POST["num"])) {
          $phnError = "Phone number is required";
          exit();
        }
          //password
          if (empty($_POST["pwd"]) || empty($_POST["pwd-repeat"])) {
          $passwordError = "password is required";
        } elseif ($password!== $repassword) {
          $repasswordError="password doesn't match";
          exit();
        }
          


        

        
      }

      ?>

    <h1>Signup</h1>
    <p><span class="error">*Required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
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
    </form>


</body>
</main>
</html>