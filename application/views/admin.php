<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Full Layout - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/default/easyui.css"?>>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/icon.css"?>>
    <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/taskview.css"?>>
    <script type="text/javascript" src=<?php echo '"'.base_URL()."resource/js/jquery-1.8.0.min.js".'"'?>></script>
    <script type="text/javascript" src=<?php echo base_URL()."resource/js/jquery.easyui.min.js"?>></script>
    <script type="text/javascript" src=<?php echo base_URL()."resource/js/config.js"?>></script>
    <script type="text/javascript">
        var start_date='',end_date='',dptId='';;
        $(document).ready(function(){
            $('#department_tree').tree({    
                url: <?php echo "'".base_URL()."resource/department_tree.json'"?>,   
            });
            
            $('#department_tree').tree({    
                onSelect:function(node){
                     //alert(node.id);
                     dptId=node.id;
                }
            });
            
            $('#start_date').datebox({
                onSelect: function(date){
                    start_date = date.getFullYear()+'-'+
                                 ((date.getMonth()+1)<10? '0'+(date.getMonth()+1):(date.getMonth()+1)) + '-' +
                                 (date.getDate()<10? '0' +date.getDate():date.getDate()) ;
                    //alert(start_date);  
                }
            });
            $('#end_date').datebox({
                onSelect: function(date){
                    end_date = date.getFullYear()+'-'+
                                 ((date.getMonth()+1)<10? '0'+(date.getMonth()+1):(date.getMonth()+1)) + '-' +
                                 (date.getDate()<10? '0' +date.getDate():date.getDate()) ;
                    //alert(start_date);  
                }
            });

            
            //点击翻页链接，因翻页链接由ajax生成，故此处可用live，不能用bind
            $('.ajax_fpage').live('click',function(e){
                e.preventDefault(); 
                var url = $(this).attr('href');            
                $.post(url,
                  {
                    dptId:dptId,
                    startDate:start_date,
                    endDate:end_date,
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
                     $("#task_table").html(table);
                     $('#pagination').html(json['links']);
                  }
                );
                return false;
            });
            
            $('#get_task').click(function(){
                if((start_date=='')||(start_date==null) || (end_date=='')||(end_date==null) || (dptId==null)||(dptId=='')){
                    alert("单位、开始时间和结束时间不能为空，请重新选择");
                    return;
                }
                if(start_date > end_date){
                    alert("结束时间必须大于开始时间");
                    return;
                }  
                $.post(base_url+"index.php/index/getTaskByDptid",
                  {
                    dptId:dptId,
                    startDate:start_date,
                    endDate:end_date,
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
                     $("#task_table").html(table);
                     $('#pagination').html(json['links']);
                  }
               );
                
            });
            
            
            $('#menubtn1').click(function(){
                //alert('selected');
                 $('#tabs').tabs('select','普通查看');
                
            });
            $('#menubtn2').click(function(){
                //alert('selected');
                 
                 if ($('#tabs').tabs('exists','高级搜索')){
                    $('#tabs').tabs('select', '高级搜索');
                 } else {
                    $('#tabs').tabs('add',{
                        title:'高级搜索',
                        href:<?php echo '"'.base_URL().'index.php/search"';?>,
                        closable:true,
                    });
                 }
            });
            
            
            $('#menubtn3').click(function(){
                 if ($('#tabs').tabs('exists','任务修改')){
                    $('#tabs').tabs('select', '任务修改');
                 } else {
                    $('#tabs').tabs('add',{
                        title:'任务修改',
                        href:<?php echo '"'.base_URL().'index.php/modify_task"';?>,
                        closable:true,
                    });
                 } 
            });
            
            $('#menubtn4').click(function(){
                 if ($('#tabs').tabs('exists','任务登记')){
                    $('#tabs').tabs('select', '任务登记');
                 } else {
                    $('#tabs').tabs('add',{
                        title:'任务登记',
                        href:<?php echo '"'.base_URL().'index.php/enroll_task"';?>,
                        closable:true,
                    });
                 } 
            });
            
            var  html ='<div id="passwordpanel2">&nbsp;&nbsp;&nbsp;&nbsp;旧密码：<input id="oldpsw" type="password" /> <br />'
                    + '&nbsp;&nbsp;&nbsp;&nbsp;新密码：<input id="newpsw" type="password" /> <br />'
                    + '确认新密码：<input id="rnewpsw" type="password" /> <br /><br/>'
                    + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="changePswBtn">确认修改</button></div>';
            $('#menubtn5').click(function(){
                $('#passwordpanel').dialog({
                    title: '修改密码',
                    width: 400,
                    height: 200,
                    closed: false,
                    cache: false,
                    content: html,
                    modal: true
                });
                
            });
            
            
            $('#menubtn6').click(function(){
                 if ($('#tabs').tabs('exists','意见建议')){
                    $('#tabs').tabs('select', '意见建议');
                 } else {
                    $('#tabs').tabs('add',{
                        title:'意见建议',
                        href:<?php echo '"'.base_URL().'index.php/suggest"';?>,
                        closable:true,
                    });
                 }
            });
            
            $('#menubtn7').click(function(){
                 if ($('#tabs').tabs('exists','人员更新')){
                    $('#tabs').tabs('select', '人员更新');
                 } else {
                    $('#tabs').tabs('add',{
                        title:'人员更新',
                        href:<?php echo '"'.base_URL().'index.php/manager_user"';?>,
                        closable:true,
                    });
                 }
            });
            
            
            $('#changePswBtn').live('click',function(){
                var oldPsw = $('#oldpsw').val();
                var newPsw = $('#newpsw').val();
                var rNewPsw = $('#rnewpsw').val();
                if(oldPsw ==''||oldPsw==null || newPsw=='' ||newPsw==null || rNewPsw==''||rNewPsw==null){
                    alert('输入框不能为空');
                    return;
                }
                if(newPsw != rNewPsw) {
                    alert('两次输入密码不一致，请重新输入');
                    return;
                }
               $.post(base_url+"index.php/index/changePsw",
               {
                    userId: <?php $CI =& get_instance(); echo ($CI->session->userdata("userid"));?>, 
                    oldPsw:oldPsw,
                    newPsw:newPsw,
               },
               function(data,status){
                   //返回操作数据库影响的行数
                   if(data ==1) {
                       alert('密码修改成功');
                   }
               });
                
                
            });
              
//            $('#test').live('click',function(){
//                 //alert('test');
//                 $('#tabs').tabs('add',{    
//                    title:'New Tab',    
//                    content:'Tab Body',    
//                    closable:true,    
//                    tools:[{    
//                        iconCls:'icon-mini-refresh',    
//                        handler:function(){    
//                            alert('refresh');    
//                        }    
//                    }]    
//                });   
//            });

            

            
        });

    </script>
    
    
