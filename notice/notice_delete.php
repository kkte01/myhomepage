<meta charset='utf-8'>

<?php
	include_once $_SERVER["DOCUMENT_ROOT"]."/myHomepage/db/db_connector.php";
    $num = $_GET["num"];
    
	//$con = mysqli_connect("localhost", "user1", "12345", "sample");


	$sql = "delete from notice where num=$num";

	mysqli_query($con, $sql);



	mysqli_close($con);                // DB 연결 끊기



	if(isset($num))

		$url = "notice_list.php";




	echo "

	<script>

		location.href = '$url';
	</script>

	";

?>