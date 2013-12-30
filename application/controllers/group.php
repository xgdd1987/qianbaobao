<?php
session_start();
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Group extends CI_Controller {
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
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -   
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		$data['menu']='group';
		$this->load->model('group_model','group',TRUE);
		$data['group']=$this->group->getGroupList();
		$this->load->view('group',$data);
	}
	/**
	 * 话题列表
	 * */
	public function topicList2($id,$groupName='钱宝宝官方群组'){
		$_SESSION['groupid']=$id;
		$groupName=urldecode($groupName);
		$_SESSION['groupName']=$groupName;
		redirect("group/topicList");
	}
	public function topicList(){
		if(! isset($_SESSION['groupid'])){
			$_SESSION['groupid']='10000';	
		}
		if(! isset($_SESSION['groupName'])){
			$_SESSION['groupName']='钱宝宝官方群组';	
		}
		$data['menu']='group';
		$this->load->model('group_model','group',TRUE);
		$this->load->library('pagination');
		$config['base_url']=site_url('group/topicList');
		$config['total_rows'] = $this->group->countTopic();
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;
		
		$config['first_link'] = '首页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['last_link'] = '尾页';
		$data['topic']=$this->group->getTopicList($config['per_page'],$this->uri->segment(3));
		$this->pagination->initialize($config);
		$data['topicPin']=$this->group->getTopicPin(5); //得到置顶的5条话题
		if(count($data['topic']>0)){
			$this->load->view('topicList',$data);
		}else{
			$data['msg']="对不起，没有找到您需要的数据!";
			$this->load->view ( 'tip',$data );
		}
	}
	/**
	 * 发表新话题
	 * 备注：这里验证是否被禁言，验证的是SESSION，存在一个延迟的问题。
	 * 也就是说当管理员把该账号禁止时，如果该账号恰好在线，那么对该账号不起什么作用。只有该账号重新登录的时候才起作用。
	 * 编辑话题、禁止回帖、锁定账号等功能也存在这个问题。
	 * 解决方法 1：强制该用户下线。
	 * 		   2：对每个功能进行权限认证的时候，不读取SESSION，而是读取数据库。
	 * 现在暂时未解决这个问题 ， 等以后有时间在解决吧。 于 2012-10-30	
	 * */
	public function addTopic($id){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$quanxian2=$_SESSION['userInfo']['quanxian2'];
		$quanxian2=$quanxian2+0;
		if(0==$quanxian2){
			$this->load->helper ( array ('form') );
			$this->load->library ( 'form_validation' );
			$this->form_validation->set_rules('name', '话题标题', 'trim|max_length[50]|required|xss_clean');
			if ($this->form_validation->run () == FALSE) {
				//编辑器
				$params = array('name' => 'content','width'=>200,'height'=>200);
				$this->load->library('sinaeditor', $params);
				$this->sinaeditor->value = $this->input->post('content',TRUE);
				$info = $this->sinaeditor->create();
				$data['info'] = $info; 
				$this->load->view('addTopic',$data);
			} else {
				$this->load->model('group_model','group',TRUE);
				if($this->group->addTopic($id)){ 
					 $_SESSION["msg"]="发表成功!!";
					 
				}else{
					 $_SESSION["msg"]="发表失败!!";
				}
				redirect('group/addTopic/'.$id);
			}	
		 }
		 elseif(-1==$quanxian2 || -2==$quanxian2){
		 	$data['msg']="对不起，您已被管理员禁止发言或者发帖,请联系管理员！!";
			$this->load->view ( 'tip',$data );	
		 }
		 
		
		
	}
	/**
	 * 编辑话题
	 * */
	public function editTopic($id){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$quanxian2=$_SESSION['userInfo']['quanxian2'];
		if(0==$quanxian2){
			$this->load->helper ( array ('form') );
			$this->load->model('group_model','group',TRUE);
			$this->load->library ( 'form_validation' );
			$this->form_validation->set_rules('name', '话题标题', 'trim|max_length[50]|required|xss_clean');
			$content=$this->group->getTopicByIdUserId($id);
			if(count($content)>0){
				if ($this->form_validation->run () == FALSE) {
					//编辑器
					$params = array('name' => 'content','width'=>200,'height'=>200);
					$this->load->library('sinaeditor', $params);
					$postContent=$this->input->post('content',TRUE);
					if($postContent==''){
						$this->sinaeditor->value = $content[0]['content'];
					}else{
						$this->sinaeditor->value = $postContent;
					}
					$info = $this->sinaeditor->create();
					$data['info'] = $info; 
					$data['topic']=$content;
					$this->load->view('editTopic',$data);
				} else {
					
					if($this->group->editTopic($id)){ 
						 $_SESSION["msg"]="发表成功!!";
						 
					}else{
						 $_SESSION["msg"]="发表失败!!";
					}
					redirect('group/editTopic/'.$id);
				}
			}else{
				$data['msg']="对不起，没有找到您需要的数据!";
				$this->load->view ( 'tip',$data );
			}
		}elseif(-1==$quanxian2 || -2==$quanxian2){
		 	$data['msg']="对不起，您已被管理员禁止发言或者发帖,请联系管理员！!";
			$this->load->view ( 'tip',$data );	
		 }
	}
	/**
	 * 按id 操作话题
	 * $op=0：置顶；$op=1:删除；$op=2:取消置顶
	 * */
	public function doTopic($op=-1,$id=0){
		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		$quanxian=$_SESSION['userInfo']['quanxian'];
		if($quanxian ==1 || $quanxian==2){
			$this->load->model('group_model','group',TRUE);
			if( $op==0){
				if($this->group->pinTopic(0,$id)){ //pin=0:不置顶；pin=1：置顶
					echo "操作成功!";
				}else{
					echo "操作失败";
				}
			}elseif($op==1){
				if($this->group->pinTopic(1,$id)){//pin=0:不置顶；pin=1：置顶
					echo "操作成功!";
				}else{
					echo "操作失败";
				}	
			}elseif($op==2){
				if($this->group->doTopic(1,$id)){//$op=0:不删除；$op=1:删除
					echo "删除成功!";
				}else{
					echo "删除失败";
				}
			}else{
				echo "警告：非法操作";
			}	
		}else{
			echo "警告：非法操作";
		}
	}
	/**
	 * 按id查看话题
	 * */
	public function getTopicById($id=0){
		$_SESSION['topicid']=$id;
		$this->load->model('group_model','group',TRUE);
		$this->group->dianji($id);
		redirect('group/getTopicById2/');	
	}
	

	public function getTopicById2(){
		if(isset($_SESSION['topicid'])){
			if(!isset($_SESSION['groupName'])){
				$_SESSION['groupid']="10000";
				$_SESSION['groupName']="钱宝宝官方群组";
			}
			$id=$_SESSION['topicid'];
			$this->load->library ( 'form_validation' );
			$this->load->library('pagination');
			$this->form_validation->set_rules('content', '密码', 'required|xss_clean');
			$this->load->model('group_model','group',TRUE);
			if ($this->form_validation->run () == FALSE) {
				
				$config['base_url']=site_url('group/getTopicById2');
				$config['total_rows'] = $this->group->countReplies($id);
				$config['per_page'] = 10;
				$config['uri_segment'] = 3;
				$config['num_links'] = 2;
				
				$config['first_link'] = '首页';
				$config['prev_link'] = '上一页';
				$config['next_link'] = '下一页';
				$config['last_link'] = '尾页';
				
				$data['topic']=$this->group->getTopicById($id);
				$groupid=$data['topic'][0]['groupid'];
				$_SESSION['groupid']=$groupid;
				if($groupid=='10000'){
					$_SESSION['groupName']="钱宝宝官方群组";
				}elseif($groupid=='10002'){
					$_SESSION['groupName']="理财小贴士";
				}elseif($groupid=='10003'){
					$_SESSION['groupName']="败家心得";
				}elseif($groupid=='10004'){
					$_SESSION['groupName']="有儿有女";
				}elseif($groupid=='10005'){
					$_SESSION['groupName']="使用帮助";
				}
				if(count($data['topic'])>0){
					$uri=$this->uri->segment(3);
					$data['replies']=$this->group->getTopicReplies($config['per_page'],$uri,$id);
//					$data['per_row']=$config['per_page'];
					if($uri=='')
						$uri=0;
					$data['lou']=$uri+1;
					$this->pagination->initialize($config);
					//表情
					$this->load->helper('smiley');
					$this->load->library('table');
					$tmpl = array (
		                    'table_open'          => '<table width="100%"  border="0" cellpadding="4" cellspacing="0">',
		                    'heading_row_start'   => '<tr>',
		                    'heading_row_end'     => '</tr>',
		                    'heading_cell_start'  => '<th>',
		                    'heading_cell_end'    => '</th>',
		                    'row_start'           => '<tr height="25">',
		                    'row_end'             => '</tr>',
		                    'cell_start'          => '<td>',
		                    'cell_end'            => '</td>',
		                    'row_alt_start'       => '<tr height="25">',
		                    'row_alt_end'         => '</tr>',
		                    'cell_alt_start'      => '<td>',
		                    'cell_alt_end'        => '</td>',
		                    'table_close'         => '</table>'
		              );
					$this->table->set_template($tmpl); 
					$image_array = get_clickable_smileys(base_url().'qsmileys/', 'content');
					$col_array = $this->table->make_columns($image_array,10);
					$data['smiley_table'] = $this->table->generate($col_array);
					$this->load->view('getTopicById',$data);
				}else{
					$data['msg']="对不起，没有找到您需要的数据!";
					$this->load->view ( 'tip',$data );
				}
			} else{
				$quanxian2=$_SESSION['userInfo']['quanxian2'];
				if(0==$quanxian2){
					if($this->group->addReplies()){ 
						 $_SESSION["msg"]="回复成功!!";
						 
					}else{
						 $_SESSION["msg"]="回复失败!!";
					}
					redirect('group/getTopicById/'.$id);
				}elseif(-1==$quanxian2 || -3==$quanxian2){
				 	$data['msg']="对不起，您已被管理员禁止发言或者回帖,请联系管理员！!";
					$this->load->view ( 'tip',$data );	
				 }
			}	
		}else{
			$data['msg']="对不起，没有找到您需要的数据!";
			$this->load->view ( 'tip',$data );
		}
		
		
	}
	/**
	 * 裁剪图片
	 * */
	public function cutPhoto($x,$y,$w,$h,$pic){
		ini_set ( 'memory_limit', '100M' );
		$src='imgtemp/'.$pic;
		$targ_w = $targ_h = 80;//默认图片为80的正方形
		$jpeg_quality = 90;//图片的质量
		list ( $w_src, $h_src, $type ) = getimagesize ( $src );
		switch ($type){
			case 1: // gif -> jpg
				$img_r = imagecreatefromgif($src);
			break;
			case 2: // jpeg -> jpg
				$img_r = imagecreatefromjpeg($src);
			break;
			case 3: // png -> jpg
				$img_r = imagecreatefrompng($src);
			break;
		}
		$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
		$photo='photo/'.date('YmdHis').rand(0,1000).'.jpg';
		if(imagejpeg($dst_r,$photo,$jpeg_quality)){
			imagedestroy($img_r);
			imagedestroy($dst_r);
			if(file_exists($src)){
				unlink($src);
			}
			//进行数据库操作 
			$this->load->model('user_model','user',TRUE);
			if($this->user->editUser('photo',$photo)){
				if(file_exists($_SESSION['userInfo']['photo'])){ //删除旧头像
					if($_SESSION['userInfo']['photo'] != 'images/default.gif')
						unlink($_SESSION['userInfo']['photo']);
				}
				$_SESSION['userInfo']['photo']=$photo;
				echo '头像修改成功!';
			}else{
				echo '头像修改失败!';
			}
		}else{
			if(file_exists($src)){
				unlink($src);
			}
			echo '头像修改失败!';
		}
	}
	/**
	 * 屏蔽不当回复
	 * */
 	function pingbi($id){
 		if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"] === TRUE)  {
	 	 } else {
			 redirect('welcome/index');
		 }
		 $quanxian=$_SESSION['userInfo']['quanxian'];
		 	if(1 == $quanxian || 2 == $quanxian){
		 	$this->load->model('group_model','group',TRUE);
			if($this->group->pingbi($id)){
				echo '屏蔽成功!';
			}else{
				echo '屏蔽失败!';
			}
		 }else{
		 	echo '非法操作';
		 }
 	}
 	
}

/* End of file group.php */
/* Location: ./application/controllers/group.php */