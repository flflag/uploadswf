<?php
session_start();
//constant
define('SERVERADDR','http://202.198.131.136/');
define('PATH','birthday/');
define('RELAFILEDIR','uploads/');
$absavepath = SERVERADDR.PATH.RELAFILEDIR;
//functions
function printLoginForm()
{
    echo  <<<Eof
<form action="" method="post">
    <label for="login">徐老师、张老师，还有谁？</label>
    <input id="login" name="login" type="text" />
    <input type="submit" value="确定" />
</form>
Eof;
}
function printFileForm()
{
    echo  <<<Eof
<form action="" enctype="multipart/form-data" method="post">
    <label for="swf">上传新文件:</label>
    <input id="swf" name="swf" type="file" />
    <input type="submit" value="上传" />
</form>
Eof;
}
function alert($message)
{
    echo '<br />';
    echo $message;
}
/*
function print_manage_form(){
//检索已上传的文件并打出控制表
    $dir = RELAFILEDIR;
    if(is_dir($dir))
    {
    echo 'exed!';
        $dir_res = opendir($dir);
        $dir_list = array();
        while($filen = readdir($dir_res))
        {
            array_push($dir_list,$filen);
        }
        closedir($dir_res);
        print_r($dir_list);
        foreach($dir_list as $filename)
        {
        }
    }
}
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>上传swf</title>
</head>
<body>
<?
//$action = empty($_GET['action'])?$_GET['action']:'firstcome';

$_SESSION['first'] = TRUE;
if(empty($_SESSION['now']) || $_SESSION['now']!=='loged')
{
    printLoginForm();
    if(!empty($_POST['login']))
    {
        if($_POST['login'] === '樊老师')
        {
            $_SESSION['now'] = 'loged';
            echo '<script type="text/javascript">location=location;</script>';
        }
        else
        {
            $_SESSION['first'] = FALSE;
        }
            //header('location:'.$PHP_SELF);
    }
    if($_SESSION['first'] === FALSE)
    {
        alert('不对');
    }
}
else
{
    printFileForm();
    if(!empty($_FILES['swf']))
    {
        if($_FILES['swf']['type']!=='application/x-shockwave-flash')
        {
            alert('安全考虑，只能上传swf文件');
        }
        else
        {
            if(preg_match('/^[a-zA-Z0-9-_.]+.swf$/',$_FILES['swf']['name']) === 1){
                //print_r($_FILES);
                $uploadfile = RELAFILEDIR.$_FILES['swf']['name']; 
                move_uploaded_file($_FILES['swf']['tmp_name'],$uploadfile);
                //获取上传文件宽高有关html代码
                $picsize = getimagesize('http://localhost/'.PATH.$uploadfile);
                //输出上传成功信息
                $pichtml = '<embed width="'.$picsize[0].'" height="'.$picsize[1].'" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="'.SERVERADDR.PATH.$uploadfile.'">';
                alert('文件已上传<br />'.$pichtml.'<br />引用路径：<br />'.SERVERADDR.PATH.$uploadfile.'<br />参考HTML代码（为原本的宽高）：<br />'.htmlentities($pichtml).'<!--<a href="#">复制代码</a>-->');
            }
            else
            {
                //var_dump($_FILES['swf']['name']);
                //var_dump(preg_match('/^[a-zA-Z0-9-_.]+.swf$/',$_FILES['swf']['name']));
                alert('请用英文字母_.-组成文件名');
            }
        }
    }
}
?>
</body>
</html>

