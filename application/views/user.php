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
    <script src="<?php echo base_url();?>js/jquery.Jcrop.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>css/jquery.Jcrop.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url();?>css/demos.css" type="text/css" />

	<script type="text/javascript">
       var c = new Calendar("c");
       document.write(c);
       function changeStyle(id){
			document.getElementById(id+"1").style.display="none";
			document.getElementById(id+"2").style.display="";
       }
       function updateUser(key){
    	    document.getElementById(key+"1").style.display="";
			document.getElementById(key+"2").style.display="none";
			kvalue=document.getElementById(key).value;
			var url="<?php echo site_url('welcome/editUser');?>/"+key+"/"+kvalue;
			url=encodeURI(url);
			$.post(url,null,callback,"text");
     }
       function exitUpdate(key){
    	   document.getElementById(key+"1").style.display="";
		   document.getElementById(key+"2").style.display="none";
      }
       function callback(data){
          // alert(data);
           var dt=data.split("=");
           if(dt[0] == 0){
				alert(dt[1]);
           }else{
        	   document.getElementById(dt[0]).value=dt[1];
        	   document.getElementById(dt[0]+"1").innerHTML=dt[1];
           }
    	   
		//	window.location.reload();
		}
		function changePass(){
			var oldpass=document.getElementById("oldpass").value;
			var newpass=document.getElementById("newpass").value;
			var rnewpass=document.getElementById("rnewpass").value;
			if(oldpass.length<5){
				alert("原密码的长度不能小于5位!");
				return;
			}
			if(newpass.length<5){
				alert("新密码的长度不能小于5位!");
				return;
			}
			if(newpass == oldpass){
				alert("新密码和原密码不能相同!");
				return;
			}
			if(newpass != rnewpass){
				alert("新密码和确认密码不相同!");
				return;
			}
			var url="<?php echo site_url('welcome/changePass');?>/"+oldpass+"/"+newpass;
			$.post(url,null,callback2,"text");
		}
		function callback2(data){
			alert(data);
			document.getElementById("oldpass").value="";
			document.getElementById("newpass").value="";
			document.getElementById("rnewpass").value="";
		}
		function updatePhoto(){
			document.getElementById("updatePhoto").style.display="";
			document.getElementById("updatePhoto1").style.display="none";
			document.getElementById("updatePhoto2").style.display="";
		}
		function exitUpdatePhoto(){
			document.getElementById("updatePhoto").style.display="none";
			document.getElementById("updatePhoto1").style.display="";
			document.getElementById("updatePhoto2").style.display="none";
		}
		function checkPhoto(){
			var f=document.getElementById("photo").value;
	         if(f=="")
	         { alert("请选择上传图片");return false;}
	         else
	         {
		         if(!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(f))
		         {
		           alert("图片类型必须是 gif、jpeg、jpg、png中的一种！")
		           return false;
		         }
	         }
	         document.getElementById("pop1").style.display="";
	         document.getElementById("doing").style.display="";
	         return true;
		}
    </script>
    <script type="text/javascript">
    function checkCoords()
	{
    	
		if (!parseInt($('#w').val())){
			alert('请在左侧图片中选中一块区域进行裁剪!');
			return false;
		}
		var x=$('#x').val();
		var y=$('#y').val();
		var w=$('#w').val();
		var h=$('#h').val();

		var picname=$('#picname').val();
		var url="<?php echo site_url('group/cutPhoto');?>/"+x+"/"+y+"/"+w+"/"+h+"/"+picname;
		document.getElementById("outer").style.display="none";
		document.getElementById("doing").style.display="";
		$.post(url,null,callback3,"text");
	};
	function callback3(data){
		alert(data);
		window.location.href="<?php echo site_url('welcome/user');?>";
	}
	function shouwcut(){
		var o1 = document.getElementById("pop1"); 
		var o2 = document.getElementById("outer");
		o1.style.width = document.documentElement.scrollWidth; 
		o1.style.height = document.documentElement.scrollHeight
		o1.style.display = "block"; 
		o2.style.display = "block";
	}
	//取消编辑头像
	function exitshouwcut(){
		//用js删除已上传的图片 2012-10-24

		
		window.location.href="<?php echo site_url('welcome/user');?>";
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
					<div id="MainB4">&nbsp;您的当前位置: &gt;&gt;账号管理&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="updatePhoto1" onclick="updatePhoto();">点我修改头像</a><a href="#" style="display: none;" id="updatePhoto2" onclick="exitUpdatePhoto();">点我取消修改头像</a>
						<?php if($quanxian==1 || $quanxian==2){ echo '&nbsp;<a href="'.site_url('admin/set_user_quanxian/0').'">管理普通会员</a>';echo '&nbsp;<a href="'.site_url('admin/set_user_zt/-1').'">管理已锁定账号</a>';echo '&nbsp;<a href="'.site_url('admin/set_user_quanxian2/-1').'">管理已禁言账号</a>';} ?>
						<?php if($quanxian==2) echo '&nbsp;<a href="'.site_url('admin/set_user_quanxian/1').'">管理管理员</a>';?>
						<a href="<?php echo site_url('welcome/login_log');?>">登录日志</a>
					</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a></div>
        	</div>
        	<div style="background-color: #FFFFFF;">
        		<div style="margin:0 auto;text-align: center;"><font color=red size=2> <?php echo $error;?></font></div>
        		<div style="width:500px;display: none;" id="updatePhoto">
        					
							<form method="post"  enctype="multipart/form-data" onSubmit="return checkPhoto();">
							<input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['userInfo']['id']+0;?>" />
							<table class="DataTab2" width="798" id="tab">
								<tbody>
									<tr>
										<th width="100"><font size="2"><b>修改头像:</b>&nbsp;</font></th>
										<td><input type="file" name="photo" id="photo" class="inputText" style="width:300px;" />
									&nbsp;<input type="submit" value="确认" class="btnSubmit" onclick="checkPhoto();"/>
									&nbsp;<input type="button" value="取消" class="btnSubmit" onclick="exitUpdatePhoto();"/></td>
									</tr>
								</tbody>
							</table>
							</form>
						</div></div>
            <div id="MainList">
                <div class="MainUserList">
                	<table class="DataTab2" width="523" id="tab">
						<tbody>
							<tr>
								<th width="100">用户名</th>
								<td><?php echo $_SESSION['userInfo']['username'];?></td>
							</tr>
							<tr>
								<th width="100">用户级别</th>
								<td><?php echo $jibie;?></td>
							</tr>
							<tr>
								<th>性别</th>
								<td title="双击此处修改性别" ondblclick="changeStyle('sex');">
									<span id="sex1"><?php $sex=$_SESSION['userInfo']['sex']; echo $sex;?></span>
									<span id="sex2" style="display: none;">	
										<select id="sex" style="width:50px;">
											<option <?php if($sex=="男") echo "selected=selected"; ?> value="男">男</option>
											<option <?php if($sex=="女") echo "selected=selected"; ?> value="女">女</option>
											<option <?php if($sex=="保密") echo "selected=selected"; ?> value="保密">保密</option>
										</select>
										&nbsp;<input type="button" value="确认修改" class="btnSubmit" onclick="updateUser('sex');"/>
										&nbsp;<input type="button" value="取消" class="btnSubmit" onclick="exitUpdate('sex');"/> 
									</span>
								</td>
							</tr>
							
							<tr>
								<th>生日</th>
								<td title="双击此处修改生日" ondblclick="changeStyle('birthday');">
									<span id="birthday1"><?php echo $_SESSION['userInfo']['birthday'];?></span>
									<span id="birthday2" style="display: none;">	
										<input type="text" id="birthday" readonly="readonly"  onfocus="c.showMoreDay = false;c.show(this);" class="inputText" value="<?php echo $_SESSION['userInfo']['birthday'];?>" style="text-align: center;width:163px;" />
										&nbsp;<input type="button" value="确认修改" class="btnSubmit" onclick="updateUser('birthday');"/>
										&nbsp;<input type="button" value="取消" class="btnSubmit" onclick="exitUpdate('birthday');"/> 
									</span>
								</td>
							</tr>
							<tr>
								<th>邮箱</th>
								<td><?php echo $_SESSION['userInfo']['email'];?></td>
							</tr>
							<tr>
								<th>积分</th>
								<td><?php if($_SESSION['userInfo']['jifen']=='')echo 0;else echo $_SESSION['userInfo']['jifen'];?>分</td>
							</tr>
							<tr>
								<th>注册日期</th>
								<td><?php echo $_SESSION['userInfo']['date_time'];?></td>
							</tr>
						</tbody>
					</table>
				</div>
                <div id="MainAddUserForm">
                	<div class="MainAddUserFormHead">修改密码</div>
					<div class="EditFromItemSpace"></div>
					<div class="EditFromItem">原密码：<input id="oldpass" value="" type="password" class="inputText" maxlength="20"></div>
					<div class="EditFromItem">新密码：<input id="newpass" value="" type="password" class="inputText" maxlength="15"></div>
					<div class="EditFromItem">确&nbsp;&nbsp;&nbsp;&nbsp;认：<input id="rnewpass" value="" type="password" class="inputText" maxlength="15"></div>
					<div class="EditFromItem"><input name="submit" class="btnSubmit" type="button" value="修改" onclick="changePass();"></div>
					<div class="EditFromItemSpace"></div>

				</div>
                <div class="clear"></div>                
            </div>
        </div>
		<div id="MainFoot"><?php $this->load->view('foot');?></div>
    </div>
</div>
</div>


<div id="pop1" style="opacity: .7;z-index:1;background-color:#CCCCCC;filter: alpha(opacity=80);width:100%;height:100%;position:absolute;left:0px;top:0px;display:none"> 
</div>
  <div id="outer" style="z-index:2;	position:absolute;left:10%;top:100px;display:none;">
  <div class="jcExample">
    <h1>裁剪头像</h1>
    <table border=0 width="100%" align="center">
      <tr>
        <td align="center">
          <img src="<?php echo base_url().'imgtemp/'.$picname;?>" id="target1" alt="头像裁切" />
        </td>
        <td valign="top" width="55">
        	<br/>头像预览:<br/><br/><br/><br/><br/><br/><br/><br/><br/>
        	<input type="button" class="AddBtn" onclick="checkCoords();" style="margin-left:0;" value="确定" />
        </td>
        <td valign="top" width="100">
          <div style="width:100px;height:100px;overflow:hidden;">
            <img src="<?php echo base_url().'imgtemp/'.$picname;?>" id="preview" alt="Preview" class="jcrop-preview" />
          </div>
          <br/><br/><br/>&nbsp;
          <input type="button" class="AddBtn" onclick="exitshouwcut();" style="margin-left:0;margin-top:10px;" value="取消" />
          <input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" id="picname" name="picname" value="<?php echo $picname;?>"/>
        </td>
      </tr>
    </table>
  </div>
  </div>
<div id="doing" style="z-index:3;	position:absolute;left:20%;top:150px;display:none;">
<div class="jcExample" style="text-align: center;">
<font size="5">后台处理中,请稍后...</font>
</div>

</div>






<?php if($has_post_photo == TRUE){?>
	<script type="text/javascript">updatePhoto();</script>

	<?php 
			if($picname != 'default.gif'){
	?>
		 <script type="text/javascript">
		   shouwcut();
    jQuery(function($){
      // Create variables (in this scope) to hold the API and image size
      var jcrop_api, boundx, boundy;
      $('#target1').Jcrop({
        onChange: updatePreview,
        onSelect: updatePreview,
        aspectRatio: 1,
        setSelect: [0,0,80,80]
      },function(){
         
        // Use the API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
  //      alert("boundx:"+boundx);
  //      alert("boundxy:"+boundy);
        // Store the API in the jcrop_api variable
        jcrop_api = this;
      });
  //    alert(1);
      function updatePreview(c)
      { 
  //  	  alert("updatePreview");
        if (parseInt(c.w) > 0)
        {
        	$('#x').val(c.x);
    		$('#y').val(c.y);
    		$('#w').val(c.w);
    		$('#h').val(c.h);
          var rx = 100 / c.w;
          var ry = 100 / c.h;
          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
      };
    });
 
  </script>
	<?php 			
				
			}
		}
	?>
	<script>//shouwcut();</script>
</body>
</html>
