<!doctype html>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>钱宝宝 - 您的理财小助手 - [www.qianbaobao365.com]</title> 
    <meta http-equiv="Content-Language" content="zh-cn"> 
	<meta name="keywords" content="小钱袋子,钱宝宝,理财,小助手" />
	<meta name="Description" content="钱宝宝,您的理财小助手！" />
	<meta name="Author" content="Http://www.qianbaobao365.com" />
	<link href="<?php echo base_url();?>css/css.css" rel="stylesheet" type="text/css">
	<SCRIPT type="text/javascript" src="<?php echo base_url();?>js/Calendar5.js"></SCRIPT>
	  <script type="text/javascript">
        var c = new Calendar("c");
       document.write(c);
       function duibi(a, b) {
   	    var arr = a.split("-");
   	    var starttime = new Date(arr[0], arr[1], arr[2]);
   	    var starttimes = starttime.getTime();

   	    var arrs = b.split("-");
   	    var lktime = new Date(arrs[0], arrs[1], arrs[2]);
   	    var lktimes = lktime.getTime();

   	    if (starttimes > lktimes) {
   	        return false;
   	    }
   	    else
   	        return true;

   	}
       function tongji(){
			var st=document.getElementById('st').value;
			var et=document.getElementById('et').value;
			if(st == ""){
				alert("开始日期不能为空!");
				return;
			}
			if(et == ""){
				alert("结束日期不能为空!");
				return ;
			}
			if(!duibi(st,et)){
				alert("开始日期不能大于结束日期");
				return ;
			}
			//判断日期大小
			window.location.href="<?php echo site_url('welcome/count');?>"+"/"+st+"/"+et;
			
       }
    </script>
