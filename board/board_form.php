<!DOCTYPE html>
<html>

<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/css/common.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/board/board.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/css/normalize.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/css/slide.css">
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/js/vendor/modernizr.custom.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/js/vendor/jquery-1.10.2.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/js/main.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/board/board.js"></script>
</head>
<body> 
<header>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/myhome/header.php";?>
</header>
<?php
	//세션이용시 session_start(); 가 필요하지만 header.php에서 이미 하기 때문에 사용X
	//사용시 중복 오류가 뜨게 된다.
	if (!isset($_SESSION['userid']))
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
   	<div id="board_box">
	    <h3 id="board_title">
	    		게시판 > 글 쓰기
		</h3>
	    <form  name="board_form" method="post" action="board_dmi.php" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="insert">
	    	 <ul id="board_form">
				<li>
					<span class="col1">이름 : </span>
					<span class="col2"><?=$username?></span>
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
	    		<li>
			        <span class="col1"> 첨부 파일</span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">완료</button></li>
				<li><button type="button" onclick="location.href='board_list.php'">목록</button></li>
			</ul>
	    </form>
	</div> <!-- board_box -->
</section> 
<footer>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/myhome/footer.php";?>
</footer>
</body>
</html>
