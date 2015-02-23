<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
    body{width:980px;margin:10px auto;overflow:auto;padding:8px;word-wrap:break-word;}
    textarea{width:95%;height:80px;}
    input,select{font-size:12px;}
    body,textarea{font-size:14px;font-family:Arial;line-height:22px;color:#333;}
    a{color:#168;text-decoration:none;}
    hr{height:1px;border:none;border-bottom:1px dashed #abc;}
    div{padding:2px;}
    span{color:#e55;}
    form{margin:0;}
    div#treeview{float:left;width:160px;}
    div#rightview{float:right;width:800px;}
    div#tableview{margin-top: 7px;}
    ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:150px;height:400px;overflow-y:scroll;overflow-x:auto;}
    .foot{clear:left;text-align: center;}
    div#showSearch{text-align: right;}
    div#searchPanel{text-align: right;}
</style>

<script type="text/javascript" src= <?php echo base_URL()."js/config.js"?>></script>
</head>
<body>
    <img src=<?php echo base_url()."img/top.gif"?> alt="任务管理系统" /> 
    <?php
        //echo base_URL();
        $CI =& get_instance();
        //var_dump($CI->session->userdata);
        $sessionUser= $CI->session->userdata("username");   
        if(is_administrator()){                                                                                                       
            echo '<a href="'.base_URL().'" style="float:right;" >返回</a>&nbsp <a style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
        }else if(is_user()){                                                                                 
            echo '<a href="'.base_URL().'" style="float:right;" >返回</a>&nbsp <a style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
        }else{ 
            //echo '<script>alert("in is_administrator()");</script>';
            header('location:'.base_URL().'index.php/login');                                                                                      
            //echo '<a href="http://localhost/taskmgr/index.php/register" style="float:right;" >注册</a>&nbsp <a href="http://localhost/taskview/index.php/login" style="float:right;" >登录&nbsp&nbsp  </a>';
        }

    ?>
    <hr /> 


<?php
        echo '<div id="content">';
        for($i=0;$i<count($rows);$i++){
              if(count($rows) >0){
                echo (($i%2)?'<div':'<div style="background-color:#ACD6FF;border:#eee 1px solid;"').'>';
                echo ("<span style='color:#188;font-size:18px;'>".$rows[$i]['sgtcontent'].'</span>');
                echo ("<span style='color:#000;float:right'>".$rows[$i]['pubdate'].'&nbsp&nbsp'.urldecode($rows[$i]['username']).'</span><br/>');
                echo ('<b>[管理员答复]</b> '.$rows[$i]['answer'].'</div>'); 
            }
        }
        echo '</div>';
        echo $links;
//        if($recordNo >0){
//            for($i=0;$i<$recordNo;$i++){
//                $row = mysql_fetch_array($result);
//                $complete = ($row['iscompleted']==1)?"<span style='color:#188;font-size:18px;'>[已完成]</span>":"<span style='color:red;font-size:18px;'>[未完成]</span>";
//                echo (($i%2)?'<div':'<div style="background-color:#f5f5f5;border:#eee 1px solid;"').'>';
//                echo ('<input type="checkbox" name="tasklist[]" value="'.$row['taskid'].'">'.'</input>');
//                echo ($complete."<span style='color:#188;font-size:18px;'>".$row['tasktitle'].'</span>');
//                echo ("<span style='color:#000;float:right'>".$row['pubtime'].'&nbsp&nbsp'.urldecode($row['username']).'</span>');
//                echo ('<br/>');
//                echo ($row['taskcontent'].'</div>'); 
//            }
//        }
//        echo '</div>';
        
        
        
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

    
    <hr/>
    <?php echo form_open(base_url().'index.php/suggest/summit') ?>
        <br/>
        给个建议：
        <textarea name="suggestion"></textarea>
        <input type="submit" value=" 提 交 " />
    </form>


</body>
</html>




