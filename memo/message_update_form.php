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
<script src="./message.js"></script>
<script>
  function check_input() {
      if (!document.message_form.subject.value)
      {
          alert("제목을 입력하세요!");
          document.message_form.subject.focus();
          return;
      }
      if (!document.message_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.message_form.content.focus();
          return;
      }
      document.message_form.submit();
   }
</script>
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
	    		답변 쪽지 수정하기
		</h3>
<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/myHomepage/db/db_connector.php";
	$num  = $_GET["num"];

	//$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from message where num=$num";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
	$send_id      = $row["send_id"];
	$rv_id      = $row["rv_id"];
	$subject    = $row["subject"];
	$content    = $row["content"];

	//$subject = "RE: ".$subject; 

	//$content = "> ".$content; 
	//$content = str_replace("\n", "\n>", $content);
	//$content = "\n\n\n-----------------------------------------------\n".$content;

	$result2 = mysqli_query($con, "select name from members where id='$rv_id'");
	$record = mysqli_fetch_array($result2);
	$send_name = $record["name"];
?>		
	    <form  name="message_form" method="post" action="message_update.php">
            <input type="hidden" name="send_id" value="<?=$send_id?>">
	    	<input type="hidden" name="rv_id" value="<?=$rv_id?>">
            <input type="hidden" name="num" value="<?=$num?>">
	    	<div id="write_msg">
	    	    <ul>
				<li>
					<span class="col1">보내는 사람 : </span>
					<span class="col2"><?=$userid?></span>
				</li>	
				<li>
					<span class="col1">수신 아이디 : </span>
					<span class="col2"><?=$send_name?>(<?=$rv_id?>)</span>
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
