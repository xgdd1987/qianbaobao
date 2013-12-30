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
			var temp=document.getElementById("name").value;
			if(temp == ""){
				alert("标题不能为空!");
				document.getElementById("name").focus();
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
					<div id="MainB4">&nbsp;您的当前位置: <a href="<?php echo site_url('group/index');?>">群组</a>&gt;&gt;<a href="<?php echo site_url('group/topicList2/'.$_SESSION['groupid'].'/'.$_SESSION['groupName']);?>"><?php echo $_SESSION['groupName'];?></a>&gt;&gt;发表新话题</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a></div>
			</div>
			<div id="MainList">
				<div id="MainAddCashForm" style="height:550px;"><form method="post" onsubmit="return checkform();">
					<div class="MainAddCashFormItem" style="height:250px;">
					<div style="width:430px;float: left;">
					<label for=Title>标题：</label><input type="text" name="name" id="name" value="<?php echo set_value('name');?>" maxlength="50" style="width:300px;" class="inputText"><br />
					<?php echo $info;?><br />
					<input name="Submit" type="submit" id="Submit" value="发表" class="AddBtn">
					<input name="Submit" type="button" id="Submit" value="返回" class="AddBtn" onclick="history.back(-1);">
					</div>
					<div style="width:250px;float: right;"><br/><br/><?php // echo $smiley_table; ?></div> 
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