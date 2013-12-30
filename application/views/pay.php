<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>钱宝宝 - 您的理财小助手 - [www.qianbaobao365.com]</title>
<meta http-equiv="Content-Type" content="text/html; chaRset=utf-8" />
<meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手" />
	<meta name="Description" content="钱宝宝,您的理财小助手！" />
	<meta name="Author" content="Http://www.qianbaobao365.com" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js" ></script>
<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	function delPay(id){
		if(confirm('确定删除吗？此操作将不能恢复！')){
			var url="<?php echo site_url('welcome/delPay');?>/"+id;
			$.post(url,null,callback1,"text");
		}
	}
	function callback1(data){
		alert(data);
		window.location.reload();
	}
	function editPay(){
		var id=document.getElementById("payid").value;
		var name=document.getElementById("payname").value;
		var url;
		
		var payc=form1.payc;
		var i = 0;
		var check=true;
		var payvalue="";
		for(i=0;i<payc.length;i++){
			if(payc[i].checked==true){
				payvalue=payc[i].value;
				check=false;
			}
		}
		if(name == ""){
			alert("名称不能为空!");
			return;
		}else if(check){
			alert("请选择方式!");
			return;
		   }else{
			if(id==""){
				url="<?php echo site_url('welcome/addPay');?>/"+name+"/"+payvalue;
				
			}else{
				url="<?php echo site_url('welcome/editPay');?>/"+id+"/"+name+"/"+payvalue;
			}
			url=encodeURI(url);
			$.post(url,null,callback1,"text");
		   }
	}
	function addPay(){
		var id=document.getElementById("payid").value;
		var name=document.getElementById("payname").value;		
		var payc=form1.payc;
		var i = 0;
		var check=true;
		var payvalue="";
		for(i=0;i<payc.length;i++){
			if(payc[i].checked==true){
				payvalue=payc[i].value;
				check=false;
			}
		}
		if(name == ""){
			alert("名称不能为空!");
			return;
		}else if(check){
			alert("请选择方式!");
			return;
		}else{
			url="<?php echo site_url('welcome/addPay');?>/"+name+"/"+payvalue;
		url=encodeURI(url);
		$.post(url,null,callback1,"text");
		}
	}
	function editReady(id,name,payvalue){
		document.getElementById("payid").value=id;
		document.getElementById("payname").value=name;
		var payc=form1.payc;
		var i = 0;
		if(payvalue!=""){
			for(i=0;i<payc.length;i++){
				if(payc[i].value==payvalue){
					payc[i].checked=true;
				}else{
					payc[i].checked=false;
				}
			}
		}
		
		document.getElementById("submit1").value="修改";
		document.getElementById("submit2").type="button";
	}
	function changebg(op,id){
		if(op==1)
			$("#"+id).css("background-color","#CDF08F");
		else if(op==0)
			$("#"+id).css("background-color","white");
    }
</script>
</head>
<body>
<div id="CashPage" style="width: 99%;">
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
					<div id="MainB3"><strong>&nbsp;<?php echo $_SESSION['userInfo']['username'];?></strong>：您好，欢迎使用钱宝宝。您可以添加新的分类与编辑支付方式。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: &gt;&gt;支付方式</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a></div>
        	</div>
            <div id="MainList">
                <div class="MainClassList">
                	<div class="MainClassListHead">支付方式</div>
                	<div class="MainClassListBdoy">
						<?php foreach($pay as $row):?>
                			<div class="MainClassListItemTxt" id="<?php echo $row['id']+0;?>" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);"><?php echo $row['name'];?></div>
                			<div class="MainClassListItemDel" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);">
                				<a href="#" title="删除" onclick="delPay(<?php echo $row['id']+0;?>);"></a>
                			</div>
                			<div class="MainClassListItemEdit" onmouseover="changebg(1,<?php echo $row['id']+0;?>);" onmouseout="changebg(0,<?php echo $row['id']+0;?>);">
                				<a href="#" title="编辑" onclick="editReady(<?php echo $row['id']+0;?>,'<?php echo $row['name'];?>','<?php echo $row['pay'];?>');"></a>
                			</div>
						<?php endforeach;?>
					</div></div>
                <div id="MainAddPayForm">
                <form name="form1">
                <div class="MainAddPayFormHead">添加与编辑支付方式</div>
				<div class="EditFromItemSpace"></div>
				<div class="EditFromItem">名称:
					<input name="payname" id="payname" type="text" class="inputText" maxlength="10" style="width:170px;"/>&nbsp;&nbsp;
					<input name="payid" id="payid" type="hidden" maxlength="100" />
				</div>
				<div class="EditFromItem">方式:
					<input type="radio" name="payc" value="1"  />现金
					<input type="radio" name="payc" value="2"  />刷卡
					<input type="radio" name="payc" value="3"  />代金券
					<input type="radio" name="payc" value="0"  />其他
				</div>
				<div class="EditFromItem">
					<input name="submit1" id="submit1" class="btnSubmit" type="button" onclick="editPay();" value="添加" />
					<input name="submit2" id="submit2" class="btnSubmit" type="hidden" onclick="addPay();" value="新添加" />
					
					
				</div>
				<div class="EditFromItemSpace"></div></form>
</div>
                <div class="clear"></div>                
            </div>
        </div>
		<div id="MainFoot"><?php $this->load->view('foot');?></div>
    </div>
</div>
</div>
</body>
</html>
