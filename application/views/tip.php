<!doctype html>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝-账单列表</title>  
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
			<?php 
				$this->load->view("head");
				if(isset($_SESSION['userInfo']['id'])){
					$isLogin=TRUE;
				}else{
					$isLogin=FALSE;
				}
			?>
		</div>
		<div id="MainBody">
			<div id="MainCount">
				<div id="MainBanner">
					<div id="MainB1"><img width="80" src="<?php if($isLogin==TRUE && $_SESSION['userInfo']['photo']!='') $photo=$_SESSION['userInfo']['photo'];else $photo='images/default.gif'; echo base_url().$photo;?>" align="middle" /></div>
					<div id="MainB2">&nbsp;<?php if(isset($gonggao)) echo $gonggao;?></div>
					<div id="MainB3"><strong>&nbsp;<?php if($isLogin==TRUE) echo $_SESSION['userInfo']['username'];else echo "游客"?></strong>：您好，欢迎使用钱宝宝。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: &gt;&gt;温馨提示</div>
				</div>
				
				
			</div>
			<div id="MainList">
				<div id="MainAddCashForm" style="text-align: center;">
					<br/><br/><br/><br/>
					<font size="3">钱宝宝温馨提醒您：<?php echo $msg;?></font>
					<br/><br/><br/><br/>
				</div>
			</div>
		</div>
		<div id="MainFoot"><?php $this->load->view('foot');?></div>
	</div>
</div>
</div>



</body></html>