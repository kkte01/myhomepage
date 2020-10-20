<?php
    if($_POST['mode'] === null){
        $_POST['mode'] = "insert";
    }

    if(isset($_POST['mode'])&&$_POST['mode']=="insert"){
        echo"
        <script>
            location.href='board_form.php';
        </script>";
    }
    if(){
        
    }
?>