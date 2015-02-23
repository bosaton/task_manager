<?php
date_default_timezone_set("Asia/Shanghai");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>任务管理系统</title>
<link rel="stylesheet" href=<?php echo base_URL()."/css/jquery-ui.min.css"?> type="text/css">
<link rel="stylesheet" href=<?php echo base_URL()."/css/taskview.css"?> type="text/css">
<script type="text/javascript" src= <?php echo base_URL()."/js/jquery-1.8.2.min.js"?>></script>
<script type="text/javascript" src= <?php echo base_URL()."/js/jquery-ui.min.js"?>></script>
<script type="text/javascript" src= <?php echo base_URL()."/js/config.js"?>></script>
<script type="text/javascript" src= <?php echo base_URL()."/js/jquery.ui.datepicker-zh-CN.js"?>></script>
<script type="text/javascript" src= <?php echo base_URL()."/js/jquery.json-2.4.js"?>></script>

<script type="text/javascript">
     var reqStartDate='',reqEndDate='';

     //“登记新任务”栏目中 动态加载 任务类别
     function fillTaskType(){
         $.post(baseUrl+"index.php/taskmanager/getTaskType",
              function(data,status){
                  var json= JSON.parse(data);
                  for(var i=0;i<json.length;i++){
                      $('#tasktype').append("<option value='"+json[i].tasktypeid+"'>"+json[i].tasktypename+"</option>");
                  }
              }
         );
     }
     
     
     $(document).ready(function(){
        //jquery ui datepicker初始化
        $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
        $("#datepicker5").datepicker({ dateFormat: "yy-mm-dd", }); 
        $("#datepicker6").datepicker($.datepicker.regional['zh-CN']);
        $("#datepicker7").datepicker({ dateFormat: "yy-mm-dd", }); 
        $("#datepicker8").datepicker({ dateFormat: "yy-mm-dd", }); 
         
        //页面加载后自动加载“登记新任务” 栏目中的 任务类别 
        fillTaskType(); 
        
        //预备ajax错误报警
        $("div").ajaxError(function(){
             alert("与服务器Ajax获取数据错误，请与管理员联系 (taskmanager.php)");
        });
        
        //点击翻页链接，因翻页链接由ajax生成，故此处可用live，不能用bind
        $('.ajax_fpage').live('click',function(e){
            e.preventDefault(); 
            var url = $(this).attr('href');            
            $.post(url,
              {
                userId: <?php $CI =& get_instance(); echo ($CI->session->userdata("userid")) ?>, 
                startDate:reqStartDate,
                endDate:reqEndDate,
              },
              function(data,status){
                 var json= JSON.parse(data);
                 //console.log(json[0]);
                 
                 var content="";
                 for(var i=0;i<json['per_page'];i++){
                     if(json[i]== 'undefined' || json[i]==null) break;
                     content = content +  "<tr>"
                        + "<th rowspan='1'> <input type='checkbox' name='tasklist' value='" + json[i].taskid +"'></input></th>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].tasktypename +"</font></td>"
                        + "<td >" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                        + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                        + "<td >" + json[i].status +"</td>"
                        + "</tr>"  ;
                 }
                 var table= "<table border='1' frame='border' rules='all'>"
                        + "<tr bgcolor='#ddddff'> <th width='40px'><input type='checkbox'/></th> <th width='75px'>任务类别</th> <th width='170px'>日期</th> <th width='500px'>任务内容</th> <th width='70px'>责任人</th> <th>备注</th> </tr>"
                        + content
                        + "</table>";       
                 $("#tableview").html(table);
                 $('#pagination').html(json['links']);
                  
              }
            );
            return false;
        }); 
        
        //点击“获取任务”，为修改和删除任务 做准备 
        $('#reqTask').click(function(){
           var startDate='',endDate='';
           startDate = $('#datepicker5').datepicker("getDate");            //Date javascript object
           endDate = $("#datepicker6").datepicker("getDate");
           if((startDate=='')||(startDate==null) || (endDate=='')||(endDate==null)){
                alert("开始时间和结束时间不能为空，请重新选择");
                return;
           }
           if(startDate > endDate){
                alert("结束时间必须大于开始时间");
                return;
           }
           var start = startDate.getFullYear()+'-'
                + (parseInt(startDate.getMonth())+1 <10 ?'0'+(parseInt(startDate.getMonth())+1):(parseInt(startDate.getMonth())+1)) +'-'
                + (startDate.getDate()<10? '0'+startDate.getDate():startDate.getDate()); 
           var end =   endDate.getFullYear()+'-'
                + (parseInt(endDate.getMonth())+1 <10 ?'0'+(parseInt(endDate.getMonth())+1):(parseInt(endDate.getMonth())+1)) +'-'
                + (endDate.getDate()<10? '0'+endDate.getDate():endDate.getDate()); 
           reqStartDate=start;
           reqEndDate=end;
           //alert(start + end);
           $.post(baseUrl+"index.php/taskmanager/getTable",
              {
                userId: <?php $CI =& get_instance(); echo ($CI->session->userdata("userid"));?>, 
                startDate:start,
                endDate:end,
              },
              function(data,status){
                 //console.dir('--'+status);
                 var json= JSON.parse(data);
                 //console.log(data);
                 var content="";
                 for(var i=0;i<json['per_page'];i++){
                     if(json[i]== 'undefined' || json[i]==null) break;
                     content = content +  "<tr>"
                        + "<th rowspan='1'> <input type='checkbox' name='tasklist' value='" + json[i].taskid +"'></input></th>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].tasktypename +"</font></td>"
                        + "<td >" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                        + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                        + "<td align='center'>" + json[i].status +"</td>"
                        + "</tr>"  ;
                 }
                 var table= "<table border='1' frame='border' rules='all'>"
                        + "<tr bgcolor='#ddddff'> <th width='40px'><input type='checkbox'/></th> <th width='75px'>任务类别</th> <th width='170px'>日期</th> <th width='500px'>任务内容</th> <th width='70px'>责任人</th> <th>备注</th> </tr>"
                        + content
                        + "</table>";       
                 $("#tableview").html(table);
                 //console.log(table)
                 $('#pagination').html(json['links']);
              }
           );  
        });
        
        
        //点击'修改'后，被修改那一项将加载到下面‘添加新任务’栏目中
        $('#modify').click(function(){
            var taskid='';
            if($("[name='tasklist']:checked").length !=1){
                alert('每次只能修改1条任务');
            }else{
                $("[name='tasklist']:checked").each(function(){
                       //alert($(this).val());
                     taskid= $(this).val(); 
                });
                $.post(baseUrl+"index.php/taskmanager/loadTaskToTable",
                  {
                     taskid: taskid, 
                  },
                  function(data,status){
                     //console.dir(status);
                     var json= JSON.parse(data);
                     //console.log(json[0].tasktypeid);
                     $('#tasktype').val(json[0].tasktypeid);
                     $('#taskcontent').val(json[0].taskcontent);
                     $('#responsible').val(json[0].responsible);
                     $( "#datepicker7" ).datepicker("setDate",json[0].startdate);
                     $( "#datepicker8" ).datepicker("setDate",json[0].enddate);
                     $('#taskid').val(json[0].taskid);
                  }
               );
            }
        });
        
        //输入新任务或者加载欲修改任务相关信息后，点击‘提交’
        $('#newTaskBtn').click(function(){
           var startDate='',endDate='',taskcontent='',responsible='',taskid='';
           startDate = $('#datepicker7').datepicker("getDate");            //Date javascript object
           endDate = $("#datepicker8").datepicker("getDate");
           taskcontent = $('#taskcontent').val();
           responsible = $('#responsible').val();
           taskid = $('#taskid').val();
           tasktypeid= $('#tasktype').val();

           if((startDate=='')||(startDate==null) || (endDate=='')||(endDate==null) || (taskcontent=='')||(responsible=='')){
                alert("任务内容、责任人、开始时间和结束时间都不能为空，请重新选择");
                //alert(startDate.getFullYear());
                return;
           }
           if(startDate > endDate){
                alert("结束时间必须大于开始时间");
                return;
           }
           var start = startDate.getFullYear()+'-'
                + (parseInt(startDate.getMonth())+1 <10 ?'0'+(parseInt(startDate.getMonth())+1):(parseInt(startDate.getMonth())+1)) +'-'
                + (startDate.getDate()<10? '0'+startDate.getDate():startDate.getDate()); 
           var end =   endDate.getFullYear()+'-'
                + (parseInt(endDate.getMonth())+1 <10 ?'0'+(parseInt(endDate.getMonth())+1):(parseInt(endDate.getMonth())+1)) +'-'
                + (endDate.getDate()<10? '0'+endDate.getDate():endDate.getDate()); 
           //alert(start+end);
           $.post(baseUrl+"index.php/taskmanager/submitModify",
              {
                 taskid: taskid,
                 tasktypeid:tasktypeid,
                 startdate:start,
                 enddate:end,
                 taskcontent:taskcontent,
                 responsible:responsible, 
                 reqstartdate:reqStartDate,
                 reqenddate:reqEndDate,
              },
              function(data,status){
                 if(taskid == '系统自动分配'){
                     alert('添加新任务成功');
                 }else{
                     alert('修改任务成功');
                 }
                 
                 //console.log(status);
                 var json= JSON.parse(data);
                 //console.log(json[0]);
                 
                 var content="";
                 for(var i=0;i<json.length;i++){
                     content = content +  "<tr>"
                        + "<th rowspan='1'> <input type='checkbox' name='tasklist' value='" + json[i].taskid +"'></input></th>"
                        + "<td >" + json[i].tasktypename +"</td>"
                        + "<td >" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                        + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                        + "<td >" + json[i].responsible +"</td>"
                        + "<td >" + json[i].status +"</td>"
                        + "</tr>"  ;
                 }
                 var table= "<table border='1' frame='border' rules='all'>"
                        + "<tr bgcolor='#ddddff'> <th width='40px'><input type='checkbox'/></th> <th width='75px'>任务类别</th> <th width='170px'>日期</th> <th width='500px'>任务内容</th> <th width='70px'>责任人</th> <th>备注</th> </tr>"
                        + content
                        + "</table>";       
                 $("#tableview").html(table);
                 $( "#datepicker5" ).datepicker("setDate",reqStartDate);
                 $( "#datepicker6" ).datepicker("setDate",reqEndDate);
              }
           );
            
        });
        
        //点击'删除'后，选中的信息将被删除
        $('#delete').click(function(){
            var tasklist = new Array();
            $("[name='tasklist']:checked").each(function(){
                 tasklist.push($(this).val()); 
            });
            //console.log(tasklist);
            //console.log(tasklist.toString());
            //console.log(reqStartDate +reqEndDate );
            $.post(baseUrl+"index.php/taskmanager/deleteTask",
              {
                 tasklist: tasklist.toString(),
                 reqstartdate:reqStartDate,
                 reqenddate:reqEndDate,
              },
              function(data,status){
                 alert('删除成功');
                 console.log(status);
                 var json= JSON.parse(data);
                 console.log(json[0]);
                 
                 var content="";
                 for(var i=0;i<json.length;i++){
                     content = content +  "<tr>"
                        + "<th rowspan='1'> <input type='checkbox' name='tasklist' value='" + json[i].taskid +"'></input></th>"
                        + "<td >" + json[i].tasktypename +"</td>"
                        + "<td >" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                        + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                        + "<td >" + json[i].responsible +"</td>"
                        + "<td >" + json[i].status +"</td>"
                        + "</tr>"  ;
                 }
                 var table= "<table border='1' frame='border' rules='all'>"
                        + "<tr bgcolor='#ddddff'> <th width='40px'><input type='checkbox'/></th> <th width='75px'>任务类别</th> <th width='170px'>日期</th> <th width='500px'>任务内容</th> <th width='70px'>责任人</th> <th>备注</th> </tr>"
                        + content
                        + "</table>";       
                 $("#tableview").html(table);
                 $( "#datepicker5" ).datepicker("setDate",reqStartDate);
                 $( "#datepicker6" ).datepicker("setDate",reqEndDate);  
              }
            );
        });
        
        
     });

