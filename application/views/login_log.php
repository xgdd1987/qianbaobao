<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>钱宝宝 - 您的理财小助手 - [www.qianbaobao365.com]</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手" />
	<meta name="Description" content="钱宝宝,您的理财小助手！" />
	<meta name="Author" content="Http://www.qianbaobao365.com" /> 
<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js" ></script>
<script type="text/javascript">
			       function changebg(op,id){
		        $("#tab tbody tr").css("background-color","white");
				$("#"+id).css("background-color","#CDF08F");
				
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
					<div id="MainB3"><strong>&nbsp;<?php echo $_SESSION['userInfo']['username'];?></strong>：您好！欢迎使用钱宝宝!(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: <a href="<?php echo site_url('welcome/user');?>" title="帐号管理">账号管理</a>&gt;&gt;登录日志&nbsp; 
						
					</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onclick="return confirm('确定退出登录吗？');">安全退出</a></div>
            </div>
            <div id="MainList">
            	<div class="ListTip">
            		这是您当前账号最近10次的系统登录日志!
            	</div>
	            <table class="DataTab" width="798" id="tab">
					<thead>
					<tr>
					<th width="200">登录时间</th>
					<th width="200">退出时间</th>
					<th width="200">登录IP</th>
					<th>登录地区</th>
					</tr>
					</thead>
					<tbody>
						<?php foreach($login_log as $row): $id=$row['id']+0;?>
						<tr id="<?php echo $id;?>" onmouseover="changebg(1,<?php echo $id;?>);" >
							<th><?php echo $row['last_login_time'];?></th>
							<th><?php echo $row['last_loginout_time'];?></th>
							<th><?php echo $row['last_login_ip'];?></th>
							<th><?php echo $row['last_login_area'];?></th>
						</tr>
						<?php endforeach;?>
					</tbody>
					</table>
				<div id="PageList">
					
			
				</div>
			</div>
        </div>
		<div id="MainFoot"><?php $this->load->view("foot");?></div>
    </div>
</div>
</div>
</body>
</html>
