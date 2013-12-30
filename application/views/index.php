<!doctype html>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝-登录 - 您的理财小助手 - [www.qianbaobao365.com]</title>  
    <meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手" />
	<meta name="Description" content="钱宝宝,您的理财小助手！" />
	<meta name="Author" content="Http://www.qianbaobao365.com" />
	<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="LoginPannel">
	<form name="PostForm" method="post">
	<div id="LoginHead">
		<a href="#"></a>
	</div>
	<div id="LoginBody">
		<div class="LoginFromItem">
			<div class="LoginFromItemTxt">帐号：</div>
			<div class="LoginFromItemInput">
				<input name="username" id="username" type="text" class="inputText" maxlength="20"  value="<?php echo set_value('username');?>"/>
			</div>
			<?php echo form_error("username"); ?>
		</div>
		<div class="LoginFromItem" >
			<div class="LoginFromItemTxt">密码：</div>
			<div class="LoginFromItemInput">
				<input name="password" id="password" type="password" value="<?php echo set_value('password');?>" class="inputText" maxlength="20"  />
			</div>
			<?php echo form_error("password"); ?>
		</div>	
		<div class="LoginFromItem">
			<input name="submit" class="btnSubmit" type="submit" value="登 录">&nbsp;&nbsp;&nbsp;&nbsp;
			<input class="btnSubmit" type="button" value="注册" onclick="window.open('<?php echo base_url().'index.php/welcome/signUp'; ?>');">
			<a href="<?php echo site_url('welcome/get_password');?>">忘记密码?</a>	
		</div>
		<div class="LoginFromUrl">技术支持：<a href="#"">钱宝宝</a></div>
	</div>
	</form>
</div>
<div id="tcCount">统计</div>
    <?php 
    	if(isset($_SESSION["msg"]) && $_SESSION["msg"]!=""){
    		echo "<script type='text/javascript'>alert('".$_SESSION["msg"]."');</script>";	
    		$_SESSION["msg"]="";
    	}
    ?>
    <div style="display: none;"><script src="http://s14.cnzz.com/stat.php?id=4721910&web_id=4721910&show=pic" language="JavaScript"></script></div>
</body></html>