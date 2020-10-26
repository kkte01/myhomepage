<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>김판우 사이트</title>
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/common.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/memo/message.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/slide.css">
<script src="../js/vendor/modernizr.custom.min.js"></script>
<script src="../js/vendor/jquery-1.10.2.min.js"></script>
<script src="../js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script src="../js/main.js"></script>
<script src="./notice.js"></script>
</head>
<body> 
<header>
	<?php include $_SERVER['DOCUMENT_ROOT']."/myHomepage/header.php";?>
</header>  
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
   	<div id="message_box">
	    <h3 id="write_title">
	    		공지사항 수정하기
		</h3>
<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/myHomepage/db/db_connector.php";
	$num  = $_GET["num"];

	//$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from notice where num=$num";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
	$name      = $row["name"];
	$subject    = $row["subject"];
	$content    = $row["content"];
?>		
	    <form  name="board_form" method="post" action="notice_update.php">
			<input type = "hidden" name="num" value="<?=$num?>">
			<input type = "hidden" name="name" value="<?=$name?>">
	    	<div id="write_msg">
	    	    <ul>
				<li>
					<span class="col1">작성자 : </span>
					<span class="col2"><?=$name?></span>
				</li>		
	    		<li>
	    			<span class="col1">제목 : </span>
	    			<span class="col2"><input name="subject" type="text" value="<?=$subject?>"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">글 내용 : </span>
	    			<span class="col2">
	    				<textarea name="content"><?=$content?></textarea>
	    			</span>
	    		</li>
	    	    </ul>
	    	    <button type="button" onclick="check_input()">수정하기</button>
	    	</div>
	    </form>
	</div> <!-- message_box -->
</section> 
<footer>
	<?php include $_SERVER['DOCUMENT_ROOT']."/myHomepage/footer.php";?>
</footer>
</body>
</html>
