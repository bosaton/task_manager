<?php
  class Suggest extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->library('session') ;
          $this->load->model('suggestion');
      }
      
      function index(){
          $this->load->view('suggest');
      }
      
      function get_suggestion(){
           $this->load->library('pagination');
          $config['base_url'] = base_url().'/index.php/suggest/get_suggestion/';
          $config['total_rows'] = $this->suggestion->countOfSuggestion();
          $config['per_page'] = 10; 
          $config['anchor_class'] ="class='ajax_fpage_2'";
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
          $rows['links']= $this->pagination->create_links();
          $rows['per_page'] = $config['per_page'];
          $temp= json_encode($rows);
          echo $temp; 
          
      }
      
      
      function summit(){
          $suggestion = $this->input->post('suggestion');
          $pubdate =date("Y-m-d");
          $CI =& get_instance();
          $userid= $CI->session->userdata("userid"); 
          $rows= $this->suggestion->insertSuggestion($suggestion,$userid,$pubdate);
          return $this->get_suggestion();
      }
      
  }
?>
