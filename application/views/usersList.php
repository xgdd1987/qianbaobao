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


	<script src="<?php echo base_url();?>js/jquery.js" type="text/javascript"></script>

	<script type="text/javascript">
	var bgid="";
	function setbgid(id){
		bgid=id;
    }
      function edit_user(value,userid){
			var temp=value.split(",");
			if(temp[0]=="rsetpass"){
				if(confirm('确定吗？此操作将不能恢复,该会员的密码将被系统重置为默认密码:qianbaobao365.com')){
					var url="<?php echo site_url('admin/editUser');?>/"+userid+"/"+temp[0]+"/"+temp[1];
					$.post(url,null,callback1,"text");
				}
			}else if(temp[0]=="photo" || temp[0]=="jifen"){
				if(confirm('确定吗？此操作将不能恢复！')){
					var url="<?php echo site_url('admin/editUser');?>/"+userid+"/"+temp[0]+"/"+temp[1];
					$.post(url,null,callback1,"text");
				}
			}else{
				if(confirm('确定进行此操作?')){
					var url="<?php echo site_url('admin/editUser');?>/"+userid+"/"+temp[0]+"/"+temp[1];
					$.post(url,null,callback1,"text");
				}
			}
       }
      function callback1(data){
			alert(data);
			window.location.reload();
		}
       function changebg(op,id){
    	   if(bgid!=""){
				$("#"+bgid).css("background-color","white");
			}
			$("#"+id).css("background-color","#CDF08F");
        }
    </script>
  
</head>
<body>
<div id="CashPage">
<div id="MainPage">
    <div id="MainContain">
        <div id="MainHead">
        <?php	$quanxian=$_SESSION['userInfo']['quanxian'];
        		if($quanxian==-1) 
        			$jibie='已被管理员禁止发言';
        		elseif($quanxian==0) 
        			$jibie='普通会员';
        		elseif($quanxian==1) 
        			$jibie='管理员';
        		elseif($quanxian==2) 
        			$jibie='超级管理员';
        		else echo '未知';
        ?>    
		<?php 
				$this->load->view("head");
		?>
        </div>
        <div id="MainBody">
        	<div id="MainCount">
				<div id="MainBanner">
					<div id="MainB1"><img width="80" src="<?php if($_SESSION['userInfo']['photo'] != '') $photo=$_SESSION['userInfo']['photo'];else $photo='images/default.gif'; echo base_url().$photo;?>" align="middle" /></div>
					<div id="MainB2">&nbsp;<?php if(isset($gonggao)) echo $gonggao;?></div>
					<div id="MainB3"><strong>&nbsp;<?php echo $_SESSION['userInfo']['username'];?></strong>：您好，欢迎使用钱宝宝。您可以修改个人信息与修改密码。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: <?php echo '&nbsp;<a href="'.site_url('welcome/user').'">账号管理</a>';?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php if($quanxian==1 || $quanxian==2){ echo '&nbsp;<a href="'.site_url('admin/set_user_quanxian/0').'">管理普通会员</a>';echo '&nbsp;<a href="'.site_url('admin/set_user_zt/-1').'">管理已锁定账号</a>';echo '&nbsp;<a href="'.site_url('admin/set_user_quanxian2/-1').'">管理已禁言账号</a>';} ?>
						<?php if($quanxian==2) echo '&nbsp;<a href="'.site_url('admin/set_user_quanxian/1').'">管理管理员</a>';?>
					</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a></div>
        	</div>
        	
            <div id="MainList">
                <table class="DataTab" width="798" id="tab">
					<thead>
					<tr>
					<th width="50">用户id</th>
					<th width="100">用户名</th>
					<th width="30">性别</th>
					<th width="200">邮箱</th>
					<th width="140">注册日期</th>
					<th width="50">积分</th>
					<th width="70">用户级别</th>
					<th width="70">用户状态</th>
					<th >操作</th>
					</tr>
					</thead>
					<tbody>
					<?php 
						foreach($users as $row):
							$quanxian2=$row['quanxian2'];
							if(-1 == $quanxian2)	$stu='禁止发言';
							elseif(0 == $quanxian2)	$stu='自由发言';
							elseif(-2 == $quanxian2)	$stu='禁止发帖';
							elseif(-3 == $quanxian2)	$stu='禁止回帖';
							else $stu='未定义';
							if(-1 == $row['zhuangtai'])	$stu='已锁定';
							elseif(1 == $row['zhuangtai']) ;
							else $stu='未激活';
							$id=$row['id']+0;
								
					?>
						<tr id="<?php echo $id;?>" onmouseover="changebg(1,<?php echo $id;?>);" onmouseout="setbgid(<?php echo $id;?>);">
							<th><?php echo $id;?></th>
							<th><?php echo $row['username'];?></th>
							<th><?php echo $row['sex'];?></th>
							<th><?php echo $row['email'];?></th>
							<th><?php echo $row['date_time'];?></th>
							<th><?php echo $row['jifen']+0;?></th>
							<th>
								<?php 
									if($row['quanxian']==0){
										echo '普通会员';
									}elseif($row['quanxian']==1){
										echo '管理员';
									}
								?>
							</th>
							<th><?php echo $stu;?></th>
							<th>
								<select onchange="edit_user(this.value,<?php echo $id;?>);">
									<option value="">选择操作</option>
									<option value="quanxian2,-1">禁止发言</option>
									<option value="quanxian2,-2">禁止发帖</option>
									<option value="quanxian2,-3">禁止回帖</option>
									<option value="quanxian2,0">恢复发言</option>
									<optgroup label="----------"></optgroup>
									<option value="rsetpass,999">重置密码</option>
									<option value="photo,999">删除头像</option>
									<option value="jifen,0">积分清零</option>
									<optgroup label="----------"></optgroup>
									<option value="zhuangtai,-1">锁定账号</option>
									<option value="zhuangtai,1">解锁账号</option>
									<?php if($quanxian==2):?>
									<optgroup label="----------"></optgroup>
									<option value="quanxian,1">设为管理员</option>
									<option value="quanxian,0">取消管理员</option>
									<?php endif;?>
								</select>
							</th>
						</tr>
					<?php endforeach;?>
					</tbody>
					</table>
				<div id="PageList">
					<?php echo $this->pagination->create_links();?>
				</div>               
            </div>
        </div>
		<div id="MainFoot"><?php $this->load->view('foot');?></div>
    </div>
</div>
</div>


</body>
</html>