<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/common.css">
<link rel="stylesheet" type="text/css" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/board/board.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/normalize.css">
<link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/css/slide.css">
<div id="board_box">
	    <h3>
	    	공지사항 > 목록보기
		</h3>
	    <ul id="board_list">
				<li>
					<span class="col1">번호</span>
					<span class="col2">제목</span>
					<span class="col3">글쓴이</span>
					<!-- <span class="col4">첨부</span> -->
					<span class="col5">등록일</span>
					<span class="col6">조회</span>
				</li>
<?php

	//include_once $_SERVER['DOCUMENT_ROOT']."/myHomepage/db/db_connector.php";
	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;

	$con = mysqli_connect("localhost", "root", "123456", "sample");
	$sql = "select * from notice order by num desc limit 5";
	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수

	$scale = 10;

	// 전체 페이지 수($total_page) 계산 
	if ($total_record % $scale == 0)     
		$total_page = floor($total_record/$scale);      
	else
		$total_page = floor($total_record/$scale) + 1; 
 
	// 표시할 페이지($page)에 따라 $start 계산  
	$start = ($page - 1) * $scale;      
 
	$number = $start+1;
	//$number = $total_record - $start;

   for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)
   {
      mysqli_data_seek($result, $i);
      // 가져올 레코드로 위치(포인터) 이동
      $row = mysqli_fetch_array($result);
      // 하나의 레코드 가져오기
	  $num         = $row["num"];
	  $id          = $row["id"];
	  $name        = $row["name"];
	  $subject     = $row["subject"];
      $regist_day  = $row["regist_day"];
      $hit         = $row["hit"];
?>
				<li>
					<span class="col1"><?=$number?></span>
					<span class="col2"><a href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/notice/notice_view.php?num=<?=$num?>&page=<?=$page?>"><?=$subject?></a></span>
					<span class="col3"><?=$name?></span>
					<span class="col5"><?=$regist_day?></span>
					<span class="col6"><?=$hit?></span>
				</li>	
<?php
		  //$number--;
		  $number++;
   }
   mysqli_close($con);

?>
	    	</ul>
  	
			<ul class="buttons">
				<li><button onclick="location.href='http:\\/\\/<?=$_SERVER['HTTP_HOST']?>/myHomepage/notice/notice_list.php'">목록</button></li>
				<li>
<?php 
    if($userlevel == 1) {
?>
					<button onclick="location.href='http:\\/\\/<?=$_SERVER['HTTP_HOST']?>/myHomepage/notice/notice_form.php'">글쓰기</button>
<?php
	} else {
?>
					<a href="javascript:alert('관리자만 이용가능합니다!')"><button>글쓰기</button></a>
<?php
	}
?>
				</li>
			</ul>
	</div> <!-- board_box -->