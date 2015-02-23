 <script type="text/javascript">
    $(document).ready(function(){
       //alert('suggest ready'); 
       $.post(base_url+"index.php/suggest/get_suggestion",
       {
            userId: <?php $CI =& get_instance(); echo ($CI->session->userdata("userid"));?>, 
       },
       function(data,status){
             var json= JSON.parse(data);
          //console.log(data);
             
             var content="<div id='content'>";
             for(var i=0;i<json['per_page'];i++){
                 if(json[i]== 'undefined' || json[i]==null) break;
                 content = content +  ((i%2)?'<div':'<div style="background-color:#ACD6FF;border:#eee 1px solid;"') + '>'
                        + "<span style='color:#188;font-size:18px;'>"+ json[i].sgtcontent + '</span>'
                        + "<span style='color:#000;float:right'>"+json[i].pubdate+'&nbsp&nbsp' +json[i].username+ '</span><br/>'
                        +'<b>[管理员答复]</b> ' + json[i].answer+'</div>'  ;
                 
             }
             content = content+ '</div>';
             $("#task_table_6").html(content);
             $('#pagination_6').html(json['links']);
       });
       
       
        $('.ajax_fpage_2').live('click',function(e){
            e.preventDefault(); 
            var url = $(this).attr('href');            
            $.post(url, 
            {
                userId: <?php $CI =& get_instance(); echo ($CI->session->userdata("userid"));?>, 
            },
            function (data,status){
                 var json= JSON.parse(data);
          //console.log(data);
             
                 var content="<div id='content'>";
                 for(var i=0;i<json['per_page'];i++){
                     if(json[i]== 'undefined' || json[i]==null) break;
                     content = content +  ((i%2)?'<div':'<div style="background-color:#ACD6FF;border:#eee 1px solid;"') + '>'
                            + "<span style='color:#188;font-size:18px;'>"+ json[i].sgtcontent + '</span>'
                            + "<span style='color:#000;float:right'>"+json[i].pubdate+'&nbsp&nbsp' +json[i].username+ '</span><br/>'
                            +'<b>[管理员答复]</b> ' + json[i].answer+'</div>'  ;
                     
                 }
                 content = content+ '</div>';
                 $("#task_table_6").html(content);
                 $('#pagination_6').html(json['links']);
            });
            return false;
        });
        
        $('#submit_sgst').click(function(){
            var suggestion =$('#suggestion').val();
            if(suggestion ==null || suggestion ==''){
                alert('不能发布空信息');
                return;
            }
            
            $.post(base_url+"index.php/suggest/summit",
            {
                suggestion: suggestion,
            },
            function(data,status){
                 var json= JSON.parse(data);

                 var content="<div id='content'>";
                 for(var i=0;i<json['per_page'];i++){
                     if(json[i]== 'undefined' || json[i]==null) break;
                     content = content +  ((i%2)?'<div':'<div style="background-color:#ACD6FF;border:#eee 1px solid;"') + '>'
                            + "<span style='color:#188;font-size:18px;'>"+ json[i].sgtcontent + '</span>'
                            + "<span style='color:#000;float:right'>"+json[i].pubdate+'&nbsp&nbsp' +json[i].username+ '</span><br/>'
                            +'<b>[管理员答复]</b> ' + json[i].answer+'</div>'  ;
                     
                 }
                 content = content+ '</div>';
                 $("#task_table_6").html(content);
                 $('#pagination_6').html(json['links']);
                
            });
              
            
            
            
        }) ;
        
    });
 
 
 </script>
    <div id='task_table_6'></div>
    <div id='pagination_6'></div>

    <hr/>
    <div >
        <br/>
        给个建议：
        <textarea id="suggestion"></textarea>
        <a id="submit_sgst" href="#" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-ok'">提交</a>
    </div>