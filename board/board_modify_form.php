<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/common.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/board/board.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/normalize.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/slide.css">
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/js/vendor/modernizr.custom.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/js/vendor/jquery-1.10.2.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/js/main.js"></script>
<script src="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/board/board.js"></script>
<!-- <script>
  function check_input() {
      if (!document.board_form.subject.value)
      {
          alert("제목을 입력하세요!");
          document.board_form.subject.focus();
          return;
      }
      if (!document.board_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.board_form.content.focus();
          return;
      }
      document.board_form.submit();
   }
</script> -->
</head>
<body> 
<header>
	<?php include $_SERVER["DOCUMENT_ROOT"]."/myHomepage/header.php";?>
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
	    <h3 id="board_title">
	    		게시판 > 글 쓰기
		</h3>
<?php
	include_once $_SERVER['DOCUMENT_ROOT']."/myHomepage/db/db_connector.php";
	$num  = $_GET["num"];
	$page = $_GET["page"];
	
	//$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from board where num=$num";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$id = $row['id'];
	$name       = $row["name"];
	$subject    = $row["subject"];
	$content    = $row["content"];		
	$file_name  = $row["file_name"];
	
    //해당 글에 작성자가 아닐 때 수정 방어
    if(!isset($_SESSION['userid']) || $_SESSION['userid'] !== $id){
      mysqli_close($con);
      alert_back("수정 권한이 없습니다.");
    }
?>
	    <form  name="board_form" method="post" action="board_dmi.php" enctype="multipart/form-data">
	    	 <ul id="board_form">
			 <input type="hidden" name="mode" value="update">
			 <input type="hidden" name="num" value="<?=$num?>">
			 <input type="hidden" name="page" value="<?=$page?>">
			 <input type="hidden" name="id" value="<?=$id?>">
				<li>
					<span class="col1">이름 : </span>
					<span class="col2"><?=$name?></span>
				</li>		
	    		<li>
	    			<span class="col1">제목 : </span>
	    			<span class="col2"><input name="subject" type="text" value="<?=$subject?>"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">내용 : </span>
	    			<span class="col2">
	    				<textarea name="content"><?=$content?></textarea>
	    			</span>
	    		</li>
	    		<li>
			        <span class="col1"> 첨부 파일 : </span>
			        <span class="col2"><?=$file_name?></span>
			    </li>
				<li>
			        <span class="col1"> 파일 삭제 여부:</span>
			        <span class="col2"><input type="checkbox" name="delete" value="delete"></span>
			    </li>
				<li>
					<span class="col1"> 첨부 파일</span>
					<span class="col2"><input type="file" name="upfile"></span>
				</li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">수정하기</button></li>
				<li><button type="button" onclick="location.href='board_list.php'">목록</button></li>
			</ul>
	    </form>
	</div> <!-- board_box -->
</section> 
<footer>
<?php include $_SERVER["DOCUMENT_ROOT"]."/myHomepage/footer.php";?>
</footer>
</body>
</html>
