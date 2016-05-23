<?php
/**
 * Created by PhpStorm.
 * User: YangBin
 * Date: 2016/5/23
 * Time: 20:54
 */
class Eu extends CI_Controller
{
    //构造函数初始化数据模型
    public function __construct()
    {
        parent:: __construct();//静态用父类构造方法
        $this->load->model('admin_model');//实例化用户模型
        $this->load->helper('url_helper');//加载url_helper中的辅助函数
    }

    public function alist(){
        $this -> load -> view('eu/alist');
    }

    public function getAdmin(){
        $start = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $page_size = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $offset = ($start-1)*$page_size;
        $result = array();
        $num = $this ->db -> count_all_results('admin');
        $result['total'] = $num;
        $res = $this -> db -> limit($page_size,$offset) -> get('admin') ->result_object();
        $result['rows'] = $res;
        echo json_encode($result);
    }

    public function save(){
        $name = $_REQUEST['name'];
        $password = $_REQUEST['password'];
        $level = $_REQUEST['level'];
        $data = array(
            'name'=>$name,
            'password'=>$password,
            'level'=>$level
        );
        $result = $this -> db -> insert('admin',$data);
        if ($result){
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('msg'=>'Some errors occured.'));
        }
    }

    public function update(){
        $id = intval($_GET['id']);
        $name = $_REQUEST['name'];
        $password = $_REQUEST['password'];
        $level = $_REQUEST['level'];
        $data = array(
            'name'=>$name,
            'password'=>$password,
            'level'=>$level
        );
        $result = $this -> db -> where('id',$id) -> update('admin',$data);
        if ($result){
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('msg'=>'Some errors occured.'));
        }

    }

    public function delete(){
        $id = intval($_REQUEST['id']);
        $result = $this -> db -> where('id',$id) -> delete('admin');
        if ($result){
            echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('msg'=>'Some errors occured.'));
        }

    }
}