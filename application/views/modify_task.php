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
        //点击“获取任务”，为修改和删除任务 做准备 
        $('document').ready(function(){
           $.post(base_url+"index.php/modify_task/getTable",
              {
                 userId: <?php $CI =& get_instance(); echo ($CI->session->userdata("userid"));?>, 
              },
              function(data,status){
                 //console.dir('--'+status);
                 var json= JSON.parse(data);
                 var content="";
                 for(var i=0;i<json.length;i++){
                     if(json[i]== 'undefined' || json[i]==null) break;
                     content = content +  "<tr>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].tasktypename +"</font></td>"
                        + "<td style='font-size:10pt'>" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                        + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                        + "<td align='center'> <a class='deletetask' href='"+json[i].taskid+"'>删除</a> </td>"
                        + "</tr>"  ;
                 }
                 var table= "<table border='1' frame='border' rules='all' style='font-size:11pt'>"
                        + "<tr bgcolor='#ddddff'><th width='75px' align='center'>任务类别</th> <th width='170px' align='center'>日期</th> <th width='460px' align='center'>任务内容</th> <th width='70px' align='center'>责任人</th> <th align='center'>操作</th> </tr>"
                        + content
                        + "</table>";       
                 $("#manage_tableview").html(table);
              }
           );  
        });
    
    
        $('.modifytask').live('click',function(e){
            e.preventDefault(); 
            var url = $(this).attr('href');   
            //alert(url);
            
            return false;
        });
        
        
        $('.deletetask').live('click',function(e){
            e.preventDefault(); 
            var url = $(this).attr('href');
         //console.log('send delete taskid:'+url);   
            $.post(base_url+"index.php/modify_task/deleteTask",
              {
                 taskid: url,
              },
              function(data,status){
                 //console.dir('--'+status);
          //console.log('receive delete taskid:'+url); 
                 if(status=='success') {
                      $.messager.show({
                            title:'消息提醒',
                            msg:'任务删除成功',
                            timeout:5000,
                            showType:'slide'
                     });
                 }
                 var json= JSON.parse(data);
                 var content="";
                 for(var i=0;i<json.length;i++){
                     if(json[i]== 'undefined' || json[i]==null) break;
                     content = content +  "<tr>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].tasktypename +"</font></td>"
                        + "<td style='font-size:10pt'>" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                        + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                        + "<td align='center'> <a class='deletetask' href='"+json[i].taskid+"'>删除</a> </td>"
                        + "</tr>"  ;
                 }
                 var table= "<table border='1' frame='border' rules='all' style='font-size:11pt'>"
                        + "<tr bgcolor='#ddddff'><th width='75px' align='center'>任务类别</th> <th width='170px' align='center'>日期</th> <th width='460px' align='center'>任务内容</th> <th width='70px' align='center'>责任人</th> <th align='center'>操作</th> </tr>"
                        + content
                        + "</table>";       
                 $("#manage_tableview").html(table);
              }
            );
            return false;
        });
    </script>

    <hr/>
    <div id='manage_tableview'></div>
    <div id='manage_pagination'></div>

</body>
</html>