</head>
<body class="easyui-layout">
	<div data-options="region:'north',border:false" style="height:60px;background:#B3DFDA;padding:11px">
        <img src=<?php echo base_URL().'resource/img/top.gif'?>></img>
    </div>
	<div data-options="region:'west',split:true,title:'导航'" style="width:150px;">
		<div id="aa" class="easyui-accordion" style="overflow:auto;">   
			<div title="任务查看" data-options="selected:true" style="overflow:auto;">   
				<ul>
					<li>
                        <a id="menubtn1" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-search'">普通查看</a>
                        <a id="menubtn2" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-search'">高级搜索</a>
                   
					</li>
                </ul>
			</div>   
			<div title="任务管理"  style="padding:10px;"> 
                <a id="menubtn3" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-search'">任务修改</a>  
				<a id="menubtn4" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-search'">任务登记</a>  
			</div>   
			<div title="人员管理" style="padding:10px;">   
				<a id="menubtn7" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-search'">人员更新</a>   
			</div>
            <div title="个人设置" style="padding:10px;">   
                <a id="menubtn5" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-search'">修改密码</a>   
            </div> 
            <div title="其他" style="padding:10px;">   
                <a id="menubtn6" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-search'">意见建议</a>   
            </div>  
		</div>  
	</div>
	<div data-options="region:'south',border:false" style="height:50px;background:#A9FACD;padding:10px;">
        <div style="text-align: center;">@SEU</div>
    </div>
	<div data-options="region:'center'" id='container'>
		<div id="tabs" class="easyui-tabs" fit="true" border="false" tools='#logoutTool'>   
			<div title="普通查看" style="padding:3px;">   
				<div class="easyui-layout" fit="true">
                    <div region="center" title="功能列表" id="bt_function_laout_center">
                        &nbsp;&nbsp;
                        起止日期： 
                        <input id="start_date" type="text" class="easyui-datebox" required="required"></input> —
                        <input id="end_date" type="text" class="easyui-datebox" required="required"></input> 
                        <a id="get_task" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-search'">查找任务</a>  
                        <hr/>
                        <div id='task_table'>
                            
                        </div>
                        <div id="pagination" ></div>
                    
                    </div>
                    <div region="west" style="width: 120px;" title="选择单位" split='true'>
                        <ul id="department_tree" >
                                      
                        </ul>  
                    </div>
                </div>
			</div>   
		</div>  
	    <div id='logoutTool'>
             <?php
                $CI =& get_instance();
                $sessionUser= $CI->session->userdata("username");   
                if(is_administrator()){                                                                                                       
                    echo '<a href="'.base_URL().'/index.php/login/logout" style="float:right;" >退出</a>&nbsp <a style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
                }else if(is_user()){                                                                                 
                    echo '<a href="'.base_URL().'/index.php/login/logout" style="float:right;" >退出</a>&nbsp <a style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
                }else{ 
                    header('location:'.base_URL().'index.php/login');                                                                                      
                }
            ?>

        </div>
    
    </div>
    
    <div id='passwordpanel'>
    
    </div>
    
    
</body>
</html>