</head>
<body>
<div id="CashPage">
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
					<div id="MainB3"><strong>&nbsp;<?php echo $_SESSION['userInfo']['username'];?></strong>：您好，欢迎使用钱宝宝。您私人的财务统计报表，快看看您的钱宝宝里还有多少银子吧。(<?php echo date('Y-m-d H:i');?>)</div>
					<div id="MainB4">&nbsp;您的当前位置: &gt;&gt;财务分析</div>
				</div>
				<div id="loginOut"><a href="<?php echo site_url('welcome/loginOut');?>" title="退出登录" onClick="return confirm('确定退出登录吗？');">安全退出</a></div>
			</div>
			<div id="MainList">
				<div id="MainCountList">
					<?php if($st != '2000-01-01'): ?>
					<div class="CountTip">现在列出的是从 <span class="KeyWords"><strong><?php echo $st;?></strong></span> - <span class="KeyWords"><strong><?php echo $et;?></strong></span> 的统计结果。<a href="javascript:history.go(-1)">(返回)</a></div>
					<?php endif;?>
					<div Class="MainCountHead"><strong>统计概况：</strong>温馨提示:&nbsp;横向: XX收入&nbsp;-&nbsp;XX支出&nbsp;=&nbsp;XX结余 &nbsp;|&nbsp;竖向: 总XX&nbsp;+&nbsp;总XX&nbsp;=&nbsp;总XX</div>
					<div class="MainCountBdoy">
					<?php 
						$shouru=$shouru[0]['sum']==null?0:$shouru[0]['sum'];
						$zhichu=$zhichu[0]['sum']==null?0:$zhichu[0]['sum'];
						$jie=$jie[0]['sum']==null?0:$jie[0]['sum'];
						$dai=$dai[0]['sum']==null?0:$dai[0]['sum'];
						
						$xianjins=$xianjins[0]['sum']==null?0:$xianjins[0]['sum'];
						$xianjinz=$xianjinz[0]['sum']==null?0:$xianjinz[0]['sum'];
						
						$shuakas=$shuakas[0]['sum']==null?0:$shuakas[0]['sum'];
						$shuakaz=$shuakaz[0]['sum']==null?0:$shuakaz[0]['sum'];
						
						$daijinquans=$daijinquans[0]['sum']==null?0:$daijinquans[0]['sum'];
						$daijinquanz=$daijinquanz[0]['sum']==null?0:$daijinquanz[0]['sum'];
						
						$qitas=$qitas[0]['sum']==null?0:$qitas[0]['sum'];
						$qitaz=$qitaz[0]['sum']==null?0:$qitaz[0]['sum'];
					?>
						
						
						<div class="MainCountList2">所有<b>现金</b>总收入：<span class="MainCount_in"><?php echo $xianjins;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/jian.png';?>"/></span>所有<b>现金</b>总支出：<span class="MainCount_out"><?php echo $xianjinz;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/deng.png';?>"/></span>所有<b>现金</b>结余：<span class="MainCount_total"><?php echo $xianjins-$xianjinz;?>￥</span></div>
						<div class="MainCountList2"><img style="margin-left:35px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList2">所有<b>刷卡</b>总收入：<span class="MainCount_in"><?php echo $shuakas;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/jian.png';?>"/></span>所有<b>刷卡</b>总支出：<span class="MainCount_out"><?php echo $shuakaz;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/deng.png';?>"/></span>所有<b>刷卡</b>结余：<span class="MainCount_total"><?php echo $shuakas-$shuakaz;?>￥</span></div>
						<div class="MainCountList2"><img style="margin-left:35px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList2">所有<b>代金券</b>总收入：<span class="MainCount_in"><?php echo $daijinquans;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/jian.png';?>"/></span>所有<b>代金券</b>总支出：<span class="MainCount_out"><?php echo $daijinquanz;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/deng.png';?>"/></span>所有<b>代金券</b>结余：<span class="MainCount_total"><?php echo $daijinquans-$daijinquanz;?>￥</span></div>
						<div class="MainCountList2"><img style="margin-left:35px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/jia.png';?>"/></div>				
						<div class="MainCountList2">所有<b>其他</b>总收入：<span class="MainCount_in"><?php echo $qitas;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/jian.png';?>"/></span>所有<b>其他</b>总支出：<span class="MainCount_out"><?php echo $qitaz;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/deng.png';?>"/></span>所有<b>其他</b>金结余：<span class="MainCount_total"><?php echo $qitas-$qitaz;?>￥</span></div>
						
						<div class="MainCountList2"><img style="margin-left:35px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/jia.png';?>"/></div>
						
						<div class="MainCountList2">所有借入：<span class="MainCount_out"><?php echo $jie;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/jian.png';?>"/></span>所有借出：<span class="MainCount_in"><?php echo $dai;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/deng.png';?>"/></span>所有负债(借入-借出)：<span class="MainCount_total"><?php echo $jie-$dai;?>￥</span></div>
						
						<div class="MainCountList2"><img style="margin-left:35px;" src="<?php echo base_url().'images/deng.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/deng.png';?>"/></div>
						<div class="MainCountList"><img style="margin-left:100px;" src="<?php echo base_url().'images/deng.png';?>"/></div>
						<div class="clear"></div>
						<hr width="100%" />
						<div class="MainCountList2">&nbsp;所有总收入：<span class="MainCount_total"><?php echo $shouru+$jie;?>￥</span></div> 
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/jian.png';?>"/></span>&nbsp;所有总支出：<span class="MainCount_total"><?php echo $zhichu+$dai;?>￥</span></div>
						<div class="MainCountList"><span style="margin-right: 50px;"><img src="<?php echo base_url().'images/deng.png';?>"/></span>所有结余：<span class="MainCount_total"><?php echo $shouru-$zhichu+$jie-$dai;?>￥</span></div>
						<div class="clear"></div>
					</div>
					<div Class="MainCountHead"><strong>收入分类统计：</strong></div>
					<div class="MainCountBdoy">
					
						<?php if(isset($shouru_c)): foreach($shouru_c as $row):?>
							<div class="MainCountClassList"><a href="<?php echo site_url('welcome/cashList3').'/'.($row['classid']);?>"><?php  echo $row['classname'];?>：<?php echo $row['classtotal'];?>￥ / <?php if($shouru != 0) echo round( $row['classtotal']/$shouru * 100 , 2);else echo 0;  ?>%    </a>  </div>
						<?php endforeach;endif;?> 
						<div class="clear"></div>
					</div>										
					<div Class="MainCountHead"><strong>支出分类统计：</strong></div>
					<div class="MainCountBdoy">
						<?php if(isset($zhichu_c)): foreach($zhichu_c as $row):?>
							<div class="MainCountClassList"><a href="<?php echo site_url('welcome/cashList3').'/'.($row['classid']);?>"><?php  echo $row['classname'];?>：<?php echo $row['classtotal'];?>￥ / <?php if($zhichu != 0) echo round( $row['classtotal']/$zhichu * 100 , 2);else echo 0;  ?>%  </a> </div>
						<?php endforeach;endif;?>  
						<div class="clear"></div>
					</div>																		
					<div Class="MainCountHead"><strong>资金流入(借)分类统计：</strong></div>
					<div class="MainCountBdoy">
						<?php if(isset($jie_c)): foreach($jie_c as $row):?>
							<div class="MainCountClassList"><a href="<?php echo site_url('welcome/cashList3').'/'.($row['classid']);?>"><?php  echo $row['classname'];?>：<?php echo $row['classtotal'];?>￥ / <?php if($jie != 0)echo round( $row['classtotal']/$jie * 100 , 2);else echo 0;  ?>%   </a> </div>
						<?php endforeach; endif; ?> 
						<div class="clear"></div>
					</div>
					<div Class="MainCountHead"><strong>资金流出(贷)分类统计：</strong></div>
					<div class="MainCountBdoy">
 						<?php  if(isset($dai_c)): foreach($dai_c as $row):?>
							<div class="MainCountClassList"><a href="<?php echo site_url('welcome/cashList3').'/'.($row['classid']);?>"><?php  echo $row['classname'];?>：<?php echo $row['classtotal'];?>￥ / <?php if($dai!=0) echo round( $row['classtotal']/$dai * 100 , 2);else echo 0;  ?>% </a> </div>
						<?php endforeach; endif;?> 
						<div class="clear"></div>
					</div>										
					<div Class="MainCountHead"><strong>指定统计：</strong></div>  
					<div class="MainCountBdoy">
						<?php 
						//得到当前月份的天数和得到上一月的天数
								$curMonth=date('m');
								$curYear=date('Y');
								$curMonth=sprintf("%02s",$curMonth);
								$curMonthDays=cal_days_in_month(CAL_GREGORIAN,$curMonth,$curYear);
								
								$prevMonth=$curMonth;
								$prevYear=$curYear;
								if($curMonth>1){
									$prevMonth=$curMonth-1;
								}else{
									$prevMonth='12';
									$prevYear=$curYear-1;
								}
								$prevMonth=sprintf("%02s",$prevMonth);
								$prevMonthDays=cal_days_in_month(CAL_GREGORIAN,$prevMonth,$prevYear);
						?>
						<div class="MainCountSelectList"><a href="<?php echo site_url('welcome/count/'.date("Y-m-d").'/'.date("Y-m-d"));?>">今日统计</a></div>
						<div class="MainCountSelectList"><a href="<?php echo site_url('welcome/count/'.date("Y-m-d",time()-2592000).'/'.date("Y-m-d"));?>">最近30天</a></div>
						<div class="MainCountSelectList"><a href="<?php echo site_url('welcome/count/'.date("Y-m-").'01'.'/'.date("Y-m-").$curMonthDays);?>">本月统计</a></div>
						<div class="MainCountSelectList"><a href="<?php echo site_url('welcome/count/'.date("Y-m-").'01'.'/'.date("Y-m-").$prevMonthDays);?>">上月统计</a></div> 
						<div class="clear"></div>  
					</div>
					<div Class="MainCountHead"><strong>个性统计：</strong></div>
					<div class="MainCountBdoy">
						<div class="MainCountSelectForm">
							从 <input name="st" id="st" type="text" class="inputText" value="<?php if(isset($st)) echo $st;?>" onfocus="c.showMoreDay = false;c.show(this);" readonly="readonly" > 
							到 <input name="et" id="et" type="text" class="inputText" value="<?php if(isset($et)) echo $et;?>" onfocus="c.showMoreDay = false;c.show(this);" readonly="readonly" >
							<input type="button" value="统计" class="btnSubmit" onclick="tongji();"/></div>					
					</div>
				</div>
			</div>
		</div>
		<div id="MainFoot"><?php $this->load->view('foot');?></div>
	</div>
</div>
</div>



</body></html>