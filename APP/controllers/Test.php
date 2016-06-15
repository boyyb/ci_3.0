<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {


	public function index()
	{
		$this->load->helper('url');
		redirect('user/login');
	}

	//显示身份证信息查询表格
	public function table(){
		$this -> load -> view('table');
	}

	//接受ajax请求，以json格式返回数据
	public function data(){
		$name = $_POST['name'];
		$name = trim($name);
		if($name == 'bingo') {
			$data = array("idnum"=>'500221199901112142',"sex"=>1);
			echo json_encode($data);
		}elseif($name == 'yb'){
			$data = array("idnum"=>'510221188801112188',"sex"=>0);
			echo json_encode($data);
		}elseif($name == '张三'){
			$data = array("idnum"=>'555555555555555588',"sex"=>1);
			echo json_encode($data);
		}

	}
}

