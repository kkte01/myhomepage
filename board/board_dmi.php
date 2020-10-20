<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/myhome/db/db_connector.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/myhome/db/create_table.php";

if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
else $userid = "";
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else $username = "";



if (isset($_POST['mode']) && $_POST['mode'] == "insert") {
	create_table($con, "board");

	if (!$userid) {
		alert_back('게시판 글쓰기는 로그인 후 이용해 주세요!');
	}

	$subject = $_POST["subject"];
	$content = $_POST["content"];
	test_input($subject);
	test_input($content);
	// $subject = tmlspecialchars($subject, ENT_QUOTES)h;
	// $content = htmlspecialchars($content, ENT_QUOTES);

	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
	//저장할 파일 위치
	$upload_dir = './data/';
	//파일은 무조건 $_FILES로 들어와야한다.
	$upfile_name	 = $_FILES["upfile"]["name"]; //진짜 이름
	//서버 임시버퍼 장치에 업로드된 파일의 경로
	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"]; //클라이언트가 파일을 업로드시 서버 임시버퍼장치에 저장해놓은 이름
	$upfile_type     = $_FILES["upfile"]["type"];	//확장자
	$upfile_size     = $_FILES["upfile"]["size"];	//크기
	$upfile_error    = $_FILES["upfile"]["error"];	//에러
	//echo"upfile_tmp_name  = .$upfile_tmp_name <br>";
	//php 해석기에서의 거짓 0, false, null, "",'' 빼고는 다 참이다.
	if ($upfile_name && !$upfile_error) {	//파일을 내가 지정한 문자열을 기준으로 분리시키는 함수
		$file = explode(".", $upfile_name);
		$file_name = $file[0];
		$file_ext  = $file[1];
		//중복을 방지하려고 초까지 구해서 이름에 추가한다.
		$new_file_name = date("Y_m_d_H_i_s");
		$new_file_name = $new_file_name . "_" . $file_name; // 중복방지를 위해 파일이름(확장를 제외한)을 더 추가했다.
		$copied_file_name = $new_file_name . "." . $file_ext;
		$uploaded_file = $upload_dir . $copied_file_name; // <- ex) ./data/2020_09_23_10_50_20_00_memo.txt
		//echo"uploaded_file = $uploaded_file";
		//용량 크기 변경 원할 시  php.ini에서 upload 파일 최대크기를 변경해주면된다.
		if ($upfile_size  > 1000000) {
			alert_back('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요!');
			exit;
		}
		//파일을 저장하는 함수
		if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {	
			alert_back('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
			exit;
		}
	} else {
		$upfile_name      = "";
		$upfile_type      = "";
		$copied_file_name = "";
	}

	//$con = mysqli_connect("localhost", "user1", "12345", "sample");

	$sql = "insert into board (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
	$sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
	$sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

	// 포인트 부여하기
	$point_up = 100;

	$sql = "select point from members where id='$userid'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$new_point = $row["point"] + $point_up;

	$sql = "update members set point=$new_point where id='$userid'";
	mysqli_query($con, $sql);

	mysqli_close($con);                // DB 연결 끊기

	echo "
	   <script>
	    location.href = 'board_list.php';
	   </script>
	";
}else if (isset($_POST['mode']) && $_POST['mode'] == "update") {
	$num = $_POST["num"];
	$page = $_POST["page"];
	$checked = $_POST["delete"];
	$id = $_POST['id'];
	$subject = $_POST["subject"];
	$content = $_POST["content"];

	//해당 글에 작성자가 아닐 때 관리자가 아닐 때  삭제 방어
	if (!isset($_SESSION['userid']) || $_SESSION['userid'] !== $id) {
		mysqli_close($con);
		alert_back("수정 권한이 없습니다.");
	}
	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
	//저장할 파일 위치
	$upload_dir = './data/';
	//파일은 무조건 $_FILES로 들어와야한다.
	$upfile_name	 = $_FILES["upfile"]["name"]; //진짜 이름
	//서버 임시버퍼 장치에 업로드된 파일의 경로
	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"]; //클라이언트가 파일을 업로드시 서버 임시버퍼장치에 저장해놓은 이름
	$upfile_type     = $_FILES["upfile"]["type"];	//확장자
	$upfile_size     = $_FILES["upfile"]["size"];	//크기
	$upfile_error    = $_FILES["upfile"]["error"];	//에러
	//echo"upfile_tmp_name  = .$upfile_tmp_name <br>";
	//지우는 함수
	if ($checked === "delete") {
		$sql = "select * from board where num = $num";
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);

		$copied_name = $row["file_copied"];
		//업로드 된 파일을 지우는 함수
		if ($copied_name) {
			$file_path = "./data/" . $copied_name;
			unlink($file_path);
		}
	}
	//(isset($_POST['delete'])&& $checked === "delete" ) || 
	if ((isset($_POST['delete']) && $checked === "delete") || ($upfile_name && !$upfile_error)) {
		if ($upfile_name && !$upfile_error) {
			//파일을 내가 지정한 문자열을 기준으로 분리시키는 함수
			$file = explode(".", $upfile_name);
			$file_name = $file[0];
			$file_ext  = $file[1];
			//중복을 방지하려고 초까지 구해서 이름에 추가한다.
			$new_file_name = date("Y_m_d_H_i_s");
			$new_file_name = $new_file_name . "_" . $file_name; // 중복방지를 위해 파일이름(확장를 제외한)을 더 추가했다.
			$copied_file_name = $new_file_name . "." . $file_ext;
			$uploaded_file = $upload_dir . $copied_file_name; // <- ex) ./data/2020_09_23_10_50_20_00_memo.txt
			//echo"uploaded_file = $uploaded_file";
			//용량 크기 변경 원할 시  php.ini에서 upload 파일 최대크기를 변경해주면된다.
			if ($upfile_size  > 1000000) {
				alert_back('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!');
			}
			//파일을 저장하는 함수
			if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
				alert_back('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
			}
		} else {
			$upfile_name      = "";
			$upfile_type      = "";
			$copied_file_name = "";
		}
		$sql = "update board set subject='$subject', content='$content', regist_day='$regist_day',file_name='$upfile_name',file_type='$upfile_type',file_copied='$copied_file_name' ";
		$sql .= " where num=$num";
		mysqli_query($con, $sql);
	} else {
		$sql = "update board set subject='$subject', content='$content', regist_day='$regist_day'";
		$sql .= " where num=$num";
		mysqli_query($con, $sql);
	}


	// $sql = "update board set subject='$subject', content='$content', regist_day='$regist_day'";
	// $sql .= " where num=$num";
	// mysqli_query($con, $sql);
	mysqli_close($con);

	echo "
	      <script>
	          location.href = 'board_list.php?page=$page';
	      </script>
	  ";
}else if (isset($_POST['mode']) && $_POST['mode'] == "delete") {
	$num   = $_POST["num"];
	$page   = $_POST["page"];

	//$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from board where num = $num";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);

	$copied_name = $row["file_copied"];
	$id = $row["id"];

	session_start();
	//해당 글에 작성자가 아닐 때 관리자가 아닐 때  삭제 방어
	//session 값은 무조건 문자열을 반환하기 때문에 관계식 설정을 ==으로 진행해야한다.
	if (!isset($_SESSION['userid']) || ($_SESSION['userlevel'] != 1 && $_SESSION['userid'] !== $id)) {
		mysqli_close($con);
		alert_back("삭제 권한이 없습니다.");
	}



	//해당된 파일을 찾아 삭제
	if ($copied_name) {
		$file_path = "./data/" . $copied_name;
		unlink($file_path);
	}

	$sql = "delete from board where num = $num";
	mysqli_query($con, $sql);
	mysqli_close($con);

	echo "
	     <script>
	         location.href = 'board_list.php?page=$page';
	     </script>
	   ";
}
