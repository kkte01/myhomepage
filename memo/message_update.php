<meta charset='utf-8'>

<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/myhome/db/db_connector.php";
    $num = $_POST["num"];
    //$mode = $_GET["mode"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
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
		
		// $send_id = $_POST["send_id"];
		$rv_id = $_POST['rv_id'];
		$subject = $_POST['subject'];
		$content = $_POST['content'];
	}else{
		alert_back("action 방식이 틀립니다.");
    }
    test_input($subject);
    test_input($content);
    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
    //받는 사람이 멤버테이블에 실제로 존재하는지 점검
	$sql = "select * from members where id='$rv_id'";
	$result = mysqli_query($con, $sql);
	//레코드셋의 개수를 체크해서 저장한다.
    $num_record = mysqli_num_rows($result);
    if($num_record){
        $sql = "update message set subject='$subject',content='$content',regist_day='$regist_day' where num='$num'";
        mysqli_query($con,$sql);
    }else{
        alert_back("Error: ".mysqli_error($con));
    }
    mysqli_close($con);                // DB 연결 끊기

    echo "
	   <script>
	    location.href = 'message_box.php?mode=send';
	   </script>
	";
?>