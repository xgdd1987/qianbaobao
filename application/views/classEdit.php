<!doctype html>
<html>
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手" />
	<meta name="Description" content="钱宝宝,您的理财小助手！" />
	<meta name="Author" content="Http://www.qianbaobao365.com" />
    <title>钱宝宝 - 您的理财小助手 - [www.qianbaobao365.com]</title>  
	<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js" ></script>
	<style type="text/css"> 
<!--
*{padding:0;margin:0}  
.pop{z-index:2;position:absolute;left:40%;top:40%;width:300px;height:100px;border:2px solid #F25000;background-color:white;display:none;} 
--> 
</style>
	<script type="text/javascript">
		function delClass(id){
			if(confirm('确定删除吗？该操作将删除该分类与该分类下的所有记账记录！此操作将不能恢复！')){
				var url="<?php echo site_url('welcome/delClass');?>/"+id;
				$.post(url,null,callback1,"text");
			}
		}
		function callback1(data){
			alert(data);
			window.location.reload();
		}
		//提交弹出框
		function editClass(){
			var id=document.getElementById("hiddenid").value;
			var name=document.getElementById("newname").value;
			var istongji =document.getElementById("istongji2");
			var tongji=1;
			if(istongji.checked){
				 tongji=1;
			}else{
				 tongji=0;
			}
			var url="<?php echo site_url('welcome/editClass');?>/"+id+"/"+name+"/"+tongji;
			url=encodeURI(url);
			$.post(url,null,callback2,"text");
		}
		function callback2(data){
			alert(data);
			window.location.reload();
		}
		//弹出框
		function show1(id,name,istongji){
			var o1 = document.getElementById("pop1"); 
			var o2 = document.getElementById("pop2");
			document.getElementById("hiddenid").value=id;
			document.getElementById("newname").value=name;
			if(istongji==1){
				document.getElementById("istongji2").checked="checked";
			}else{
				document.getElementById("istongji2").checked="";
			}
			o1.style.width = document.documentElement.scrollWidth; 
			o1.style.height = document.documentElement.scrollHeight
			o1.style.display = "block"; 
			o2.style.display = "block"; 
		}
		//隐藏弹出框
		function hiddenPop(){
			document.getElementById("pop1").style.display = "none";
			document.getElementById("pop2").style.display = "none";
		}
		//添加类
		function addClass(){
			var pid=document.getElementById("pid").value;
			var className=document.getElementById("className").value;
			var istongji =document.getElementById("istongji");
			var tongji=1;
			if(!istongji.checked){
				 tongji=0;
			}
			if(pid=="" || className==""){
				alert("请选择隶属分类或者名称不能为空!");
			}else{
				var url="<?php echo site_url('welcome/addClass');?>/"+pid+"/"+className+"/"+tongji;
				url=encodeURI(url);
				$.post(url,null,callback2,"text");
			}
		}
		 function changebg(op,id){
				if(op==1)
					$("#div1"+id).css("background-color","#CDF08F");
				else if(op==0)
					$("#div1"+id).css("background-color","white");
	        }
	</script>
	
	
</head>
<body>
<div id="CashPage" style="width:99%;">
<div id="MainPage">
	<div id="MainContain">
		<div id="MainHead">
			<?php $this->load->view('head');?>
		</div>
		<div id="MainBody">
			<div id="MainCount">
				<div id="MainBanner">
					<div id="MainB1"><img width="80" src="<?php if($_SESSION['userInfo']['photo'] != '') $photo=$_SESSION['userInfo']['photo'];else $photo='images/default.gif'; echo base_url().$photo;?>" align="middle" /></div>
					<div id="MainB2">&nbsp;<?php if(isset($gonggao)) echo $gonggao;?></div>
					<div id="MainB3"><strong>&nbsp;<?php echo $_SESSION['userInfo']['username'];?></strong>：您好，欢迎使用钱宝宝。您可以添加新的分类与编辑分类。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: &gt;&gt;分类设置</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a></div>
			</div>
			<div id="MainList">
				<div class="MainClassList">
					<div class="MainClassListHead">收入分类</div>
					<div class="MainClassListBdoy" style="padding: 10px 0px;">
						<?php foreach($shouru as $row):?>
						<div class="MainClassListItemTxt" id="div1<?php echo $row['id']+0;?>" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><?php echo $row['name'];?></div>
						<div class="MainClassListItemDel" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);">
							<a href="#" title="删除" onClick="delClass(<?php echo $row['id']+0;?>);"></a>
						</div>
						<div class="MainClassListItemEdit" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><a href="#" title="编辑"  onClick="show1(<?php echo $row['id']+0;?>,'<?php echo $row['name'];?>',<?php echo $row['istongji'];?>);"></a></div>
						<?php endforeach;?>
					</div>
				</div>
				<div class="MainClassList">
					<div class="MainClassListHead">支出分类</div>
					<div class="MainClassListBdoy">
						<div class="MainClassListBdoy">
						<?php foreach($zhichu as $row):?>
						<div class="MainClassListItemTxt" id="div1<?php echo $row['id']+0;?>" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><?php echo $row['name'];?></div>
						<div class="MainClassListItemDel" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);">
							<a href="#" title="删除" onClick="delClass(<?php echo $row['id']+0;?>);"></a>
						</div>
						<div class="MainClassListItemEdit" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><a href="#" title="编辑"  onClick="show1(<?php echo $row['id']+0;?>,'<?php echo $row['name'];?>',<?php echo $row['istongji'];?>);"></a></div>
						<?php endforeach;?>
					</div>
					</div></div>
				<div class="MainClassList">
					<div class="MainClassListHead">借贷分类</div>
					<div class="MainClassListBdoy">
						<div class="MainClassListBdoy">
						<?php foreach($jie as $row):?>
						<div class="MainClassListItemTxt" id="div1<?php echo $row['id']+0;?>" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><?php echo $row['name'];?>&nbsp;(+)</div>
						<div class="MainClassListItemDel" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);">
							<a href="#" title="删除" onClick="delClass(<?php echo $row['id']+0;?>);"></a>
						</div>
						<div class="MainClassListItemEdit" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><a href="#" title="编辑"  onClick="show1(<?php echo $row['id']+0;?>,'<?php echo $row['name'];?>',<?php echo $row['istongji'];?>);"></a></div>
						<?php endforeach;?>
						<?php foreach($dai as $row):?>
						<div class="MainClassListItemTxt" id="div1<?php echo $row['id']+0;?>" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><?php echo $row['name'];?>&nbsp;(-)</div>
						<div class="MainClassListItemDel" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);">
							<a href="#" title="删除" onClick="delClass(<?php echo $row['id']+0;?>);"></a>
						</div>
						<div class="MainClassListItemEdit" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><a href="#" title="编辑"  onClick="show1(<?php echo $row['id']+0;?>,'<?php echo $row['name'];?>',<?php echo $row['istongji'];?>);"></a></div>
						<?php endforeach;?>
					</div>
					</div></div>
				<div id="MainAddClassForm">
					<div class="MainAddClassFormHead">添加类别</div>
					<div class="EditFromItemSpace"></div>
					<div class="EditFromItem">隶属：
						<select name="pid" id="pid" class="inputText" style="width:155px;">
							<option value="">-----请选择隶属分类----</option>
							<option value="1" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;收入 </option>
							<option value="2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;支出</option>
							<option value="3" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;借(资金流入)</option>
							<option value="4" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;贷(资金流出)</option>
						</select></div>
					<div class="EditFromItem">名称：<input name="className" id="className" value="" type="text" class="inputText" maxlength="10"></div>
					<div class="EditFromItem">是否在财务分析中统计：<input name="istongji" id="istongji"  type="checkbox" class="checkbox2" maxlength="10" checked="checked"/>&nbsp;&nbsp;</div>
					<div class="EditFromItem"><input name="submit" class="btnSubmit" type="button" value="添加" onclick="addClass();"></div>
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

 
 
 <div id="pop2">
					<div class="MainAddClassFormHead">修改类别名称<a style="float: right;width:14px;height:14px;background: url('<?php echo base_url();?>/images/pop_close.png');" onclick="hiddenPop();" href="#" ></a></div>
					<div class="EditFromItemSpace"></div>
					<div class="EditFromItem">新名称：
						<input  name="newname" id="newname" class="inputText" type="text" value="" maxlength="8" />
						<input type="hidden" name="hiddenid" id="hiddenid" />
					</div>
					<div class="EditFromItem">是否在财务分析中统计：<input name="istongji2" id="istongji2" type="checkbox" class="checkbox2" maxlength="10" checked="checked"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
					<div class="EditFromItem"><input name="submit" class="btnSubmit" type="button" value="修改" onclick="editClass();">&nbsp;&nbsp;<input name="submit" class="btnSubmit" type="button" value="取消" onclick="hiddenPop();"></div>
					<div class="EditFromItemSpace"></div>
				</div>
</body></html>