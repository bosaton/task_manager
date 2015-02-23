<?php
  class Enroll_task extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->model('task');
      }
      function index(){
          $this->load->view('enroll_task');
      }
  
      //获取任务的所有类型，供页面加载时‘登记新任务’栏目使用
      function getTaskType(){
          //log_message('info', 'get Task Type: '.date("Y-m-d").'  '.$_SERVER["REMOTE_ADDR"]);
          
          $query = $this->task->getTaskType();
          $rows = $query->result_array();
          $temp = json_encode($rows);
          echo $temp;
      }
             
       //用户提交新任务或者提交修改 
      function new_task(){
          $tasktypeid = $_REQUEST['tasktypeid'];
          $taskimportance = $_REQUEST['taskimportance'];
          $startdate = $_REQUEST['startdate'];
          $enddate=$_REQUEST['enddate'];
          $taskcontent = $_REQUEST['taskcontent'];
          $responsible = $_REQUEST['responsible'];
      
          $CI =& get_instance(); 
          $userId = $CI->session->userdata("userid");
          
          $enrolldate = date("Y-m-d");
    //file_put_contents('c:\error.txt',$userId.$tasktypeid.$startdate.$enddate.$taskcontent.$responsible);
          $query = $this->task->newTask($userId,$tasktypeid,$taskimportance,$startdate,$enddate,$taskcontent,$responsible,$enrolldate);
          $query = $this->task->getTaskByUserid($userId,$startdate,$enddate);
          $temp = json_encode($query) ;
          echo $temp;
      }
      
  }
?>
