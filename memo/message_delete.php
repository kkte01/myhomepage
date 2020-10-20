<meta charset='utf-8'>

<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/myhome/db/db_connector.php";
	$num = $_GET["num"];

	$mode = $_GET["mode"];



	//$con = mysqli_connect("localhost", "user1", "12345", "sample");


	$sql = "delete from message where num=$num";

	mysqli_query($con, $sql);



	mysqli_close($con);                // DB 연결 끊기



	if(isset($mode))

		$url = "message_box.php?mode=$mode";

	// else

	// 	$url = "httpmessage_box.php?mode=rv";



	echo "

	<script>

		location.href = '$url';
	</script>

	";

?>

  
