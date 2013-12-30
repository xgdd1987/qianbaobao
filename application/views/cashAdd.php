<!doctype html>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝 - 您的理财小助手 - [www.qianbaobao365.com]</title> 
    <meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手">
	<meta name="Description" content="钱宝宝,您的理财小助手！">
	<meta name="Author" content="Http://www.qianbaobao365.com">  
	<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css">
	<SCRIPT type="text/javascript" src="<?php echo base_url();?>js/Calendar5.js"></SCRIPT>
	<script type="text/javascript">
       var c = new Calendar("c");
       document.write(c);
       function checkform(){
			var temp=document.getElementById("cashName").value;
			if(temp == ""){
				alert("账单名称不能为空!");
				document.getElementById("cashName").focus();
				return false;
			}
			temp=document.getElementById("money").value;
			if(temp == ""){
				alert("金额不能为空!");
				document.getElementById("money").focus();
				return false;
			}
			if(isNaN(temp)){
				alert("请输入有效的金额!");
				document.getElementById("money").focus();
				return false;
			}
			temp=document.getElementById("class").value;
			if(temp == ""){
				alert("请选择类别!");
				document.getElementById("class").focus();
				return false;
			}
			temp=document.getElementById("pay").value;
			if(temp == ""){
				alert("请选择支付方式!");
				document.getElementById("pay").focus();
				return false;
			}
			temp=document.getElementById("oper").value;
			if(temp == ""){
				alert("经手人不能为空!");
				document.getElementById("oper").focus();
				return false;
			}
			temp=document.getElementById("payDate").value;
			if(temp == ""){
				alert("日期不能为空!");
				document.getElementById("payDate").focus();
				return false;
			}
    		return true;
        }
    </script>
</head>
<body>

<div id="CashPage">
<div id="MainPage">
	<div id="MainContain">
		<div id="MainHead">
			<?php 
				$this->load->view("head");
			?>
		</div>
		<div id="MainBody">
			<div id="MainCount">
				<div id="MainBanner">
					<div id="MainB1"><img width="80" src="<?php if($_SESSION['userInfo']['photo'] != '') $photo=$_SESSION['userInfo']['photo'];else $photo='images/default.gif'; echo base_url().$photo;?>" align="middle" /></div>
					<div id="MainB2">&nbsp;<?php if(isset($gonggao)) echo $gonggao;?></div>
					<div id="MainB3"><strong>&nbsp;<?php echo $_SESSION['userInfo']['username'];?></strong>：您好，欢迎使用小钱袋子。科学理财，从记账开始。快点添加新账单吧。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: &gt;&gt;添加新账单</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a></div>
			</div>
			<div id="MainList">
				<div id="MainAddCashForm"><form method="post" onsubmit="return checkform();">
<div class="MainAddCashFormItem">
<label for=Title>账单名称：</label><input type="text" name="cashName" id="cashName" value="" maxlength="200" style="width:300px;" class="inputText"><br />
<label for=Amount>金额(￥)：</label><input type="text" name="money" id="money" value="" maxlength="8" class="inputText"><br />
<label for=SmallClassID>类别：</label>
		<select name="class" id="class" class="inputText" style="width:155px;">
			<option value="">请选择类别</option>
			<optgroup label="------------收入-----------"></optgroup>
			<?php foreach($shouru as $row):?>
			<option value="<?php echo $row['id']+0;?>"><?php echo $row['name'];?></option>
			<?php endforeach;?>
			<optgroup label="------------支出-----------"></optgroup>
			<?php foreach($zhichu as $row):?>
			<option value="<?php echo $row['id']+0;?>"><?php echo $row['name'];?></option>
			<?php endforeach;?>
			<optgroup label="------------借--------------"></optgroup>
			<?php foreach($jie as $row):?>
			<option value="<?php echo $row['id']+0;?>"><?php echo $row['name'];?></option>
			<?php endforeach;?>
			<optgroup label="------------贷--------------"></optgroup>
			<?php foreach($dai as $row):?>
			<option value="<?php echo $row['id']+0;?>"><?php echo $row['name'];?></option>
			<?php endforeach;?>
		</select><br />
	<label for=PayClassID>支付方式：</label><select name="pay" id="pay" class="inputText" style="width:155px;">
		<option value="">请选择支付方式</option>
			<?php foreach($pay as $row):?>
	<option value="<?php echo ($row['id']+0).','.$row['name'].'-'.($row['pay']+0);?>"><?php echo $row['name'];?></option>
	<?php endforeach;?>
	</select><br />
<label for=Author>经手人：</label><input type="text" name="oper" id="oper" maxlength="50" class="inputText" value="<?php echo $_SESSION['userInfo']['username'];?>"><br />
<label for=PostTime>日期：</label><input type="text" name="payDate" id="payDate" readonly="readonly" style="width:100px; height:18px;" onfocus="c.showMoreDay = false;c.show(this);" class="inputText" Value=""><br />
<label for=Summary>备注：</label><textarea name="mark" id="mark" class="inputText" style="width:400px; overflow:auto;line-height:20px;" rows="8">无</textarea><br />
<input name="Submit" type="submit" id="Submit" value="添加账单" class="AddBtn">
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