</script>
</head>

<body>
	
    <img src=<?php echo base_url()."img/top.gif"?> alt="任务管理系统" /> &nbsp;&nbsp;&nbsp;&nbsp;
    <a  style="font-size: 20px; ">管理页面</a>
    
	<?php
        $CI =& get_instance();
        $sessionUser= $CI->session->userdata("username");   
        if(is_administrator()){                                                                                                       
            echo '<a href="'.base_URL().'" style="float:right;" >返回</a>&nbsp <a style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
        }else if(is_user()){                                                                                 
            echo '<a href="'.base_URL().'" style="float:right;" >返回</a>&nbsp <a style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
        }else{ 
            header('location:'.base_URL().'index.php/login');                                                                                      
        }
	?>
	<hr />
	<div >
        	开始日期：
            <input type='text' id='datepicker5'/>
            结束日期：
            <input type='text' id='datepicker6'/>
            <button id='reqTask'>获取任务</button>
	</div>
	

    
	<?php
    
//     echo "<div id='content'>";
//     $content = "<table border='1' frame='border' rules='all'>"
//             ."<tr bgcolor='#ddddff'><th><input type='checkbox'/></th><th width='75px'>任务类别</th> <th width='170px'>日期</th> <th width='500px'>任务内容</th> <th width='70px'>责任人</th> <th>备注</th> </tr>";
//
//     foreach($rows as $row){
//        if(count($rows) >0){
//            $content = $content."<td align='center'> <input type='checkbox' name='tasklist[]' value='".$row['taskid']."'</input></td>"
//                        . "<td align='center'>" . $row['tasktypename'] ."</td>"
//                        . "<td >" . ($row['startdate']==$row['enddate']? $row['startdate']:$row['startdate']."—".$row['enddate'])."</td>"
//                        . "<td ><font face='仿宋_gb2312'>" . $row['taskcontent'] ."</font></td>"
//                        . "<td align='center'><font face='仿宋_gb2312'>" . $row['responsible'] ."</font></td>"
//                        . "<td align='center'>" . $row['status'] ."</td>"
//                        . "</tr>"  ;
//        }
//     }
//     $content =$content. "</table>";
//     echo $content.'</div>';
    ?>
    <div id='tableview'> </div>
	<button id='modify' >修改</button>
    <button id='delete' >删除</button> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
    <span id='pagination'> </span>
    
    <hr/>
    <img src=<?php echo base_url()."img/newtask.gif"?> alt="" />
    <div id='newtask'>
        任务类别：
        <select id="tasktype">
        </select>
        开始日期：
        <input type='text' id='datepicker7'/>
        结束日期：
        <input type='text' id='datepicker8'/>
        任务编号：
        <input type='text' id='taskid' disabled="disabled" value="系统自动分配"></input>
        <br/>
        任务内容：
        <textarea id="taskcontent" style="width: 277px;height: 50px;"></textarea>
        责任人：&nbsp;&nbsp;&nbsp;&nbsp;
        <input id="responsible" type="text" style="width:123px"></input>  &nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="checkbox" id="completed" value="1">已完成</input>  &nbsp;&nbsp;&nbsp;&nbsp;
        <button id="newTaskBtn" value=" 提 交 ">提交</button>
    </div>
    
</body>
</html>

