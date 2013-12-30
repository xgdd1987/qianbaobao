<!doctype html>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝-查看话题</title>  
    <meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手">
	<meta name="Description" content="钱宝宝,您的理财小助手！">
	<meta name="Author" content="Http://www.qianbaobao365.com">  
	<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css">
	<SCRIPT type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></SCRIPT>
</head>
<script type="text/javascript">
	function tishi(){
		alert("对不起，请登录后回复!");
	}
	function huifu(op,lou){
		var username=document.getElementById(lou+"lou1").innerHTML;
		if(op==0){
			document.getElementById(lou+"lou2").style.display="";
//			document.getElementById(lou+"huifu").style.background-color="red";
			$("#"+lou+"huifu").css("background-color","#EEEEEE");
			
		}else if(op==1){
			document.getElementById(lou+"lou2").style.display="none";
			$("#"+lou+"huifu").css("background-color","white");
		}else if(op==2){
			var hui=document.getElementById("content");
			hui.value="回复"+lou+"楼 @"+username;
			hui.focus();
		}
	}
	function pingbi(id){
		var url="<?php echo site_url('group/pingbi');?>/"+id;
		$.post(url,null,callback1,"text");
	}
	function callback1(data){
		alert(data);
		window.location.reload();
	}
</script>
<?php echo smiley_js(); ?>
<body>

<div id="CashPage">
<div id="MainPage">
	<div id="MainContain">
		<div id="MainHead">
			<?php 
				$this->load->view("head");
				$quanxian=0;
				$bianji=FALSE;
				$bianji2=FALSE;
				if(isset($_SESSION['userInfo']['username'])){
					$isLogin=TRUE;
					$quanxian=$_SESSION['userInfo']['quanxian'];
					if($_SESSION['userInfo']['username'] == $topic[0]['username']){
						$bianji2=TRUE;
					}
				}else{
					$isLogin=FALSE;
				}
				if(1 == $quanxian || 2 == $quanxian){
					$bianji=TRUE;
				}
			?>
		</div>
		<div id="MainBody">
			<div id="MainCount">
				<div id="MainBanner">
					<div id="MainB1"><img width="80" src="<?php if( $isLogin==TRUE && $_SESSION['userInfo']['photo'] != '') $photo=$_SESSION['userInfo']['photo'];else $photo='images/default.gif'; echo base_url().$photo;?>" align="middle" /></div>
					<div id="MainB2">&nbsp;<?php if(isset($gonggao)) echo $gonggao;?></div>
					<div id="MainB3"><strong>&nbsp;<?php if($isLogin==TRUE) echo $_SESSION['userInfo']['username'];else echo "游客"?></strong>：您好，欢迎使用钱宝宝。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: <a href="<?php echo site_url('group/index');?>">群组</a>&gt;&gt;<a href="<?php echo site_url('group/topicList2/'.$_SESSION['groupid'].'/'.$_SESSION['groupName']);?>"><?php echo $_SESSION['groupName'];?></a>&gt;&gt;查看话题&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('group/addTopic/'.$_SESSION['groupid']);?>">发表新话题</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php if($isLogin){?>
						<a href="#post_fast">回复话题</a>
						<?php }else {?>
						<a href="#" onclick="tishi();">回复话题</a>
						<?php }?> 
					</div>
				</div>
				<div id="loginOut">
					<?php if($isLogin==TRUE){?>
					<a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a>
					<?php }else{?>
					<a href="<?php echo site_url('welcome/index');?>" title="登录">点我登陆</a>	
					<?php }?>
				</div>
			</div>
			<div id="MainList">
					<DIV class="group-list">
						<?php  foreach($topic as $row):?>
						<DIV class="group_topic_t">
							<DIV class="member_t">
								<IMG border="0" alt="<?php echo $row['username'];?>的头像" src="<?php if($row['photo']!='') echo  base_url().$row['photo'];else echo base_url().'images/default.gif'; ?>" width="80" height="80"><SPAN></SPAN>
							</DIV>
							<DIV class="content_t">
								<DIV class="t">
									<SPAN><img src="<?php echo base_url().'images/louzhubiaoshi.png';?>" /></SPAN><I><?php echo $row['username'];?>: </I><?php echo "<a href='".site_url('group/getTopicById2')."'>".$row['name']."</a>";?><EM>@ <?php echo $row['date_time'];?></EM>&nbsp;<?php if($bianji2) echo "<a href='".site_url('group/editTopic/'.($row['id']+0))."'>编辑</a>";?>
								</DIV>
								<?php if($lou<=10):?>
								<DIV class="body_t">
									<?php echo$row['content'];?>
								</DIV>
								<?php endif;?>
							</DIV>
							<DIV class="clr"></DIV>
						</DIV><?php endforeach;?>
						<DIV class="group_topic_f">
						<?php foreach($replies as $row):?>
							<DIV class="f_item" id="<?php echo $lou.'huifu';?>" onmouseover="huifu(0,<?php echo $lou;?>);" onmouseout="huifu(1,<?php echo $lou;?>);">
								<DIV class="member_f">
									<IMG border="0" alt="<?php echo $row['username'];?>的头像" src="<?php if($row['photo']!='') echo base_url().$row['photo'];else echo base_url().'images/default.gif'; ?>"	width="40" height="40"><SPAN></SPAN>
								</DIV>
								<DIV class="content_f">
									<DIV class="f">
										<SPAN><?php if($lou==1)echo '沙发';elseif($lou==2)echo '板凳';elseif($lou==3)echo '地板'; else echo $lou.'楼';?></SPAN><I  id="<?php echo $lou.'lou';?>1"><?php echo $row['username'];?>: </I><EM>@ <?php echo $row['date_time'];?></EM>
									</DIV>
									<DIV class="body_f"><?php echo parse_smileys($row['content'],base_url().'qsmileys/');?></DIV>
									
										<div id="<?php echo $lou.'lou';?>2" style="float: right;display: none;"><?php if($bianji==TRUE) echo '<a href="#" onclick="pingbi('.($row['id']+0).')">屏蔽此不当言论</a>&nbsp;';?> <a href="#post_fast" onclick="huifu(2,'<?php echo $lou;?>');">回复</a></div>
									
								</DIV>
								
								<DIV class="clr"></DIV>
							</DIV>
						<?php $lou++; endforeach;?>
						</DIV>


						<?php $link=$this->pagination->create_links();if($link!=''){?>
						<DIV class="pager">
						 <?php  echo $link; ?>
						</DIV>
						<?php }?>

