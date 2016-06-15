<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	//构造函数初始化数据模型
	public function __construct(){
		parent :: __construct();//静态用父类构造方法
		//$this -> load -> model('admin_model');//实例化用户模型
		$this -> load ->database();//直接连接数据库，利用配置的参数
		$this -> load -> helper('url_helper');//加载url_helper中的辅助函数
	}
	
	//显示管理员信息
	public function show()
	{
		var_dump($_COOKIE);die;
		//判断是否已登录
		$this -> load -> library('session');
		if(empty($this->session->username) && empty($_COOKIE['nologin'])){
			echo '<script>alert("请先登录!");window.location="login";</script>';
		}

		$query = $this -> db -> get('admin');//查询admin表,返回结果
		$data = $query -> result_array();//结果集对象转换为数组，row_array()是转换第一个
		//var_dump($data);die;
		//转换等级为人类易读方式
		foreach($data as $k=>$v){
			switch($v['level']){
				case 0:$data[$k]['level']='超级管理员';break;
				case 1:$data[$k]['level']='管理员';break;
				case 2:$data[$k]['level']='普通用户';break;
				default:break;
			}
		}
		/*echo '客户端ip：',$_SERVER['REMOTE_ADDR'],'<br/>';
		echo '服务器ip：',$_SERVER['SERVER_ADDR'],'<br/>';
		echo uri_string(),'<br/>'; //测试辅助函数-url_helper中的一个函数
		echo current_url(),'<br/>';
		echo site_url();*/
 		$this -> load -> view('show',array("data"=>$data));//传送数据到模板
		$this->output->enable_profiler(TRUE);//启动分析器
	}
	//测试url传参
	public function get(){
		//redirect(site_url(''));die;
		var_dump($_GET);//可以通过在url后面加上 ?id=2&name=大牛 方式获取
		echo $this -> input -> get('name');//通过get方式获取值 需要满足"?name=xx&age=22"这种标准形式
		echo $this -> uri -> segment(2); //用段的方式获取 1代表控制器 以此类推 例如xx/index.php/控制器/方法/值1/...
		echo '<br/>';
		echo $this->uri->segment(3);
		echo '<br/>';
		echo $this->uri->segment(4);
		$this->output->enable_profiler(TRUE);//启动分析器
	}
	
	public function add(){
		$this -> load -> view('add');
	}
	
	public function save(){
		
		$flag = $this -> db -> insert('admin',$_POST);
		if($flag){
			redirect('user/show');
		}else{
			redirect('user/add');
		}
	}
	
	public function del(){
		$id = $this->uri->segment(3);
		$this -> db -> delete('admin',array('id'=>$id));
		redirect('user/show');
	}
	
	public function update(){
		$id = $this -> uri -> segment(3);
		$res = $this -> db -> where(array('id'=>$id))
		 	               -> get('admin')
						   -> result_array();
		$this -> load -> view('update',array('data'=>$res[0]));
	}
	
	public function usave(){
		$id = $_POST['id'];
		$flag = $this -> db -> update('admin',$_POST,array('id'=>$id));
		if($flag){
			redirect('user/show');
		}else{
			redirect('user/update');
		}
	}
	//批量插入条用户数据
	public function test(){
		for($i=70001;$i<=150000;$i++){
			$str = 'abcdefghijklmnkopqrstuvwxyz';
			$arr['name'] = substr($str,rand(0,strlen($str)-1),1);
			$arr['name'] .= substr($str,rand(0,strlen($str)-1),1);
			$arr['name'] .= substr($str,rand(0,strlen($str)-1),1);
			$arr['name'] .= $i;
			$arr['gender'] = rand(0,1);
			$arr['age'] = rand(18,30);
			//var_dump($arr);die;
			$this -> db -> insert('userinfo',$arr);
		}
		echo $this -> db -> insert_id();
		echo PHP_EOL;
		echo $this -> db -> last_query();
	}

	/**
	 *
     */
	public function userList(){
		//分页处理
		$total_rows = $this -> db -> count_all_results('userinfo');//获取总条数
		$per_page = 20;//每页显示条数
		$this -> load -> library('pagination');//加载分页类
		//配置分页相关参数
		$config['base_url'] = "http://127.0.0.1/CI-3.0.6/user/userlist/page/";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['first_link'] = '首页'; // 第一页显示
		$config['last_link'] = '末页'; // 最后一页显示
		$config['next_link'] = '下一页 >'; // 下一页显示
		$config['prev_link'] = '< 上一页'; // 上一页显示
		$config['cur_tag_open'] = ' <strong class="current">'; // 当前页开始样式
		$config['cur_tag_close'] = '</strong>';
		$this -> pagination -> initialize($config);
		$pageStr = $this -> pagination -> create_links();//获取分页显示栏
		//根据条件获取数据
		$start = $this->uri->segment(4);//根据url中的参数获取开始位置
		$arr = $this -> db -> limit($per_page,$start)
				           -> get('userinfo')
						   -> result_array();
		$this -> load -> view('userlist',array('arr'=>$arr,'pageStr'=>$pageStr));
		$this->output->enable_profiler(TRUE);//启动分析器
	}
	
	public function upload(){
		$this -> load -> view('upload');
	}
	//保存上传图片
	public function psave(){
		//处理文件上传
		$config['upload_path'] = getcwd().'/Public/upload/';//这个路径需要服务器的绝对路径,getcwd()获取当前目录的绝对路径
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '0'; 
		$config['max_width'] = '1600';
		$config['max_height'] = '1600';
		$config['file_name'] = date('YmdHis',time()).'_'.uniqid().'.jpg';
		$this -> load -> library('upload',$config);
		$res = $this -> upload -> do_upload('userfile');//userfile 是上传文件表单的name值
		//保存文件名到数据库
		if($res){
			$arr = $this -> upload -> data();
			$file_name_new = $arr['orig_name'];
			$data['imagename'] = $file_name_new;
			$data['pid'] = 10;
			$res = $this -> db -> insert('photo',$data);
			echo '保存图片',$res ? '成功！' : '失败！';
			echo '<script>alert("保存数据库成功！")</script>';
		}else{
			$this -> load -> view('upload',array('info'=>'图片上传失败，请重新上传！'));
			//redirect('user/upload');

		}
	}
	//搜索查询结果并分页
	public function search(){
		$keywords = $this -> input -> get('search');
		//根据关键字查询获取总条数
		$total_rows = $this -> db -> like('name', $keywords)
								  -> count_all_results('userinfo');
		$per_page = 20;//每页显示条数
		//分页处理
		$this -> load -> library('pagination');//加载分页类
		//配置分页相关参数
		$config['reuse_query_string'] = TRUE;//将查询字符串参数添加到 URI 分段的后面
		$config['base_url'] = "http://127.0.0.1/CI-3.0.6/user/search/page";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['first_link'] = '首页'; // 第一页显示
		$config['last_link'] = '末页'; // 最后一页显示
		$config['next_link'] = '下一页 >'; // 下一页显示
		$config['prev_link'] = '< 上一页'; // 上一页显示
		$config['cur_tag_open'] = ' <strong class="current">'; // 当前页开始样式
		$config['cur_tag_close'] = '</strong>';
		$this -> pagination -> initialize($config);
		$pageStr = $this -> pagination -> create_links();//获取分页显示栏
		//根据条件获取数据
		$start = pathinfo($_SERVER['PHP_SELF'])['basename'];//根据当前url中的参数获取开始位置的数字
		if($keywords){
			$arr = $this -> db -> like('name', $keywords)
					           -> limit($per_page,$start)
					           -> get('userinfo')
					           -> result_array();
			//重构数组，高亮查询关键字
			foreach($arr as $k=>$v){
				$replacement = '<span style="background:greenyellow">'.$keywords.'</span>';
				$arr[$k]['name'] = preg_replace("/$keywords/",$replacement,$v['name']);
			}
			$this -> load -> view('userlist',array('arr'=>$arr, 'pageStr'=>$pageStr));
		}else{
			redirect('user/userlist');
		}

		$this->output->enable_profiler(TRUE);//启动分析器

	}
	//测试框架自带验证码辅助函数，不够好用
	public function getCode(){
		$this->load->helper('captcha');
		$vals = array(
				'word' => rand(1000, 10000),
				'img_path' => './captcha/',
				'img_url' => 'http://localhost/CI-3.0.6/captcha/',
				'img_width' => '80',
				'img_height' => 30,
				'expiration' => 7200,
				'font_size'	=> 20 //？？？？设置字体大小无效果
		);
		$cap = create_captcha($vals);
		echo $cap['image'];

	}
	//测试自己封装的验证码类库
	public function vcode(){
		$this->load->library('session');
		$this->load->library('captcha');//加载自定义的类库
		$code = $this-> captcha -> getCaptcha();
		$this -> session -> vcode = $code;//将验证码传递给session
		$this -> captcha -> showImg();//显示验证码图片

	}
	//显示登录页面
	public function login(){
		//验证登录
		if(isset($_POST) && !empty($_POST)){
			$this->load->library('session');
			$name = $_POST['name'];
			$password = $_POST['password'];
			$nologin = isset($_POST['nologin']) ? $_POST['nologin'] : 0;
			echo $code1 = strtolower($this->session->vcode);
			echo $code2 = $_POST['vcode'];
			if(strtolower($code1) == strtolower($code2) && !empty($code1)) {
				$flag = $this -> db -> where(array('name'=>$name,'password'=>$password))
						-> count_all_results('admin');
				if($flag){
					$this -> session -> username = $name;
					if($nologin == 1){
						setcookie('nologin','1',time()+3600);
						setcookie('username',$name,time()+3600);
					}
					redirect('user/show');
				}else{
					echo '用户密码错误！';
				}
			}else{
				echo '验证码不正确！';
			}
		}
		//登陆页面
		$this -> load -> view('login');
	}

	public function notice(){
		//验证用户名是否存在
		$name = $_POST['name'];
		$flag = $this -> db -> where(array('name'=>$name)) -> count_all_results('admin');
		if($flag == 0){
			echo '用户名不存在!';
			return;
		}
	}

	public function logout(){
		$this->load->library('session');
		$this->load->helper('url');
		$this->session->unset_userdata('code');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('vcode');
		redirect('user/login');
	}

	public function aaa(){
		var_dump($_COOKIE);
	}

}



