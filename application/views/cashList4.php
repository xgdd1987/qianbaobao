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
		var bgid="";
		function delCash(id){
			if(confirm('确定删除吗？此操作将不能恢复！')){
				var url="<?php echo site_url('welcome/delCash4');?>/"+id;
				$.post(url,null,callback1,"text");
			}
		}
		function delAllCash(){
			if(confirm('确定清空回收站吗？此操作将不能恢复！')){
				var url="<?php echo site_url('welcome/delAllCash');?>";
				$.post(url,null,callback1,"text");
			}
		}
		function resetCash(id){
			if(confirm('确定恢复该账单吗？')){
				var url="<?php echo site_url('welcome/resetCash');?>/"+id;
				$.post(url,null,callback1,"text");
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
	       function setbgid(id){
				bgid=id;
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
					<div id="MainB3"><strong>&nbsp;<?php echo $_SESSION['userInfo']['username'];?></strong>：您好！<span class="MainCount_in">总收入：<?php $shouru=$shouru[0]['sum'];if($shouru != null)echo $shouru;else echo 0; ?>&nbsp;￥</span> | <span class="MainCount_out">总支出：<?php $zhichu=$zhichu[0]['sum'];if($zhichu != null) echo $zhichu;else echo 0; ?>&nbsp;￥</span> | <span class="MainCount_in">借入：<?php $jie=$jie[0]['sum'];if($jie != null) echo $jie;else echo 0; ?>&nbsp;￥</span> | <span class="MainCount_out">借出：<?php $dai=$dai[0]['sum']; if($dai != null) echo $dai;else echo 0; ?>&nbsp;￥</span> | <span class="MainCount_total">结余：<?php echo $shouru-$zhichu+$jie-$dai;?>&nbsp;￥</span></div>
					<div id="MainB4">&nbsp;您的当前位置: &gt;&gt;回收站账单&nbsp; 
						
					</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onclick="return confirm('确定退出登录吗？');">安全退出</a></div>
            </div>
            <div id="MainList">
            	<?php if(isset($tip)):?>
            	<div class="ListTip">
            		<?php echo $tip;?>
            		
            	</div>
            	<?php endif;?>
	            <table class="DataTab" width="798" id="tab">
					<thead>
					<tr>
					<th width="88">时间</th>
					<th width="50">类型</th>
					<th width="110">类别</th>
					<th width="260">账单名称</th>
					<th width="105">支付方式</th>
					<th width="105">金额</th>
					<th width="80">操作</th>
					</tr>
					</thead>
					<tbody>
						<?php foreach($cashList as $row):$id=$row['id']+0;?>
						<tr id="<?php echo $id;?>" onmouseover="changebg(1,<?php echo $id;?>);" onmouseout="setbgid(<?php echo $id;?>);">
							<th><?php echo $row['paydate'];?></th>
							<th><img src="<?php echo base_url();if($row['pid']==1 ||$row['pid']==3) echo 'images/1.gif';else echo 'images/2.gif'; ?>" /></th>
							<th><?php echo $row['name'];?></th>
							<th class="dtLeft" title="备注:&nbsp;<?php echo $row['mark'];?>"><?php echo $row['cashname'];?></th>
							<th><?php echo $row['pay'];?></th>
							<th><span class=""><?php echo $row['money'];?></span></th>
							<th><a href="#" title="删除账单" onclick="delCash(<?php echo $id;?>);"><img src="<?php echo base_url();?>images/del.gif"/></a>
								<a href="#" title="恢复账单" onclick="resetCash(<?php echo $id;?>);"><img src="<?php echo base_url();?>images/edit.gif"/></a>
							</th>
						</tr>
						<?php endforeach;?>
						
					</tbody>
					</table>
					<div style="float: right;margin-top: 5px;"><a href="#" title="一键清空回收站" onclick="delAllCash();">一键清空回收站</a></div>
				<div id="PageList">
					<?php echo $this->pagination->create_links();?>
			
				</div>
			</div>
        </div>
		<div id="MainFoot"><?php $this->load->view("foot");?></div>
    </div>
</div>
</div>
</body>
</html>
