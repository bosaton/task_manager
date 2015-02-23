<!DOCTYPE html>
<html>
<head>

</head>
<body>

        <script type="text/javascript">
        //点击“获取任务”，为修改和删除任务 做准备 
        $('document').ready(function(){
             //console.log('test');
             $('#manage_user_table').datagrid({
                columns:[[
                    {field:'userid',title:'编号',width:70,align:'center'},
                    {field:'username',title:'用户名',width:100,align:'center'},
                    {field:'department',title:'单位',width:100,align:'center'},
                    {field:'role',title:'角色',width:100,align:'center'},
                ]],
            });
            
            $('#resetpsw').live('click',function(e){
                var row = $('#manage_user_table').datagrid('getSelected');
                if(row ==null) alert('重置密码前必须选择用户!');
                $.messager.confirm('Confirm','确认重置<b> '+row.username+'  </b>的密码？',function(r){
                    if (r){
                        //alert('row-userid:'+row.userid);
                        $.post(base_url+"index.php/manager_user/resetpsw",
                              {
                                 userid: row.userid, 
                              },
                              function(data,status){
                                  console.log(data);
                                    $.messager.show({
                                        title:'消息提醒',
                                        msg:'密码重置成功，新密码为11111',
                                        timeout:5000,
                                        showType:'slide'
                                    });
                              }
                       );    
                    }
                });


            });
//            
//            
//            $('.deleteuser').live('click',function(e){
//               e.preventDefault();
//               alert('test');
//               console.log('test');
//               return false;
//            }); 
//
//            $('.testclassin').live('click',function(e){
//               e.preventDefault();
//               alert('testclassin'); 
//               return false;
//                
//            });
//            $('.testidin').live('click',function(e){
//               e.preventDefault();
//               alert('testidin'); 
//               return false;
//                
//            });

            
//             $('#manage_user_table').datagrid('loadData',[{
//                  username:'username',
//                  department:'dpt',
//                  role:0,
//                  operate:'op',
//                },{
//                  username:'username',
//                  department:'dpt',
//                  role:0,
//                  operate:'op',
//                },
//                ]
//             );

           $.post(base_url+"index.php/manager_user/getUser",
              {
                 userId: '1', 
              },
              function(data,status){
                 //console.dir('--'+status);
                 var json= JSON.parse(data);
                 //console.log(json);
                 var users =new Array;
                 for(var i=0;i<json.length;i++){
                     users[i]={};
                     users[i].userid =  json[i].userid;
                     users[i].username =  json[i].username;
                     users[i].department = json[i].department;
                     users[i].role = (json[i].role == 0 ? '管理员':'用户') ;
                     //users[i].role = "<a class='testclassin' onclick='javascript:alert(12);return false' href='1'>test</a>" ;
                    // users[i].operate = "<a class='resetpsw' href='" + json[i].userid +"'>重置密码 </a>&nbsp;&nbsp;<a class='deleteuser' href='" + json[i].userid +"'>删除</a>" ;
                 }
                 $('#manage_user_table').datagrid('loadData',users);
                 //$('#testid').html("<a class='testidin' href='1'>testidin</a>")
              }
           ); 
        });
    

    </script>


    <hr/>

    <table id='manage_user_table' toolbar="#manager_user_tb">
    </table>
    <div id="manager_user_tb">
        <a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true" id='resetpsw'>重置密码</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:alert('Cut')">删除人员</a>
    </div>


</body>
</html>