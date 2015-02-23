<?php
  class Manager_user extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->model('user');
      }
      function index(){
          $this->load->view('manager_user');
      }
  
      //
      function getUser(){
          $query = $this->user->getUser();
          $temp = json_encode($query);
          echo $temp;
      }
      
      function resetpsw(){
          $userid = $this->input->post('userid');
    //file_put_contents('c:\error.txt',$userid);
          $query = $this->user->resetpsw($userid);
          $temp = json_encode($query);
          echo $temp;
      }  
           
       //用户提交新任务或者提交修改 
      function new_task(){
          $tasktypeid = $_REQUEST['tasktypeid'];
          $startdate = $_REQUEST['startdate'];
          $enddate=$_REQUEST['enddate'];
          $taskcontent = $_REQUEST['taskcontent'];
          $responsible = $_REQUEST['responsible'];
      
          $CI =& get_instance(); 
          $userId = $CI->session->userdata("userid");
          
    //file_put_contents('c:\error.txt',$userId.$tasktypeid.$startdate.$enddate.$taskcontent.$responsible);
          $query = $this->task->newTask($userId,$tasktypeid,$startdate,$enddate,$taskcontent,$responsible);
          $query = $this->task->getTaskByUserid($userId,$startdate,$enddate);
          $temp = json_encode($query) ;
          echo $temp;
      }
      
  }
?>
