<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct(){
        parent :: __construct();//静态用父类构造方法
        $this -> load -> model('admin_model');//实例化用户模型
        $this -> load -> helper('url_helper');//加载url_helper中的辅助函数
    }

    public function test(){
        echo 11111111111111111;
    }

    public function add(){
        $this -> load -> view('admin/add');
    }

    public function save(){
        $_POST['createtime'] = $_POST['createtime'] ? strtotime($_POST['createtime']) : time();
        //$_POST['createtime'] = time();
        $flag = $this -> db -> insert('news',$_POST);
        if($flag){
            //echo 'ok';
            redirect('admin/news/nlist');
        }else{
            //echo 'fail';
            redirect('admin/news/add');
        }
    }

    public function nlist(){
        if(isset($_POST['search']) && !empty($_POST['search'])){
            $keyword = $_POST['search'];
            $this -> db -> like('title',$keyword)
                        -> or_like('content',$keyword);
        }
        $data = $this -> db -> get('news') -> result_array();
        //对关键字进行高亮处理
        if(isset($keyword) && !empty($data)){
            foreach($data as $k=>$v){
                $replacement = '<span style="background:greenyellow">'.$keyword.'</span>';
                $data[$k]['title'] = preg_replace("/$keyword/",$replacement,$v['title']);
                $data[$k]['content'] = preg_replace("/$keyword/",$replacement,$v['content']);

            }
        }
        //对结果进行排序，时间最近的在最前面(正常录入无需此步)
        usort($data, function($a, $b) {
            if ($a['createtime'] == $b['createtime']) return 0;
            return $a['createtime'] > $b['createtime'] ? -1 : 1;
        });
        //天分组和月分组的空数组
        $ddata = array();
        $mdata = array();
        foreach($data as $k=>$v){
            //当月的数据按天分组
            if(date('Y-m') == date('Y-m',$v['createtime'])){
                $ddata[date('Y-m-d',$v['createtime'])][] = $v;
                continue;
            }
            //不是当月的数据按月进行分组
            $mdata[date('Y-m',$v['createtime'])][] = $v;
        }

        //var_dump($mdata);die;
        $this -> load -> view('admin/list',array('ddata'=>$ddata,'mdata'=>$mdata));
    }


}