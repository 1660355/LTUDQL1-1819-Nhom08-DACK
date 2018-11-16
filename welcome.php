<?php
   include('session.php');
?>
<?php
  $postmsg = "";
  $chmsg = "";
  if (isset($_POST['uploadstatus'])) {
  	$postimage = $_FILES['postimage']['name'];
        $postimage_text = mysqli_real_escape_string($db, $_POST['image_text']);
  	$target2 = "img/".basename($postimage);
  	$query2 = "INSERT INTO status (id_user,picture,picture_text) VALUES ('$id_user_session','$postimage','$postimage_text')";
  	
        $resultedit=mysqli_query($db, $query2);

  	if (move_uploaded_file($_FILES['postimage']['tmp_name'], $target2)) {
  		$postmsg = "Image uploaded successfully";
  	}else{
  		$postmsg = "Failed to upload image";
  	}
  
  } 
  if (isset($_POST['edit'])) {
  	$chfimage = $_FILES['chimage']['name'];
        $target3 = "img/".basename($chfimage);
        $chfname = mysqli_real_escape_string($db, $_POST['chfirstname']);
        $chlname = mysqli_real_escape_string($db, $_POST['chlastname']);
        $chemail = mysqli_real_escape_string($db, $_POST['chemail']);
        $chdate = mysqli_real_escape_string($db, $_POST['chdate']);
        $chsex = mysqli_real_escape_string($db, $_POST['chsex']);
  	$query3 = "UPDATE users SET picture ='$chfimage',first_name='$chfname',last_name='$chlname',email='$chemail',data='$chdate',gender='$chsex' where id=$id_user_session";   
        $resultedit=mysqli_query($db, $query3);
  	if (move_uploaded_file($_FILES['chimage']['tmp_name'], $target3)) {
  		$chmsg = "Image uploaded successfully";
  	}else{
  		$chmsg = "Failed to upload image";
  	}
  
  }
    if(isset($_POST['showformadd'])){
         $idadd=substr( $_POST['showformadd'], 3);
         $resultadd=mysqli_query($db, "SELECT * FROM users where id =$idadd ");
         $rowadd = mysqli_fetch_array($resultadd);
        $queryadd = "INSERT INTO friends (id_user,id_friend,name_friend) VALUES ('$id_user_session','".$rowadd['id']."','".$rowadd['username']."')";
        mysqli_query($db, $queryadd);
                
    } 
    $result1 = mysqli_query($db, "SELECT * FROM status");
    $resultmypost=mysqli_query($db, "SELECT * FROM status where id_user=$id_user_session");
    $resultaddfriend=mysqli_query($db, "SELECT * FROM users WHERE id not in (SELECT id_friend FROM friends WHERE id_user=$id_user_session) and id !=$id_user_session");
    $resultlistfriend=mysqli_query($db, "SELECT * FROM friends where id_user = $id_user_session");
    
    
     
  	
  
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>FACEBOOK</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
  <script src="script.js"></script>
  <script>
      
var i = 1;	
$(document).ready(function(){
	$('.chat_head').click(function(){
		$('.chat_body').slideToggle('slow');
	});
	$('.msg_head').click(function(){
		$('#b'+$(this).attr('value')).slideToggle('slow');
                
	});
        
	$('.close').click(function(){
		$('#a'+$(this).attr('value')).hide();
		if(i > 1)
			i--;
	});
	$('.user').click(function(){
		$('#a'+$(this).attr('value')).show();
		$('#a'+$(this).attr('value')).attr('style', "right:" + (290 * i) + "px");
		if(i<6)
			i++;
		
		$('#b'+$(this).attr('value')).show();
	});
	$('textarea').keypress(function(e){
		if (e.keyCode == 13) {
			e.preventDefault();
			var msg = $(this).val();
			$(this).val('');
			if(msg!='')
			{
				chat.send(msg,$(this).attr('value'));
				$('#c'+$(this).attr('value')).scrollTop($('#c'+$(this).attr('value'))[0].scrollHeight);
			}
		}
    });
});
  </script>
  <style>
      @import url(https://fonts.googleapis.com/css?family=Cabin:400);
      
#img_div{
        width: 757px;
        margin-left: 55px;
   	padding: 5px;
   	margin: 10px auto;
   	border: 1px solid #cbcbcb;
        border-radius: 12px;
   }
   #img_div:after{
   	content: "";
   	display: block;
   	clear: both;
        
   }
   
