<!doctype html>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝-通过邮件重置密码</title>  
    <meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手">
	<meta name="Description" content="钱宝宝,您的理财小助手！">
	<meta name="Author" content="Http://www.qianbaobao365.com">  
	<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css">
</head>
<body>

<div id="CashPage">
<div id="MainPage">
	<div id="MainContain">
		<div id="MainHead">
			<?php $this->load->view("head");?>
		</div>
		<div id="MainBody">
			<div id="MainCount">
				<div id="MainBanner">
					<div id="MainB1"><img width="80" src="<?php echo base_url();?>images/default.gif" align="middle" /></div>
					<div id="MainB2">&nbsp;<?php if(isset($gonggao)) echo $gonggao;?></div>
					<div id="MainB3"><strong>&nbsp;游客</strong>：您好，欢迎使用钱宝宝。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: 密码找回</div>
				</div>
			</div>
			<div id="MainList">
				<div id="MainAddCashForm" style="text-align: center;">
					<form method="post" onsubmit="return checkform();">
					<br/><br/>
					<table align="center" border=0>
						<tr height="50">
							<td width='100'>要找回密码的账号：</td>
							<td width='200'><input type="text" name="username" id="username" value="<?php echo set_value('username');?>" maxlength="50"  class="inputText"></td>
							<td width='200'><?php echo form_error("username"); ?></td>
						</tr>
						<tr height="30">
							<td>新密码：</td>
							<td><input type="password" name="password" id="password" value="<?php echo set_value('password');?>" maxlength="80" class="inputText"></td>
							<td><?php echo form_error("password"); ?></td>
						</tr>
						<tr height="30">
							<td>重复新密码：</td>
							<td><input type="password" name="rpassword" id="rpassword" value="<?php echo set_value('rpassword');?>" maxlength="80" class="inputText"></td>
							<td><?php echo form_error("rpassword"); ?></td>
						</tr>
						<tr height="50">
							<td><input name="Submit" type="submit" id="Submit" value="确定" class="AddBtn"></td>
							<td><input name="Submit" type="reset" id="Submit" value="重    置" class="AddBtn"></td>
							<td></td>
						</tr>
					</table>
<div class="MainAddCashFormItem" >
<label for=Title  style="width:200px;"></label><br />
<label for=Amount style="width: 200px;"></label><br />


</div></form> 
				</div>
			</div>
		</div>
		<div id="MainFoot"><?php $this->load->view('foot');?></div>
	</div>
</div>
</div>

<?php 
    	if(isset($_SESSION["msg"]) && $_SESSION["msg"]!=""){
    		echo "<script type='text/javascript'>alert('".$_SESSION["msg"]."');</script>";	
    		$_SESSION["msg"]="";
    	}
    ?>

</body></html>