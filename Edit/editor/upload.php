<?php
/**
*新浪在线编辑器PHP版
*
*gently
*2008年2月27日（此次更新较为仓促，欢迎报告BUG。）
*博客：http://www.zendstudio.net/
*
**/
//include_once('../../application/config/config.php');
$act=addslashes($_GET['action']);
$type=addslashes($_GET['uploadtype']);
if($act=='upload'){
	if($type=='attach'){
		$fileType=array('rar','zip');//允许上传的文件类型
	}
	elseif($type=='img'){
		$fileType=array('jpg','gif','bmp','png');
	}
	$upfileDir='/uploadfile/';
	$base_url='http://www.qianbaobao365.com';
//$upfileDir=base_url().'/upload/';
	$maxSize=500; //单位：KB
	$fileExt=substr(strrchr($_FILES['file1']['name'],'.'),1);
	if(!in_array(strtolower($fileExt),$fileType))
		die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>alert('不允许上传该类型的文件！-808');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if($_FILES['file1']['size']> $maxSize*1024)
		die( "<script>alert('文件过大！');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if($_FILES['file1']['error'] !=0)
		die("<script><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">alert('未知错误，文件上传失败！');window.parent.$('divProcessing').style.display='none';history.back();</script>");
	$targetDir=dirname(__FILE__).'/../../'.$upfileDir;
	$targetFile=date('Ymd').time().strrchr($_FILES['file1']['name'],'.');
	$realFile=$targetDir.$targetFile;
	if(function_exists('move_uploaded_file')){
		 move_uploaded_file($_FILES['file1']['tmp_name'],$realFile);
	}
	else{
		@copy($_FILES['file1']['tmp_name'],$realFile);
	}
	if($type=='img'){
		die("<script>window.parent.LoadIMG('{$base_url}{$upfileDir}{$targetFile}');</script>");
	}
	elseif($type=='attach'){
		die("<script>window.parent.LoadAttach('{$base_url}{$upfileDir}{$targetFile}');</script>");
	}
}

