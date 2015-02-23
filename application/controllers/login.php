<?php
  class Login extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->helper('form');
          //$this->load->library('session') ;
          $this->load->model('user');
      }
      function index(){
          $this->load->view('login');
      }
      
      /*
      * 处理登录表单提交的数据
      */
      function formsubmit(){
      
          //log_message('error','['. $_SERVER['REMOTE_ADDR'].']  正在登录'); 
          $data = array(
                'username'=>$this->input->post('username'),
                'password'=>md5($this->input->post('password'))
          );

          $query =$this->user->getPswByUser($data['username']);
          $rows = $query->result();
          //echo '<script>alert("logining-'.$_POST['username'].'-'.md5($_POST['password']).'-'.$rows[0]->password.'");</script>';
          
          if($query->num_rows()==1){
             if($rows[0]->password == $data['password']){
                $sessionData = array(
                    'userid'=>$rows[0]->userid,
                    'username'=>$data['username'],
                    'userip'=>$_SERVER['REMOTE_ADDR'],
                    'role'=>$rows[0]->role,
                );
                $this->session->set_userdata($sessionData);
                //var_dump($rows[0]); 
                if($rows[0]->role ==0)
                    redirect(base_URL().'admin/index','location'); 
                else  
                    redirect(base_URL().'index.php/index/index','location'); 
             }else{
                echo '<script>alert("密码错误，请重新登录");</script>';
                $this->load->view('login');  
             } 
          }else if($query->num_rows()!=1){
             echo '<script>alert("用户名错误，无此用户");</script>';
             $this->load->view('login'); 
          }else{
             echo '数据库错误，请联系管理员HH!'; 
          }
      }
  
      function logout(){
          $this->session->unset_userdata('userid');
          $this->session->unset_userdata('username');
          $this->session->unset_userdata('role');
          header('location:'.base_url().'index.php/index');
      }
  }
?>
