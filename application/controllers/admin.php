<?php
  class Admin extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->helper('form');
          $this->load->library('session') ;
          $this->load->model('user');
          $this->load->model('task');
      }

      function index(){
          $query = $this->task->getTask();
          $rows =  $query->result_array();
          $data=array(
                "rows"=>$rows);
          $this->load->view('admin',$data);
      }
      function touncmple(){
          //echo '<script> alert("in touncmple ");</script>';
          $query =$this->task->chgToUncmpl($_POST['tasklist']);
          redirect('admin/index','location');
          //$this->index(); 
      }
      function tocmple(){
          $query =$this->task->chgToCmpl($_POST['tasklist']);
          //$this->index();
          redirect('admin/index','location');
          
      }
      function dlttask(){
          $query =$this->task->delTask($_POST['tasklist']);
          $this->index();
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
            $this->load->view('admin',$data);
        }else{
            $query =$this->task->searchTaskC($_POST['searchText']);
            $rows =  $query->result_array();
            $data=array(
                "rows"=>$rows);
            $this->load->view('admin',$data);
        }
      }
  }
?>
