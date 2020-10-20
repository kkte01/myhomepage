<?php
    function create_table($con,$table_name){
        $flag = false;
        $sql = "show tables from sample";
        $result = mysqli_query($con,$sql) or die("실패원인 : ".mysqli_error($con));
        //반복문을 통해서 레코드셋의 값을 첫번째 필드명을 하나씩 가져와 비교를 한다.
        while($row = mysqli_fetch_row($result)){
            if($row[0]==="$table_name"){
                $flag = true;
            break;
            }
        }
        //flag 값을 이용해 case중 맞는 테이블 명이 있으면 그에따른 기능을 작동한다.
        if($flag == false){
            switch($table_name){
                case "members":
                $sql = "CREATE TABLE `members` (
                    `num` int(11) NOT NULL AUTO_INCREMENT,
                    `id` char(15) NOT NULL,
                    `pass` char(15) NOT NULL,
                    `name` char(10) NOT NULL,
                    `email` char(80) DEFAULT NULL,
                    `regist_day` char(20) DEFAULT NULL,
                    `level` int(11) DEFAULT NULL,
                    `point` int(11) DEFAULT NULL,
                    PRIMARY KEY (`num`)
                  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;";
                break;
                case "message": 
                    $sql = "CREATE TABLE `message`(
                        `num` int NOT NULL auto_increment,
                        `send_id` char(20) NOT NULL,
                        `rv_id` char(20) NOT NULL,
                        `subject` char(200) NOT NULL,
                        `content` text NOT NULL,
                        `regist_day` char(20),
                        primary key(`num`)
                        )ENGINE= InnoDB DEFAULT CHARSET=utf8;
                    ;";
                break;
                case"board": $sql = "CREATE TABLE `board`(
                    `num` int not null auto_increment,
                    `id` char(15) not null,
                    `name` char(10) not null,
                    `subject` char(200) not null,
                    `content` text not null,
                    `regist_day` char(20) not null,
                    `hit` int not null,
                    `file_name` char(40),
                    `file_type` char(40),
                    `file_copied` char(40),
                    primary key(`num`)
                )ENGINE= InnoDB DEFAULT CHARSET=utf8;";
                break;
                case 'free' :
                    $sql = "CREATE TABLE `free` (
                    `num` int(11) NOT NULL AUTO_INCREMENT,
                    `id` char(15) NOT NULL,
                    `name` char(10) NOT NULL,
                    `nick` char(10) NOT NULL,
                    `subject` varchar(100) NOT NULL,
                    `content` text NOT NULL,
                    `regist_day` char(20) DEFAULT NULL,
                    `hit` int(11) DEFAULT NULL,
                    `is_html` char(1) DEFAULT NULL,
                    `file_name_0` char(40) DEFAULT NULL,
                    `file_copied_0` char(30) DEFAULT NULL,
                    `file_type_0` char(30) DEFAULT NULL,
                    PRIMARY KEY (`num`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                    break;
                case 'free_ripple' :
                    $sql = "CREATE TABLE `free_ripple` (
                    `num` int(11) NOT NULL AUTO_INCREMENT,
                    `parent` int(11) NOT NULL,
                    `id` char(15) NOT NULL,
                    `name` char(10) NOT NULL,
                    `nick` char(10) NOT NULL,
                    `content` text NOT NULL,
                    `regist_day` char(20) DEFAULT NULL,
                    PRIMARY KEY (`num`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                    break;
                    case 'image_free' :
                        $sql = "CREATE TABLE `image_free` (
                        `num` int(11) NOT NULL AUTO_INCREMENT,
                        `id` char(15) NOT NULL,
                        `name` char(10) NOT NULL,
                        `subject` varchar(100) NOT NULL,
                        `content` text NOT NULL,
                        `regist_day` char(20) DEFAULT NULL,
                        `hit` int(11) DEFAULT NULL,
                        `is_html` char(1) DEFAULT NULL,
                        `file_name_0` char(40) DEFAULT NULL,
                        `file_copied_0` char(30) DEFAULT NULL,
                        `file_type_0` char(30) DEFAULT NULL,
                        PRIMARY KEY (`num`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                        break;
                        case 'image_free_ripple' :
                            $sql = "CREATE TABLE `image_free_ripple` (
                            `num` int(11) NOT NULL AUTO_INCREMENT,
                            `parent` int(11) NOT NULL,
                            `id` char(15) NOT NULL,
                            `name` char(10) NOT NULL,
                            `content` text NOT NULL,
                            `regist_day` char(20) DEFAULT NULL,
                            PRIMARY KEY (`num`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                            break;
                default : echo"<script>alert('해당된 테이블명이 없습니다.');</script>"; break;
            }//end of switch
            if(mysqli_query($con,$sql)){
                echo"<script>alert('{$table_name}테이블 생성완료');</script>";
            }else{
               echo"테이블 생성 실패원인 : ".mysqli_error($con);
            }
        }//end of if


    }
?>