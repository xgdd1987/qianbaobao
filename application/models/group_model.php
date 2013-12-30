<?php
class Group_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
	/**
     * 查询所有群组
     * 
     * */
    function getGroupList(){
    	$this->db->order_by('id','asc');
    	$query=$this->db->get_where('group');
		return $query->result_array();
    }
	/**
	 * 查询topic的条数
	 * */
	function countTopic(){
		$this->db->from("topic");
		if(isset($_SESSION['groupid'])){
			$this->db->where('groupid',$_SESSION['groupid']);	
		}
		$this->db->where('pin',0);
		$this->db->where('isdelete',0);
		$count=$this->db->count_all_results();
//		echo $this->db->last_query();exit;
		return $count;
	}
	/**
     * 分页查询所有群组内的话题
     * 
     * */
    function getTopicList($index=5,$offset=0){
    	$this->db->order_by("id desc");
		$this->db->select('id,name,userid,username,pin,replies,dianji,date_time');
		$this->db->from("topic");
    	if(isset($_SESSION['groupid'])){
			$this->db->where('groupid',$_SESSION['groupid']);	
		}
		$this->db->where('pin',0);
		$this->db->where('isdelete',0);
		$this->db->limit($index,$offset);
		$query=$this->db->get();
//		$query->result_array();
//		echo $this->db->last_query();exit;
		
		return $query->result_array();
    }    
	/**
     * 查询群组内的最新固定数量话题
     * pin:		0:不置顶；1:置顶
     * */
    function getTopicPin($index=5,$offset=0){
    	$this->db->order_by("id desc");
		$this->db->select('id,name,userid,username,pin,replies,dianji,date_time');
		$this->db->from("topic");
		$this->db->where('pin',1);
		$this->db->where('isdelete',0);
		$this->db->limit($index,$offset);
		$query=$this->db->get();
		return $query->result_array();
    }
	/**
     * 添加新话题
     * pin:		0:不置顶；1:置顶
     * */
    function addTopic($id){
    	$date_time=date('Y-m-d H:i:s');
    	$data=array('name'=>$this->input->post('name',TRUE),
    				'userid'=>$_SESSION['userInfo']['id'],
    				'content'=>$this->input->post('content',TRUE),
    				'groupid'=>$id,
    				'username'=>$_SESSION['userInfo']['username'],
    				'date_time'=>$date_time,
    				'replies'=>0,
    				'dianji'=>0,
    				'pin'=>0,
    				'isdelete'=>0
    			);
//    			print_r($this->input->post('content',TRUE));exit;
    	$this->db->trans_start();
    	$this->db->insert("topic",$data);
    	$data=array('lastpostuser'=>$_SESSION['userInfo']['username'],
 					'lastpostdatetime'=>$date_time
 		);
 		$this->db->where('id',$_SESSION['groupid']);
 		$this->db->update('group',$data); //更新最后回复人
    	
    	
    	$this->db->set('count', 'count+1',FALSE);
    	$this->db->where('id',$id);
    	$this->db->where('isdelete',0);
 		$this->db->update('group'); 
 		$this->db->trans_complete(); 
    	$this->db->trans_off();
    	if ($this->db->trans_status() === FALSE){
	   		 return FALSE;
		}else{
			 return TRUE;
		}
    }
    /**
	 * 屏蔽不当回复
	 * */
    public function pingbi($id){
		$this->db->set('content', '<font color="red">提示：该楼层含有不当言论，已经被管理员屏蔽!</font>');
    	$this->db->where('id',$id);
 		return $this->db->update('replies'); 
    }
    
    public function dianji($id){
    	//每点击一次 热度+1
		$this->db->set('dianji', 'dianji+1',FALSE);
    	$this->db->where('id',$id);
    	$this->db->where('isdelete',0);
 		return $this->db->update('topic'); 
    }
    /**
     * 置顶、取消置顶话题
     * pin=0:不置顶；pin=1：置顶
     * */
    public function pinTopic($pin=0,$id){
		$this->db->set('pin', $pin);
    	$this->db->where('id',$id);
    	$this->db->where('isdelete',0);
 		return $this->db->update('topic'); 
    }
    /**
     * 根据id，删除话题
     * $op=0:不删除；$op=1:删除
     * */
    public function doTopic($op=0,$id){
    	$this->db->trans_start();
    	$this->db->where('id',$id);
    	$this->db->set('isdelete',$op);	
 		$this->db->update('topic'); //删除帖子
		
 		$this->db->set('count', 'count-1',FALSE); //帖子数 -1
    	$this->db->where('id',$_SESSION['groupid']);
    	$this->db->where('isdelete',0);
 		$this->db->update('group'); 
 		
   		$this->db->trans_complete(); 
    	$this->db->trans_off();
	    if ($this->db->trans_status() === FALSE){
	   		 return FALSE;
		}else{
			 return TRUE;
		}
    }
	/**
	 * 根据id，查询话题
	 * */
	public function getTopicById($id=0){
		
//		echo $this->db->last_query();exit;
		$arr=array('isdelete'=>0,'id'=>$id);
		$sql="select t.id,t.groupid,t.userid,t.username,t.name,t.content,t.date_time,u.photo  from ".$this->db->dbprefix."topic t,".$this->db->dbprefix."users u where t.userid=u.id and t.isdelete=0  and t.id=".$id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	/**
	 * 根据id userId，查询话题
	 * */
	public function getTopicByIdUserId($id=0){
		
//		echo $this->db->last_query();exit;
		$quanxian=$_SESSION['userInfo']['quanxian'];
		if(1 == $quanxian || 2 == $quanxian ){
			$arr=array('isdelete'=>0,'id'=>$id);
		}else{
			$arr=array('isdelete'=>0,'id'=>$id,'userid'=>$_SESSION['userInfo']['id']);
		}
		
    	$query=$this->db->get_where('topic', $arr);
		return $query->result_array();
	}
	/**
	 *  根据id 修改话题
	 * 
	 * */
    public function editTopic($id){
//    	echo $this->input->post('content');exit;
		$this->db->where('id',$id);
    	$data=array("name"=>$this->input->post('name',TRUE),
		"content"=>$this->input->post('content'),
		"date_time"=>date("Y-m-d H:i:s"));
 		return $this->db->update('topic',$data); 
    }
	/**
     * 添加回复
     * */
    function addReplies(){
    	$this->db->trans_start();
    	$topicid=$this->input->post('topicid',TRUE);
    	$date_time=date("Y-m-d H:i:s");
		$this->db->set('replies', 'replies+1',FALSE);
    	$this->db->where('id',$topicid);
    	$this->db->where('isdelete',0);
 		$this->db->update('topic'); //回复数+1
 		$data=array('lastpostuser'=>$_SESSION['userInfo']['username'],
 					'lastpostdatetime'=>$date_time
 		);
 		$this->db->where('id',$_SESSION['groupid']);
 		$this->db->update('group',$data); //更新最后回复人
    	$userId=$_SESSION['userInfo']['id'];
    	$data=array('topicid'=>$topicid,
    				'userid'=>$userId,
    				'content'=>$this->input->post('content',TRUE),
			    	'date_time'=>$date_time,
			    	'isdelete'=>0
    				);
    	$this->db->insert("replies",$data);
    	$this->db->trans_complete(); 
    	$this->db->trans_off();
    	if ($this->db->trans_status() === FALSE){
	   		 return FALSE;
		}else{
			 return TRUE;
		}
    }
	/**
	 * 查询话题回复的条数
	 * */
	function countReplies($id){
		$this->db->from("replies");
		$this->db->where('topicid',$id);
		$this->db->where('isdelete',0);
		$count=$this->db->count_all_results();
		return $count;
	}
	/**
     * 分页查询话题回复
     * 
     * */
    function getTopicReplies($index=5,$offset=0,$id){
    	if($offset!=0)
    		$sql="SELECT r.id,r.userid,r.content,r.date_time,u.username,u.photo  FROM ".$this->db->dbprefix."replies r,".$this->db->dbprefix."users u WHERE r.userid=u.id and  r.topicid =".$id." AND r.isdelete = 0 ORDER BY r.id asc LIMIT ".$offset.",".$index;
    	else
    		$sql="SELECT r.id,r.userid,r.content,r.date_time,u.username,u.photo  FROM ".$this->db->dbprefix."replies r,".$this->db->dbprefix."users u WHERE r.userid=u.id and  r.topicid =".$id." AND r.isdelete = 0 ORDER BY r.id asc LIMIT ".$index;
//		echo $sql;exit;
		$query = $this->db->query($sql);
		return $query->result_array();
    }
 
}