<?php
function free_delete($id1,$num1,$page1,$page){
  $message="";
  if($_SESSION['userid']=="admin"||$_SESSION['userid']==$id1){
    $mode="delete";
    $message='<form style="display:inline" action="'.$page1.'?mode=delete&page='.$page.'" method="post">
    <input type="hidden" name="num" value="'.$num1.'">
    <input type="hidden" name="mode" value="'.$mode.'">
    <input type="submit" value="삭제">
    </form>';
  }
  return $message;
}

function free_ripple_delete($id1,$num1,$page1,$page,$hit,$parent){
  $message="";
  if($_SESSION['userid']=="admin"||$_SESSION['userid']==$id1){
    $mode = "delete_ripple";
    $message='<form style="display:inline" action="'.$page1.'?page='.$page.'&hit='.$hit.'" method="post">
    <input type="hidden" name="num" value="'.$num1.'">
    <input type="hidden" name="hit" value="'.$hit.'">
    <input type="hidden" name="page" value="'.$page.'">
    <input type="hidden" name="parent" value="'.$parent.'">
    <input type="hidden" name="mode" value="'.$mode.'">
    <input type="submit" value="삭제">
    </form>';
  }
  return $message;
}

?>
