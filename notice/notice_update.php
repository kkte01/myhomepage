<meta charset='utf-8'>

<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/myhome/db/db_connector.php";
    $num = $_POST["num"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //php에서의 검증
	
		if(!isset($_POST['name'])){
			alert_back("작성자 가 비어있습니다.");
		}
		if(!isset($_POST['subject'])){
			alert_back("subject 가 비어있습니다.");
		}
		if(!isset($_POST['content'])){
			alert_back("content 가 비어있습니다.");
		}
		
		$name = $_POST["name"];
		$subject = $_POST['subject'];
		$content = $_POST['content'];
	}else{
		alert_back("action 방식이 틀립니다.");
    }
    test_input($subject);
    test_input($content);
    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

    $sql = "update notice set name='$name',subject='$subject',content='$content',regist_day='$regist_day' where num='$num'";
    mysqli_query($con,$sql);
    
    mysqli_close($con);                // DB 연결 끊기

    echo "
	   <script>
	    location.href = 'notice_list.php';
	   </script>
	";
?>