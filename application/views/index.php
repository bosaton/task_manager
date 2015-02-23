<?php
date_default_timezone_set("Asia/Shanghai");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>任务管理系统</title>
    <link rel="stylesheet" href=<?php echo base_URL()."css/zTreeStyle/zTreeStyle.css"?> type="text/css">
    <link rel="stylesheet" href=<?php echo base_URL()."css/jquery-ui.min.css"?> type="text/css">
    <link rel="stylesheet" href=<?php echo base_URL()."css/taskview.css"?> type="text/css">
    <script type="text/javascript" src= <?php echo base_URL()."js/jquery-1.8.2.min.js"?>></script>
    <script type="text/javascript" src= <?php echo base_URL()."js/config.js"?>></script>
    <script type="text/javascript" src= <?php echo base_URL()."js/jquery-ui.min.js"?>></script>
    <script type="text/javascript" src= <?php echo base_URL()."js/jquery.ui.datepicker-zh-CN.js"?>></script>
    <script type="text/javascript" src= <?php echo base_URL()."js/jquery.ztree.core-3.5.js"?>></script>
    <script type="text/javascript" src= <?php echo base_URL()."js/layer/layer.min.js"?>></script>


<SCRIPT type="text/javascript">
        //ztree 配置
        var treeSetting = { 
            callback:{
                onClick: treeClick,
            }
        };
        //因部门结构基本固定，可以一次性人工录入，注意id即可
        var treeNodes =[
            { id:1, name:"1Y", open:true,
                children: [
                    { id:101,pId:1,name:"1Y1L",},
                    { id:102,pId:1,name:"1Y2L",},
                    { id:103,pId:1,name:"1Y3L",},
                ]},
            { id:2,name:"2Y", 
                children: [
                    { id:201,pId:2,name:"2Y1L",},
                    { id:202,pId:2,name:"2Y2L",},
                    { name:"2Y3L",},
                ]},
            { name:"3Y", 
                children: [
                    { name:"3Y1L",},
                    { name:"3Y2L",},
                    { name:"3Y3L",},
                ]},
            { name:"4Y", 
                children: [
                    { name:"4Y1L",},
                    { name:"4Y2L",},
                    { name:"4Y3L",},
                ]},
            { name:"5Y", 
                children: [
                    { name:"5Y1L",},
                    { name:"5Y2L",},
                    { name:"5Y3L",},
                ]},
        ];


        var dptId='';
        var start='',end='';
        function treeClick(event, treeId, treeNode, clickFlag) {
            //alert("[ "+getTime()+" onClick ]&nbsp;&nbsp;clickFlag = " + clickFlag + " (" + (clickFlag===1 ? "普通选中": (clickFlag===0 ? "<b>取消选中</b>" : "<b>追加选中</b>")) + ")");
            dptId = treeNode.id;
        }  
              
