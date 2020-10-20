<?php
    $real_name = $_GET["real_name"];
    $file_name = $_GET["file_name"];
    $file_type = $_GET["file_type"];
    $file_path = "./data/".$real_name;
    //$_SERVER['HTTP_USER_AGENT'] : 웹브라우저 정보를 가져온다.
    //preg_match(data, target) : target 에서 data정보를 찾아라. 있으면 true 없으면 false
    //strpos(a, b) : a 안에서 b라는 것을 찾는다.
    $ie = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || 
        (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== false && 
            strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false);

    //IE인경우 한글파일명이 깨지는 경우를 방지하기 위한 코드 
    if( $ie ){
        //file_name의 utf-8의 형식을 euc-kr로 바꿔준다.
         $file_name = iconv('utf-8', 'euc-kr', $file_name);
    }

    if( file_exists($file_path) )
    {   
        //"rb" 2진법으로 읽으라는 뜻
		$fp = fopen($file_path,"rb"); 
		Header("Content-type: application/x-msdownload"); //타입
        Header("Content-Length: ".filesize($file_path));     //사이즈
        Header("Content-Disposition: attachment; filename=".$file_name);   //파일의 진짜 이름
        Header("Content-Transfer-Encoding: binary"); //인코딩
		Header("Content-Description: File Transfer"); //파일을 보내라
        Header("Expires: 0");       //전송시간 설정 0= 설정안함
    } 
	//fpassthru 다 전송 하면 false값을 리턴
    if(!fpassthru($fp)) 
		fclose($fp); 
?>

  
