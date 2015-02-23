<?php
  class Search extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->model('task');
      }
      
      function index(){
          $this->load->view('search');
      }
      
      function getSearchResult(){
           $startDate = $this->input->post('startDate');
           $endDate = $this->input->post('endDate');
           $type= $this->input->post('type');
           $content= $this->input->post('content');
           
           $countOfTask =$this->task->countOfTaskBySearch($type,$content,$startDate,$endDate);
           $this->load->library('pagination');
           $config['base_url'] = base_url().'/index.php/search/getTaskByDptid/';
           $config['total_rows'] = $countOfTask;
           $config['per_page'] = 15; 
           $config['anchor_class'] ="class='ajax_fpage'";
           $config['first_link'] = '首页';
           $config['last_link'] = '尾页';
           $config['next_link'] = '下一页';
           $config['prev_link'] = '上一页';
           $this->pagination->initialize($config); 
           $offset = intval($this->uri->segment(3));

           
           $rows =$this->task->searchTask($type,$content,$startDate,$endDate);
           $rows['links']= $this->pagination->create_links();
           $rows['per_page'] = $config['per_page'];
           $temp = json_encode($rows);
           echo $temp;     
      }
  }
?>
