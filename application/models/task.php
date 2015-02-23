<?php
  class Task extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      function getTask(){
          $sql='select * from task';
          $query= $this->db->query($sql);
          return $query;
      }
      function searchTaskU($searchText){
          $sql = "select * from task where username = '".$searchText."'";
          $query = $this->db->query($sql);
          return $query;
      }
      function searchTaskC($searchText){
          $sql = "select * from task where tasktitle LIKE '%".$searchText."%' OR taskcontent LIKE '%".$searchText."%'";
          $query = $this->db->query($sql);
          return $query;
      }
      function addTask($tasktitle,$taskcontent,$pubtime,$username,$completed){
          $sql='insert into task values(NULL,"'.$tasktitle.'","'.$tasktitle
                .'","'.$pubtime.'","'.$username.'",'.$completed.')';
          //var_dump($sql);
          $query= $this->db->query($sql);
      }
      function chgToUncmpl($tasklist){
         for($i=0;$i<count($tasklist);$i++){
             $sql = "UPDATE task SET iscompleted = 0 WHERE taskid ='".$tasklist[$i]."'";
             $query = $this->db->query($sql);
             //$result = mysql_query($query) or die('query error');
         } 
      }
      function chgToCmpl($tasklist){
         for($i=0;$i<count($tasklist);$i++){
             $sql = "UPDATE task SET iscompleted = 1 WHERE taskid ='".$tasklist[$i]."'";
             $query = $this->db->query($sql);
             //$result = mysql_query($query) or die('query error');
         } 
      }
      function delTask($tasklist){
         for($i=0;$i<count($tasklist);$i++){
             $sql = "delete from task WHERE taskid ='".$tasklist[$i]."'";
             $query = $this->db->query($sql);
             //$result = mysql_query($query) or die('query error');
         } 
      }
      
  }
?>
