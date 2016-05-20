<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 
class test extends CI_Controller
{
 
	function __construct()
	{
		parent::__construct();
	}
 
	public function index()
	{
		echo "我是test模块的test控制器的index方法！";
	}



}



