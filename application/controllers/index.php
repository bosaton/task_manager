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
          $this->load->view('index');
      }
      
      /*
      * 场景：用户点击获取任务时调动
      * 功能：根据部门id，开始时间和结束时间 来获取任务
      */
      function getTaskByDptid(){
           $dptId = $this->input->post('dptId');
           $startDate = $this->input->post('startDate');
           $endDate = $this->input->post('endDate');
           
           $countOfTask =$this->task->countOfTaskByDptId($dptId,$startDate,$endDate);
           $this->load->library('pagination');
           $config['base_url'] = base_url().'/index.php/index/getTaskByDptid/';
           $config['total_rows'] = $countOfTask;
           $config['per_page'] = 15; 
           $config['anchor_class'] ="class='ajax_fpage'";
           $config['first_link'] = '首页';
           $config['last_link'] = '尾页';
           $config['next_link'] = '下一页';
           $config['prev_link'] = '上一页';
           $this->pagination->initialize($config); 
           $offset = intval($this->uri->segment(3));
       
//           $rows = $this->task->getTask($userId,$startDate,$endDate,$offset,$config['per_page']);
//           //file_put_contents('c:\error.txt',json_encode($rows).'---' );
//           $rows['links']= $this->pagination->create_links();
//           $rows['per_page'] = $config['per_page'];
//           //$rows = $this->task->getTaskByUserid($userId,$startDate,$endDate);
//           $temp= json_encode($rows);
//           echo $temp;
           
           $rows = $this->task->getTaskByDptid($dptId,$startDate,$endDate,$offset,$config['per_page']);
           $rows['links']= $this->pagination->create_links();
           $rows['per_page'] = $config['per_page'];
           $temp= json_encode($rows);
           echo $temp;
      }
      
      /*
      * 场景：高级搜索
      * 功能：根据内容或责任人，开始时间和结束时间 来获取任务
      */
      function getSearchResult(){
           $startDate = $this->input->post('startDate');
           $endDate = $this->input->post('endDate');
           $type= $this->input->post('type');
           $content= $this->input->post('content');
           $rows =$this->task->searchTask($type,$content,$startDate,$endDate);
           $temp = json_encode($rows);
           echo $temp; 
      }
      
      /*
      * 场景：用户修改登录密码
      * 功能：用户修改登录密码
      */
      function changePsw(){
          $userId = $this->input->post('userId');
          $oldPsw = $this->input->post('oldPsw');
          $newPsw = $this->input->post('newPsw');
          $rows= $this->user->changePsw($userId,$newPsw);
          $temp = json_encode($rows);
          echo $temp;
      }
      
      
//      function search(){
//         if($_POST['searchopt'] == 'user'){
//            $query =$this->task->searchTaskU($_POST['searchText']);
//            $rows =  $query->result_array();
//            $data=array(
//                "rows"=>$rows);
//            $this->load->view('index',$data);
//        }else{
//            $query =$this->task->searchTaskC($_POST['searchText']);
//            $rows =  $query->result_array();
//            $data=array(
//                "rows"=>$rows);
//            $this->load->view('index',$data);
//        }
//      }
  }
?>
