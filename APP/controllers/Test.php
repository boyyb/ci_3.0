<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {


	public function index()
	{
		
		//echo 'aaa';
		echo getcwd();echo '<br/>';
		chdir('aa/bb');
		echo getcwd();echo '<br/>';
	}
}

