<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/myhome/db/db_connector.php";
    session_start();
    // if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    // else $userlevel = "";

    if ( $_SESSION['userlevel'] != 1 && isset($_SESSION["userlevel"]))
    {
        alert_back('관리자가 아닙니다! 회원 삭제는 관리자만 가능합니다!');
        // echo("
        //     <script>
        //     alert('관리자가 아닙니다! 회원 삭제는 관리자만 가능합니다!');
        //     history.go(-1)
        //     </script>
        // ");
        //         exit;
    }

    $num   = $_GET["num"];

    //$con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "delete from members where num = $num";
    mysqli_query($con, $sql);

    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'admin.php';
	     </script>
	   ";
?>

