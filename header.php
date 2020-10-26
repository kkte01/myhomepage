<script>
    function delete_check(){
        const value  = confirm("정말 탈퇴 하시겠습니까?");
        if(value){
            location.href = "http://<?=$_SERVER['HTTP_HOST']?>/member/member_out.php";
        }
    }
</script>
<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";
    if (isset($_SESSION["userpoint"])) $userpoint = $_SESSION["userpoint"];
    else $userpoint = "";
?>		
        <div id="top">
            <h3>
                <!-- 절대경로로 수정 -->
                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/myHomepage/index.php">김판우 사이트</a>
            </h3>
            <ul id="top_menu">  
<?php
    
    if(!$userid) {
?>                
                <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/member/member_form.php">회원 가입</a> </li>
                <li> | </li>
                <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/login/login_form.php">로그인</a></li>
                
<?php
    } else {
                $logged = $username."(".$userid.")님[Level:".$userlevel.", Point:".$userpoint."]";
                //$logged = "홍길동"."("."aaaa".")님[Level:"."9".", Point:"."100"."]";
?>
                <li><?=$logged?> </li>
                <li> | </li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/myHomepage/login/logout.php">로그아웃</a> </li>
                <li> | </li>
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/myHomepage/member/member_modify_form.php">정보 수정</a></li>
                <li> | </li>
                <li><a href="#" onclick="delete_check()">회원탈퇴</a></li>
<?php
    }
?>
<?php
    if($userlevel==1) {
?>
                <li> | </li>
                <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/admin/admin.php">관리자 모드</a></li>
<?php
    }
?>
            </ul>
        </div>
        <div id="menu_bar">
            <ul> 
                <!-- 절대경로로 수정 -->
                <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/myHomepage/index.php">HOME</a></li>
                <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/memo/message_form.php">쪽지 만들기</a></li>                                
                <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/board/board_list.php">게시판 가기</a></li>
                <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/free/list.php">답변형 게시판</a></li>
                <li><a href="http://<?=$_SERVER['HTTP_HOST']?>/myHomepage/image_free/list.php">이미지 게시판</a></li>
            </ul>
        </div>