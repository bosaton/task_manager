<?php
  class Suggest extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->library('session') ;
          $this->load->model('suggestion');
          $this->load->model('task');
      }
      
      function index(){
          $this->load->library('pagination');
          $config['base_url'] = base_url().'/index.php/suggest/index/';
          $config['total_rows'] = $this->suggestion->countOfSuggestion();
          $config['per_page'] = 10; 
          $config['anchor_class'] ="class='ajax_fpage'";
          $config['first_link'] = '首页';
          $config['last_link'] = '尾页';
          $config['next_link'] = '下一页';
          $config['prev_link'] = '上一页';
          $this->pagination->initialize($config); 
          $offset = intval($this->uri->segment(3));

//          $rows = $this->task->getTask($offset,$config['per_page']);
//          $data=array(
//                "rows"=>$rows);
//          $data['links']= $this->pagination->create_links();
      
          $rows = $this->suggestion->getSuggestion($offset,$config['per_page']);
          $data=array(
                "rows"=>$rows);
          $data['links']= $this->pagination->create_links();
          $this->load->view('suggest',$data); 
      }
      
      function summit(){
          $suggestion = $this->input->post('suggestion');
          if(empty($suggestion)){
              echo '<script type="text/javascript">alert("不能发布空信息")</script>';
              header('location:'.base_url().'index.php/suggest/index');
              return true;
          }
          $pubdate =date("Y-m-d");
          $CI =& get_instance();
          $userid= $CI->session->userdata("userid"); 
          $rows= $this->suggestion->insertSuggestion($suggestion,$userid,$pubdate);
          header('location:'.base_url().'index.php/suggest/index');
      }
      
  }
?>
