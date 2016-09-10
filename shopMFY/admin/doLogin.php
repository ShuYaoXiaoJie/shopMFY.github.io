<?php 
//error_reporting(E_ALL ^ E_NOTICE);
require_once '../include.php';
$username = isset($_POST['username']) ? $_POST['username'] : '';
//$username=$_POST['username'];
//$password=$_POST['password'];
$password=md5($_POST['password']);
$verify=$_POST['verify'];
$verify1=$_SESSION['verify'];
@$autoFlag=$_POST['autoFlag'];
if($verify==$verify1){
    $sql="select * from MFY_admin where username='{$username}' and password='{$password}'";
    $row=checkAdmin($sql);
   /*  var_dump($row);
    $res = checkAdmin($sql);
    var_dump($res); */
   if($row){
        //如果选了一周内自动登陆
        if($autoFlag){
            setcookie("adminId",$row['id'],time()+7*24*3600);
            setcookie("adminName",$row["username"],time()+7*24*3600);
        }
       $_SESSION['adminName']=$row['username'];
		$_SESSION['adminId']=$row['id'];
         alertMes("登陆成功", "index1.php");
    }else{
        alertMes("登陆失败，重新登陆", "login.php");

    }
}else{
    alertMes("验证码错误，重新登陆", "login.php");
}