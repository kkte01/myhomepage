<?php
    //DB 불러오기
	include_once $_SERVER["DOCUMENT_ROOT"]."/myhome/db/db_connector.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/myhome/db/create_table.php";
	//게시판 테이블 생성 함수
    create_table($con,"board");
    if(!$_SERVER["REQUEST_METHOD"] == "POST"){
        alert_back("action 방식이 틀립니다.");
    }
    if(!$userlevel != 1){
        alert_back("관리자만 이용가능합니다!");
    }else{
        if(!isset($_POST["subject"])){
            alert_back("제목이 작성되어있지 않습니다!");
        }
        if(!isset($_POST["content"])){
            alert_back("내용이 작성되어있지 않습니다!");
        }
        session_start();
        $userid = $_SESSION["userid"];
        $username = $_SESSION["username"];
        $subject=$_POST["subject"];
        $content=$_POST["content"];
    }
    test_input($subject);
    test_input($content);

    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

    $sql = "insert into notice (id, name, subject, content, regist_day, hit) values('$userid','$username','$subject','$content','$regist_day',0)";
    mysqli_query($con,$sql);

    mysqli_close($con);                // DB 연결 끊기

    echo"<script>
    location.href = 'notice_list.php';
    </script>";
?>