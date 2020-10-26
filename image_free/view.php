<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/myHomepage/db/db_connector.php";
include $_SERVER['DOCUMENT_ROOT'] . "/myHomepage/free/lib/free_func.php";
$num = $id = $subject = $content = $day = $hit = $image_width = $q_num = "";
$file_type_0 = "";
if (empty($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}

if (isset($_GET["num"]) && !empty($_GET["num"])) {
  $num = test_input($_GET["num"]);
  $hit = test_input($_GET["hit"]);
  $q_num = mysqli_real_escape_string($con, $num);

  $sql = "UPDATE `image_free` SET `hit`=" . $hit . " where `num`= " . $q_num . ";";
  $result = mysqli_query($con, $sql);
  if (!$result) {
    die('Error update 1: ' . mysqli_error($con));
  }

  $sql = "SELECT * from `image_free` where num ='$q_num';";
  $result = mysqli_query($con, $sql);
  if (!$result) {
    die('Error: ' . mysqli_error($con));
  }
  $row = mysqli_fetch_array($result);
  $id = $row['id'];
  $name = $row['name'];
  // $nick=$row['nick'];
  $hit = $row['hit'];
  $subject = htmlspecialchars($row['subject']);
  $content = htmlspecialchars($row['content']);
  $subject = str_replace("\n", "<br>", $subject);
  $subject = str_replace(" ", "&nbsp;", $subject);
  $content = str_replace("\n", "<br>", $content);
  $content = str_replace(" ", "&nbsp;", $content);
  $is_html = $row['is_html'];
  $file_name_0 = $row['file_name_0'];
  $file_copied_0 = $row['file_copied_0'];
  $file_type_0 = $row['file_type_0'];
  $day = $row['regist_day'];

  //숫자 0 " " '0' null 0.0   $a = array()
  if (!empty($file_copied_0) && $file_type_0 == "image") {
    //이미지 정보를 가져오기 위한 함수 width, height, type
    $image_info = getimagesize("./data/" . $file_copied_0);
    $image_width = $image_info[0];
    $image_height = $image_info[1];
    $image_type = $image_info[2];
    if ($image_width > 400) $image_width = 400;
  } else {
    $image_width = 0;
    $image_height = 0;
    $image_type = "";
  }
}

?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/css/common.css">
  <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/free/css/greet.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/css/normalize.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/css/slide.css">
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/js/vendor/modernizr.custom.min.js"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/js/vendor/jquery-1.10.2.min.js"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/js/main.js"></script>

  <!-- <link rel="stylesheet" href="../css/memo.css"> -->
  <script type="text/javascript" src="./js/member_form.js?ver=1"></script>
  <title>김판우 사이트</title>
</head>

<body>
  <header>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/myHomepage/header.php"; ?>
  </header>
  <section>
  <div class="slideshow">
    <div class="slideshow_slides">
      <a href="#"><img src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/img/red1.png" alt="slide1"></a>
      <a href="#"><img src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/img/red2.png" alt="slide2"></a>
      <a href="#"><img src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/img/red3.png" alt="slide3"></a>
      <a href="#"><img src="http://<?= $_SERVER['HTTP_HOST'] ?>/myHomepage/img/red2.png" alt="slide4"></a>
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
          <h3>이미지 게시판</h3>
        </div>
        <div class="clear"></div>
        <div id="write_form_title"></div>
        <div class="clear"></div>
        <div id="write_form">
          <div class="write_line"></div>
          <div id="write_row1">
            <div class="col1">아이디</div>
            <div class="col2"><?= $id ?>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              조회 : <?= $hit ?> &nbsp;&nbsp;&nbsp; 입력날짜: <?= $day ?>
            </div>

          </div>
          <!--end of write_row1  -->
          <div class="write_line"></div>
          <div id="write_row2">
            <div class="col1">제&nbsp;&nbsp;목</div>
            <div class="col2"> <input type="text" name="subject" value="<?= $subject ?>" readonly></div>
          </div>
          <!--end of write_row2  -->
          <div class="write_line"></div>

          <div id="view_content">
            <div class="col2">
              <?php
              if ($file_type_0 == "image") {
                echo "<img src='./data/$file_copied_0' width='$image_width'><br>";
                $file_path = "./data/" . $file_copied_0;
                $file_size = filesize($file_path);
                //2. 업로드된 이름을 보여주고 [저장] 할것인지 선택한다.
                echo ("
                        ▷ 첨부파일 : $file_name_0 &nbsp; [ $file_size Byte ]
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href='download.php?mode=download&num=$q_num'>저장</a><br><br>
                      ");
              } else if (!empty($_SESSION['userid']) && !empty($file_copied_0)) {
                $file_path = "./data/" . $file_copied_0;
                $file_size = filesize($file_path);
                //2. 업로드된 이름을 보여주고 [저장] 할것인지 선택한다.
                echo ("
                        ▷ 첨부파일 : $file_name_0 &nbsp; [ $file_size Byte ]
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href='download.php?mode=download&num=$q_num'>저장</a><br><br>
                      ");
              }
              ?>
              <?= $content ?>
            </div>
            <!--end of col2  -->
          </div>
          <!--end of view_content  -->
        </div>
        <!--end of write_form  -->

        <!--덧글내용시작  -->
        <div id="ripple">
          <div id="ripple1">덧글</div>
          <div id="ripple2">
            <?php
            $sql = "select * from `image_free_ripple` where parent='$q_num' ";
            $ripple_result = mysqli_query($con, $sql);
            while ($ripple_row = mysqli_fetch_array($ripple_result)) {
              $ripple_num = $ripple_row['num'];
              $ripple_id = $ripple_row['id'];
              $ripple_nick = $ripple_row['name'];
              $ripple_date = $ripple_row['regist_day'];
              $ripple_content = $ripple_row['content'];
              $ripple_content = str_replace("\n", "<br>", $ripple_content);
              $ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
            ?>
              <div id="ripple_title">
                <ul>
                  <li><?= $ripple_nick . "&nbsp;&nbsp;" . $ripple_date ?></li>
                  <li id="mdi_del">
                    <?php
                    $message = free_ripple_delete($ripple_id, $ripple_num, 'dml_board.php', $page, $hit, $q_num);
                    echo $message;
                    ?>
                  </li>
                </ul>
              </div>
              <div id="ripple_content">
                <?= $ripple_content ?>
              </div>
            <?php
            } //end of while
            mysqli_close($con);
            ?>

            <form name="ripple_form" action="dml_board.php?mode=insert_ripple" method="post">
              <input type="hidden" name="parent" value="<?= $q_num ?>">
              <input type="hidden" name="hit" value="<?= $hit ?>">
              <input type="hidden" name="page" value="<?= $page ?>">
              <div id="ripple_insert">
                <input type="hidden" name="mode" value="insert_ripple">
                <div id="ripple_textarea"><textarea name="ripple_content" rows="3" cols="80"></textarea></div>
                <div id="ripple_button"> <input type="image" src="./img/memo_ripple_button.png"></div>
              </div>
              <!--end of ripple_insert -->
            </form>
          </div>
          <!--end of ripple2  -->
        </div>
        <!--end of ripple  -->

        <div id="write_button">
          <a href="./list.php?page=<?= $page ?>"><img src="./img/list.png"></a>

          <?php
          //관리자이거나 해당된 작성자일경우 수정, 삭제가 가능하도록 설정
          if ($_SESSION['userid'] == "admin" || $_SESSION['userid'] == $id) {
            echo ('<a href="./write_edit_form.php?mode=update&num=' . $num . '"><img src="./img/modify.png"></a>&nbsp;');
            echo ('<img src="./img/delete.png" onclick="check_delete(' . $num . ')">&nbsp;');
          }
          //로그인하는 유저에게 글쓰기 기능을 부여함.
          if (!empty($_SESSION['userid'])) {
            echo '<a href="write_edit_form.php"><img src="./img/write.png"></a>';
          }
          ?>
        </div>
        <!--end of write_button-->
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