<DIV class="reply_fast">
	<a id="post_fast"></a>
	<H4 style="background: rgb(239, 239, 239); padding: 8px 4px; font-size: 12px;">快速回复</H4>
	<DIV class="form">
		<FORM method="post" name="group_post_form">
			<INPUT id="groupid" name="topicid" value="<?php echo $topic[0]['id']+0;?>" type="hidden">
			<INPUT id="userid" name="userid" value="<?php if($isLogin) echo $_SESSION['userInfo']['id']+0;;?>" type="hidden">
			<table border=0 width="100%">
				<tr>
					<td>回复内容:</td>
					<td><TEXTAREA class="inputText" name="content" id="content" style="width:400px; overflow:auto;line-height:20px;" rows="8"></TEXTAREA></td>
					<td width='300'><?php echo $smiley_table; ?></td>
				</tr>
			</table></div>
			<div><SPAN style="width: 60px;">&nbsp;</SPAN>
				
				<?php if($isLogin){?>
						<INPUT class="AddBtn" name="topic-post-submit" value="快速回复" type="submit">
						<?php }else {?>
						<INPUT class="AddBtn" onclick="tishi();" name="topic-post-submit" value="快速回复" type="button">
						
						<?php }?>
			</div>
			<P>&nbsp;</P></FORM>
	</DIV>
</DIV>

							 
						
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