<?php
//echo md5("king");
//echo md5("queen");
//echo md5("admin");
$sql = "insert MFY_admin(username,password,email)values('king','b2086154f101464aab3328ba7e060deb','419626329@qq.com')";
//$sql = "insert MFY_admin(username,password,email)values('queen','72545f3f86fad045a26ed54abd2bbb9f','419626329@qq.com')";
//$sql = "insert MFY_admin(username,password,email)values('admin','21232f297a57a5a743894a0e4a801fc3','419626329@qq.com')";
echo $sql;

//三个超级用户，密码与用户名相同，分别是“king","queen","admin";