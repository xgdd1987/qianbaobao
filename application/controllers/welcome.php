<?php
session_start();
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Welcome extends CI_Controller {
	 function __construct(){
	 	 parent::__construct();
	 	 date_default_timezone_set('Asia/Shanghai');//设置北京时间
//	 	 if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
//	 	 	 //	redirect('welcome/loginSuccess');
//	 	 }
//	 	 else {
//			 //	redirect('welcome/index');exit;
//		 }
	 }
	/**
	 * 登录
	 */
	public function index(){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 	redirect('welcome/loginSuccess');
	 	 }
		$this->load->helper ( array ('form') );
		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules('username', '用户名', 'required|xss_clean');
  		$this->form_validation->set_rules('password', '密码', 'required|xss_clean');
  		$this->form_validation->set_error_delimiters('<div class="LoginFromItemError">&nbsp;*&nbsp;', '</div>');
		if ($this->form_validation->run () == FALSE) {
			$this->load->view ( 'index' );
		} else {
			$this->load->model('user_model','user',TRUE);
			$data=$this->user->checkLogin();
			if(count($data)>0){
				 $jihuo=$data[0]['zhuangtai'];
				 if($jihuo == '1'){
				 	 $_SESSION["isLogin"]=TRUE;
					 $_SESSION["userInfo"]=$data[0];
					 $ip=$this->input->ip_address();//获取登录ip地址
					 $ip_id=$this->user->login_log($ip);//记录ip地址
					 $_SESSION['ip_id']=$ip_id[0]['id'];
					 redirect('welcome/loginSuccess');
				 }else if($jihuo =='-1'){
				 	 $_SESSION["isLogin"]=FALSE;
					 $_SESSION["msg"]="该账号已经被管理员锁定!";
					 redirect('welcome/index');
				 }else{
				 	$_SESSION["isLogin"]=FALSE;
					 $_SESSION["msg"]="该账号还未激活!";
					 redirect('welcome/index');
				 }
			}else{
				 $_SESSION["msg"]="账号或者密码错误!";
				 $this->load->view ( 'index');
			}
			
		}
	}
	/**
	 * 
	 * 记录登陆日志
	 * */
	public function login_log(){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		 $this->load->model('user_model','user',TRUE);
		 $data['login_log']=$this->user->get_login_log(10);
		 $this->load->view('login_log',$data);
	}
	/**
	 * 登录成功跳转
	 * */
	public function loginSuccess(){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		 redirect('welcome/cashList');
		
	}
	/**
	 * 更换验证码
	 * */
	public function changeimg($imgname='00.zip'){
		$imgname='./imgtemp/captcha/'.$imgname; 
		if(file_exists($imgname)){ //删除旧
			unlink($imgname);
		}
		$this->load->helper('captcha');
		$vals = array(
		    'img_path' => './imgtemp/captcha/',
		    'img_url' => base_url().'imgtemp/captcha/'
		);
		$cap = create_captcha($vals);
		$_SESSION['captcha']=$cap['word'];
		echo $cap['src'].','.$cap['imgname'];
	}
	/**
	 * 账单列表
	 * 
	 * */
	public function cashList2(){
		$_SESSION['class']="-1";
		$_SESSION['payclass']="-1";
		$_SESSION['beginDate']="-1";
		$_SESSION['endDate']="-1";
		$_SESSION['today']="-1";
		redirect('welcome/cashList');
	}
	public function cashList3($class="-1",$pay="-1",$beginDate="-1",$endDate="-1",$today="-1"){
		$_SESSION['class']=$class;
		$pay=urldecode($pay);
		$_SESSION['payclass']=$pay;
		$_SESSION['beginDate']=$beginDate;
		$_SESSION['endDate']=$endDate;
		$_SESSION['today']=$today;
		redirect('welcome/cashList');
	}
	public function cashList(){
	//	echo $_GET["t"];
//		$str = iconv("gb2312","utf-8",$str);
//		mb_convert_encoding($str, "utf-8", "gb2312");
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		 
		$this->load->model('user_model','user',TRUE); 
		$data['shouru']=$this->user->countPay(1);
		$data['zhichu']=$this->user->countPay(2);
		$data['jie']=$this->user->countPay(3);
		$data['dai']=$this->user->countPay(4);
		$data['menu']='cashList';
		
		$this->load->library('pagination');
		$config['base_url']=site_url('welcome/cashList');
		$config['total_rows'] = $this->user->countCash();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		
		$config['first_link'] = '首页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '尾页';
//		$config['enable_query_strings']=TRUE;
		$data['cashList']=$this->user->searchCash($config['per_page'],$this->uri->segment(3));
		$tip="";
		if(count($data['cashList'])>0){
			if(isset($_SESSION['class']) && $_SESSION['class']!="-1")
				$tip="类别为&nbsp;<span class='KeyWords'>".$data['cashList'][0]['name']."</span>&nbsp;";
			if(isset($_SESSION['payclass']) && $_SESSION['payclass']!="-1"){
				$payclass=$_SESSION['payclass'];
				if(1 == $payclass) $payclass="现金";
				elseif(2 == $payclass) $payclass="刷卡";
				elseif(3 == $payclass) $payclass="代金券";
				elseif(4 == $payclass) $payclass="其他";
				else				   $payclass="未定义";
				$tip="支付方式为&nbsp;<span class='KeyWords'>".$payclass."</span>&nbsp;";	
			}
			
			if(isset($_SESSION['beginDate']) && $_SESSION['beginDate']!="-1")
				$tip="时间为&nbsp;<span class='KeyWords'>>=".$_SESSION['beginDate']."</span>&nbsp;";
			if(isset($_SESSION['endDate']) && $_SESSION['endDate']!="-1")
				$tip="时间为&nbsp;<span class='KeyWords'><=".$_SESSION['endDate']."</span>&nbsp;";
			if(isset($_SESSION['today']) && $_SESSION['today']!="-1")
				$tip="时间为&nbsp;<span class='KeyWords'>".$_SESSION['today']."</span>&nbsp;";
			if($tip!="")
				$data['tip']="现在列出的是".$tip."的全部账单。";
		}
		$this->pagination->initialize($config);
		$this->load->view("cashList",$data);
	}
	/**
	 * 已删除账单
	 * */
	public function cashList4(){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		 
		$this->load->model('user_model','user',TRUE); 
		$data['shouru']=$this->user->countPay(1);
		$data['zhichu']=$this->user->countPay(2);
		$data['jie']=$this->user->countPay(3);
		$data['dai']=$this->user->countPay(4);
		$data['menu']='cashList';
		
		$this->load->library('pagination');
		$config['base_url']=site_url('welcome/cashList4');
		$config['total_rows'] = $this->user->countCash4();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		
		$config['first_link'] = '首页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '尾页';
//		$config['enable_query_strings']=TRUE;
		$data['cashList']=$this->user->searchCash4($config['per_page'],$this->uri->segment(3));
		$tip="";
		if(count($data['cashList'])>0){
			if(isset($_SESSION['class']) && $_SESSION['class']!="-1")
				$tip="类别为&nbsp;<span class='KeyWords'>".$data['cashList'][0]['name']."</span>&nbsp;";
			if(isset($_SESSION['payclass']) && $_SESSION['payclass']!="-1"){
				$payclass=$_SESSION['payclass'];
				if(1 == $payclass) $payclass="现金";
				elseif(2 == $payclass) $payclass="刷卡";
				elseif(3 == $payclass) $payclass="代金券";
				elseif(4 == $payclass) $payclass="其他";
				else				   $payclass="未定义";
				$tip="支付方式为&nbsp;<span class='KeyWords'>".$payclass."</span>&nbsp;";	
			}
				$data['tip']="现在列出的是&nbsp;<span class='KeyWords'>回收站</span>&nbsp;中的全部账单。";
		}
		$this->pagination->initialize($config);
		$this->load->view("cashList4",$data);
	}
	/**
	 * 根据id，删除账单，即将isdelete=1
	 * */
	public function delCash($id){
	if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		if($this->user->delCash($id)){
			echo "删除成功!";
		}else{
			echo "删除失败!";
		}
	}
	/**
	 * 根据id，恢复账单，即将isdelete=0
	 * */
	public function resetCash($id){
	if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		if($this->user->resetCash($id)){
			echo "恢复账单成功!";
		}else{
			echo "恢复账单失败!";
		}
	}
	/**
	 * 根据id，删除账单，即将delete
	 * */
	public function delCash4($id){
	if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		if($this->user->delCash4($id)){
			echo "删除成功!";
		}else{
			echo "删除失败!";
		}
	}
	/**
	 * 一键清空回收站账单
	 * */
	public function delAllCash(){
	if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		if($this->user->delAllCash()){
			echo "操作成功!";
		}else{
			echo "操作失败!";
		}
	}
	/**
	 * 注册
	 * */
	public function signUp(){
		$this->load->helper ( array ('form') );
		$this->load->library ( 'form_validation' );
		$this->load->model('user_model','user',TRUE);
		$this->form_validation->set_rules('username', '用户名', 'trim|required|min_length[3]|max_length[15]|xss_clean|callback_username_check|is_unique[users.username]');
		$this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[15]|xss_clean');
  		$this->form_validation->set_rules('rpassword', '确认密码', 'required|matches[password]|xss_clean');
		$this->form_validation->set_rules('sex', '性别', 'required|xss_clean');
		$this->form_validation->set_rules('email', '电子邮箱', 'trim|required|valid_email|xss_clean|is_unique[users.email]');
		$this->form_validation->set_rules('birthday', '出生日期', 'trim|required|xss_clean');
		$this->form_validation->set_rules('captcha', '验证码', 'trim|required|xss_clean');
  		$this->form_validation->set_error_delimiters('<div class="SignFromItemError">X&nbsp;*&nbsp;', '</div>');
		if ($this->form_validation->run () == FALSE) {
			$this->load->helper('captcha');
			$vals = array(
			    'img_path' => './imgtemp/captcha/',
			    'img_url' => base_url().'imgtemp/captcha/'
			);
			$data['cap']= create_captcha($vals);
			$_SESSION['captcha']=$data['cap']['word'];
			$this->load->view ( 'signUp', $data);
		} else {
			if(strcasecmp($_SESSION['captcha'],$this->input->post('captcha',TRUE))==0){
				if($this->user->signUp()){ 
					 $_SESSION["msg"]="注册成功!!";
					 //分类设置中，自动设置默认类别
					 //支付方式中，自动设置默认方式
				}else{
					 $_SESSION["msg"]="注册失败!!";
				}
				redirect('welcome/index');
			}else{
				 $data['captcha_err']='验证码填写不正确!';
				 $this->load->helper('captcha');
				$vals = array(
				    'img_path' => './imgtemp/captcha/',
				    'img_url' => base_url().'imgtemp/captcha/'
				);
				$data['cap']= create_captcha($vals);
				$_SESSION['captcha']=$data['cap']['word'];
				$this->load->view ( 'signUp', $data);
			}
			
		}
	}
	/**
	 * 验证用户名
	 * */
	 public function username_check($str)
	 {
	  if ($str == 'test')
	  {
	   $this->form_validation->set_message('username_check', '非法的用户名!');
	   return FALSE;
	  }
	  else
	  {
	   return TRUE;
	  }
	 }
	/**
	 * 我要记账
	 * */
	public function cashAdd(){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->helper ( array ('form') );
		$this->load->library ( 'form_validation' );
		$this->load->model('user_model','user',TRUE);
		$data['shouru']=$this->user->getClassById(1);
		$data['zhichu']=$this->user->getClassById(2);
		$data['jie']=$this->user->getClassById(3);
		$data['dai']=$this->user->getClassById(4);
		$data['pay']=$this->user->getPayList();
		$this->form_validation->set_rules('cashName', '账单名称', 'trim|required|xss_clean');
		$this->form_validation->set_rules('oper', '经手人', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mark', '备注', 'trim|xss_clean');
		if ($this->form_validation->run () == FALSE) {
			$this->load->view ( 'cashAdd',$data );
		} else {
			if($this->user->addCash()){ 
				 $_SESSION["msg"]="记录成功!!";
				 
			}else{
				 $_SESSION["msg"]="记录失败!!";
			}
			redirect('welcome/cashAdd');
		}
	}
	/**
	 * 修改记账
	 * */
	public function cashEdit($id=0){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->helper ( array ('form') );
		$this->load->library ( 'form_validation' );
		$this->load->model('user_model','user',TRUE);
		$data['cash']=$this->user->getCashById($id);
		if(count($data['cash'])){
			$data['shouru']=$this->user->getClassById(1);
			$data['zhichu']=$this->user->getClassById(2);
			$data['jie']=$this->user->getClassById(3);
			$data['dai']=$this->user->getClassById(4);
			$data['pay']=$this->user->getPayList();
			$this->form_validation->set_rules('cashName', '账单名称', 'trim|required|xss_clean');
			$this->form_validation->set_rules('oper', '经手人', 'trim|required|xss_clean');
			$this->form_validation->set_rules('mark', '备注', 'trim|xss_clean');
			if ($this->form_validation->run () == FALSE) {
				$this->load->view ( 'cashEdit',$data );
			} else {
				if($this->user->cashEdit($id)){ 
					 $_SESSION["msg"]="修改成功!!";
					 
				}else{
					 $_SESSION["msg"]="修改失败!!";
				}
				redirect('welcome/cashEdit/'.$id);
			}
		}else{
			$data['msg']="对不起，没有找到您需要的数据!";
			$this->load->view ( 'tip',$data );
		}
		
	}
	/**
	 * 账单分类
	 * */
	public function classEdit(){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		$data['shouru']=$this->user->getClassById(1);
		$data['zhichu']=$this->user->getClassById(2);
		$data['jie']=$this->user->getClassById(3);
		$data['dai']=$this->user->getClassById(4);
		$data['menu']='cashList';
		$this->load->view('classEdit',$data);	
	}
	/**
	 * 删除类
	 * */
	public function delClass($id){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		//需要同时删除该分类与该分类下的所有记账记录
		$this->load->model('user_model','user',TRUE);
		if(!$this->user->delClass($id)){
			echo "删除失败!";
		}else{
			echo "删除成功!";
		}
	}
	/**
	 * 编辑类
	 * 
	 * */
	public function editClass($id,$name,$istongji=1){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$name=urldecode($name);
		$this->load->model('user_model','user',TRUE);
		if(!$this->user->editClass($id,$name,$istongji)){
			echo "修改失败!";
		}else{
			echo "修改成功!";
		}
	}
	/**
	 * 添加类
	 * 
	 * */
	public function addClass($pid,$name,$istongji=1){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$name=urldecode($name);
		$this->load->model('user_model','user',TRUE);
		if(!$this->user->addClass($pid,$name,$istongji)){
			echo "添加失败!";
		}else{
			echo "添加成功!";
		}
	}
	/**
	 * 退出登录
	 * */
	public function loginOut(){
		$this->load->model('user_model','user',TRUE);
		if($this->user->loginout()){
			session_destroy();
		}else{
		
		}
			
		redirect("group/index");
	}
	/**
	 * 支付方式
	 * */
	public function pay(){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		$data['pay']=$this->user->getPayList();
		
		$data['menu']='cashList';
		$this->load->view('pay',$data);
	}
	/**
	 * 根据id，删除支付方式
	 * 
	 * */
	public function delPay($id){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		if(!$this->user->delPay($id)){
			echo "删除失败!";
		}else{
			echo "删除成功!";
		}
	}
	/**
	 * 添加支付方式
	 * 
	 * */
	public function addPay($name,$payvalue){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$name=urldecode($name);
		$this->load->model('user_model','user',TRUE);
		if(!$this->user->addPay($name,$payvalue)){
			echo "添加失败!";
		}else{
			echo "添加成功!";
		}
	}
	/**
	 * 编辑支付方式
	 * 
	 * */
	public function editPay($id=0,$name="",$payvalue=0){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$name=urldecode($name);
		$this->load->model('user_model','user',TRUE);
		if(!$this->user->editPay($id,$name,$payvalue)){
			echo "修改失败!";
		}else{
			echo "修改成功!";
		}
	}
	/**
	 * 财务分析
	 * */
	public function count($beginDate='2012-01-01',$endDate='2014-01-01'){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		$data['menu']='count';
		$data['shouru']=$this->user->countPay('1',$beginDate,$endDate);
		$data['zhichu']=$this->user->countPay('2',$beginDate,$endDate);
		$data['jie']=$this->user->countPay('3',$beginDate,$endDate);
		$data['dai']=$this->user->countPay('4',$beginDate,$endDate);
		
		$xianjinPays='-1';
		$shuaKaPays='-1';
		$daiJinQunPays='-1';
		$qiTaPays='-1';
		$temp=$this->user->getPayByPay('1');
		foreach($temp as $row){
			$xianjinPays.=','.($row['id']+0);
		}
//		echo $xianjinPays;exit;
		$temp=$this->user->getPayByPay('2');
		foreach($temp as $row){
			$shuaKaPays.=','.($row['id']+0);
		}
		$temp=$this->user->getPayByPay('3');
		foreach($temp as $row){
			$daiJinQunPays.=','.($row['id']+0);
		}
//		echo $daiJinQunPays;exit;
		$temp=$this->user->getPayByPay('0');
		foreach($temp as $row){
			$qiTaPays.=','.($row['id']+0);
		}
		$data['xianjins']=$this->user->countPay('1',$beginDate,$endDate,$xianjinPays);
		$data['xianjinz']=$this->user->countPay('2',$beginDate,$endDate,$xianjinPays);
		
		$data['shuakas']=$this->user->countPay('1',$beginDate,$endDate,$shuaKaPays);
		$data['shuakaz']=$this->user->countPay('2',$beginDate,$endDate,$shuaKaPays);
		
		$data['daijinquans']=$this->user->countPay('1',$beginDate,$endDate,$daiJinQunPays);
		$data['daijinquanz']=$this->user->countPay('2',$beginDate,$endDate,$daiJinQunPays);
		
		$data['qitas']=$this->user->countPay('1',$beginDate,$endDate,$qiTaPays);
		$data['qitaz']=$this->user->countPay('2',$beginDate,$endDate,$qiTaPays);
		$data['st']=$beginDate;
		$data['et']=$endDate;
		
		$shouru=$this->user->getClassById(1,1);
		$zhichu=$this->user->getClassById(2,1);
		$jie=$this->user->getClassById(3,1);
		$dai=$this->user->getClassById(4,1);
		$i=0;
		foreach($shouru as $row){
			$total=$this->user->countClassPay($row['id']+0,$beginDate,$endDate);
			$total=$total[0]['money']==null?'0.00':$total[0]['money'];
			$data['shouru_c'][$i]=array('classid'=>$row['id']+0, 'classname'=>$row['name'],'classtotal'=>$total);
			$i++;
		}
		$i=0;
		foreach($zhichu as $row){
			$total=$this->user->countClassPay($row['id']+0,$beginDate,$endDate);
		
			$total=$total[0]['money']==null?'0.00':$total[0]['money'];
			
			$data['zhichu_c'][$i]=array('classid'=>$row['id']+0,'classname'=>$row['name'],'classtotal'=>$total);
			$i++;
		}
		$i=0;
		foreach($jie as $row){
			$total=$this->user->countClassPay($row['id']+0,$beginDate,$endDate);
			$total=$total[0]['money']==null?'0.00':$total[0]['money'];
			$data['jie_c'][$i]=array('classid'=>$row['id']+0,'classname'=>$row['name'],'classtotal'=>$total);
			$i++;
		}
		$i=0;
		foreach($dai as $row){
			$total=$this->user->countClassPay($row['id']+0,$beginDate,$endDate);
			$total=$total[0]['money']==null?'0.00':$total[0]['money'];
			$data['dai_c'][$i]=array('classid'=>$row['id']+0,'classname'=>$row['name'],'classtotal'=>$total);
			$i++;
		}	
		$this->load->view('count',$data);
	}
	/**
	 * 账号管理
	 * */
	public function user(){
		// enctype="multipart/form-data"
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->library ( 'form_validation' );
		$this->load->model('user_model','user',TRUE);
		$data['menu']='user';
		$data['error']='';
		$data['picname']='default.gif';
		$data['has_post_photo']=FALSE;
		$this->form_validation->set_rules('userid', '', 'trim|xss_clean');
		if ($this->form_validation->run () == FALSE) {
			$this->load->view('user',$data);	
		}else{
			  $data['has_post_photo']=TRUE;
			  $pic="";
			  $config['upload_path'] = './imgtemp/';
			  $config['allowed_types'] = 'gif|jpg|png|jpeg|jpe';
			  $config['max_size'] = '1024';
			  $config['encrypt_name']=TRUE;
			  $this->load->library('upload', $config);
			  if ( ! $this->upload->do_upload("photo")) {
					$data['error']=$this->upload->display_errors();
					$this->load->view('user',$data);
			   } else {		
			  		$upload_data = $this->upload->data();
				    $pic=$upload_data['file_name'];
				    $data['picname']=$pic;
			   }
			$this->load->view('user',$data);
		}
//		$data['shouru']=$this->user->countPay(1,$beginDate,$endDate);
		
	}
	/**
	 * 修改用户信息
	 * */
	public function editUser($key,$value){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		if($key=='birthday' || $key == 'sex'|| $key == 'photo'){ //过滤非法操作
			$value=urldecode($value);
			$this->load->model('user_model','user',TRUE);
			if($this->user->editUser($key,$value)){
				$_SESSION['userInfo'][$key]=$value;
				echo $key.'='.$value;
			}
		}else{
			echo "0=请不要进行非法操作!";
		}
		
	}
	/**
	 * 修改密码
	 * */
	public function changePass($oldpass,$newpass){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
		$rs=$this->user->checkOldPass($oldpass);
		if(count($rs)==1){
			if($this->user->changePass($newpass)){
				echo "密码修改成功!";
			}else{
				echo "密码修改失败!";
			}
		}else{
			echo "原密码不正确,修改失败！";
		}
	}
	/**
	 * 群组
	 * */
	public function group(){
		
		$this->load->view('group');
	}
	/**
	 * 系统更新日志
	 * 
	 * */
	public function logs(){
		$this->load->view("logs.html");
	}
	/**
	 * 下载账单
	 * */
	public function down_cash($st,$et){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$this->load->model('user_model','user',TRUE);
			$arr=$this->user->down_cash($st,$et);
			if(count($arr)>0){
//				$arr=array(1=>array('date'=>'2012-10-18','pay'=>'支出','payc'=>'借出','name'=>'借出10块钱','pay2'=>'网银','e'=>'10.00'),
// 				2=>array('date'=>'2012-10-19','pay'=>'支出3','payc'=>'借出3','name'=>'借出10块钱3','pay2'=>'网银3','e'=>'13.00')
//		 		);
		 		$this->array_to_excel($arr,$_SESSION['userInfo']['username'].'的'.$st.'到'.$et.'的账单列表');
			}else{
				$data['msg']="对不起，没有符合您的条件的账单可以导出!";
				$this->load->view ( 'tip',$data );
			}
		 
 		
 	}
 	/**
 	 * 把账单列表数组变成excel，并提供下载
 	 * 
 	 * */
 	public function array_to_excel($arr=array(),$filename='test'){
 		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
 		$this->load->library('PHPExcel');
 		$this->phpexcel->getProperties()->setCreator("钱宝宝-www.qianbaobao365.com")
							 ->setLastModifiedBy("钱宝宝-www.qianbaobao365.com")
							 ->setTitle("钱宝宝-www.qianbaobao365.com")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("钱宝宝-www.qianbaobao365.com")
							 ->setKeywords("钱宝宝 www.qianbaobao365.com")
							 ->setCategory("账单列表");
		$this->phpexcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
		
		$this->phpexcel->getActiveSheet()->setCellValue('A1', '编号')
				                              ->setCellValue('B1', '时间')
				                              ->setCellValue('C1', '类型')
				                              ->setCellValue('D1', '类别')
				                              ->setCellValue('E1', '账单名称')
				                              ->setCellValue('F1', '支付方式')
			    	                          ->setCellValue('G1', '金额(￥)')
			    	                          ->setCellValue('H1', '经手人')
			    	                          ->setCellValue('I1', '备注');
		$i=1;	
		foreach($arr as $row){
			$i++;
			$payclass=$row['payclass'];
			if(1==$payclass || 3==$payclass) $payclass='收入';
			elseif(2==$payclass || 4==$payclass) $payclass='支出';
			else $payclass='未定义';
			$this->phpexcel->getActiveSheet()->setCellValue('A'.$i, $i-1)
				                              ->setCellValue('B'.$i, $row['paydate'])
				                              ->setCellValue('C'.$i, $payclass)
				                              ->setCellValue('D'.$i, $row['name'])
				                              ->setCellValue('E'.$i, $row['cashname'])
				                              ->setCellValue('F'.$i, $row['pay'])
				                              ->setCellValue('G'.$i, $row['money'])
				                              ->setCellValue('H'.$i, $row['oper'])
				                              ->setCellValue('I'.$i, $row['mark']);
			$this->phpexcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		}
		$this->phpexcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->phpexcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		
		$this->phpexcel->setActiveSheetIndex(0);
		$this->phpexcel = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
		header("Pragma:public");
		header('Expires: 0');
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header('Content-Type:application/force-download');
		header('Content-Type:application/vnd.ms-execl');
		header('Content-Type:application/octet-stream');
		header('Content-Type:application/download');
		//这里面就是这个文件的名字,可以根据需要定义
//		header("Content-Disposition:attachment;filename=".$filename.".xlsx");
		$ua = $_SERVER["HTTP_USER_AGENT"]; 
		$encoded_filename = urlencode($filename); 
		$encoded_filename = str_replace("+", " ", $encoded_filename); 
		$encoded_filename =$encoded_filename.'.xlsx';
		header('Content-Type: application/octet-stream'); 
		if (preg_match("/MSIE/", $ua)) { 
		header('Content-Disposition: attachment; filename="' . $encoded_filename . '"'); 
		} else if (preg_match("/Firefox/", $ua)) { 
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"'); 
		} else { 
		header('Content-Disposition: attachment; filename="' . $filename . '"'); 
		} 
		
		
		header('Content-Transfer-Encoding:binary');
		$this->phpexcel->save('php://output');
 	}
 	/**
 	 * 注册成功发送账号激活邮件
 	 * */
 	private function regest_send_email($email=''){
 		$this->load->library('email');
 		$config['useragent']='163.com';
 	    $config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'smtp.163.com';
	    $config['smtp_user'] = 'qianbaobao365@163.com';//这里写上你的163邮箱账户
	    $config['smtp_pass'] = '36845347';//这里写上你的163邮箱密码
	    $config['mailtype'] = 'html';
	    $config['validate'] = true;
	    $config['priority'] = 1;
	    $config['crlf']  = "\\r\\n";
	    $config['smtp_port'] = 25;
	    $config['charset'] = 'utf-8';
	    $config['wordwrap'] = TRUE;
		$this->email->initialize($config);
 		$this->email->from('qianbaobao365@163.com', '钱宝宝官方网站');
		$this->email->to($email);
		$this->email->subject('钱宝宝网站账号激活邮件--请勿回复');
		$message='<FONT color=#000080>亲爱的钱宝宝用户，您好：<br/><br/>请您点击下面链接来激活您的钱宝宝网站账号:<br/><a href="http://www.qianbaobao365.com">激活</a><br/><br/><br/>';
		$message.='如果点击链接不工作...<br/>请您选择并复制整个链接，打开浏览器窗口并将其粘贴到地址栏中。然后单击"转到"按钮或按键盘上的 Enter 键。<br/><br/><br/>';
		$message.='为了确保您的帐号安全，该链接仅7天内访问有效。<br/><br/>如果该链接已经失效，请您点击下面链接来重新获取激活保密邮箱的邮件:<br/><a href="http://www.qianbaobao365.com">http://www.qianbaobao365.com</a><br/><br/><br/>';
		$message.='<FONT color=red>请勿直接回复该邮件</FONT>，有关钱宝宝网站账号激活的更多帮助信息，请访问：<a href="http://www.qianbaobao365.com">http://www.qianbaobao365.com</a><br/><br/>';
		$message.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$message.='钱宝宝官方网站</font>';
		$this->email->message($message);	
		$this->email->send();
		//进行邮件发送成功提示 
		$data['de']= $this->email->print_debugger();
		$this->load->view('test',$data);
 	}
	/**
 	 * 找回密码，发送邮件
 	 * */
 	private function getpass_send_email($getpassstr,$email=''){
 		$this->load->library('email');
 	
 		$config['useragent']='163.com';
 	    $config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'smtp.163.com';
	    $config['smtp_user'] = 'qianbaobao365@163.com';//这里写上你的163邮箱账户
	    $config['smtp_pass'] = '36845347';//这里写上你的163邮箱密码

// 		$config['useragent']='qq.com';
// 	    $config['protocol'] = 'SSL';
//	    $config['smtp_host'] = 'smtp.qq.com';
//	    $config['smtp_user'] = 'qianbaobao365@qq.com';//这里写上你的163邮箱账户
//	    $config['smtp_pass'] = 'wenxiuxiaoxia';//这里写上你的163邮箱密码
//	    $config['smtp_port'] = '465';
 		
// 		$config['useragent']='163.com';
// 	    $config['protocol'] = 'smtp';
//	    $config['smtp_host'] = 'smtp.yahoo.cn';
//	    $config['smtp_user'] = 'qianbaobao365@yahoo.cn';//这里写上你的163邮箱账户
//	    $config['smtp_pass'] = 'q36845347';//这里写上你的163邮箱密码

//  		$config['useragent']='hotmail.com';
// 	    $config['protocol'] = 'smtp';
//	    $config['smtp_host'] = 'smtp.live.com';
//	    $config['smtp_user'] = 'qianbaobao365@hotmail.com';//这里写上你的163邮箱账户
//	    $config['smtp_pass'] = 'sdws36845347';//这里写上你的163邮箱密码
 
// 		$config['useragent']='gmail.com';
// 		$config['protocol'] = 'smtp';
//	    $config['smtp_host'] = 'ssl://smtp.gmail.com';
//		$config['smtp_user'] = 'qianbaobao365@gmail.com';
//		$config['smtp_pass'] = '36845347';
//		$config['smtp_port'] = '465';
//		$config['smtp_timeout'] = 5; 		
 		
	    $config['mailtype'] = 'html';
	    $config['validate'] = true;
	    $config['priority'] = 1;
	    $config['crlf']  = "\\r\\n";
	    $config['charset'] = 'utf-8';
	    $config['wordwrap'] = TRUE;
		$this->email->initialize($config);
 		$this->email->from('qianbaobao365@163.com', '钱宝宝官方网站');
		$this->email->to($email);
		$this->email->subject('钱宝宝网站账号激活邮件--请勿回复');
		$jihuourl=site_url('welcome/get_password2/'.$getpassstr);
		$message='<FONT color=#000080>亲爱的钱宝宝用户，您好：<br/><br/>请您点击下面链接来重新设置您的钱宝宝网站账号密码:<br/><a href="'.$jihuourl.'">'.$jihuourl.'</a><br/><br/><br/>';
		$message.='如果点击链接不工作...<br/>请您选择并复制整个链接，打开浏览器窗口并将其粘贴到地址栏中。然后单击"转到"按钮或按键盘上的 Enter 键。<br/><br/><br/>';
		$message.='为了确保您的帐号安全，该链接仅7天内访问有效。<br/><br/>如果该链接已经失效，请您点击下面链接来重新获取激活保密邮箱的邮件:<br/><a href="http://www.qianbaobao365.com/index.php/welcome/get_password">http://www.qianbaobao365.com/index.php/welcome/get_password</a><br/><br/><br/>';
		$message.='<FONT color=red>请勿直接回复该邮件</FONT>，有关钱宝宝网站账号激活的更多帮助信息，请访问：<a href="http://www.qianbaobao365.com">http://www.qianbaobao365.com</a><br/><br/>';
		$message.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$message.='钱宝宝官方网站</font>';
		$this->email->message("dddddddddddd");	
		 $this->email->send();
		//进行邮件发送成功提示 
		$data['de']= $this->email->print_debugger();
		$this->load->view('test',$data);
 	}
 	/**
 	 * 设置用户名、邮箱，发送重置密码邮件
 	 * */
 	public function get_password(){
 		$this->load->library ( 'form_validation' );
		$this->form_validation->set_rules('username', '账号名', 'trim|max_length[50]|required|xss_clean');
		$this->form_validation->set_rules('email', '邮箱', 'trim|valid_email|max_length[50]|required|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="SignFromItemError">X&nbsp;*&nbsp;', '</div>');
		if ($this->form_validation->run () == FALSE) {
			$this->load->view('get_password');
		} else {
			$this->load->model('user_model','user',TRUE);
			$user=$this->user->get_pass_byemail();
			if(count($user)>0){ 
				$date_time=time();
				$user=$user[0];
				$emailstr=md5($user['password']);
//				$message=$this->get_email_text(1,$emailstr);
				if($this->user->set_emile_time2($user['username'],$emailstr,$date_time)){
					$rs=$this->yuanjiqiang($emailstr,$user['email']);
//					if($rs==1){
//						$_SESSION["msg"]="邮件发送成功,如果收件箱没有邮件，请注意查看是否在垃圾邮件里!";
//					}elseif($rs==0){
//						$_SESSION["msg"]="邮件发送失败，请再次尝试发送或者联系网站管理员!!";
//					}elseif($rs=='ERROR!'){
//						$_SESSION["msg"]="警告：请不要进行非法操作!";
//					}else{
//						$_SESSION["msg"]="未知错误!";
//					}
					$_SESSION["msg"]="系统已经收到您的请求，请您稍等1分钟后查收邮件，谢谢!";
				}else{
					$_SESSION["msg"]="标记邮件发送时间时，系统发生错误!";
				}
			}else{
				$_SESSION["msg"]="对不起，账号和邮箱不匹配!!";
			}
			redirect('welcome/get_password');
		}	
 	}
 	/**
 	 * 根据邮件链接，重置密码
 	 * */
 	public function get_password2($emailstr=''){
 		if($emailstr==''){
 			$data['msg']="对不起，密码找回链接不正确!";
			$this->load->view ( 'tip',$data );
 		}else{
	 		$this->load->model('user_model','user',TRUE);
			$data['user']=$this->user->get_password2($emailstr);
			
			if(isset($data['user'][0])&& $data['user'][0]>0){ 
				$nowtime=time();
				if($nowtime-$data['user'][0]['emailtime']<604800){
					$this->load->library ( 'form_validation' );
					$this->form_validation->set_rules('username', '账号名', 'trim|max_length[50]|required|xss_clean');
					$this->form_validation->set_rules('password', '密码', 'trim|min_length[6]|max_length[20]|required|xss_clean');
					$this->form_validation->set_rules('rpassword', '重复新密码', 'required|trim|min_length[6]|matches[password]');
					$this->form_validation->set_error_delimiters('<div class="SignFromItemError">X&nbsp;*&nbsp;', '</div>');
					if ($this->form_validation->run () == FALSE) {
						$this->load->view('set_password');
					} else {
						if($this->user->set_password2()){
							$data['msg']="恭喜你，您的密码已经更新!";
							$this->load->view ( 'tip',$data );
						}else{
							$data['msg']="对不起，您的密码更新失败，请过会在尝试修改!";
							$this->load->view ( 'tip',$data );
						}
					}
				}else{
					$data['msg']="对不起，密码找回链接已经超过7天的有效期!";
					$this->load->view ( 'tip',$data );
				}
			}else{
				$data['msg']="对不起，密码找回链接不正确或该链接已经被使用!";
				$this->load->view ( 'tip',$data );
			}
 		}
 	}
 	private function yuanjiqiang($getpassstr='',$email=''){
 		$key=md5($getpassstr.'sdfadf42r!@#4dFX');
 		$email=str_replace('@','-',$email);
		$str ='http://www.yuanjiqiang.com/index.php/sendmail/getpass_send_email/'.$getpassstr.'/'.$email.'/'.$key;
//		echo $str;exit; 
		$html = file_get_contents($str);
	//	echo  $html.'-----00'; exit;
		return $html;
 		if($html==1){
 			return TRUE;
 		}else{
 			return FALSE;
 		}
 	}
 	/**
 	 * 回收站
 	 * */
	public function hsz(){
	
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		 
		$this->load->model('user_model','user',TRUE); 
		
		$data['menu']='cashList';
		
		$this->load->library('pagination');
		$config['base_url']=site_url('welcome/cashList');
		$config['total_rows'] = $this->user->countCash();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		
		$config['first_link'] = '首页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '尾页';
//		$config['enable_query_strings']=TRUE;
		$data['cashList']=$this->user->searchCash($config['per_page'],$this->uri->segment(3));
		$tip="";
		if(count($data['cashList'])>0){
			
			$this->pagination->initialize($config);
			$this->load->view("hsz",$data);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */