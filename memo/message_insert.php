<meta charset='utf-8'>
<?php

	include_once $_SERVER['DOCUMENT_ROOT']."/myHomepage/db/db_connector.php";
	//보낸 방식이 post이면 받고 아닐경우는 이전 페이지로 돌아간다.(대문자 유의 하기)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		//php에서의 검증
		if(!isset($_POST["send_id"])){
			alert_back("로그인후 이용해주세요");
		}
		if(!isset($_POST['rv_id'])){
			alert_back("rv_id 가 비어있습니다.");
		}
		if(!isset($_POST['subject'])){
			alert_back("subject 가 비어있습니다.");
		}
		if(!isset($_POST['content'])){
			alert_back("content 가 비어있습니다.");
		}
		
		$send_id = $_POST["send_id"];
		$rv_id = $_POST['rv_id'];
		$subject = $_POST['subject'];
		$content = $_POST['content'];
	}else{
		alert_back("action 방식이 틀립니다.");
	}
	test_input($subject);
	// $subject = trim($subject);
	// $subject = stripslashes($subject);
	// $subject = htmlspecialchars($subject, ENT_QUOTES);
	test_input($content);
	// $content = trim($content);
	// $content = stripslashes($content);
	// $content = htmlspecialchars($content, ENT_QUOTES);
	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	// if(!$send_id) {
	// 	alert_back("로그인 후 이용해 주세요!");
	// }

	//$con = mysqli_connect("localhost", "user1", "12345", "sample");
	//받는 사람이 멤버테이블에 실제로 존재하는지 점검
	$sql = "select * from members where id='$rv_id'";
	$result = mysqli_query($con, $sql);
	//레코드셋의 개수를 체크해서 저장한다.
	$num_record = mysqli_num_rows($result);

	if($num_record)
	{
		$sql = "insert into message (send_id, rv_id, subject, content,  regist_day) ";
		$sql .= "values('$send_id', '$rv_id', '$subject', '$content', '$regist_day')";
		mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
	} else {
		alert_back("수신 아이디가 잘못 되었습니다!");
	}

	mysqli_close($con);                // DB 연결 끊기

	echo "
	   <script>
	    location.href = 'message_box.php?mode=send';
	   </script>
	";
?>

  