.chat_box{
	position:fixed;
	right:20px;
	bottom:0px;
	width:250px;
        border-radius: 12px;
        border: 1px solid #333;
        background-image:url("danhba.gif");
}
.chat_body{
	background:white;
	height:400px;
	padding:5px 0px;
        overflow:auto;
	overflow-x: hidden;
}

.chat_head,.msg_head{
    height: 36px;
	background:#000;
	color:white;
	padding:15px;
	cursor:pointer;
	border-radius:5px 5px 0px 0px;
        padding-top: 8px;
        padding-left: 70px;
}

.msg_box{
        right: 235px;
	position:fixed;
	bottom:-5px;
	width:210px;
	background:white;
	border-radius:5px 5px 0px 0px;
        border: #000;
        
}

.msg_head{
        border: 0.5px solid #333;
}

.msg_body{
	background:white;
	height:200px;
	font-size:12px;
	padding:15px;
	overflow:auto;
	overflow-x: hidden;
}
.msg_input{
	width:100%;
	border: 1px solid white;
	border-top:1px solid #DDDDDD;
	-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
	-moz-box-sizing: border-box;    /* Firefox, other Gecko */
	box-sizing: border-box; 
        
        height: 40px;
}

.close{
	float:right;
	cursor:pointer;
}
.minimize{
	float:right;
	cursor:pointer;
	padding-right:5px;
	
}

.user{
	position:relative;
	padding:10px 30px;
}
.user:hover{
	background:#f8f8f8;
	cursor:pointer;

}
.user:before{
	content:'';
	position:absolute;
	background:#2ecc71;
	height:10px;
	width:10px;
	left:10px;
	top:15px;
	border-radius:6px;
}

.msg_a{
	position:relative;
	background:#FDE4CE;
	padding:10px;
	min-height:10px;
	margin-bottom:5px;
	margin-right:10px;
	border-radius:5px;
}
.msg_a:before{
	content:"";
	position:absolute;
	width:0px;
	height:0px;
	border: 10px solid;
	border-color: transparent #FDE4CE transparent transparent;
	left:-20px;
	top:7px;
}


.msg_b{
	background:#EEF2E7;
	padding:10px;
	min-height:15px;
	margin-bottom:5px;
	position:relative;
	margin-left:10px;
	border-radius:5px;
	word-wrap: break-word;
}
.msg_b:after{
	content:"";
	position:absolute;
	width:0px;
	height:0px;
	border: 10px solid;
	border-color: transparent transparent transparent #EEF2E7;
	right:-20px;
	top:7px;
}
      
      .button {
          width: 200px;
  display: inline-block;
  border-radius: 4px;
  background: #000;
  border: none;
  color: #FFFFFF;
  text-align: center;
  transition: all 0.5s;
  cursor: pointer;
}
.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
/*      ////////////////////////*/


.webdesigntuts-workshop {
	background: #151515;
	height: 100%;
	position: absolute;
	text-align: center;
	width: 100%;
}

.webdesigntuts-workshop:before,
.webdesigntuts-workshop:after {
	display: block;	
	height: 1px;
	left: 50%;
	margin: 0 0 0 -400px;
	position: absolute;
	width: 800px;
}

