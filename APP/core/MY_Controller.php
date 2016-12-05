<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Base Controller Library
 *
 * @package Controller
 * @category Libraries
 * @property CI_DB_active_record $db
 * @property CI_Config $config
 * @property CI_Controller $controller
 * @property CI_Model $model
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Output $output
 * @property Tool $tool
 * @property UploadFile $uploadfile
 */
class MY_Controller extends CI_Controller
{

    var $ip = '';
    var $id = '';
    var $userId = FALSE;
    var $page = 1;
    var $rows = 20;
    var $offset = 0;
    var $dbtable = '';
    var $guid = FALSE;
    var $uuid = FALSE;
    var $historySize = 5;

    function __construct()
    {
        $this->myInit();
        $this->checklogin(); //检查登录
    }

    function myInit()
    {
        parent::__construct();

        $page = $this->input->get_post('page', TRUE);
        $rows = $this->input->get_post('rows', TRUE);

        $this->page = $page ? intval($page) : 1;
        $this->rows = isset($rows) ? intval($rows) : 20;
        $this->offset = ($this->page - 1) * $this->rows;
        $this->guid = $this->input->get_post('guid', TRUE);
        $this->id = $this->input->get_post('id', TRUE);
        $this->uuid = $this->input->get_post('uuid', TRUE);
        $this->dbtable = $this->input->get_post('dbtable', TRUE);
        unset($page, $rows);
        if (in_array($this->dbtable, array('user', 'role'))) {
            $this->error('无权访问数据库！');
        }
        $this->ip = $this->input->ip_address();
    }

    /**
     * 检查登录
     */
    function checklogin()
    {
        $this->userId = $this->session->userdata('userId');
        if (!$this->userId) {
            if ($_SERVER["REQUEST_METHOD"] == 'POST') {
                $this->error('请先登录!');
            } else {
                redirect(site_url('welcome/login'));
            }
        }

    }

    /**
     * 输出成功信息 json {error:0,msg:'ok',a:1} 或 输入数组则直接转化为json {}
     * @param string|array $msgArray 'ok' {error:0,msg:'ok'},array('a'=>1) {a:1}
     * @param string|array $strArray 'id' {error:0,msg:'ok',data:'id'},array('a'=>1) {error:0,msg:'ok',a:1}
     */
    function success($msgArray = '', $strArray = '')
    {
        exitJson($msgArray, 0, $strArray);
    }

    /**
     * 输出错误信息 json格式 {error:1,msg:''}
     * @param string $msg
     * @param string|array $strArray 'id' {error:0,msg:'ok',data:'id'},array('a'=>1) {error:0,msg:'ok',a:1}
     */
    function error($msg = '', $strArray = '')
    {
        exitJson($msg, 1, $strArray);
    }

    function display($template = '', $data = '')
    {

        if (file_exists(APPPATH . 'views/' . $template)) {
            $this->load->view($template, $data);
        } else {
            $this->error('页面' . $template . '不存在!');
        }

    }

    function getpagelist($dbtable, $where = array(), $fields = '*', $orderby = '')
    {

        $where = $this->getwhere($dbtable, $where);
        $fields = $this->getfields($dbtable, $fields);

        return $this->getlist($dbtable, $where, $fields, $orderby);
    }

    function getlist($dbtable, $where = '', $fields = '*', $orderby = '')
    {
        if (is_array($where)) {

            $wherestr = join(' and ', $where);;
        } else {
            $wherestr = $where;
        }

        $m = M($dbtable);
        $result = array();
        $result['total'] = $m->count($wherestr); //统计行数
        $result["rows"] = $m->fetall($wherestr, $fields, $orderby, $this->offset, $this->rows);

        return $result;
    }

    function getwhere($dbtable, $where = '', $remove = array('sort'))
    {

        if (is_string($where)) {
            if (empty($where)) {
                $where = array();
            } else {
                $where = array($where);
            }
        }

        $table_fields = $this->db->field_data($dbtable); //解析表,返回字段名数组

        foreach ($table_fields as $field) {
            if ($remove) {
                if (in_array($field->name, $remove)) {
                    continue;
                }
            }
            $val = $this->input->post($field->name, TRUE);
            $val = trim($val);
            if ($field->name == 'acode') {
                if (!empty($val)) {
                    $where[] = "acode like " . handleAcode($val); //用户访问数据范围
                    continue;
                } else {
                    $where[] = "acode like " . handleAcode($this->session->userdata('userAcode')); //用户访问数据范围
                }
            }
            if ($field->name == 'idnum' && !empty($val)) {  //新老身份证查询
                $idnum2 = idnumUpgrade($val);
                if ($idnum2) {
                    $where[] = "idnum IN ('{$val}','{$idnum2}')";
                    continue;
                }
            }
            if ($field->name == 'lyaddress' && $val != "") {
                $where[] = "CONCAT(province,discou,street,housenum,'号',bdnum,'栋/附号') like '%" . $val . "%'";
                continue;
            }
            //处理儿童出生证明号为0的模糊查询
            if ($field->name == 'birnum' && $val == 0 && $val != "") {
                $where[] = $field->name . " like '%" . $val . "%' ";
            }
            if (!empty($val) && !in_array($val, array('--', '不清楚', '请选择'))) {
                if ($field->type == 'varchar') {
                    $where[] = $field->name . " like '%" . $val . "%' ";
                } else {
                    $where[] = $field->name . " ='" . $val . "' ";
                }

            }

        }
        return $where;
    }

    function getfields($dbtable, $fields = '*')
    {
        if ($fields != '*') {
            return $fields;
        }
        $m = M($dbtable);
        $table_fields = $m->getField(); //解析表,返回字段名数组
        $postfields = $this->input->post('fields');
        if (!$postfields) {
            return $fields;
        }
        $fieldsarr = explode(',', $postfields);
        $fieldsarray = array('id');
        foreach ($table_fields as $field) {

            if (in_array($field, $fieldsarr)) {
                $fieldsarray[] = $field;
            }

        }
        if (count($fieldsarray) > 1) {
            $fields = join(',', $fieldsarray);
        }
        return $fields;
    }


}

/* End of file: MY_Controller.php */
/* Location: application/core/MY_Controller.php */