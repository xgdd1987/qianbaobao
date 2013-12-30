<!doctype html>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝-注册 - 您的理财小助手 - [www.qianbaobao365.com]</title>  
    <meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手" />
	<meta name="Description" content="钱宝宝,您的理财小助手！" />
	<meta name="Author" content="Http://www.qianbaobao365.com" />
	<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
	<SCRIPT type="text/javascript" src="<?php echo base_url();?>js/Calendar5.js"></SCRIPT>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js" ></script>
	  <script type="text/javascript">
       var c = new Calendar("c");
       document.write(c);
       function changeimg(){
    	   imgname=$("#imgname").val();
      		var url="<?php echo site_url('welcome/changeimg');?>/"+imgname;
      		$.post(url,null,callback1,"text");
      	}
      	function callback1(data){
      		var temp=data.split(",");
      		$("#imgsrc").attr({"src":temp[0]});	
      		$("#imgname").val(temp[1]);	
       	}
    </script>
</head>
<body>
	<div style="float: right;margin-right: 15%;font-size: 14px;"><a href="<?php echo base_url();?>">已有账号,&nbsp;马上登录</a></div>
	<div id="SignPannel" >
	<form name="PostForm" method="post">
	<div id="SignHead"><a href="<?php echo base_url();?>"></a></div>
	<div id="SignBody">
		<div class="LoginFromItem">
			<div class="SignFromItemTxt">用户名：</div>
			<div class="LoginFromItemInput">
				<input name="username" id="username"  type="text" class="inputText" maxlength="15"  value="<?php echo set_value('username');?>"/>
			</div>
			<?php if(form_error("username")!='') echo form_error("username");else echo "<div class='SignFromItemMsg'>√&nbsp;*&nbsp;可使用中文、英文字母、数字</div>"; ?>
		</div>
		<div class="LoginFromItem" >
			<div class="SignFromItemTxt">密码：</div>
			<div class="LoginFromItemInput">
				<input name="password" id="password" type="password" value="<?php echo set_value('password');?>" class="inputText" maxlength="20"  />
			</div>
			<?php if(form_error("password")!='') echo form_error("password"); else echo "<div class='SignFromItemMsg'>√&nbsp;*&nbsp;6位&nbsp;<=&nbsp;密码长度&nbsp;<=&nbsp;15位</div>";?>
		</div>
		<div class="LoginFromItem" >
			<div class="SignFromItemTxt">确认密码：</div>
			<div class="LoginFromItemInput">
				<input name="rpassword" id="rpassword" type="password" value="<?php echo set_value('rpassword');?>" class="inputText" maxlength="20"  />
			</div>
			<?php if(form_error("rpassword")!='') echo form_error("rpassword");else echo "<div class='SignFromItemMsg'>√&nbsp;*&nbsp;请在输入一遍密码</div>"; ?>
		</div>	
		<div class="LoginFromItem">
			<div class="SignFromItemTxt">性别：</div>
			<div class="LoginFromItemInput">&nbsp;&nbsp;&nbsp;&nbsp;
				男&nbsp;<input type="radio" name="sex[]"  value="男" <?php echo set_radio('sex', '男','TRUE'); ?> />&nbsp;&nbsp;&nbsp;&nbsp;
				女&nbsp;<input type="radio" name="sex[]" value="女" <?php echo set_radio('sex', '女'); ?> />

			</div>
			<?php echo form_error("sex"); ?>
		</div>
		<div class="LoginFromItem">
			<div class="SignFromItemTxt">电子邮箱：</div>
			<div class="LoginFromItemInput">
				<input name="email" id="email" type="text" class="inputText" maxlength="20"  value="<?php echo set_value('email');?>"/>
			</div>
			<?php if(form_error("email")!='') echo form_error("email");else echo "<div class='SignFromItemMsg'>√&nbsp;*&nbsp;电子邮箱用于找回密码.</div>"; ?>
		</div>
		<div class="LoginFromItem">
			<div class="SignFromItemTxt">出生日期：</div>
			<div class="LoginFromItemInput">
				<input name="birthday" id="birthday" type="text"  class="inputText" onfocus="c.showMoreDay = false;c.show(this);" readonly="readonly" style="width:100px; height:18px;" maxlength="20"  value="<?php if(set_value('birthday')=='')echo '1990-01-01';else echo set_value('birthday');?>"/>
			</div>
			<?php echo form_error("birthday"); ?>
		</div>
		<div class="LoginFromItem">
			<div class="SignFromItemTxt">验证码：</div>
			<div class="LoginFromItemInput">
				<input type="hidden" name="imgname" id="imgname" value="<?php echo $cap['imgname'];?>"/>
				<input name="captcha" id="captcha" type="text"  class="inputText"  style="width:60px; height:20px; " maxlength="4"  value="<?php echo set_value('captcha');?>"/>
				&nbsp;<img style='float: right;' id="imgsrc" name="imgsrc" src="<?php echo $cap['src'];?>" border=0 alt="点击更新验证码" onclick="changeimg();" />
			</div>
			<?php if(isset($captcha_err)) echo '<div class="SignFromItemError">X&nbsp;*&nbsp;'.$captcha_err.'</div>';?>
		</div>
		<div class="LoginFromItem">
			<input name="submit" class="btnSubmit" type="submit" value="注 册">&nbsp;&nbsp;&nbsp;&nbsp;
			<input class="btnSubmit" type="reset" value="重 置" ">	
		</div>
		<div class="LoginFromUrl">技术支持：<a href="#"">xgdd1987</a></div>
	</div>
	</form>
</div>

<div id="tcCount">统计</div>
    
</body></html>