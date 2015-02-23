<?php
  class Login extends CI_Controller{
      function __construct(){
          parent::__construct();
          $this->load->helper('form');
          $this->load->library('session') ;
          $this->load->model('user');
      }
      function index(){
          $this->load->view('login');
      }
      
      function formsubmit(){ 
          //echo '<script>alert("before before validation");</script>';
          $this->load->library('form_validation');
          $this->form_validation->set_rules('username', 'Username', 'required' );  
          $this->form_validation->set_rules('password', 'Password', 'required' );  
          //echo '<script>alert("before validation");</script>';
          //validation failuew
          if($this->form_validation->run() == FALSE){
              //echo '<script>alert("validation failure");</script>';
              $this->load->view('login');
          }else{
              echo '<script>alert("login  -1- ");</script>';
              if(isset($_POST['submit'])&& !empty($_POST['submit'])) {
                  $data = array(
                        'username'=>$_POST['username'],
                        'password'=>md5($_POST['password'])
                  );

                  if($_POST['submit']=='登录'){
                      $query =$this->user->getPswByUser($data['username']);
                      $rows = $query->result();
                      //echo '<script>alert("logining1");</script>'; 
                      //echo '<script>alert("logining-'.$_POST['username'].'-'.md5($_POST['password']).'-'.$rows[0]->password.'");</script>';
                      
                      if($query->num_rows()==1){
                          //echo '<script>alert("logining1111");</script>'; 
                         //var_dump($data['password']);
                         if($rows[0]->password == $data['password']){
                            $sessionData = array(
                                'userid'=>$rows[0]->id,
                                'username'=>$data['username'],
                                'userip'=>$_SERVER['REMOTE_ADDR'],
                                'luptime'=>time(),
                                'role'=>$rows[0]->role
                            );
                            $this->session->set_userdata($sessionData);
                            echo '<script> alert("login/formsubmit");</script>';
                            //header('location:http://localhost/taskmgr/index.php/index');
                            //$this->load->view('index');
                            var_dump($rows[0]); 
                            if($rows[0]->role =='admin')
                                redirect('admin/index','location'); 
                            else  
                                redirect('index/index','location'); 
                         }else{
                            //var_dump($rows[0]->password.'--'.$_POST['password']."--".$data['password']) ;
                            echo '<script>alert("password error");</script>';
                            $this->load->view('login');  
                         } 
                      }else if($query->num_rows()==0){
                         echo '<script>alert("no user");</script>';
                         $this->load->view('login'); 
                      }else{
                         echo '数据库错误，请联系管理员HH!'; 
                      }
//                      $this->load->database();    
//                      $this->db->from('user');
//                      $this->db->where('username',$data['user']);
//                      $query =$this->db->get();
//                      if($query->num_rows()>0){
//                          //find user
//                          $row = $query->row_array();
//                          //echo '<script>alert("'.$row['password'].'");</script>';
//                          if($row['password'] == $data['psw']){
//                              //echo '<script>alert("login success");</script>';
//                              //$this->session->set_userdata($newdata);
//                              $this->load->view('welcome_message');
//                          }
//                          else{
//                             echo '<script>alert("login failure");</script>';
//                             $this->load->view('login');
//                          } 
//                      }else{
//                          //find no user
//                          echo '<script>alert("no user");</script>';
//                          $this->load->view('login');
//                      }
                  }
              }
          }
      }
  
      function logout(){
          $this->session->unset_userdata($sessionData);
          header('location:http://localhost/taskmgr/index.php/index');
          //redirect('index/index','location');   
          
      }
  }
?>
