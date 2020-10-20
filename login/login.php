<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/myhome/db/db_connector.php";

    $id   = $_POST["id"];
    $pass = $_POST["pass"];

   //$con = mysqli_connect("localhost", "root", "123456", "sample");
   $sql = "select * from members where id='$id'";
   //$result에는 recordset을 저장
   $result = mysqli_query($con, $sql);
    //검증할 경우 isset이용하고 없을 경우
    //history.go() 또는 location.href =""로 이동가능하다.
    //history는 쓴 값이 그대로 있으나location은 없어진다.
   $num_match = mysqli_num_rows($result);

   if(!$num_match) 
   {
    //history.go(int); ex) -1이면 이전페이지로 이동한다. 
     echo("
           <script>
             window.alert('등록되지 않은 아이디입니다!')
             history.go(-1)
           </script>
         ");
    }
    else
    {   //map 방식으로 가져온다.
        $row = mysqli_fetch_array($result);
        $db_pass = $row["pass"];

        mysqli_close($con);

        if($pass != $db_pass)
        {

           echo("
              <script>
                window.alert('비밀번호가 틀립니다!')
                history.go(-1)
              </script>
           ");
           exit;
        }
        else
        {   //로그인시 세션을 저장
            session_start();
            $_SESSION["userid"] = $row["id"];
            $_SESSION["username"] = $row["name"];
            $_SESSION["userlevel"] = $row["level"];
            $_SESSION["userpoint"] = $row["point"];
            //index.php로 페이지를 이동시킨다.
            echo("
              <script>
                location.href = '../index.php';
              </script>
            ");
        }
     }        
?>