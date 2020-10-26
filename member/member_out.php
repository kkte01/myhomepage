<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/myHomepage/db/db_connector.php";
    session_start();
    $id = $_SESSION['userid'];
    if($id){
        $query = "delete from members where id = '{$id}'";
        $result = mysqli_query($con,$query) or die("errors : ".mysqli_error($con));
        if($result){
            unset($_SESSION["userid"]);
            unset($_SESSION["username"]);
            unset($_SESSION["userlevel"]);
            unset($_SESSION["userpoint"]);
            echo
            "<script>
            alert('탈퇴에 성공했습니다.');
            location.href = '../index.php';
            </script>";
        }
    }else{
        echo"<script>
        alert('없는 아이디 입니다.');
        location.href = '../index.php';
        </script>";
    }
    
   
?>