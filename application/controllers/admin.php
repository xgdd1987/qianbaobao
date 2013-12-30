<?php
session_start();
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Admin extends CI_Controller {
	 function __construct(){
	 	 parent::__construct();
	 	 date_default_timezone_set('Asia/Shanghai');//设置北京时间
	 }
	 
	 /*
	  * 用户列表 
	  * 先设置权限，后跳转到列表
	  * usertype=1:查看管理员；usertype=0：查看普通用户；usertype=其他：未定义
	  * */
	public function set_user_quanxian($usertype=-999){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	} else {
			redirect('welcome/index');
		}
		$_SESSION['quanxian2']='';
		$_SESSION['zhuangtai']='';
		if(0 == $usertype){ //获取普通会员
			if($_SESSION['userInfo']['quanxian']>=1){
				$_SESSION['quanxian']=$usertype;
				redirect("admin/getUserList");		
			}else{
				$data['msg']="请不要进行非法操作!";
				$this->load->view ( 'tip',$data );
			}	
		}elseif(1 == $usertype){//获取管理员
			if($_SESSION['userInfo']['quanxian']==2){
				$_SESSION['quanxian']=$usertype;
				redirect("admin/getUserList");		
			}else{
				$data['msg']="请不要进行非法操作!";
				$this->load->view ( 'tip',$data );
			}
		}else{
			$data['msg']="对不起，没有找到您需要的数据!";
			$this->load->view ( 'tip',$data );
		}
	}
	/*
	  * 用户列表 
	  * 先设置权限，后跳转到列表
	  * 查询被禁言用户 quanxian2
	  * */
	public function set_user_quanxian2($quanxian2=-999){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	} else {
			redirect('welcome/index');
		}
		$_SESSION['quanxian']='';
		$_SESSION['zhuangtai']='';
		if($_SESSION['userInfo']['quanxian']>=1){
			$_SESSION['quanxian2']=$quanxian2;
			redirect("admin/getUserList");		
		}else{
			$data['msg']="请不要进行非法操作!";
			$this->load->view ( 'tip',$data );
		}		
	}
	/*
	  * 用户列表 
	  * 先设置权限，后跳转到列表
	  * 查询被锁定用户 zhuangtai
	  * */
	public function set_user_zt($zt=-999){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	} else {
			redirect('welcome/index');
		}
		$_SESSION['quanxian']='';
		$_SESSION['quanxian2']='';
		if($_SESSION['userInfo']['quanxian']>=1){
			$_SESSION['zhuangtai']=$zt;
			redirect("admin/getUserList");		
		}else{
			$data['msg']="请不要进行非法操作!";
			$this->load->view ( 'tip',$data );
		}		
	}
	public function getUserList(){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		if(isset($_SESSION['quanxian'])){
			$this->load->model('admin_model','admin',TRUE);
			$this->load->library('pagination');
			$config['base_url']=site_url('admin/getUserList');
			$config['total_rows'] = $this->admin->countUsers();
			$config['per_page'] = 10;
			$config['uri_segment'] = 3;
			$config['num_links'] = 2;
			
			$config['first_link'] = '首页';
			$config['prev_link'] = '上一页';
			$config['next_link'] = '下一页';
			$config['last_link'] = '尾页';
			$data['users']=$this->admin->getUserList($config['per_page'],$this->uri->segment(3));
			$this->pagination->initialize($config);
			if(count($data['users']>0)){
				$this->load->view('usersList',$data);
			}else{
				$data['msg']="对不起，没有找到您需要的数据!";
				$this->load->view ( 'tip',$data );
			}
		}else{
				$data['msg']="对不起，没有找到您需要的数据!";
				$this->load->view ( 'tip',$data );
			}
		
	}
	 
	/**
	 * 编辑普通用户信息
	 * */
	public function editUser($userid=-1,$key=-1,$value=999){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		 $quanxian=$_SESSION['userInfo']['quanxian'];
		 if($quanxian==1 || $quanxian==2 ){
				if($key=='quanxian' && $quanxian==2){ //超级管理员操作
					$this->load->model('admin_model','admin',TRUE);
					if($this->admin->editUser($userid,$key,$value)){
						echo "操作成功";
					}else{
						echo "操作失败";
					}
				}else{
					if($key=='quanxian'){
						echo "请不要进行非法操作!";
					}else{
						if($key=='photo'){
							 $value='images/default.gif';
						}
						$this->load->model('admin_model','admin',TRUE);
						if($this->admin->editUser($userid,$key,$value)){
							echo "操作成功";
						}else{
							echo "操作失败";
						}
					}
				}
		}else{
			echo "请不要进行非法操作!";
		}
	}
	
	public function test($t='.'){
		echo $t.PHP_EOL;
	}
}
	 
	 
	 
	 
	 
	 
	 
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */