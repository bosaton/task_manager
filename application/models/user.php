<?php
  class User extends CI_Model{
      var $DPT= array();  //dptId to dptName
    function __construct()
    {
        parent::__construct();
        $this->dptIdToName();
    }
    
    function dptIdToName(){
            $sql = 'select dptid,dptname from department ' ;
            $query = $this->db->query($sql);
            $rows = $query->result_array();
            for($i=0;$i<count($rows);$i++){
                //echo $rows[$i];
                $this->DPT[$rows[$i]['dptid']] = $rows[$i]['dptname'];
            }
            return 1;
    }
    function getPswByUser($username){
        //var_dump($username);
        $sql = 'select * from user where username="'.$username.'"';
        $query =$this->db->query($sql); 
        //var_dump($query->result()); 
        return $query;
    }
    
    function changePsw($userid,$newpsw){
        $sql= 'update user set password ="'.md5($newpsw).'" where userid='.$userid;
        $query = $this->db->query($sql);
        $rows = $this->db->affected_rows(); 
        return $rows;
    }
    
    function getUser(){
        $sql ='select * from user';
        $query = $this->db->query($sql);
        $rows =  $query->result_array();
        for($i=0;$i<count($rows);$i++){
              $rows[$i]['department'] = $this->DPT[$rows[$i]['dptid']];       
        }
        return $rows;
    }
    
    function resetpsw($userid){
        $sql = 'update user set password = "' .md5('11111').'" where userid='.$userid;
        $query = $this->db->query($sql);
        $rows = $this->db->affected_rows();
        return $rows;
    }
    
//    function haveUser($username){
//        $sql = 'select * from user where username="'.$username.'"';
//        $query= $this->db->query($sql);
//        if($query->num_rows()==0){
//            //var_dump($query->result());
//            return 0;
//        }else{
//            //var_dump($query->result());
//            return 1;
//        }
//    }
//    function createUser($username,$password,$department){
//        $sql = 'insert into user values ( NULL,"'.$username.'","'.md5($password).'","'.$department.'","user")';
//        //$sql = 'insert into testbew values ( "ahah")';
//        //var_dump($sql);
//        $query = $this->db->query($sql);
//        
//        
//    }
   
  }
?>
