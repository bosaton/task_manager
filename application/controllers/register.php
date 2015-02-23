<?php
  class Register extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->helper('form');
          $this->load->model('user');
      }
      function  index(){
          $this->load->view('register');
      }
      function formsubmit(){
          $this->load->library('form_validation');
          $this->form_validation->set_rules ( 'username', 'Username', 'required' );  
          $this->form_validation->set_rules ( 'password', 'Password', 'required' ); 
          $this->form_validation->set_rules ( 'rpassword', 'rPassword', 'required' );
          $this->form_validation->set_rules ( 'department', 'Department', 'required' );
          if($this->form_validation->run()==false){
              $this->load->view('register');
          }else{
              if($_POST['submit']=="注册"){
                  if($this->user->haveUser($_POST['username'])){
                      echo '<script> alert("username registered");</script>';
                      $this->load->view('register');
                  }else{
                      //echo '<script> alert("username unregistered");</script>';
                      $this->user->createUser($_POST['username'],$_POST['password'],$_POST['department']);
                      $this->load->view('login');
                      
                  }
              }
          }   
      }
  }
?>