.webdesigntuts-workshop:before {
	background: #444;
	background: linear-gradient(left, #151515, #444, #151515);
}

.webdesigntuts-workshop:after {
	background: #000;
	background: linear-gradient(left, #151515, #000, #151515);	
	top: 191px;
}

.webdesigntuts-workshop form {
	background: #111;
	background: linear-gradient(#1b1b1b, #111);
	border: 1px solid #000;
	border-radius: 5px;
	box-shadow: inset 0 0 0 1px #272727;
	display: inline-block;
	font-size: 0px;
	margin: 150px auto 0;
	padding: 20px;
	position: relative;
	z-index: 1;
}

.webdesigntuts-workshop input {
	background: #222;	
	background: linear-gradient(#333, #222);	
	border: 1px solid #444;
	border-radius: 5px 0 0 5px;
	box-shadow: 0 2px 0 #000;
	color: #888;
	display: block;
	float: left;
	font-family: 'Cabin', helvetica, arial, sans-serif;
	font-size: 13px;
	font-weight: 400;
	height: 30px;
	margin: 0;
	padding: 0 10px;
	text-shadow: 0 -1px 0 #000;
	width: 200px;
}

.ie .webdesigntuts-workshop input {
	line-height: 30px;
}

.webdesigntuts-workshop input::-webkit-input-placeholder {
   color: #888;
}

.webdesigntuts-workshop input:-moz-placeholder {
   color: #888;
}

.webdesigntuts-workshop input:focus {
	-webkit-animation: glow 800ms ease-out infinite alternate;
	        animation: glow 800ms ease-out infinite alternate;
	background: #222922;
	background: linear-gradient(#333933, #222922);
	border-color: #393;
	box-shadow: 0 0 5px rgba(0,255,0,.2), inset 0 0 5px rgba(0,255,0,.1), 0 2px 0 #000;
	color: #efe;
	outline: none;
}

.webdesigntuts-workshop input:focus::-webkit-input-placeholder { 
	color: #efe;
}

.webdesigntuts-workshop input:focus:-moz-placeholder {
	color: #efe;
}

.webdesigntuts-workshop button {
	background: #222;
	background: linear-gradient(#333, #222);
	box-sizing: border-box;
	border: 1px solid #444;
	border-left-color: #000;
	border-radius: 0 5px 5px 0;
	box-shadow: 0 2px 0 #000;
	color: #fff;
	display: block;
	float: left;
	font-family: 'Cabin', helvetica, arial, sans-serif;
	font-size: 13px;
	font-weight: 400;
	height: 30px;
	line-height: 30px;
	margin: 0;
	padding: 0;
	position: relative;
	text-shadow: 0 -1px 0 #000;
	width: 80px;
}	

.webdesigntuts-workshop button:hover,
.webdesigntuts-workshop button:focus {
	background: #292929;
	background: linear-gradient(#393939, #292929);
	color: #5f5;
	outline: none;
}

.webdesigntuts-workshop button:active {
	background: #292929;
	background: linear-gradient(#393939, #292929);
	box-shadow: 0 1px 0 #000, inset 1px 0 1px #222;
	top: 1px;
}

@-webkit-keyframes glow {
    0% {
		border-color: #393;
		box-shadow: 0 0 5px rgba(0,255,0,.2), inset 0 0 5px rgba(0,255,0,.1), 0 2px 0 #000;
    }	
    100% {
		border-color: #6f6;
		box-shadow: 0 0 20px rgba(0,255,0,.6), inset 0 0 10px rgba(0,255,0,.4), 0 2px 0 #000;
    }
}

/*     /////////////////////////////////////////////// */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    .row.content {height: 450px}
    .sidenav {
      padding-top: 20px;
      background-color: #888;
      height: 100%;
    }
    footer {
      background-color: #888;
      color: white;
      padding: 15px;
    }
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
    #text{
    width: 756px;
     height: 80px;
     border-radius: 12px;
    }
    .fileContainer {
    overflow: hidden;
    position: relative;
}

.fileContainer [type=file] {
    cursor: inherit;
    display: block;
    font-size: 999px;
    filter: alpha(opacity=0);
    min-height: 100%;
    min-width: 100%;
    opacity: 0;
    position: absolute;
    right: 0;
    text-align: right;
    top: 0;
}
  </style>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div style="background: #393939;" class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <div><img src="002-comment.png" style="margin-top: 15px; margin-right: 10px;"></div>
    </div>
    <div  class="collapse navbar-collapse" id="myNavbar" >
      <ul class="nav navbar-nav">
        <li style="margin-top: 5px;">
            <section class="webdesigntuts-workshop">
                <form action="" method="post" style="padding-right: 0px;padding-left: 0px;padding-top: 0px;padding-bottom: 0px;height: 30px; width: 200px; margin-top: 10px;">	    	    
                    <input type="text" name="searchfriend" placeholder="What are you looking for?" required>		    	
                    <input style="margin-left: 600px; width: 80px;" type="submit" name="search" value="Search" required>
                </form>
            </section>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right" >
        <li style="margin-top: 5px;"><a href="welcome.php"><b>WELCOME <?php echo $login_session; ?></b></a></li>
        <li><a href="#"><img src="house.png"></a></li>
        <li><a href="#"><img src="gear.png"></a></li>
        <li style="margin-top: 5px;"><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> LogOut</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid text-center" style="height: auto; background: #888;">    
    <div class="row content">
        <div class="col-sm-2 sidenav" style="height: auto;">
            <p style="font-weight: bold;"><h4>THÔNG TIN TÀI KHOẢN</h4></p>
        <label><cite>Avatar</cite></label><p><img src="<?php echo "./img/"."$image_session"; ?> " style="width: 200px; height: 150px;"></p>
            <label  style="float: left;"><cite>First Name: <?php echo $fname_session ?></cite></label>
            <label style="float: left;"><cite>Last Name:  <?php echo $lname_session ?></cite></label>
            <label style="float: left;"><cite>Birth Day:  <?php echo $date_session ?></cite></label>
            <label style="float: left;"><cite>Gender:  <?php echo $gender_session ?></cite></label><br>
            <form style="color: #ffffff; position: fixed; margin-top: 90px;" action="" method="post">
                <div style="margin-bottom: 20px; color: #333;"><h4><b> CÔNG CỤ</b> </h4> </div>
                <input style="background-color: #000; width: 180px; margin-bottom: 5px; left: 10px; border-radius: 12px; height: 42px;"  type="submit" name="change" value="Chỉnh sửa thông tin" required><br>
                <input style="background-color: #000; width: 180px; margin-bottom: 5px; left: 10px; border-radius: 12px; height: 42px;"  type="submit" name="viewmypost" value="Xem bài viết cá nhân" required><br>
                <input style="background-color: #000; width: 180px; margin-bottom: 5px; left: 10px; border-radius: 12px; height: 42px;"  type="submit" name="viewfriendspost" value="Xem bài viết trang chủ" required>
            </form>
        </div>
        <div style="padding-right: 0px; padding-left: 0px;" class="col-sm-8 text-left"> 
            <div style="border-radius: 12px; margin: 5px; border-color: #4E4D4B;" class="panel panel-info">
                <div style="background-color: #4E4D4B; color: #fff; height: 30px; padding-top: 3px;" class="panel-heading">
                    <div style="" class="panel-title">TẠO BÀI ĐĂNG</div>
                </div>     
                <div style="padding: 0px; height: 120px;" class="panel-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div>
                            <div style=" float: left; width: 50px; margin-top: 20px;  margin-right: 5px; margin-left: 5px;"><img src="<?php echo "./img/"."$image_session"; ?>" alt="Avatar" style="width:50px; border-radius: 50%;"></div>          
                            <div style="margin-top: 5px; ">
                                <textarea wrap="off" id="text" cols="30" rows="4" name="image_text" placeholder="Say something about this image..." required></textarea>  
                                <div style="float: left; margin-left: 55px;"><label class="fileContainer"> Chọn hình<input type="file" name="postimage" required/> </label> <img style="margin-left: 5px;margin-bottom: 20px;" src="picture.png" ></div>
                                <div style="float: right; margin-right: 40px;"><input style="width:100px;  margin-bottom: 5px; border-radius: 12px; background-color: #4E4D4B; color: #FFFFFF; cursor: pointer;" type="submit" name="uploadstatus" value="Đăng bài"  required></div>
                            </div>
                        </div> 
                    </form>
                </div>                     
            </div>
            <div style="border-radius: 12px; margin: 5px; border-color: #4E4D4B;" class="panel panel-info">
                <div style="background-color: #4E4D4B; color: #fff; padding-top: 3px;" class="panel-heading">
                    <div style="" class="panel-title">BÀI ĐĂNG</div>
                </div>     
                <div style="    width: 886px; padding: 0px;" class="panel-body">
                    
                    <?php
                    
                    if(isset($_POST['viewmypost'])){
                            
                            while ($row = mysqli_fetch_array($resultmypost)) {
                            echo "<div id='img_div'>";
                            echo "<img style=' float: left; margin: 5px; width: 220px; height: 140px;'  src='img/".$row['picture']."' >";
                            echo "<p>".$row['picture_text']."</p>";
                            echo "</div>";
                            }
                        }
                        else if(isset($_POST['search'])){
                            $namesearch=mysqli_real_escape_string($db, $_POST['searchfriend']);
                            $resultsearch=mysqli_query($db, "SELECT * FROM users WHERE username LIKE '%$namesearch%' ");
                            while ($rowsearch = mysqli_fetch_array($resultsearch)) {
                            echo "<div style=' font-weight: bold;' id='img_div'>";
                            echo "<div style='float:left; '>";
                            
                            echo "User Name:".$rowsearch['username']."<br>";
                            echo "First:".$rowsearch['first_name']." "."Last Name :".$rowsearch['last_name']."<br>";
                            echo "Birth Day:".$rowsearch['data']."<br>";
                            echo "Gender:".$rowsearch['gender']."<br>";
                            echo "<form method='post' action=''>";
                            echo  "<input style='margin-top:20px; border-radius:12px;' type='submit' name='addsearch' value='Thêm bạn'>";
                            echo "</form>";
                            echo "</div>";
                            echo "<div style='float:right;'>";
                            echo "Avatar:". "<img style=' margin: 5px; width: 220px; height: 140px;' src='img/".$rowsearch['picture']."' >";
                            echo "</div>";
                            echo "</div>";
                            }
                        }
                     else if(isset($_POST['change'])){
                        include 'form_change.php';
                        }
                     else if(isset($_POST['viewfriendspost'])){
                         while ($row = mysqli_fetch_array($result1)) {
                            echo "<div id='img_div'>";
                            echo "<img style='float: left; margin: 5px; width: 220px; height: 140px;'  src='img/".$row['picture']."' >";
                            echo "<p>".$row['picture_text']."</p>";
                            echo "</div>";
                            }
                     }
                        else {
                         echo "<img src='baidang.png'>";
                        }
                     
                    ?>
                </div>                     
            </div>
            

        </div>
        <div class="col-sm-2 sidenav" style="height: 720px;
    padding-top: 5px;    padding-left: 7px;">
  
            <div style=" overflow:auto; overflow-x: hidden; width: 220px; height: 220px; border-radius: 12px; border-color: #4E4D4B;" class="panel panel-info">
                <div style="background-color: #000; color: #fff; padding-top: 3px;" class="panel-heading">
                    <div style=" height: 16px;" class="panel-title">KẾT BẠN</div>
                </diV>
                <div style="padding-bottom: 50px; height:70px; text-align: left; margin-left: 5px;" class="panel-body">
                    <form method="post" action="">
                        <?php
                        while ($rowadfriend = mysqli_fetch_array($resultaddfriend)) {
                            echo "<input style='padding-left: 5px; border-radius: 12px; margin-top: 5px; border-left-width: 0px;padding-left: 0px; width: 40px; height: 36px;' type='submit' name='showformadd' VALUE='add".$rowadfriend['id']."'><img src='./img/".$rowadfriend['picture']."' alt='Avatar' style='margin-bottom: 5px; width:35px; border-radius: 50%;' required>"."<span style='margin-bottom: 25px;'>".$rowadfriend['username']."</span>"."<br>";
                        }
                        ?>
                    </form>
                </div>                     
            </div>
            
        </div>
  </div>
</div>
        <div  style="    left: 1130px; width: 210px; height: 360px;" class="chat_box" >
                <div class="chat_head">DANH BẠ</div>
                <div class="chat_body">
                    <?php
                        while ($rowlistfriend = mysqli_fetch_array($resultlistfriend)) {
                            echo "<div class='user' value='".$rowlistfriend['id']."' >". $rowlistfriend['name_friend']."</div>";
                           
                        }
                    ?>
        </div>
        </div>
        <?php
        while ($rowlistfriend = mysqli_fetch_array($resultlistfriend)) {
         ?>
            <div class="msg_box" id="a<?php echo $rowlistfriend['id'] ?>" style="right:290px; border: #000;">
                <div class="msg_head" value="<?php echo $rowlistfriend['id'] ?>"><?php echo $rowlistfriend['name_friend'] ?>
                    <div class="close" value="<?php echo $rowlistfriend['id'] ?>">x</div>
                </div>
                <div class="msg_wrap" id="b<?php echo $rowlistfriend['id'] ?>">
                    <div class="msg_body" id="c<?php echo $rowlistfriend['id'] ?>" value="<?php echo $rowlistfriend['id'] ?>">
                            <div class="msg_a">This is from A	</div>
                            <div class="msg_b">This is from B, and its amazingly kool nah... i know it even i liked it :)</div>
                            <div class="msg_a">Wow, Thats great to hear from you man </div>	
                            <div class="msg_push" id="d<?php echo $rowlistfriend['id'] ?>"></div>
                    </div>
                    <div class="msg_footer"><textarea class="msg_input" rows="4" value="<?php echo $rowlistfriend['id'] ?>"></textarea></div>
                </div>
            </div>
    <?php
        }
    ?>
</body>
</html>
