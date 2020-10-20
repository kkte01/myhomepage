<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>김판우 사이트</title>
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/css/common.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/board/board.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/css/normalize.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myhome/css/slide.css">
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/js/vendor/modernizr.custom.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/js/vendor/jquery-1.10.2.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myhome/js/main.js"></script>
</head>
<body> 
<header>
	<?php include $_SERVER['DOCUMENT_ROOT']."/myhome/header.php";?>
</header>  
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
	    <h3 class="title">
			게시판 > 내용보기
		</h3>
<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/myhome/db/db_connector.php";
	$num  = $_GET["num"];
	$page  = $_GET["page"];

	//$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from notice where num=$num";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
	$id      = $row["id"];
	$name      = $row["name"];
	$regist_day = $row["regist_day"];
	$subject    = $row["subject"];
	$content    = $row["content"];
	$hit          = $row["hit"];

	$content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);
    if($id != $userid){
        $new_hit = $hit + 1;
	    $sql = "update notice set hit=$new_hit where num=$num";   
	    mysqli_query($con, $sql);
    }
	
?>		
	    <ul id="view_content">
			<li>
				<span class="col1"><b>제목 :</b> <?=$subject?></span>
				<span class="col2"><?=$name?> | <?=$regist_day?></span>
			</li>
			<li>
				<?=$content?>
			</li>		
	    </ul>
	    <ul class="buttons">
				<li><button onclick="location.href='notice_list.php?page=<?=$page?>'">목록</button></li>
                <?php 
                    if($userlevel == 1){                
                ?>
				<li><button onclick="location.href='notice_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
				<li><button onclick="location.href='notice_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
				<li><button onclick="location.href='notice_form.php'">글쓰기</button></li>
                <?php }
                    ?>
		</ul>
	</div> <!-- board_box -->
</section> 
<footer>
	<?php include $_SERVER['DOCUMENT_ROOT']."/myhome/footer.php";?>
</footer>
</body>
</html>
