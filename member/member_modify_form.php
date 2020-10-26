<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>김판우 사이트</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="./member.css">
<link rel="stylesheet" href="../css/slide.css">
<script src="../js/vendor/modernizr.custom.min.js"></script>
<script src="../js/vendor/jquery-1.10.2.min.js"></script>
<script src="../js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script src="../js/main.js"></script>
<script type="text/javascript" src="./member_modify.js"></script>
</head>
<body> 
	<header>
    	<?php include $_SERVER["DOCUMENT_ROOT"]."/myHomepage/header.php";?>
    </header>
<?php    
    //$con = mysqli_connect("localhost", "root", "123456", "sample");
    include_once $_SERVER["DOCUMENT_ROOT"]."/myHomepage/db/db_connector.php";
    $sql    = "select * from members where id='$userid'";
    $result = mysqli_query($con, $sql);
    $row    = mysqli_fetch_array($result);

    $pass = $row["pass"];
    $name = $row["name"];
    //분리 시킨다. ""을 기준으로 배열로 반환
    $email = explode("@", $row["email"]);
    $email1 = $email[0];
    $email2 = $email[1];

    mysqli_close($con);
?>
	<section>
	<div class="slideshow">
        <div class="slideshow_slides">
            <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/img/red1.png" alt="slide1"></a>
            <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/img/red2.png" alt="slide2"></a>
            <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/img/red3.png" alt="slide3"></a>
            <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/img/red2.png" alt="slide4"></a>
        </div>
        <div class="slideshow_nav">
            <a href="#" class="prev">prev</a>
            <a href="#" class="next">next</a>
        </div>
        <div class="slideshow_indicator">
            <a href="#" class="active"></a>
            <a href="#"></a>
            <a href="#"></a>
            <a href="#"></a>
        </div>
</div>
        <div id="main_content">
      		<div id="join_box">
          	<form  name="member_form" method="post" action="./member_modify.php">
			    <h2>회원 정보수정</h2>
    		    	<div class="form id">
				        <div class="col1">아이디</div>
				        <div class="col2">
							<?=$userid?>
                            <input type = "hidden" name="id" value="<?=$userid?>">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>

			       	<div class="form">
				        <div class="col1">비밀번호</div>
				        <div class="col2">
							<input type="password" name="pass" value="<?=$pass?>">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">비밀번호 확인</div>
				        <div class="col2">
							<input type="password" name="pass_confirm" value="<?=$pass?>">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">이름</div>
				        <div class="col2">
							<input type="text" name="name" value="<?=$name?>">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form email">
				        <div class="col1">이메일</div>
				        <div class="col2">
							<input type="text" name="email1" value="<?=$email1?>">@<input 
							       type="text" name="email2" value="<?=$email2?>">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="bottom_line"> </div>
			       	<div class="buttons">
	                	<img style="cursor:pointer" src="../img/button_save.gif" onclick="check_input()">&nbsp;
                  		<img id="reset_button" style="cursor:pointer" src="../img/button_reset.gif"
							  onclick="reset_form()">
						<button onclick="history.go(-1)">이전 페이지</button>
	           		</div>
           	</form>
        	</div> <!-- join_box -->
        </div> <!-- main_content -->
	</section> 
	<footer>
	<?php include $_SERVER["DOCUMENT_ROOT"]."/myHomepage/footer.php";?>

    </footer>
</body>
</html>

