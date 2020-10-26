<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/myHomepage/db/db_connector.php";
    $id = $_POST["id"];

    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];

    $email = $email1."@".$email2;
          
    //$con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "update members set pass='$pass', name='$name' , email='$email'";
    $sql .= " where id='$id'";
    $result = mysqli_query($con, $sql) or die("Error : ".mysqli_error($con));
    if($result){
            session_start();
            $_SESSION["username"] = $name;
    }else{
        echo "<script>alert('failed');
            history.go(-1);
        </script>";
    }
    mysqli_close($con);
    
    

    echo "
	      <script>
	          location.href = '../index.php';
	      </script>
	  ";
?>

   
