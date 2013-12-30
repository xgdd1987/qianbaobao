<!doctype html>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝-群组列表</title>  
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
					<div id="MainB1"><img width="80" src="<?php if( $isLogin==TRUE && $_SESSION['userInfo']['photo'] != '') $photo=$_SESSION['userInfo']['photo'];else $photo='images/default.gif'; echo base_url().$photo;?>" align="middle" /></div>
					<div id="MainB2">&nbsp;<?php if(isset($gonggao)) echo $gonggao;?></div>
					<div id="MainB3"><strong>&nbsp;<?php if($isLogin==TRUE) echo $_SESSION['userInfo']['username'];else echo "游客"?></strong>：您好，欢迎使用钱宝宝。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;</div>
				</div>
				<div id="loginOut">
					<?php if($isLogin==TRUE){?>
					<a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a>
					<?php }else{?>
					<a href="<?php echo site_url('welcome/index');?>" title="登录">点我登陆</a><br/><br/>
					<a href="<?php echo site_url('welcome/signUp');?>" title="注册">马上注册</a>	
					<?php }?>
				</div>
			</div>
			<div id="MainList">
					<DIV class="group-list">
					<TABLE class="tb" width="100%">
			  <TBODY>
					<?php 
						foreach($group as $row):
							$lastpostuser=$row['lastpostuser'];
							$lastpostdatetime=$row['lastpostdatetime'];
							if($lastpostuser!='' && $lastpostdatetime != ''){
								$temp=explode(' ',$lastpostdatetime);
							}
					?>
			  <TR>
			    <TD width="60"><IMG title="" border="0" src="<?php echo base_url().$row['img'];?>" width="60" height="60"></TD>
			    <TD>
			      <H2><A href="<?php echo site_url('group/topicList2/'.($row['id']+0).'/'.$row['name']);?>"><?php echo $row['name'];?></A></H2>
			      <P><?php echo $row['comment'];?></P></TD>
			    <TD class="topic_nums" width="80">
			      <H2>&nbsp;</H2>Topic:<?php echo $row['count']; ?></TD>
			    <TD class="date_time" width="150">
			      <H2>&nbsp;</H2><EM><?php echo $lastpostuser;?></EM><?php if($lastpostuser!='' && $lastpostdatetime != '') echo '&nbsp;@&nbsp;'.$temp[0].'<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$temp[1];?></TD>
			   </TR>
			 <?php endforeach;?>
			</TBODY></TABLE></DIV>	
				
			</div>
		</div>
		<div id="MainFoot"><?php $this->load->view('foot');?></div>
	</div>
</div>
</div>
<div style="display: none;">
<a href="http://www.000webhost.com">http://www.000webhost.com</a>
</div>
</body></html>