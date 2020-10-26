<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/myHomepage/db/db_connector.php";
    $num   = $_GET["num"];
    $page   = $_GET["page"];

    //$con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "select * from board where num = $num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $copied_name = $row["file_copied"];
    $id = $row["id"];
    
    session_start();
    //해당 글에 작성자가 아닐 때 관리자가 아닐 때  삭제 방어
    //session 값은 무조건 문자열을 반환하기 때문에 관계식 설정을 ==으로 진행해야한다.
    if(!isset($_SESSION['userid']) || ($_SESSION['userlevel'] != 1 && $_SESSION['userid'] !== $id)){
      mysqli_close($con);
      alert_back("삭제 권한이 없습니다.");
    }
    
    
  
    //해당된 파일을 찾아 삭제
  if ($copied_name)
	{
		$file_path = "./data/".$copied_name;
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
	
?>

