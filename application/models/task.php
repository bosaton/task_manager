<?php
  class Task extends CI_Model{
      var $User = array();
      var $DPT= array();  //dptId to dptName
      var $TASKTYPE = array(); //taskTypeId to taskTypeName
      
      function __construct(){
          parent::__construct();
          $this->userIdToName();
          $this->taskTypeIdToName();
          $this->dptIdToName();
      }
      
      //创建userid到username的关联数组，实现例如 $User[$userid]= $username，供其他函数调用
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
      
      function taskTypeIdToName(){
            $sql = 'select tasktypeid,tasktypename from tasktype' ;
            $query = $this->db->query($sql);
            $rows = $query->result_array();
            for($i=0;$i<count($rows);$i++){
                //echo $rows[$i];
                $this->TASKTYPE[$rows[$i]['tasktypeid']] = $rows[$i]['tasktypename'];
            }
            return 1;
      }
      
      //根据任务id获取任务信息
      function getTaskByTaskid($taskid){
          $sql='select * from task where taskid='.$taskid;
          $query= $this->db->query($sql);
          $rows =  $query->result_array();
          for($i=0;$i<count($rows);$i++){
              $rows[$i]['username'] = $this->User[$rows[$i]['userid']]; 
              $rows[$i]['tasktypename'] = $this->TASKTYPE[$rows[$i]['tasktypeid']];
              $rows[$i]['dptname'] = $this->DPT[$rows[$i]['dptid']];
              //$this->DPT ;         
          }
          return $rows;
      }
      
      //根据部门id、开始时间和结束时间来获取任务信息
      function getTaskByDptid($dptId,$startDate,$endDate,$offset,$no){
          $sql='select * from task where (dptid ='.$dptId .') and ((startdate <="' .$startDate.'" and enddate >="'.
                                        $startDate.'") or (startdate >="'.$startDate.'" and startdate <="'.$endDate.'")) order by tasktypeid asc,startdate asc limit '.$offset.','.$no; 
          // $sql ='select * from task where dptid='.$dptId .' and startdate>"' .$startDate.'"'; 
          //vardump($sql);
          $query= $this->db->query($sql);
          $rows = $query->result_array();
          for($i=0;$i<count($rows);$i++){
              $rows[$i]['tasktypename'] = $this->TASKTYPE[$rows[$i]['tasktypeid']];
              $rows[$i]['dptname'] = $this->DPT[$rows[$i]['dptid']];      
          }
          return $rows;  
      }
      
      //根据用户id、开始时间、结束时间、偏移量和每页显示数量来获取任务信息
      function getTask($userId,$startDate,$endDate,$offset,$no){
          //$sql='select * from task order by tasktypeid asc,startdate asc limit '.$offset.','.$no;
          $sql='select * from task where (userid ='.$userId .') and ((startdate <="' .$startDate.'" and enddate >="'.
                                  $startDate.'") or (startdate >="'.$startDate.'" and startdate <="'.$endDate.'")) order by tasktypeid asc,startdate desc limit '.$offset.','.$no;

          $query= $this->db->query($sql);
          $rows =  $query->result_array();
           for($i=0;$i<count($rows);$i++){
              $rows[$i]['username'] = $this->User[$rows[$i]['userid']]; 
              $rows[$i]['tasktypename'] = $this->TASKTYPE[$rows[$i]['tasktypeid']];
              $rows[$i]['dptname'] = $this->DPT[$rows[$i]['dptid']];
              //$this->DPT ;         
           }
          return $rows;
      }
      
      
      //根据用户id、开始时间、结束时间来获取任务信息
      function getTaskByUserid($userId,$startDate,$endDate){
          //$sql='select * from task order by tasktypeid asc,startdate desc';
          $sql='select * from task where (userid ='.$userId .') and ((startdate <="' .$startDate.'" and enddate >="'.
                                  $startDate.'") or (startdate >="'.$startDate.'" and startdate <="'.$endDate.'")) order by tasktypeid asc,startdate desc  ';
          $query= $this->db->query($sql);
          $rows =  $query->result_array();
          for($i=0;$i<count($rows);$i++){
              $rows[$i]['username'] = $this->User[$rows[$i]['userid']]; 
              $rows[$i]['tasktypename'] = $this->TASKTYPE[$rows[$i]['tasktypeid']];
              $rows[$i]['dptname'] = $this->DPT[$rows[$i]['dptid']];
              //$this->DPT ;         
          }
          return $rows;
      }
      
      //根据用户id、开始时间、结束时间来获取任务数量信息，供分页配置使用
      function countOfTask($userId,$startDate,$endDate){
           $sql='select count("taskid") from task where (userid ='.$userId .') and ((startdate <="' .$startDate.'" and enddate >="'.
                                  $startDate.'") or (startdate >="'.$startDate.'" and startdate <="'.$endDate.'"))';
           
           //file_put_contents('c:\error.txt',$sql);
           $query= $this->db->query($sql);
           $count =  $query->result_array();
           //file_put_contents('c:\error.txt','---'.$count[0]['count("taskid")'] );
           return $count[0]['count("taskid")'] ;
      }
      
      
      function countOfTaskByDptId($dptId,$startDate,$endDate){
           $sql='select count("taskid") from task where (dptid ='.$dptId .') and ((startdate <="' .$startDate.'" and enddate >="'.
                                  $startDate.'") or (startdate >="'.$startDate.'" and startdate <="'.$endDate.'"))';
           
           //file_put_contents('c:\error.txt',$sql);
           $query= $this->db->query($sql);
           $count =  $query->result_array();
           //file_put_contents('c:\error.txt','---'.$count[0]['count("taskid")'] );
           return $count[0]['count("taskid")'] ;
      }
      
      
      
      //根据搜索类型、任务、时间来获取任务信息
      function searchTask($type,$content,$startDate,$endDate){
            if($type == "content"){
               $sql='select * from task where (taskcontent like "%'.$content .'%") and ((startdate <="' .$startDate.'" and enddate >="'.
                                        $startDate.'") or (startdate >="'.$startDate.'" and startdate <="'.$endDate.'")) order by tasktypeid asc,startdate desc';  
           }else if($type=='user'){
               $sql='select * from task where (responsible like "%'.$content .'%") and ((startdate <="' .$startDate.'" and enddate >="'.
                                        $startDate.'") or (startdate >="'.$startDate.'" and startdate <="'.$endDate.'")) order by tasktypeid asc,startdate desc'; 
           } 
         // $sql ='select * from task where dptid='.$dptId .' and startdate>"' .$startDate.'"'; 
          //vardump($sql);
 // file_put_contents('c:\error.txt',$sql);
          $query= $this->db->query($sql);
          $rows = $query->result_array();
          for($i=0;$i<count($rows);$i++){
              $rows[$i]['dptname'] = $this->DPT[$rows[$i]['dptid']]; 
              $rows[$i]['tasktypename'] = $this->TASKTYPE[$rows[$i]['tasktypeid']];
              //$this->DPT ;         
          }
          return $rows;
      }
      
      function updateTask($taskid,$tasktypeid,$startdate,$enddate,$taskcontent,$responsible){
          $sql = 'update task set tasktypeid='.$tasktypeid.',startdate="'.$startdate.'",enddate="'.$enddate
                .'",taskcontent="'.$taskcontent.'",responsible="'.$responsible.'" where taskid='.$taskid;
          $query = $this->db->query($sql);
          return $query;
      }
      
      function newTask($userid,$tasktypeid,$startdate,$enddate,$taskcontent,$responsible){
          $sql = 'select * from user where userid ='.$userid;
          $query = $this->db->query($sql);
          $rows= $query->result_array();
          $sql = 'insert into task values (NULL,"'.$taskcontent.'","'.$startdate.'","'.$enddate.'",0,'.$tasktypeid.','.$rows[0]['dptid'].','.$userid.',"'.$responsible.'")' ;
          //file_put_contents('c:\error.txt',$sql);
          $query = $this->db->query($sql);
          return $query;
      }
      
      function deleteTask($tasklist){
          $temp=' taskid='.$tasklist[0];
          for($i=1;$i<count($tasklist);$i++){
              $temp = $temp.' or taskid=' .$tasklist[$i];
          }
          $sql = 'delete from task where '.$temp;
          //file_put_contents('c:\error.txt',$sql);
          $query = $this->db->query($sql);
          return $query;
      }
      
      function getTaskType(){
          $sql ='select * from tasktype';
          $query = $this->db->query($sql);
          return $query;
      }
//      function searchTaskU($searchText){
//          $sql = "select * from task where username = '".$searchText."'";
//          $query = $this->db->query($sql);
//          return $query;
//      }
//      function searchTaskC($searchText){
//          $sql = "select * from task where tasktitle LIKE '%".$searchText."%' OR taskcontent LIKE '%".$searchText."%'";
//          $query = $this->db->query($sql);
//          return $query;
//      }
//      function addTask($tasktitle,$taskcontent,$pubtime,$username,$completed){
//          $sql='insert into task values(NULL,"'.$tasktitle.'","'.$tasktitle
//                .'","'.$pubtime.'","'.$username.'",'.$completed.')';
//          //var_dump($sql);
//          $query= $this->db->query($sql);
//      }
//      function chgToUncmpl($tasklist){
//         for($i=0;$i<count($tasklist);$i++){
//             $sql = "UPDATE task SET iscompleted = 0 WHERE taskid ='".$tasklist[$i]."'";
//             $query = $this->db->query($sql);
//             //$result = mysql_query($query) or die('query error');
//         } 
//      }
//      function chgToCmpl($tasklist){
//         for($i=0;$i<count($tasklist);$i++){
//             $sql = "UPDATE task SET iscompleted = 1 WHERE taskid ='".$tasklist[$i]."'";
//             $query = $this->db->query($sql);
//             //$result = mysql_query($query) or die('query error');
//         } 
//      }
//      function delTask($tasklist){
//         for($i=0;$i<count($tasklist);$i++){
//             $sql = "delete from task WHERE taskid ='".$tasklist[$i]."'";
//             $query = $this->db->query($sql);
//             //$result = mysql_query($query) or die('query error');
//         } 
//      }
      
  }
?>
