<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/myHomepage/db/db_connector.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/myHomepage/db/create_table.php";

create_table($con, 'image_free'); //자유게시판테이블생성
create_table($con, 'image_free_ripple'); //자유게시판덧글테이블생성
//상수 지정
define('SCALE', 10);
$memo_content = "";

if (isset($_POST["mode"]) && $_POST["mode"] == "search") {
	//제목, 내용, 아이디
	$find = test_input($_POST["find"]);
	$search = test_input($_POST["search"]);
	//보안을 위해 사용 injection 방지
	$q_search = mysqli_real_escape_string($con, $search);
	$sql = "SELECT * from `image_free` where $find like '%$q_search%' order by num desc;";
} else {
	$sql = "SELECT * from `image_free` order by num desc";
}

$result = mysqli_query($con, $sql);
$total_record = mysqli_num_rows($result);

$total_page = ($total_record % SCALE == 0) ? ($total_record / SCALE) : (ceil($total_record / SCALE));

//2.페이지가 없으면 디폴트 페이지 1페이지
if (empty($_GET['page'])) {
	$page = 1;
} else {
	$page = $_GET['page'];
}

$start = ($page - 1) * SCALE;
$number = $total_record - $start;
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/css/common.css">
	<link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/image_free/css/greet.css">
	<link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/css/normalize.css">
	<link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/css/slide.css">
	<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/js/vendor/modernizr.custom.min.js"></script>
	<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/js/vendor/jquery-1.10.2.min.js"></script>
	<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/js/main.js"></script>
	<script type="text/javascript" src="./js/member_form.js"></script>
	<title>김판우 사이트</title>
</head>

<body>
	<header>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "/myHomepage/header.php"; ?>
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

	<div id="wrap">
		<div id="content">
			<div id="col2">
				<div id="title">
					<h3>이미지 게시판 > 목록보기</h3>
				</div>
				<form name="board_form" action="list.php" method="post">
					<input type="hidden" name="mode" value="search">
					<div id="list_search">
						<div id="list_search1">총 <?= $total_record ?>개의 게시물이 있습니다.</div>
						<div id="list_search2"> <img src="./img/select_search.gif"></div>
						<div id="list_search3">
							<select name="find">
								<option value="subject">제목</option>
								<option value="content">내용</option>
								<!-- <option value="nick">별명</option> -->
								<option value="name">이름</option>
								<option value="id">아이디</option>
							</select>
						</div>
						<!--end of list_search3  -->
						<div id="list_search4"><input type="text" name="search"></div>
						<div id="list_search5"> <input type="image" src="./img/list_search_button.gif"></div>
					</div>
					<!--end of list_search  -->
				</form>
				<div id="clear"></div>
				<div id="list_top_title">
					<ul>
						<li id="list_title1"><img src="./img/list_title1.gif"></li>
						<li id="list_title2"><img src="./img/list_title2.gif"></li>
						<li id="list_title3"><img src="./img/list_title3.gif"></li>
						<li id="list_title4"><img src="./img/list_title4.gif"></li>
						<li id="list_title5"><img src="./img/list_title5.gif"></li>
					</ul>
				</div>
				<!--end of list_top_title  -->

				<div id="list_content">

					<?php
					for ($i = $start; $i < $start + SCALE && $i < $total_record; $i++) {
						mysqli_data_seek($result, $i);
						$row = mysqli_fetch_array($result);
						$num = $row['num'];
						$id = $row['id'];
						$name = $row['name'];
						$hit = $row['hit'];
						$date = substr($row['regist_day'], 0, 10);
						$subject = $row['subject'];
						$file_copied_0 = $row['file_copied_0'];
						$file_type_0 = $row['file_type_0'];
						$subject = str_replace("\n", "<br>", $subject);
						$subject = str_replace(" ", "&nbsp;", $subject);
						//숫자 0 " " '0' null 0.0   $a = array()
						if (!empty($file_copied_0) && $file_type_0 == "image") {
							//이미지 정보를 가져오기 위한 함수 width, height, type
							$image_info = getimagesize("./data/" . $file_copied_0);
							$image_width = $image_info[0];
							if ($image_width > 50) $image_width = 50;
							$image_height = $image_info[1];
							$image_type = $image_info[2];
							$image_name = "./data/".$file_copied_0;
						} else {
							//$image_width = 0;
							//$image_height = 0;
							//$image_type = "";
							$image_info = getimagesize("./img/gm_noimage.png");
							$image_width = $image_info[0];
							if ($image_width > 50) $image_width = 50;
							$image_height = $image_info[1];
							$image_type = $image_info[2];
							$image_name = './img/gm_noimage.png';
						}
						if ($row["file_name_0"])
							$file_image = "<img src='./img/file.gif'>";
						else
							$file_image = " ";
					?>
						<div id="list_item">
							<div id="list_item1"><?= $number ?></div>
							<div id="list_item2">
								<img src='<?= $image_name ?>' width='<?= $image_width ?>'>
								<a href="./view.php?num=<?= $num ?>&page=<?= $page ?>&hit=<?= $hit + 1 ?>"><?= $subject ?></a>
							</div>
							<div id="list_item3"><?= $file_image ?><?= $name ?></div>
							<div id="list_item4"><?= $date ?></div>
							<div id="list_item5"><?= $hit ?></div>
						</div>
						<!--end of list_item -->
						<div id="memo_content"><?= $memo_content ?></div>
					<?php
						$number--;
					} //end of for
					?>

					<div id="page_button">
						<div id="page_num">이전◀ &nbsp;&nbsp;&nbsp;&nbsp;
							<?php
							for ($i = 1; $i <= $total_page; $i++) {
								if ($page == $i) {
									echo "<b>&nbsp;$i&nbsp;</b>";
								} else {
									echo "<a href='./list.php?page=$i'>&nbsp;$i&nbsp;</a>";
								}
							}
							?>
							&nbsp;&nbsp;&nbsp;&nbsp;▶ 다음
							<br><br><br><br><br><br><br>
						</div>
						<!--end of page num -->
						<div id="button">
							<a href="./list.php?page=<?= $page ?>"> <img src="./img/list.png" alt="">&nbsp;</a>
							<?php //세션아디가 있으면 글쓰기 버튼을 보여줌.
							if (!empty($_SESSION['userid'])) {
								echo '<a href="write_edit_form.php"><img src="./img/write.png"></a>';
							}
							?>
						</div>
						<!--end of button -->
					</div>
					<!--end of page button -->
				</div>
				<!--end of list content -->

			</div>
			<!--end of col2  -->
		</div>
		<!--end of content -->
	</div>
	<!--end of wrap  -->
	</section>
			<footer>
				<?php include $_SERVER['DOCUMENT_ROOT']."/myHomepage/footer.php";?>
			</footer>
</body>

</html>