//        function getTime() {
//            var now= new Date(),
//            h=now.getHours(),
//            m=now.getMinutes(),
//            s=now.getSeconds();
//            return (h+":"+m+":"+s);
//        }
        
        $(document).ready(function(){
            //首先隐藏“高级搜索”栏目，显示“普通查看”栏目
            $("#searchPanel").hide();
            //ztree插件初始化
            $.fn.zTree.init($("#treeDemo"), treeSetting, treeNodes);
            //ajax错误配置
            $("div").ajaxError(function(){
                alert("与服务器Ajax获取数据错误，请与管理员联系 (index.php)");
            });
            //jquery ui datepicker插件初始化
            $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
            $("#datepicker1").datepicker({ dateFormat: "yy-mm-dd", }); 
            $("#datepicker2").datepicker($.datepicker.regional['zh-CN']);
            $("#datepicker3").datepicker({ dateFormat: "yy-mm-dd", }); 
            $("#datepicker4").datepicker({ dateFormat: "yy-mm-dd", }); 
            
            //点击翻页链接，因翻页链接由ajax生成，故此处可用live，不能用bind
            $('.ajax_fpage').live('click',function(e){
                e.preventDefault(); 
                var url = $(this).attr('href');            
                $.post(url,
                  {
                    dptId: dptId, 
                    startDate:start,
                    endDate:end,
                  },
                  function(data,status){
                     var json= JSON.parse(data);
                     var content="";
                     for(var i=0;i<json['per_page'];i++){
                         if(json[i]== 'undefined' || json[i]==null) break;
                         content = content +  "<tr>"
                            + "<th align='center'>" + json[i].dptname +"</th>"
                            + "<td align='center'><font face='仿宋_gb2312'>" + json[i].tasktypename +"</font></td>"
                            + "<td >" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                            + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                            + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                            + "<td align='center'>" + json[i].status +"</td>"
                            + "</tr>"  ;
                     }
                     var table= "<table border='1' frame='border' rules='all'>"
                            + "<tr bgcolor='#ddddff'> <th width='60px'>单位</th> <th width='75px'>任务类别</th> <th width='170px'>日期</th> <th width='360px'>任务内容</th> <th width='70px'>责任人</th> <th>备注</th> </tr>"
                            + content
                            + "</table>";       
                     $("#tableview").html(table);
                     $('#pagination').html(json['links']);
                  }
                );
                return false;
            });
            
            //普通查看  点击"查找任务"
            $("#viewPlan").click(function(){
                var startDate = $('#datepicker1').datepicker("getDate");            //Date javascript object
                var endDate = $("#datepicker2").datepicker("getDate");
                if((startDate=='')||(startDate==null) || (endDate=='')||(endDate==null) || (dptId==null)||(dptId=='')){
                    alert("单位、开始时间和结束时间不能为空，请重新选择");
                    return;
                }
                if(startDate > endDate){
                    alert("结束时间必须大于开始时间");
                    return;
                }
                start = startDate.getFullYear()+'-'
                    + (parseInt(startDate.getMonth())+1 <10 ?'0'+(parseInt(startDate.getMonth())+1):(parseInt(startDate.getMonth())+1)) +'-'
                    + (startDate.getDate()<10? '0'+startDate.getDate():startDate.getDate()); 
                end =   endDate.getFullYear()+'-'
                    + (parseInt(endDate.getMonth())+1 <10 ?'0'+(parseInt(endDate.getMonth())+1):(parseInt(endDate.getMonth())+1)) +'-'
                    + (endDate.getDate()<10? '0'+endDate.getDate():endDate.getDate()); 
                //console.log(dptId + start + end);
               
               $.post(baseUrl+"index.php/index/getTaskByDptid",
                  {
                    dptId:dptId,
                    startDate:start,
                    endDate:end,
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
                            + "<td >" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                            + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                            + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                            + "<td align='center'>" + json[i].status +"</td>"
                            + "</tr>"  ;
                     }
                     var table= "<table border='1' frame='border' rules='all'>"
                            + "<tr bgcolor='#ddddff'> <th width='60px'>单位</th> <th width='75px'>任务类别</th> <th width='170px'>日期</th> <th width='360px'>任务内容</th> <th width='70px'>责任人</th> <th>备注</th> </tr>"
                            + content
                            + "</table>";       
                     $("#tableview").html(table);
                     $('#pagination').html(json['links']);
                  }
               );
                
            });

            //高级搜索  点击“搜索”
            $("#searchBtn").click(function(){
                startDate = $('#datepicker3').datepicker("getDate");            //Date javascript object
                endDate = $("#datepicker4").datepicker("getDate");
                if(startDate > endDate){
                    alert("结束时间必须大于开始时间");
                    return;
                }
                var searchOpt='',searchText='';
                searchOpt= $("#searchOpt").val();
                searchText = $("#searchText").val();
                if(searchText == '' || searchText==null){
                    alert("搜素内容不能为空");
                    return;
                }
                
                var start = startDate.getFullYear()+'-'
                    + (parseInt(startDate.getMonth())+1 <10 ?'0'+(parseInt(startDate.getMonth())+1):(parseInt(startDate.getMonth())+1)) +'-'
                    + (startDate.getDate()<10? '0'+startDate.getDate():startDate.getDate()); 
                var end =   endDate.getFullYear()+'-'
                    + (parseInt(endDate.getMonth())+1 <10 ?'0'+(parseInt(endDate.getMonth())+1):(parseInt(endDate.getMonth())+1)) +'-'
                    + (endDate.getDate()<10? '0'+endDate.getDate():endDate.getDate()); 
                //console.log(dptId + start + end);
                $.post(baseUrl+"index.php/index/getSearchResult",
                  {
                    startDate:start,
                    endDate:end,
                    type:searchOpt,
                    content:searchText,
                  },function(data,status){
           //console.dir(data[0]);
                    var json= JSON.parse(data);  
                    var content="";
                     for(var i=0;i<json.length;i++){
                         content = content +  "<tr>"
                            + "<th align='center'>" + json[i].dptname +"</th>"
                            + "<td align='center'><font face='仿宋_gb2312'>" + json[i].tasktypename +"</font></td>"
                            + "<td >" + (json[i].startdate==json[i].enddate? json[i].startdate:json[i].startdate+"—"+json[i].enddate)+"</td>"
                            + "<td ><font face='仿宋_gb2312'>" + json[i].taskcontent +"</font></td>"
                            + "<td align='center'><font face='仿宋_gb2312'>" + json[i].responsible +"</font></td>"
                            + "<td align='center'>" + json[i].status +"</td>"
                            + "</tr>"  ;
                     }
 
                     var table= "<table border='1' frame='border' rules='all'>"
                            + "<tr bgcolor='#ddddff'> <th width='60px'>单位</th> <th width='75px'>任务类别</th> <th width='170px'>日期</th> <th width='360px'>任务内容</th> <th>责任人</th> <th>备注</th> </tr>"
                            + content
                            + "</table>";       
                     $("#tableview").html(table);
                     $("#tableview").fadeIn();
                     $(".foot").hide();
                  }
                );
            });
            
            //点击"显示高级搜索"
            $("#showSearchA").click(function(){
               $("#searchPanel").fadeIn(2000);
               $("#showSearch").hide();
               $("#treeview").hide();
               $("#hintview").hide();
               $("#tableview").html('');
               $('#pagination').html('');
            });
            
            //点击“切换普通查看”
            $("#hideSearch").click(function(){
               $("#searchPanel").fadeOut(1500);
               $("#showSearch").show(); 
               $("#treeview").show();
               $("#hintview").show();
               $("#tableview").html('');
               $('.foot').show();
            });
            
            //点击foot “使用说明”
            $("#readme").bind('click',function(e){
                e.preventDefault();        //与return false组合实现阻止链接跳转
                //layer.msg('test');
                var pagei = $.layer({
                    type: 1,   
                    title: '使用说明',
                    border: [5, 0.5, '#666'],
                    shadeClose: true,
                    area: ['560px', '380px'],
                    page: {
                        html: '<div style="width:548px; height:330px; background-color:#ddddff; color:#000;"><div style="padding:20px;">'
                        +'1. 必须升级安装IE 8.0浏览器；<a href="download/IE8-WindowsXP-x86-CHS.2728888507.rar" >(XP下IE8.0下载)</a><br/>'
                        +'2. <b>普通查看：</b> 选择单位->选择开始时间->选择结束时间->点击"查找任务"即可；<br/>'
                        +'3. <b>高级搜索：</b> 选择开始时间->选择结束时间->选择责任人或者内容->输入责任人或者内容->点击"搜索"即可；<br/>'
                        +'4. <b>登记新任务: </b>点击"任务管理"->选择任务类别->选择开始和结束时间->输入内容和责任人->点击"提交"即可；<br/>'
                        +'5. <b>修改本人已登记任务：</b>点击"任务管理"->选择开始和结束时间->点击"获取任务"即可显示本人已登记任务->选中其中一项任务->点击"修改"，任务内容即加载到下方"登记新任务"栏目中，对相关内容进行修改后->点击"提交"即可；<br/>'
                        +'6. <b>删除本人已登记任务：</b>点击"任务管理"->选择开始和结束时间->点击"获取任务"即可显示本人已登记任务->选中一项或者多项->点击"删除"即可；<br/>'
                        +'7. 建议用户登录后及时修改密码。<br/>'
                        +'</div></div>' ,
                    }
                });
                return false;   
            });
            
            var changePswPage ={
                html: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;旧密码：<input id="oldpsw" type="password" /> <br />'
                    + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新密码：<input id="newpsw" type="password" /> <br />'
                    + '确认新密码：<input id="rnewpsw" type="password" /> <br /><br/>'
                    + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="changePswBtn">确认修改</button>',      
            };
            
            //点击“修改密码” 链接
            $('#changePsw').live('click',function(e){
               e.preventDefault();
               var pagei = $.layer({
                    type: 1,   
                    title: '修改密码',
                    border: [5, 0.5, '#666'],
                    shadeClose: true,
                    area: ['360px', '280px'],
                    page: changePswPage,
                });
               return false; 
            });
            
            //修改密码提交
            $('#changePswBtn').live('click',function(e){
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
               $.post(baseUrl+"index.php/index/changePsw",
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
        });

    </SCRIPT>
</head>

<body>
	
    <img src=<?php echo base_url()."img/top.gif"?> alt="任务管理系统" /> 
	<?php
        $CI =& get_instance();
        $sessionUser= $CI->session->userdata("username");   
        if(is_administrator()){                                                                                                       
            echo '<a href="'.base_URL().'/index.php/login/logout" style="float:right;" >退出</a>&nbsp <a style="float:right;" >欢迎你, 管理员 '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
        }else if(is_user()){                                                                                 
            echo '<a href="'.base_URL().'/index.php/login/logout" style="float:right;" >退出</a>&nbsp <a style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
        }else{ 
            header('location:'.base_URL().'index.php/login');                                                                                      
        }

	?>
	<hr />                                 
    
    <div id='showSearch'>
        <a id='changePsw' href='?' >修改密码</a>   &nbsp;&nbsp;&nbsp;&nbsp;
        <a id='taskmgr' href=<?php echo base_url()."index.php/taskmanager"?> >任务管理</a> &nbsp;&nbsp;&nbsp;&nbsp;
        <a id='showSearchA' href="#" >显示高级搜索</a>
    </div>
	<div id='searchPanel' >
            <em>开始日期：</em>
            <input type='text' id='datepicker3'/>
            <em>结束日期：</em>
            <input type='text' id='datepicker4'/>&nbsp;&nbsp;
		    <select id="searchOpt">
			    <option value="content">内容</option>
			    <option value="user">责任人</option>
		    </select>
		    <input type="text" id="searchText"></input>
		    <input id='searchBtn' type="submit" value="搜索"></input>&nbsp;&nbsp;&nbsp;&nbsp;
            <a id='hideSearch' href="#" >切换普通查看</a>
	</div>
	
    
    <div id='treeview'>
          1*. 选择单位
          <ul id="treeDemo" class="ztree"></ul>
    </div>
    
    <div id='rightview'>
          <div id='hintview'>
            2*. 选择时间 &nbsp;&nbsp;&nbsp;&nbsp;
            <em>开始日期：</em>
            <input type='text' id='datepicker1'/>
            <em>结束日期：</em>
            <input type='text' id='datepicker2'/> &nbsp;&nbsp;&nbsp;&nbsp;
            3*. <input id='viewPlan' type="submit" value="查找任务" />
          </div>
          <div id='tableview'>
           
          </div>
          <div id='pagination'> </div>
    </div> 
	
    <div class='foot'>
	<hr/>
    <a id='readme' href="#" style="font-size:smaller;">使用说明</a>  |  <a id='suggestion' href=<?php echo base_url()."index.php/suggest/index"?> style="font-size:smaller;">建议反馈</a>
    </div>
</body>
</html>

