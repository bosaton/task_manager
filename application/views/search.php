<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>高级搜索</title>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/default/easyui.css"?>>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/icon.css"?>>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/taskview.css"?>>
    <script type="text/javascript" src=<?php echo base_URL()."resource/js/jquery-1.8.0.min.js"?>></script>
    <script type="text/javascript" src=<?php echo base_URL()."resource/js/jquery.easyui.min.js"?>></script>
    <script type="text/javascript" src=<?php echo base_URL()."resource/js/config.js"?>></script>
</head>
<body>
    <script type="text/javascript">

        
        var start_date='',end_date='',dptId='';;
        $(document).ready(function(){
            $('#start_date_2').datebox({
                onSelect: function(date){
                    start_date = date.getFullYear()+'-'+
                                 ((date.getMonth()+1)<10? '0'+(date.getMonth()+1):(date.getMonth()+1)) + '-' +
                                 (date.getDate()<10? '0' +date.getDate():date.getDate()) ;
                    //alert(start_date);  
                }
            });
            $('#end_date_2').datebox({
                onSelect: function(date){
                    end_date = date.getFullYear()+'-'+
                                 ((date.getMonth()+1)<10? '0'+(date.getMonth()+1):(date.getMonth()+1)) + '-' +
                                 (date.getDate()<10? '0' +date.getDate():date.getDate()) ;
                    //alert(start_date);  
                }
            });
            
        });
        
        
        function search(value,name){
            //alert(name+'-'+value+'-'+start_date);
            if((start_date=='')||(start_date==null) || (end_date=='')||(end_date==null) || (value==null)||(value=='')){
                alert("单位、开始时间和结束时间不能为空，请重新选择");
                return;
            }
            if(start_date > end_date){
                alert("结束时间必须大于开始时间");
                return;
            }  
            $.post(base_url+"index.php/search/getSearchResult",
              {
                startDate:start_date,
                endDate:end_date,
                type:name,
                content:value,
              },
              function(data,status){
                 //console.dir(data);
                 var json= JSON.parse(data);
                 //console.log(json[0].taskcontent);
                 
                 var content="";
                 for(var i=0;i<json['per_page'];i++){
                     if(json[i]== 'undefined' || json[i]==null) break;
                     content = content +  "<tr>"
                        + "<th align='center'>" + json[i].dptname +"</th>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].tasktypename +"</font></td>"
                        + "<td style='font-size:10pt'>" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                        + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                        + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                        + "</tr>"  ;
                 }
                 var table= "<table border='1' frame='border' rules='all' style='font-size:11pt'>"
                        + "<tr bgcolor='#ddddff'> <th width='60px' align='center'>单位</th> <th width='75px' align='center'>任务类别</th> <th width='170px' align='center'>日期</th> <th width='360px' align='center'>任务内容</th> <th width='70px' align='center'>责任人</th>  </tr>"
                        + content
                        + "</table>";       
                 $("#task_table_2").html(table);
                 $('#pagination_2').html(json['links']);
              }
           ); 
            
        }
        

    </script>






<div title="高级搜索" data-options="closable:true" style="overflow:auto; padding:5px; ">   
    &nbsp;&nbsp;
    起止日期： 
    <input id="start_date_2" type="text" class="easyui-datebox" required="required"></input> —
    <input id="end_date_2" type="text" class="easyui-datebox" required="required"></input> 
    
    <input id="ss" class="easyui-searchbox" style="width:240px;padding: 20px;"
        data-options="searcher:search,prompt:'输入搜索内容',menu:'#mm'"></input>   
    <div id="mm" style="width:120px">
        <div data-options="name:'content',iconCls:'icon-ok'">内容</div>
        <div data-options="name:'user'">责任人</div>
    </div>


    <hr/>
    <div id='task_table_2'>
        
    </div>
    <div id="pagination_2" ></div>
    

</div>  

</body>

</html>