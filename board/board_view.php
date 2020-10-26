<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>김판우 사이트</title>
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/common.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/board/board.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/normalize.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/slide.css">
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/js/vendor/modernizr.custom.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/js/vendor/jquery-1.10.2.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/js/main.js"></script>
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
   	<div id="board_box">
	    <h3 class="title">
			게시판 > 내용보기
		</h3>
<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/myHomepage/db/db_connector.php";
	$num  = $_GET["num"];
	$page  = $_GET["page"];

	//$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from board where num=$num";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
	$id      = $row["id"];
	$name      = $row["name"];
	$regist_day = $row["regist_day"];
	$subject    = $row["subject"];
	$content    = $row["content"];
	$file_name    = $row["file_name"];
	$file_type    = $row["file_type"];
	$file_copied  = $row["file_copied"];
	$hit          = $row["hit"];

	$content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);
	//본인의 게시물 조회수증가 방어
	if($userid != $id){
		$new_hit = $hit + 1;
		$sql = "update board set hit=$new_hit where num=$num";   
		mysqli_query($con, $sql);
	}
	
?>		
	    <ul id="view_content">
			<li>
				<span class="col1"><b>제목 :</b> <?=$subject?></span>
				<span class="col2"><?=$name?> | <?=$regist_day?></span>
			</li>
			<li>
				<?php
					if($file_name) {
						$real_name = $file_copied;
						$file_path = "./data/".$real_name;
						$file_size = filesize($file_path);

						echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
			           	}
				?>
				<?=$content?>
			</li>		
	    </ul>
	    <ul class="buttons">
				<li><button onclick="location.href='board_list.php?page=<?=$page?>'">목록</button></li>
				<li><button onclick="location.href='board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
				<form action="board_dmi.php" method="post">
				<input type="hidden" name="mode" value="delete">
				<input type="hidden" name="num" value="<?=$num?>">
				<input type="hidden" name="page" value="<?=$page?>">
				<li><button>삭제</button></li>
				</form>
				<li><button onclick="location.href='board_form.php'">글쓰기</button></li>
		</ul>
	</div> <!-- board_box -->
</section> 
<footer>
	<?php include $_SERVER['DOCUMENT_ROOT']."/myHomepage/footer.php";?>
</footer>
</body>
</html>
