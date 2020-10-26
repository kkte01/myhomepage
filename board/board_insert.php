<meta charset="utf-8">
<?php
	//DB 불러오기
	include_once $_SERVER["DOCUMENT_ROOT"]."/myHomepage/db/db_connector.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/myHomepage/db/create_table.php";
	//게시판 테이블 생성 함수
	create_table($con,"board");

    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";

    if ( !$userid )
    {
        echo("
                    <script>
                    alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
                    history.go(-1)
                    </script>
        ");
                exit;
    }

    $subject = $_POST["subject"];
    $content = $_POST["content"];
	$subject = test_input($subject);
	$content = test_input($content);
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
	if ($upfile_name && !$upfile_error)
	{	//파일을 내가 지정한 문자열을 기준으로 분리시키는 함수
		$file = explode(".", $upfile_name);
		$file_name = $file[0];
		$file_ext  = $file[1];
		//중복을 방지하려고 초까지 구해서 이름에 추가한다.
		$new_file_name = date("Y_m_d_H_i_s");
		$new_file_name = $new_file_name."_".$file_name; // 중복방지를 위해 파일이름(확장를 제외한)을 더 추가했다.
		$copied_file_name = $new_file_name.".".$file_ext;      
		$uploaded_file = $upload_dir.$copied_file_name; // <- ex) ./data/2020_09_23_10_50_20_00_memo.txt
		//echo"uploaded_file = $uploaded_file";
		//용량 크기 변경 원할 시  php.ini에서 upload 파일 최대크기를 변경해주면된다.
		if( $upfile_size  > 1000000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요!');
				history.go(-1)
				</script>
				");
				exit;
		}
		//파일을 저장하는 함수
		if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) )
		{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
		}
	}
	else 
	{
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
?>

  
