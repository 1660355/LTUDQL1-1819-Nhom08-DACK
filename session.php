<?php
   include('config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   $ses_sql = mysqli_query($db,"select username from users where username = '$user_check' ");
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   $login_session = $row['username'];
   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
   }
   $ses_sql1 = mysqli_query($db,"select picture from users where username = '$user_check' ");
   $row1 = mysqli_fetch_array($ses_sql1,MYSQLI_ASSOC);
   $image_session = $row1['picture'];
   
   $ses_sql2 = mysqli_query($db,"select first_name from users where username = '$user_check' ");
   $row2 = mysqli_fetch_array($ses_sql2,MYSQLI_ASSOC);
   $fname_session = $row2['first_name'];
   
   $ses_sql3 = mysqli_query($db,"select last_name from users where username = '$user_check' ");
   $row3 = mysqli_fetch_array($ses_sql3,MYSQLI_ASSOC);
   $lname_session = $row3['last_name'];

   $ses_sql4 = mysqli_query($db,"select data from users where username = '$user_check' ");
   $row4 = mysqli_fetch_array($ses_sql4,MYSQLI_ASSOC);
   $date_session = $row4['data'];
   
   $ses_sql5 = mysqli_query($db,"select gender from users where username = '$user_check' ");
   $row5 = mysqli_fetch_array($ses_sql5,MYSQLI_ASSOC);
   $gender_session = $row5['gender'];
   
   $ses_sql_id_user = mysqli_query($db,"select id from users where username = '$user_check' ");
   $row6 = mysqli_fetch_array($ses_sql_id_user,MYSQLI_ASSOC);
   $id_user_session = $row6['id'];
   
?>