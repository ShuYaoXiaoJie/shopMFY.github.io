<?php
/*** 验证码 ***/
require_once'string.func.php';
//通过GD库做验证码
function verifyImage($type=1, $length=4, $pixel=50, $line=0, $sess_name="verify1"){
     
    //1. 创建画布
    $width = 80;
    $height = 28;
    $type = 1;
    $length = 4;
    $image = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($image,255,255,255);
    $black = imagecolorallocate($image,0,0,0);
 
    //2. 用填充矩形填充画布
    imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);
 
    //3. 获取随机验证码
    $chars = buildRandomString($type, $length);
 
    //4. 保存到session
    $sess_name = "verify";
    $_SESSION[$sess_name] = $chars;
 
    $fontfiles = array

("MSYH.TTF","MSYHBD.TTF","SIMFANG.TTF","SIMHEI.TTF","SIMKAI.TTF","SIMSUN.TTF");
    //5. 生成验证码
    for($i=0; $i<$length; $i++){
        $size = mt_rand(14,18);// 字体大小变化
        $angle = mt_rand(-15,15);// 倾斜角度变化
        $x = 5 + $i * $size;// 位置变化
        $y = mt_rand(20,26);
        // 随机字体
        $fontfile = "../fonts/".$fontfiles[mt_rand(0,count($fontfiles)-1)];
        // 随机字体颜色
        $color = imagecolorallocate($image, mt_rand(10,90), mt_rand(20,180), mt_rand(30,130));
        $text = substr($chars, $i, 1);// 每次取一个字符
        imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
    }
 
    //6. 干扰点
    if($pixel){
        for($i=0; $i<$pixel; $i++){
            imagesetpixel($image, mt_rand(0,$width-1), mt_rand(0,$height-1), $black);
        }
    }
 
    //7. 干扰线
    if($line){
        for($i=0; $i<$line; $i++){
            $color = imagecolorallocate($image, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
            imageline($image, mt_rand(0,$width-1), mt_rand(0,$height-1), mt_rand(0,$width-1), mt_rand(0,$height-1), $color);
        }
    }
    ob_clean();
    //8. 输出到服务端
    header("content-type:image/gif");// 输出图片类型
    imagegif($image);
    imagedestroy($image);// 销毁图片内存
     
}
//verifyImage(2,4,10,5);
/**
 * 生成缩略图
 * @param string $filename
 * @param string $destination
 * @param int $dst_w
 * @param int $dst_h
 * @param bool $isReservedSource
 * @param number $scale
 * @return string
 */
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=true,$scale=0.5){
    list($src_w,$src_h,$imagetype)=getimagesize($filename);
    if(is_null($dst_w)||is_null($dst_h)){
        $dst_w=ceil($src_w*$scale);
        $dst_h=ceil($src_h*$scale);
    }
    $mime=image_type_to_mime_type($imagetype);
    $createFun=str_replace("/", "createfrom", $mime);
    $outFun=str_replace("/", null, $mime);
    $src_image=$createFun($filename);
    $dst_image=imagecreatetruecolor($dst_w, $dst_h);
    imagecopyresampled($dst_image, $src_image, 0,0,0,0, $dst_w, $dst_h, $src_w, $src_h);
    if($destination&&!file_exists(dirname($destination))){
        mkdir(dirname($destination),0777,true);
    }
    $dstFilename=$destination==null?getUniName().".".getExt($filename):$destination;
    $outFun($dst_image,$dstFilename);
    imagedestroy($src_image);
    imagedestroy($dst_image);
    if(!$isReservedSource){
        unlink($filename);
    }
    //var_dump($dstFilename);
    return $dstFilename;
}

/**
 *添加文字水印
 * @param string $filename
 * @param string $text
 * @param string  $fontfile
 */
function waterText($filename,$text="MFY.com",$fontfile="MSYH.TTF"){
    $fileInfo = getimagesize ( $filename );
    $mime = $fileInfo ['mime'];
    $createFun = str_replace ( "/", "createfrom", $mime );
    $outFun = str_replace ( "/", null, $mime );
    $image = $createFun ( $filename );
    $color = imagecolorallocatealpha ( $image, 255, 0, 0, 50 );
    $fontfile = "../fonts/{$fontfile}";
    imagettftext ( $image, 14, 0, 0, 14, $color, $fontfile, $text );
    $outFun ( $image, $filename );
    imagedestroy ( $image );
}

/**
 *添加图片水印
 * @param string $dstFile
 * @param string $srcFile
 * @param int $pct
 */
function waterPic($dstFile,$srcFile="../images/logo.jpg",$pct=30){
    $srcFileInfo = getimagesize ( $srcFile );
    $src_w = $srcFileInfo [0];
    $src_h = $srcFileInfo [1];
    $dstFileInfo = getimagesize ( $dstFile );
    $srcMime = $srcFileInfo ['mime'];
    $dstMime = $dstFileInfo ['mime'];
    $createSrcFun = str_replace ( "/", "createfrom", $srcMime );
    $createDstFun = str_replace ( "/", "createfrom", $dstMime );
    $outDstFun = str_replace ( "/", null, $dstMime );
    $dst_im = $createDstFun ( $dstFile );
    $src_im = $createSrcFun ( $srcFile );
    imagecopymerge ( $dst_im, $src_im, 0, 0, 0, 0, $src_w, $src_h, $pct );
    //	header ( "content-type:" . $dstMime );
    $outDstFun ( $dst_im, $dstFile );
    imagedestroy ( $src_im );
    imagedestroy ( $dst_im );
}












