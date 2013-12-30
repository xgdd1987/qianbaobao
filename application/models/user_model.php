<?php
class User_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    /**
     * 用户登录
     * 
     * */
    function checkLogin(){
    	$username=$this->input->post('username');
    	$password=$this->input->post('password');
    	$password=crypt(md5($password),md5($username));
    	$arr=array('username'=>$username,
    				'password'=>$password
    			);
    	$query=$this->db->get_where('users', $arr);
		return $query->result_array();
    }
    /**
     * 用户退出
     * */
    public function loginout(){
    	$this->db->where('id',$_SESSION['ip_id']);
    	$this->db->set('last_loginout_time',date('Y-m-d H:i:s'));
    	return $this->db->update("loginlog"); 
    }
    /**
     * 记录登陆日志
     * */
    public function login_log($ip){
    	$userId=$_SESSION['userInfo']['id'];
    	$data=array('userid'=>$userId,
    				'last_login_time'=>date('Y-m-d H:i:s'),
    				'last_loginout_time'=>'您没有安全退出',
    				'last_login_ip'=>$ip,
    				'last_login_area'=>''
    				);
    	$this->db->insert("loginlog",$data);
		$this->db->select_max('id');
		$this->db->where('userid',$userId);
		$query = $this->db->get('loginlog');
    	return $query->result_array(); 
    }
    /**
     * 查询登录日志
     * 
     * */
    public function get_login_log($num){
    	$userId=$_SESSION['userInfo']['id'];
    	$this->db->where('userid',$userId);
    	$this->db->limit($num,0);
    	$this->db->order_by('id','desc');
    	$query=$this->db->get('loginlog');
		return $query->result_array();
    }
    /**
     * 注册
     *  zhuangtai:   	1：已激活，-1：已锁定,其他：未激活
     *  quanxian:		0：普通会员；1：管理员；2：超级管理员
     *  quanxian2:		0：自由发言；-1:禁止发言；-2：禁止发帖；-3：禁止回复
     * */
    function signUp(){
    	date_default_timezone_set('Asia/Shanghai');
    	$sex=$this->input->post('sex',TRUE);
    	$username=$this->input->post('username',TRUE);
    	$password=$this->input->post('password',TRUE);
    	$jihuoma=md5($username); 
    	$password=crypt(md5($password),$jihuoma);
    	$data1=array("username"=>$username,
		"password"=>$password,
    	"sex"=>$sex[0],
    	"email"=>$this->input->post('email',TRUE),
    	"birthday"=>$this->input->post('birthday',TRUE),
		"date_time"=>date("Y-m-d H:i:s"),
    	"photo"=>"images/default.gif",
    	"jifen"=>0,
    	"quanxian"=>0,
    	"quanxian2"=>0,
    	"zhuangtai"=>$jihuoma);
    	$this->db->trans_start();
    	$this->db->insert("users",$data1);//注册信息写入数据库
    	$this->db->trans_complete(); 
    	$this->db->trans_off();
    //-------------------------------------------------------------------------	
    	$this->jihuo($jihuoma);//程序先自动激活,以后修改为邮件激活 2012-10-15
    //-------------------------------------------------------------------------
	    if ($this->db->trans_status() === FALSE){
	   		 return FALSE;
		}else{
			 return TRUE;
		}
    }
 	/**
     * 激活用户注册信息
     * */
    function jihuo($jihuoma='0.0'){
    	//查询是否已经激活
    	$arr=array('zhuangtai'=>$jihuoma);
    	$query=$this->db->get_where('users', $arr);
		$data=$query->result_array();
		if(count($data)>0){	 
			$userId=$data[0]['id'];   	
	    	//进行激活
	    	$this->db->where('zhuangtai',$jihuoma);
	    	$this->db->set("zhuangtai",1);
			$class=array(   array('userid'=>$userId,'pid'=>1,'name'=>'工资收入','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>1,'name'=>'补助津贴','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>1,'name'=>'意外所得','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>1,'name'=>'其他收入','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'生活开销','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'娱乐休闲','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'买衣置装','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'交通出行','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'求医问药','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'人情往来','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'供房供车','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'抚养赡养','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'网络购物','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'通讯费用','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>2,'name'=>'其他支出','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>3,'name'=>'借入','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>3,'name'=>'信用卡刷卡','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>4,'name'=>'借出','istongji'=>1,'isdelete'=>0),
							array('userid'=>$userId,'pid'=>4,'name'=>'信用卡还贷','istongji'=>1,'isdelete'=>0)
				);
			$pay=array( array('name'=>'现金','userid'=>$userId,'pay'=>1),
						array('name'=>'中国银行卡','userid'=>$userId,'pay'=>2),
						array('name'=>'建设银行卡','userid'=>$userId,'pay'=>2),
						array('name'=>'工商银行卡','userid'=>$userId,'pay'=>2),
						array('name'=>'工商信用卡','userid'=>$userId,'pay'=>2),
						array('name'=>'交通银行卡','userid'=>$userId,'pay'=>2),
						array('name'=>'支付宝','userid'=>$userId,'pay'=>2),
						array('name'=>'代金券','userid'=>$userId,'pay'=>3),
						array('name'=>'其他','userid'=>$userId,'pay'=>0),
				);
			$this->db->trans_start();
	    	$this->db->update("users");//激活用户
	    	$this->db->insert_batch('class', $class); //设置默认分类
	    	$this->db->insert_batch('pay', $pay); //设置默认分类
	    	$this->db->trans_complete(); 
	    	$this->db->trans_off();
		    if ($this->db->trans_status() === FALSE){
		   		 return '激活失败!';
			}else{
				 return '激活成功!';
			}
		}else{
			return '激活码无效或已经激活!';
		}
		
    	
    }
    /**
     * 根据分类id，查询用户支付分类设置
     * 
     * */
    function getClassById($id,$istongji=''){
    	if($istongji==''){
    		$arr=array('pid'=>$id,
    				'userid'=>$_SESSION['userInfo']['id'],
    				'isdelete'=>0	
    		);
    	}else{
    		$arr=array('pid'=>$id,
    				'userid'=>$_SESSION['userInfo']['id'],
    				'isdelete'=>0,
    				'istongji'=>$istongji	
    				);
    	}
    	
    	$this->db->order_by('id','asc');
    	$query=$this->db->get_where('class', $arr);
		return $query->result_array();
    }
    /**
     * 根据分类id，修改分类的名称
     * */
    function editClass($id,$name,$istongji){
    	$userId=$_SESSION['userInfo']['id']+0;
    	$this->db->where('id',$id);
    	$this->db->where('userid',$userId);
    	$this->db->set("name",$name);
    	$this->db->set("istongji",$istongji);
		return $this->db->update("class");
    }
	/**
     * 根据分类id，删除分类的名称,将isdelete设为1
     * */
    function delClass($id){
    	$userId=$_SESSION['userInfo']['id']+0;
    	$this->db->where('id',$id);
    	$this->db->where('userid',$userId);
    	//还需要删除该分类与该分类下的所有记账记录！
    	
    	$this->db->set("isdelete",1);
		return $this->db->update("class");
    	//return $this->db->delete("class");
    }
	/**
     * 添加类
     * */
    function addClass($pid,$name,$istongji){
    	$userId=$_SESSION['userInfo']['id'];
    	$data=array('pid'=>$pid,
    				'name'=>$name,
    				'userid'=>$userId,
    				'istongji'=>$istongji,
    				'isdelete'=>0
    				);
    	return $this->db->insert("class",$data);
    }
	/**
     * 查询用户支付方式
     * 
     * */
    function getPayList(){
    	$arr=array('userid'=>$_SESSION['userInfo']['id']);
    	$this->db->order_by('id','asc');
    	$query=$this->db->get_where('pay', $arr);
		return $query->result_array();
    }
	/**
     * 根据分类id，删除支付方式
     * */
    function delPay($id){
    	$userId=$_SESSION['userInfo']['id']+0;
    	$this->db->where('id',$id);
    	$this->db->where('userid',$userId);
    	return $this->db->delete("pay");
    }
	/**
     * 添加支付方式
     * 1:现金、2:刷卡、3:金券代、0其他；
     * */
    function addPay($name,$payvalue){
    	$userId=$_SESSION['userInfo']['id'];
    	$data=array('name'=>$name,
    				'userid'=>$userId,
    				'pay'=>$payvalue
    				);
    	return $this->db->insert("pay",$data);
    }
	/**
     * 根据支付方式id，修改支付方式的名称
     * */
    function editPay($id,$name,$payvalue){
    	$userId=$_SESSION['userInfo']['id']+0;
    	$this->db->where('userid',$userId);
    	$this->db->where('id',$id);
    	$this->db->set("name",$name);
    	$this->db->set("pay",$payvalue);
		return $this->db->update("pay");
    }
	/**
     * 增加新记账
     * payclass:		1:现金、2:刷卡、3:金券代、0其他；
     * */
    function addCash(){
    	$userId=$_SESSION['userInfo']['id'];
		$temp=$this->input->post('pay',TRUE);
		$temp=split(',',$temp);
		$temp2=split('-',$temp[1]);
    	$data=array("cashname"=>$this->input->post('cashName',TRUE),
		"money"=>$this->input->post('money',TRUE),
    	"class"=>$this->input->post('class',TRUE),
    	"pay"=>$temp2[0],
    	"payclass"=>$temp2[1],
    	"payid"=>$temp[0],
    	"oper"=>$this->input->post('oper',TRUE),
    	"paydate"=>$this->input->post('payDate',TRUE),
    	"mark"=>$this->input->post('mark',TRUE),
    	"userid"=>$userId,
    	"isdelete"=>0,
		"date_time"=>date("Y-m-d H:i:s"));
    	return $this->db->insert("cashlist",$data);
    }
    /**
     * 	统计一段时间内支出、收入、借、贷总和
	 *	SELECT sum(`qbb_cashlist`.`money`) FROM `qbb_cashlist` Inner Join `qbb_class` 
	 *		ON `qbb_cashlist`.`class` = `qbb_class`.`id` and `qbb_class`.`pid`=4 and `qbb_cashlist`.`paydate`>='2012-10-01' 
	 *			and `qbb_cashlist`.`paydate`<='2012-10-12' and `qbb_cashlist`.`userid`=3
     * */
    public function countPay($pid='-1',$beginDate='2000-01-01',$endDate='2222-01-01',$payid=''){
    	$userId=$_SESSION['userInfo']['id'];
    	if($payid==''){
    		$sql="SELECT sum(l.`money`) sum FROM `".$this->db->dbprefix."cashlist` l Inner Join `".$this->db->dbprefix."class` c ON l.`class` = c.`id` and c.`istongji`=1 and c.`pid` =".$pid." and l.`paydate`>='".$beginDate."' and l.`paydate`<='".$endDate."' and l.isdelete=0 and l.`userid`=".$userId;
    	}else{
    		$sql="SELECT sum(l.`money`) sum FROM `".$this->db->dbprefix."cashlist` l Inner Join `".$this->db->dbprefix."class` c ON l.`class` = c.`id` and c.`istongji`=1 and c.`pid` =".$pid." and payid in(".$payid.") and l.`paydate`>='".$beginDate."' and l.`paydate`<='".$endDate."' and l.isdelete=0 and l.`userid`=".$userId;
    	}
    	$query = $this->db->query($sql);
		return $query->result_array();
    }
	/**
     * 	统计一段时间内小分类总和
     * 	从cashlist中查询
     * 
	 * */
    public function countClassPay($classId=-1,$beginDate='2000-01-01',$endDate='2222-01-01'){
    	$userId=$_SESSION['userInfo']['id'];
    	$sql="select sum(money) money from ".$this->db->dbprefix."cashlist where class=".$classId." and userid=".$userId." and isdelete=0 and paydate >='".$beginDate."' and paydate <='".$endDate."'";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
	/**
	 * 查询cashList的条数
	 * payclass:		1:现金、2:刷卡、3:金券代、0其他；
	 * */
	function countCash(){
		$userId=$_SESSION['userInfo']['id'];
		$this->db->from("cashlist");
		$this->db->where('userid',$userId);
		$this->db->where('isdelete',0);
		if(isset($_SESSION['class']) && $_SESSION['class']!="-1")
			$this->db->where('class',$_SESSION['class']);
		if(isset($_SESSION['payclass']) && $_SESSION['payclass']!="-1")
			$this->db->where('payclass',$_SESSION['payclass']);
		if(isset($_SESSION['beginDate']) && $_SESSION['beginDate']!="-1")
			$this->db->where('paydate',$_SESSION['beginDate']);
		if(isset($_SESSION['endDate']) && $_SESSION['endDate']!="-1")
			$this->db->where('paydate',$_SESSION['endDate']);
		if(isset($_SESSION['today']) && $_SESSION['today']!="-1")
			$this->db->where('paydate',$_SESSION['today']);
		return $this->db->count_all_results();
	}
	/**
	 * 查询cashList4的条数
	 * payclass:		1:现金、2:刷卡、3:金券代、0其他；
	 * */
	function countCash4(){
		$userId=$_SESSION['userInfo']['id'];
		$this->db->from("cashlist");
		$this->db->where('userid',$userId);
		$this->db->where('isdelete',1);
		
		return $this->db->count_all_results();
	}
	/**
	 * 按分页查询个人账单
	 * payclass:		1:现金、2:刷卡、3:金券代、0其他；
	 * sql:SELECT l.id,l.cashname,l.money,l.pay,l.oper,l.paydate,l.mark,c.pid,c.name FROM  `qbb_cashList` l, `qbb_class` c WHERE l.class=c.id and l.`isdelete` = 0 ORDER BY l.`id` desc LIMIT 20
	 * */
	function searchCash($index=5,$offset=0){
		if($offset==null) $offset=0;
		$userId=$_SESSION['userInfo']['id'];
		$sql="SELECT l.id,l.cashname,l.money,l.class,l.pay,l.payclass,l.oper,l.paydate,l.mark,c.pid,c.name FROM  `".$this->db->dbprefix."cashlist` l, `".$this->db->dbprefix."class` c WHERE l.class=c.id and l.`isdelete` = 0 and c.`isdelete` = 0 and l.`userid`=".$userId;
		if(isset($_SESSION['class']) && $_SESSION['class']!="-1")
			$sql=$sql." and l.class=".$_SESSION['class'];
		if(isset($_SESSION['payclass']) && $_SESSION['payclass']!="-1")
			$sql=$sql." and payclass='".$_SESSION['payclass']."'";
		if(isset($_SESSION['beginDate']) && $_SESSION['beginDate']!="-1")
			$sql=$sql." and l.paydate >= '".$_SESSION['beginDate']."'";
		if(isset($_SESSION['endDate']) && $_SESSION['endDate']!="-1")
			$sql=$sql." and l.paydate <='".$_SESSION['endDate']."'";
		if(isset($_SESSION['today']) && $_SESSION['today']!="-1")
			$sql=$sql." and l.paydate ='".$_SESSION['today']."'";
		$sql=$sql." ORDER BY l.`paydate` desc LIMIT ".$offset.",".$index;
		$query = $this->db->query($sql);
		return $query->result_array();

	}
/**
	 * 按分页查询个人账单
	 * payclass:		1:现金、2:刷卡、3:金券代、0其他；
	 * sql:SELECT l.id,l.cashname,l.money,l.pay,l.oper,l.paydate,l.mark,c.pid,c.name FROM  `qbb_cashList` l, `qbb_class` c WHERE l.class=c.id and l.`isdelete` = 0 ORDER BY l.`id` desc LIMIT 20
	 * */
	function searchCash4($index=5,$offset=0){
		if($offset==null) $offset=0;
		$userId=$_SESSION['userInfo']['id'];
		$sql="SELECT l.id,l.cashname,l.money,l.class,l.pay,l.payclass,l.oper,l.paydate,l.mark,c.pid,c.name FROM  `".$this->db->dbprefix."cashlist` l, `".$this->db->dbprefix."class` c WHERE l.class=c.id and l.`isdelete` = 1 and c.`isdelete` = 0 and l.`userid`=".$userId;
		
		$sql=$sql." ORDER BY l.`paydate` desc LIMIT ".$offset.",".$index;
		$query = $this->db->query($sql);
//		$query->result_array();
//		echo $this->db->last_query();exit;
		return $query->result_array();

	}
	/**
	 * 根据id，查询账单
	 * */
	public function getCashById($id=0){
		$arr=array('isdelete'=>0,'id'=>$id);
		$query=$this->db->get_where('cashlist', $arr);
		return $query->result_array();
	}
    /**
     * 根据id，修改账单
     * */
    function cashEdit($id=0){
    	$userId=$_SESSION['userInfo']['id'];
    	$this->db->where('id',$id);
    	$this->db->where('userid',$userId);
    	$temp=$this->input->post('pay',TRUE);
		$temp=split(',',$temp);
    	$data=array("cashname"=>$this->input->post('cashName',TRUE),
		"money"=>$this->input->post('money',TRUE),
    	"class"=>$this->input->post('class',TRUE),
    	"pay"=>$temp[1],
    	"payid"=>$temp[0],
    	"oper"=>$this->input->post('oper',TRUE),
    	"paydate"=>$this->input->post('payDate',TRUE),
    	"mark"=>$this->input->post('mark',TRUE),
    	"isdelete"=>0,
		"date_time"=>date("Y-m-d H:i:s"));
		return $this->db->update("cashlist",$data);
    }
	/**
	 * 根据id，删除账单，即将isdelete=1
	 * */
	public function delCash($id){
		$userId=$_SESSION['userInfo']['id'];
    	$this->db->where('userid',$userId);
		$this->db->where('id',$id);
		$arr=array('isdelete'=>1);
		return $this->db->update("cashlist",$arr);
	}
	/**
	 * 根据id，恢复账单，即将isdelete=0
	 * */
	public function resetCash($id){
		$userId=$_SESSION['userInfo']['id'];
    	$this->db->where('userid',$userId);
		$this->db->where('id',$id);
		$arr=array('isdelete'=>0);
		return $this->db->update("cashlist",$arr);
	}
	/**
	 * 根据id，删除账单，即将delete
	 * */
	public function delCash4($id){
		$userId=$_SESSION['userInfo']['id'];
    	$this->db->where('userid',$userId);
		$this->db->where('id',$id);
		return $this->db->delete("cashlist");
	}
	/**
	 * 一键清空回收站
	 * */
	public function delAllCash(){
		$userId=$_SESSION['userInfo']['id'];
    	$arr=array('userid'=>$userId,'isdelete'=>1);
		return $this->db->delete("cashlist",$arr);
	}
	/**
	 * 修改用户信息
	 * */
	public function editUser($key,$value){
		$userId=$_SESSION['userInfo']['id'];
    	$this->db->where('id',$userId);
    	$data=array($key=>$value);
		return $this->db->update("users",$data);
	}
    /**
     * 验证旧密码
     * 
     * */
    function checkOldPass($oldpass=''){
    	$username=$_SESSION['userInfo']['username'];
    	$password=crypt(md5($oldpass),md5($username));
    	$arr=array('username'=>$username,
    				'password'=>$password
    			);
    	$query=$this->db->get_where('users', $arr);
		return $query->result_array();
    }
	/**
	 * 修改密码
	 * */
	public function changePass($newpass){
		$userId=$_SESSION['userInfo']['id']+0;
		$username=$_SESSION['userInfo']['username'];
    	$newpass=crypt(md5($newpass),md5($username));
    	
    	$this->db->where('id',$userId);
    	$data=array('password'=>$newpass);    	
    	return $this->db->update("users",$data);
	}
	/**
     * 根据支付方式，查找符合的pay
     * 1:现金、2:刷卡、3:金券代、0其他；
     * */
    function getPayByPay($id){
    	$arr=array('userid'=>$_SESSION['userInfo']['id'],'pay'=>$id);
    	$query=$this->db->get_where('pay', $arr);
		return $query->result_array();
    }
    /**
	 * 下载账单
	 * $sql=SELECT l.paydate,l.cashname,c.pid,c.name,l.pay,l.money,l.payclass,l.oper,l.mark FROM  `qbb_cashlist` l, `qbb_class` c WHERE l.class=c.id and l.`isdelete` = 0 and c.`isdelete` = 0 and l.`userid`=7
	 * */
	public function down_cash($st,$et){
		$userId=$_SESSION['userInfo']['id'];
		$sql="SELECT l.paydate,l.cashname,c.pid,c.name,l.pay,l.money,l.payclass,l.oper,l.mark FROM  `".$this->db->dbprefix."cashlist` l, `".$this->db->dbprefix."class` c WHERE l.class=c.id and l.`isdelete` = 0 and l.`userid`=".($userId+0);
		$sql=$sql." and l.paydate >= '".$st."' and l.paydate <='".$et."'  ORDER BY l.`paydate` asc ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
   /**
     * 根据用户名、邮箱找回密码。现在验证用户名和邮箱是否一致
     * 
     * */
    function get_pass_byemail(){
    	$arr=array('username'=>$this->input->post('username',TRUE),
    				'email'=>$this->input->post('email',TRUE)
    	);
    	$this->db->select('username,password,email');
    	$query=$this->db->get_where('users', $arr);
		return $query->result_array();
    }
	/**
	 * 修改找回密码时发送邮件的时间
	 * */
	public function set_emile_time($username,$password,$date_time){
    	$this->db->where('username',$username);
    	$data=array('emailtime'=>$date_time,'emailstr'=>md5($password));
		return $this->db->update("users",$data);
	}
	public function set_emile_time2($username,$emailstr,$date_time,$emailtext=''){
    	$this->db->where('username',$username);
    	$data=array('emailtime'=>$date_time,'emailstr'=>$emailstr,'emailtext'=>$emailtext);
		return $this->db->update("users",$data);
	}
	/**
 	 * 根据邮件链接，重置密码时验证用户名和邮件发送时间
 	 * */
 	public function get_password2($emailstr=''){
 		$arr=array('emailstr'=>$emailstr);
    	$this->db->select('username,emailtime');
    	$query=$this->db->get_where('users', $arr);
		return $query->result_array();
 	}
	/**
	 * 根据邮件链接，设置用户新密码
	 * */
	public function set_password2(){
		$username=$this->input->post('username',TRUE);
		$password=$this->input->post('password',TRUE);;
    	$newpass=crypt(md5($password),md5($username));
    	$this->db->where('username',$username);
    	$data=array('password'=>$newpass,'emailstr'=>'');    	
    	return $this->db->update("users",$data);
	}
	/**
 	 * 将要发送邮件的人员查找出来
 	 * 
 	 * */
 	public function get_not_send_email(){
		$sql="select email,emailstr,emailtext from ".$this->db->dbprefix."users where emailstr != '' order by emailtime asc limit 10 ";
		$query = $this->db->query($sql);
		return $query->result_array();
 	}
}