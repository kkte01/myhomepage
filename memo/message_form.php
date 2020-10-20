<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>김판우 사이트</title>
<!-- 절대경로로 찾아온다. -->
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/css/common.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/memo/message.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/css/slide.css">
<script src="../js/vendor/modernizr.custom.min.js"></script>
<script src="../js/vendor/jquery-1.10.2.min.js"></script>
<script src="../js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script src="../js/main.js"></script>
<script src="./message.js"></script>
</head>
<body>  
<header>
    <?php include $_SERVER['DOCUMENT_ROOT']."/myhome/header.php";?>
</header>  
<?php
//include 시 사용
include_once $_SERVER['DOCUMENT_ROOT']."/myhome/db/db_connector.php";
include_once $_SERVER['DOCUMENT_ROOT']."/myhome/db/create_table.php";

create_table($con,"message");
	if (!$userid )
	{
		echo("<script>
				alert('로그인 후 이용해주세요!');
				history.go(-1);
				</script>
			");
		exit;
	}
?>
<section>
<div class="slideshow">
        <div class="slideshow_slides">
            <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/img/red1.png" alt="slide1"></a>
            <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/img/red2.png" alt="slide2"></a>
            <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/img/red3.png" alt="slide3"></a>
            <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/img/red2.png" alt="slide4"></a>
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
   	<div id="message_box">
	    <h3 id="write_title">
	    		쪽지 보내기
		</h3>
		<ul class="top_buttons">
				<li><span><a href="message_box.php?mode=rv">수신 쪽지함 </a></span></li>
				<li><span><a href="message_box.php?mode=send">송신 쪽지함</a></span></li>
		</ul>
	    <form  name="message_form" method="post" action="./message_insert.php">
	    	<div id="write_msg">
	    	    <ul>
				<li>
					<span class="col1">보내는 사람 : </span>
					<!-- get방식을 post방식으로 변환 -->
					<span class="col2"><?=$userid?><input type="hidden" name="send_id" value="<?=$userid?>"></span>
				</li>	
				<li>
					<span class="col1">수신 아이디 : </span>
					<span class="col2"><input name="rv_id" type="text"></span>
				</li>	
	    		<li>
	    			<span class="col1">제목 : </span>
	    			<span class="col2"><input name="subject" type="text"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">내용 : </span>
	    			<span class="col2">
	    				<textarea name="content"></textarea>
	    			</span>
	    		</li>
	    	    </ul>
	    	    <button type="button" onclick="check_input()">보내기</button>
	    	</div>	    	
	    </form>
	</div> <!-- message_box -->
</section> 
<footer>
    <?php include $_SERVER['DOCUMENT_ROOT']."/myhome/footer.php";?>
</footer>
</body>
</html>
