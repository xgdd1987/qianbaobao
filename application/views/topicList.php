<!doctype html>
<html>
<head> 
<?php 
					$quanxian=0;
					if(isset($_SESSION['userInfo']['quanxian'])){
						$quanxian=$_SESSION['userInfo']['quanxian'];
					}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝-话题列表</title> 
    <meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手">
	<meta name="Description" content="钱宝宝,您的理财小助手！">
	<meta name="Author" content="Http://www.qianbaobao365.com">   
	<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css">
	<SCRIPT type="text/javascript" src="<?php echo base_url();?>js/jquery-1.8.2.min.js"></SCRIPT>
	<?php if(1 == $quanxian || 2 == $quanxian){ ?>
	<script type="text/javascript">
		function quanxian(op,id){
			if(op==0){
				document.getElementById(id+"1").style.display="";
				document.getElementById(id+"2").style.display="";
				$("#"+id+"tr").css("background-color","#CDF08F");
			}else if(op==1){
				document.getElementById(id+"1").style.display="none";
				document.getElementById(id+"2").style.display="none";
				$("#"+id+"tr").css("background-color","white");
			}
		}
		//op=0 取消置顶；op=1 置顶；；op=2 删除；
		function doTopic(op,id){
			var url="";
			if(op==2){
				if(confirm('确定删除吗？此操作将不能恢复！')){
					url="<?php echo site_url('group/doTopic');?>/"+op+"/"+id;
				}else{
					return false;
				}
			}else{
				url="<?php echo site_url('group/doTopic');?>/"+op+"/"+id;
			}
			$.post(url,null,callback1,"text");
		}
		function callback1(data){
			alert(data);
			window.location.reload();
		}
	</script>
	<?php } ?>
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
					<div id="MainB4">&nbsp;您的当前位置: <a href="<?php echo site_url('group/index');?>">群组</a>&gt;&gt;<a href="<?php echo site_url('group/topicList2/'.$_SESSION['groupid'].'/'.$_SESSION['groupName']);?>"><?php echo $_SESSION['groupName'];?></a>&gt;&gt;话题列表&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('group/addTopic/'.$_SESSION['groupid']);?>">发表新话题</a></div>
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
						<TABLE class="tb" width="100%" border=0>
						  <TBODY>
								<?php 
									
									foreach($topicPin as $row):
										$id=$row['id']+0;
								?>
							  <TR id="<?php echo $id.'tr';?>" <?php if(1 == $quanxian || 2 == $quanxian){ echo 'onmouseover="quanxian(0,'.$id.');" onmouseout="quanxian(1,'.$id.');"'; }?>>
							    <TD width="24">
							    	<IMG border="0" alt="置顶话题" src="<?php echo base_url().'images/zding.gif';?>" width="31" height="17">
							    	<?php if(1 == $quanxian || 2 == $quanxian) echo "<a href='#' id='".$id."1' style='display:none;width:20px;' onclick='doTopic(0,".$id.");' >取消置顶</a><br/><a href='#' id='".$id."2' style='display:none;width:20px;' onclick='doTopic(2,".$id.");' >删除</a>";?>
							    </TD>
							    <TD><A href="<?php echo site_url('group/getTopicById/'.$id);?>" title="<?php echo $row['name'];?>"><?php echo $row['name'];?></A></TD>
							    <TD class="topic_nums" width="50">跟帖:<?php echo $row['replies'];?></TD>
							    <TD class="topic_nums" width="50">热度:<?php echo $row['dianji'];?></TD>
							    <TD class="topic_nums" width="70"><?php echo $row['username'];?></TD>
							    <TD class="date_time" width="80"><?php echo $row['date_time'];?></TD>
							 </TR>
								 <?php endforeach;?>
								<?php 
									foreach($topic as $row):
										$id=$row['id']+0;
								?>
							  <TR id="<?php echo $id.'tr';?>" <?php if(1 == $quanxian || 2 == $quanxian){ echo 'onmouseover="quanxian(0,'.$id.');" onmouseout="quanxian(1,'.$id.');"'; }?>>
							    <TD>
							    	<IMG border="0" alt="话题" src="<?php echo base_url().'images/topic.png';?>" width="16" height="16">
							    	<?php if(1 == $quanxian || 2 == $quanxian) echo "<a href='#' id='".$id."1' style='display:none;width:20px;' onclick='doTopic(1,".$id.");' >置顶</a><br/><a href='#' id='".$id."2' style='display:none;width:20px;' onclick='doTopic(2,".$id.");' >删除</a>";?>
							    </TD>
							    <TD><A href="<?php echo site_url('group/getTopicById/'.$id);?>" title="<?php echo $row['name'];?>"><?php echo $row['name'];?></A></TD>
							    <TD class="topic_nums">跟帖:<?php echo $row['replies'];?></TD>
							    <TD class="topic_nums">热度:<?php echo $row['dianji'];?></TD>
							    <TD class="topic_nums"><?php echo $row['username'];?></TD>
							    <TD class="date_time"><?php echo $row['date_time'];?></TD>
							 </TR>
						 <?php endforeach;?>
						</TBODY></TABLE>
						<?php $link=$this->pagination->create_links();if($link!=''):?>
						<DIV class="pager">
						 <?php  echo $link; ?>
						</DIV>
						<?php endif;?>
					</DIV>
			</div>
		</div>
		<div id="MainFoot"><?php $this->load->view('foot');?></div>
	</div>
</div>
</div>



</body></html>