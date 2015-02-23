<?php
  class Taskmanager extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->helper('form');
          $this->load->model('user');
          $this->load->model('task');
          //$this->output->enable_profiler(TRUE);
      }

      function index(){
//          $this->load->library('pagination');
//          $config['base_url'] = base_url().'/index.php/taskmanager/index/';
//          $config['total_rows'] = 17;
//          $config['per_page'] = 5; 
//          $config['anchor_class'] ="class='ajax_fpage'";
//          $config['first_link'] = '首页';
//          $config['last_link'] = '尾页';
//          $config['next_link'] = '下一页';
//          $config['prev_link'] = '上一页';
//          $this->pagination->initialize($config); 
//          $offset = intval($this->uri->segment(3));
//
//          $rows = $this->task->getTask($offset,$config['per_page']);
//          $data=array(
//                "rows"=>$rows);
//          $data['links']= $this->pagination->create_links();
          $this->load->view('taskmanager');
      }
      
      /*
      * 场景：用户在‘任务管理’栏目中查找个人发布的任务信息，留给后面修改或者删除备用
      * 功能：根据用户id，开始时间和结束时间 来获取任务，并进行分页显示
      */
      function getTable(){
           $CI =& get_instance(); 
           $userId = $CI->session->userdata("userid");
           $startDate = $this->input->post('startDate');
           $endDate = $this->input->post('endDate');
           $countOfTask =$this->task->countOfTask($userId,$startDate,$endDate);
           $this->load->library('pagination');
           $config['base_url'] = base_url().'/index.php/taskmanager/getTable/';
           $config['total_rows'] = $countOfTask;
           $config['per_page'] = 10; 
           $config['anchor_class'] ="class='ajax_fpage'";
           $config['first_link'] = '首页';
           $config['last_link'] = '尾页';
           $config['next_link'] = '下一页';
           $config['prev_link'] = '上一页';
           $this->pagination->initialize($config); 
           $offset = intval($this->uri->segment(3));
       
           $rows = $this->task->getTask($userId,$startDate,$endDate,$offset,$config['per_page']);
           //file_put_contents('c:\error.txt',json_encode($rows).'---' );
           $rows['links']= $this->pagination->create_links();
           $rows['per_page'] = $config['per_page'];
           //$rows = $this->task->getTaskByUserid($userId,$startDate,$endDate);
           $temp= json_encode($rows);
           echo $temp;
      }
      
