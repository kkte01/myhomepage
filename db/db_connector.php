<?php
    //1. database의 시간 설정
    date_default_timezone_set("Asia/Seoul");
    //2. db 접속 및 오류 처리(db가 없을경우 db생성기능부여)
    $server_name = "127.0.0.1";
    $user_name = "root";
    $password = "123456";
    $db_flag = false;
    $con = mysqli_connect($server_name,$user_name,$password);
    if(!$con){
        //접속시 에러 메세지를 보여주는 함수
        die("connection faild".mysqli_connect_error());
    }
    //3. db 확인하기
    $query = "show databases";
    //쿼리문 실행 시 에러 메세지를 보여주는 함수
    $result=mysqli_query($con,$query) or die("Errors :".mysqli_error($con));
    while($row=mysqli_fetch_array($result)){
        if($row["Database"]=="sample"){
            $db_flag = true;
            break;
        }
    }
    //4. db가 없을경우 생성
    if($db_flag === false){
        $sql = "create database sample";
        $value = mysqli_query($con,$sql) or die("Errors : ".mysqli_error($con));
        if($value === true){
            echo"<script>alert('create db success');</script>";
        }
    }
    //5. db 접속하기($con에다가 db(sample)를 연결하기때문에 $con으로 사용해야한다.)
    $dbcon = mysqli_select_db($con,"sample") or die("Errors : ".mysqli_error($con));
    if(!$dbcon){
        echo"<script>alert('DB select error :'".mysqli_error($con).");</script>";
    }
    
    //alert 창을 주는 함수
    function alert_back($message){
        echo("
			<script>
			alert('{$message}');
			history.go(-1)
			</script>
			");
		exit;
    }
    //공백,백슬래쉬를 없애고 특수문자를 html화 해주는 함수
    function test_input($data){
        $data = trim($data);
	    $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES);
        
        return $data;
    }
?>