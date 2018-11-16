
<?php
   include "src/header.php";
   include("config.php"); 
   session_start();
  
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      if(isset($_POST['login'])){
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      $sql = "SELECT id FROM users WHERE username = '$myusername' and passcode = '$mypassword'";
              
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);   
      $active = $row['active'];
      $count = mysqli_num_rows($result);
            if($count == 1) {
              $_SESSION['login_user'] = $myusername;  
               header("location: welcome.php");
            }else {
               $error ="Your Login Name or Password is incorrect!";
            }
        }
        
   }
?>
<?php
    $username = "";
    $email    = "";
    $errors = array(); 
    $msg = "";
    if (isset($_POST['create'])) {
        $username = mysqli_real_escape_string($db, $_POST['username1']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
        $date = mysqli_real_escape_string($db, $_POST['date']);
        $gender = mysqli_real_escape_string($db, $_POST['sex']);
        $image = $_FILES['image']['name'];
        $target = "img/".basename($image);
        $password_1 = mysqli_real_escape_string($db, $_POST['password1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['repassword']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
        if ($password_1 != $password_2) {
              array_push($errors, "The two passwords do not match");
        }
        $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        if ($user) { // if user exists
          if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
          }
          if ($user['email'] === $email) {
            array_push($errors, "email already exists");
          }
        }
        if (count($errors) == 0) {
            $password = $password_1;
            $query = "INSERT INTO users (username, email, passcode,first_name,last_name,data,gender,picture) "
                    . "VALUES('$username', '$email', '$password','$firstname','$lastname','$date','$gender','$image')"; 
            mysqli_query($db, $query);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }
        mysqli_query($db, $sql);
    }     
    $result = mysqli_query($db, "SELECT * FROM users");
?>
<div style="background: #4E4D4B;" class="fb-header">
    <div style="background: #4E4D4B;" id="img1" class="fb-header"><img src="img/facebook.png"></div>
	<?php 
	   include 'form_login.php';
	?>
</div>
<div class="fb-body" style="margin-top: 20px; height: 500px;">
      <?php
            include 'form_register.php';
 	?>
 </div>


