<?php
  class Index extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->helper('form');
          $this->load->library('session') ;
          $this->load->model('user');
          $this->load->model('task');
      }

      function index(){
 //         $data['mytitle']='my site';
//          $data['base']= $this->config->item('base_url');
//          $data['css'] = $this->config->item('css');
//          $data['text'] ='please log in here';
          //echo $data['base'];
          //echo '<script> alert("index/index");</script>';
          $query = $this->task->getTask();
          $rows =  $query->result_array();
          $data=array(
                "rows"=>$rows);
          $this->load->view('index',$data);
      }
      
      function formsubmit(){
          if(!is_administrator()&& !is_user()){
              echo '<script> alert("please login");</script>';
              $this->load->view('login') ;
          }else{
              $this->load->library('form_validation');
              $this->form_validation->set_rules('tasktitle','Tasktitle','required');
              $this->form_validation->set_rules('taskcontent','Taskcontent','required');
              if($this->form_validation->run()==false){
                  $this->index();
              }else{
                  $completed = isset($_POST['completed'])?1:0;
                  $this->task->addTask($_POST['tasktitle'],$_POST['taskcontent'],date('Y-m-d H:i:s '),$this->session->userdata('username'),$completed);
                  $this->index();
              }  
          }
      }
      
      function search(){
         if($_POST['searchopt'] == 'user'){
            $query =$this->task->searchTaskU($_POST['searchText']);
            $rows =  $query->result_array();
            $data=array(
                "rows"=>$rows);
            $this->load->view('index',$data);
        }else{
            $query =$this->task->searchTaskC($_POST['searchText']);
            $rows =  $query->result_array();
            $data=array(
                "rows"=>$rows);
            $this->load->view('index',$data);
        }
      }
  }
?>