//      function link(){
//           $CI =& get_instance(); 
//           $userId = $CI->session->userdata("userid");
//           $startDate = $this->input->post('startDate');
//           $endDate = $this->input->post('endDate');
//           
//           
//           $this->load->library('pagination');
//           $config['base_url'] = base_url().'/index.php/taskmanager/getTable/';
//           $config['total_rows'] = 15;
//           $config['per_page'] = 5; 
//           $config['anchor_class'] ="class='ajax_fpage'";
//           $config['first_link'] = '首页';
//           $config['last_link'] = '尾页';
//           $config['next_link'] = '下一页';
//           $config['prev_link'] = '上一页';
//           $this->pagination->initialize($config); 
//           $offset = intval($this->uri->segment(3));
//           file_put_contents('c:\error.txt',$userId.'--'.$startDate.'--'.$offset);
//           $rows = $this->task->getTask($userId,$startDate,$endDate,$offset,$config['per_page']);
//           $rows['links']= $this->pagination->create_links();
//           $temp= json_encode($rows);
//           echo $temp;
//      }
      
      //获取任务的所有类型，供页面加载时‘登记新任务’栏目使用
      function getTaskType(){
          //log_message('info', 'get Task Type: '.date("Y-m-d").'  '.$_SERVER["REMOTE_ADDR"]);
          
          $query = $this->task->getTaskType();
          $rows = $query->result_array();
          $temp = json_encode($rows);
          echo $temp;
      }
      
      //用户选择某项点击‘修改’后，要从数据库中获取此项任务相关信息，以便加载到‘登记新任务’栏目中
      function loadTaskToTable(){
          $taskid = $this->input->post('taskid');
          $query = $this->task->getTaskByTaskid($taskid);
          //$rows = $query->result_array();
          $temp = json_encode($query);
          echo $temp;
      }
     
      //用户提交新任务或者提交修改 
      function submitModify(){
          $taskid = $_REQUEST['taskid'] ;
          $tasktypeid = $_REQUEST['tasktypeid'];
          $startdate = $_REQUEST['startdate'];
          $enddate=$_REQUEST['enddate'];
          $taskcontent = $_REQUEST['taskcontent'];
          $responsible = $_REQUEST['responsible'];
          $reqstartdate = $_REQUEST['reqstartdate'];
          $reqenddate = $_REQUEST['reqenddate'];
          $CI =& get_instance(); 
          $userId = $CI->session->userdata("userid");
          if($taskid =='系统自动分配'){
              $query = $this->task->newTask($userId,$tasktypeid,$startdate,$enddate,$taskcontent,$responsible);
              $query = $this->task->getTaskByUserid($userId,$startdate,$enddate);
          }else{
              $query = $this->task->updateTask($taskid,$tasktypeid,$startdate,$enddate,$taskcontent,$responsible);
              $query = $this->task->getTaskByUserid($userId,$reqstartdate,$reqenddate);
          }
          $temp = json_encode($query) ;
          echo $temp;
      }
      
      //用户删除自己已发布的任务
      function deleteTask(){
          //eval( "(" + $_REQUEST['tasklist'] + ")" );
          //put_file_contents('c:\error.txt',);
          
          $tasklist =  explode(",",$_REQUEST['tasklist']);
          //file_put_contents('c:\error.txt',$tasklist[0]);
          $reqstartdate = $_REQUEST['reqstartdate'];
          $reqenddate = $_REQUEST['reqenddate'];
          $query = $this->task->deleteTask($tasklist);
          
          $CI =& get_instance(); 
          $userId = $CI->session->userdata("userid");
          $query = $this->task->getTaskByUserid($userId,$reqstartdate,$reqenddate);
          $temp = json_encode($query) ;
          echo $temp;
      }
      
//      function touncmple(){
//          //echo '<script> alert("in touncmple ");</script>';
//          $query =$this->task->chgToUncmpl($_POST['tasklist']);
//          redirect('admin/index','location');
//          //$this->index(); 
//      }
//      function tocmple(){
//          $query =$this->task->chgToCmpl($_POST['tasklist']);
//          //$this->index();
//          redirect('admin/index','location');
//          
//      }
//      function dlttask(){
//          $query =$this->task->delTask($_POST['tasklist']);
//          $this->index();
//      }
//      function formsubmit(){
//          if(!is_administrator()&& !is_user()){
//              echo '<script> alert("please login");</script>';
//              $this->load->view('login') ;
//          }else{
//              $this->load->library('form_validation');
//              $this->form_validation->set_rules('tasktitle','Tasktitle','required');
//              $this->form_validation->set_rules('taskcontent','Taskcontent','required');
//              if($this->form_validation->run()==false){
//                  $this->index();
//              }else{
//                  $completed = isset($_POST['completed'])?1:0;
//                  $this->task->addTask($_POST['tasktitle'],$_POST['taskcontent'],date('Y-m-d H:i:s '),$this->session->userdata('username'),$completed);
//                  $this->index();
//              }  
//          }
//      }
//      
//      function search(){
//         if($_POST['searchopt'] == 'user'){
//            $query =$this->task->searchTaskU($_POST['searchText']);
//            $rows =  $query->result_array();
//            $data=array(
//                "rows"=>$rows);
//            $this->load->view('admin',$data);
//        }else{
//            $query =$this->task->searchTaskC($_POST['searchText']);
//            $rows =  $query->result_array();
//            $data=array(
//                "rows"=>$rows);
//            $this->load->view('admin',$data);
//        }
//      }
  }
?>
