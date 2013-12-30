<div id="MainLogo"><a href="#" title="钱宝宝 - 您的理财小助手"></a></div>
			<div id="MainNav">
				<ul>
					<li class="Add">
						<a href="<?php echo site_url('welcome/cashAdd');?>" title="我要记账">我要记账</a>
					</li>
					<li><a <?php if(isset($menu) && $menu == "cashList") echo 'class="on"'; ?> href="<?php echo site_url('welcome/cashList2');?>" title="账单列表">账单列表</a>
						<ul>
							<li><a href="<?php echo site_url('welcome/classEdit');?>" title="分类设置">分类设置</a></li>
							<li><a href="<?php echo site_url('welcome/pay');?>" title="支付方式">支付方式</a></li>
							<li><a href="<?php echo site_url('welcome/cashList4');?>" title="账单回收站">账单回收站</a></li>
						</ul>
					</li>
					
					<li><a <?php if(isset($menu) && $menu == 'count') echo 'class="on"'; ?> href="<?php echo site_url('welcome/count');?>" title="财务分析">财务分析</a></li>
					<li><a <?php if(isset($menu) && $menu == 'user') echo 'class="on"'; ?> href="<?php echo site_url('welcome/user');?>" title="帐号管理">帐号管理</a></li>
		<!--  			<li><a <?php if(isset($menu) && $menu == 'hsz') echo 'class="on"'; ?> href="<?php echo site_url('welcome/hsz');?>" title="回收站">回收站</a></li>-->
					<li><a <?php if(isset($menu) && $menu == 'group') echo 'class="on"'; ?> href="<?php echo site_url('group/index');?>" title="群组">群组</a></li>
					
				</ul>
			</div>
			<div class="clear"></div>