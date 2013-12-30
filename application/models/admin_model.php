<?php
class Admin_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
	/**
	 * 修改用户信息
	 * */
	public function editUser($userid,$key,$value){
    	
    	if($key == 'rsetpass'){
    		$data=array('id'=>$userid);
    		$this->db->select('username');
    		$query=$this->db->get_where('users', $data);
    		$username=$query->result_array();
    		$username=$username[0]['username'];
    		$password=crypt(md5('qianbaobao365.com'),md5($username));
    		$data=array('password'=>$password);
    	}elseif($key == 'photo'){
    		$data=array('id'=>$userid);
    		$this->db->select('photo');
    		$query=$this->db->get_where('users', $data);
    		$photo=$query->result_array();
    		$photo=$photo[0]['photo'];
    		if(file_exists($photo) && $photo != 'images/default.gif'){ //删除旧头像
				unlink($photo);
			}
    		$data=array($key=>$value);
    	}else{
    		$data=array($key=>$value);
    	}
		$this->db->where('id',$userid);
    	return $this->db->update("users",$data);
	}
	/**
	 * 查询users的条数
	 * */
	function countUsers(){
		$this->db->from("users");
		if(isset($_SESSION['quanxian']) && $_SESSION['quanxian']!='')
			$this->db->where('quanxian',$_SESSION['quanxian']);
		elseif(isset($_SESSION['quanxian2']) && $_SESSION['quanxian2']!=''){
				$this->db->where('quanxian2 <',0);
		}
		elseif(isset($_SESSION['zhuangtai']) && $_SESSION['zhuangtai'] !='')
			$this->db->where('zhuangtai',$_SESSION['zhuangtai']);
		return $this->db->count_all_results();
	}
	/**
     * 分页条件查询用户
     * 
     * */
    function getUserList($index=5,$offset=0){
    	$this->db->order_by("id desc");
		$this->db->from("users");
    	if(isset($_SESSION['quanxian']) && $_SESSION['quanxian']!='')
			$this->db->where('quanxian',$_SESSION['quanxian']);
		elseif(isset($_SESSION['quanxian2']) && $_SESSION['quanxian2']!=''){
				$this->db->where('quanxian2 <',0);
		}
		elseif(isset($_SESSION['zhuangtai']) && $_SESSION['zhuangtai'] !='')
			$this->db->where('zhuangtai',$_SESSION['zhuangtai']);
		$this->db->limit($index,$offset);
		$query=$this->db->get();
		
		return $query->result_array();
    } 
}