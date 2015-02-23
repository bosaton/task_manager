<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>enroll</title>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/default/easyui.css"?>>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/icon.css"?>>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/taskview.css"?>>
    <script type="text/javascript" src=<?php echo base_URL()."resource/js/jquery-1.8.0.min.js"?>></script>
    <script type="text/javascript" src=<?php echo base_URL()."resource/js/jquery.easyui.min.js"?>></script>
    <script type="text/javascript" src=<?php echo base_URL()."resource/js/config.js"?>></script>

</head>
<body>

    <script type="text/javascript">
         var start_date_4='', end_date_4='' ,tasktypeid='',task_importance=0;
         //“登记新任务”栏目中 动态加载 任务类别
         function fillTaskType(){
             //alert('teseee');
             $.post(base_url+"index.php/enroll_task/getTaskType",
                  function(data,status){
                      var json= JSON.parse(data);
                      var array = new Array();
                      for(var i=0;i<json.length;i++){
                          array[i]=new Array();
                          //console.log(json[i].tasktypeid);
                          array[i]["value"]=json[i].tasktypeid;
                          array[i]["label"]=json[i].tasktypename;
                      }
                      $('#tasktype').combobox('loadData',array);
                  }
             );
        }
         
        $(document).ready(function(){
             $('#start_date_4').datebox({
                onSelect: function(date){
                    start_date_4 = date.getFullYear()+'-'+
                                 ((date.getMonth()+1)<10? '0'+(date.getMonth()+1):(date.getMonth()+1)) + '-' +
                                 (date.getDate()<10? '0' +date.getDate():date.getDate()) ;
                    //alert(start_date);  
                }
            });
            $('#end_date_4').datebox({
                onSelect: function(date){
                    end_date_4 = date.getFullYear()+'-'+
                                 ((date.getMonth()+1)<10? '0'+(date.getMonth()+1):(date.getMonth()+1)) + '-' +
                                 (date.getDate()<10? '0' +date.getDate():date.getDate()) ;
                    //alert(start_date);  
                }
            });
            $('#tasktype').combobox({
                valueField:'value',
                textField:'label',
                editable:false ,
            });
            $('#tasktype').combobox({
                onSelect: function(record){
                   //console.log(record.value);
                   tasktypeid = record.value;
                }
            });
            fillTaskType(); 
            
            $('#taskimportance').combobox({
                onSelect: function(record){
                   //console.log(record.value);
                   task_importance = record.value;
                }
            });
            
            $('#newTaskBtn').click(function(){
                taskcontent = $('#taskcontent').val();
                responsible = $('#responsible').val();
                //console.log(tasktypeid+'-'+taskcontent+'-'+responsible);
                $.post(base_url+"index.php/enroll_task/new_task",
                  {
                     tasktypeid:tasktypeid,
                     taskimportance:task_importance,
                     startdate:start_date_4,
                     enddate:end_date_4,
                     taskcontent:taskcontent,
                     responsible:responsible,
                  },
                  function(data,status){
                     var json= JSON.parse(data);
                     var content="";
                     for(var i=0;i<json.length;i++){
                         content = content +  "<tr>"
                            + "<td align='center'><font face='仿宋_gb2312'>" + json[i].tasktypename +"</font></td>"
                            + "<td style='font-size:10pt'>" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                            + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                            + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                            + "<td >" + json[i].status +"</td>"
                            + "</tr>"  ;
                     }
                     var table= "<table border='1' frame='border' rules='all' style='font-size:11pt'>"
                            + "<tr bgcolor='#ddddff'> <th width='75px' align='center'>任务类别</th> <th width='170px' align='center'>日期</th> <th width='350px' align='center'>任务内容</th> <th width='70px' align='center'>责任人</th> <th>备注</th> </tr>"
                            + content
                            + "</table>";       
                     $("#task_table_4").html(table);
                  }
               );
 
            });
            
            
        });
        
    </script>
    
    <div id='task_table_4'></div>
    <div id='newtask'>
        <hr/>
        任务类型：
        <select id="tasktype" class="easyui-combobox" style="width:140px;">  </select>&nbsp;&nbsp;
        起止日期：
        <input id="start_date_4" type="text" class="easyui-datebox" required="required"></input> —
        <input id="end_date_4" type="text" class="easyui-datebox" required="required"></input> 
        <hr/>
        任务内容：
        <textarea id="taskcontent" style="width: 277px;height: 50px;"></textarea>&nbsp;&nbsp;
        重要性：
        <select id="taskimportance" class="easyui-combobox" style="width:140px;">
          <option value="0">日常工作或一般性工作</option>  
          <option value="1">重要工作或大项任务</option>  
        </select>
        <hr/> 
        责任人：
        <input id="responsible" class="easyui-textbox" data-options="iconCls:'icon-search'" style="width:73px"> </input>
        <a id="newTaskBtn" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-ok'">提交</a>
    </div>

</body>
</html>