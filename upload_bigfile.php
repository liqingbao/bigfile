<?php
/**
 * 大文件切割上传，把每次上传的数据合并成一个文件
 * @author liqingbao
 */
$fileName = urldecode($_POST['fileName']);
$dot = strripos($fileName , '.');
//文件名中空格换成'_'
$fileName = str_replace(' ', '_', substr($fileName, 0 , $dot) );
//文件后缀，含'.'
$ext = substr($fileName, $dot);
//确定上传的文件名
$writeFileName = date('F_d_Y_').mt_rand(1,99999).$ext;
$phpFileName = empty($_POST['phpFileName']) ? './upload/'.$writeFileName : urldecode($_POST['phpFileName']);
$json['phpFileName'] = $phpFileName;
//第一次上传时没有文件，就创建文件，此后上传只需要把数据追加到此文件中
if(file_exists($phpFileName))
{
    $json['status'] = file_put_contents($phpFileName,file_get_contents($_FILES['file']['tmp_name']),FILE_APPEND) > 0;
}
else
{
    $json['status'] = move_uploaded_file($_FILES['file']['tmp_name'],$phpFileName);
}
echo json_encode($json);
?>
