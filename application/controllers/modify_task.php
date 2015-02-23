<?php
  class Modify_task extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->helper('form');
          //$this->load->library('session') ;
          $this->load->model('user');
          $this->load->model('task');
      }
      function index(){
          $this->load->view('modify_task');
      }
      
      function getTable(){
           $CI =& get_instance(); 
           $userId = $CI->session->userdata("userid");
           $startDate = date("Y-m-d",strtotime("-1 week"));
           $endDate = date("Y-m-d");
       
           $rows = $this->task->getTaskByUserid($userId,$startDate,$endDate);
     //file_put_contents('c:\error.txt',json_encode($rows).'---' );
           $temp= json_encode($rows);
           echo $temp;
      }
      
      
      function deleteTask(){
          //eval( "(" + $_REQUEST['tasklist'] + ")" );
          //put_file_contents('c:\error.txt',);
          
          $taskid = $_REQUEST['taskid'];
          $query = $this->task->deleteTask($taskid);

          //TODO
          $CI =& get_instance(); 
          $userId = $CI->session->userdata("userid");
          $startDate = date("Y-m-d",strtotime("-1 week"));
          $endDate = date("Y-m-d");
          $query = $this->task->getTaskByUserid($userId,$startDate,$endDate);
          $temp = json_encode($query) ;
          echo $temp;
      }
      
  }
?>
