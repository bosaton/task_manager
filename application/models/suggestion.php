<?php
  class Suggestion extends CI_Model{
      var $User = array();
      function __construct(){
          parent::__construct();
          $this->userIdToName();
          $this->load->helper('form');
//          $this->userIdToName();
//          $this->taskTypeIdToName();
//          $this->dptIdToName();
      }
      
      function userIdToName(){
            $sql = 'select userid,username from user' ;
            $query = $this->db->query($sql);
            $rows = $query->result_array();
            for($i=0;$i<count($rows);$i++){
                //echo $rows[$i];
                $this->User[$rows[$i]['userid']] = $rows[$i]['username'];
            }
            return 1;
      }
      
      function getSuggestion($offset,$per_page){
          $sql ='select * from suggestion order by pubdate desc limit '.$offset.','.$per_page;
          $query = $this->db->query($sql);
          $rows = $query->result_array();
          for($i=0;$i<count($rows);$i++){
              $rows[$i]['username'] = $this->User[$rows[$i]['userid']];        
          }
          return $rows;
      }
      
      //获取建议数量信息，供分页配置使用
      function countOfSuggestion(){
           $sql='select count("taskid") from suggestion ';
           $query= $this->db->query($sql);
           $count =  $query->result_array();
           //file_put_contents('c:\error.txt','---'.$count[0]['count("taskid")'] );
           return $count[0]['count("taskid")'] ;
      }
      
      function insertSuggestion($suggestion,$userid,$pubdate){
 
          $sql = 'insert into suggestion values (NULL,"'. $suggestion.'",'.$userid.',"'.$pubdate.'","","")';
          $query = $this->db->query($sql);
          $rows = $this->db->affected_rows();
          return $rows;
      }
      
      
      
  }
?>
