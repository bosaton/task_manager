<?php
date_default_timezone_set("Asia/Shanghai");
//$cookie = (isset($_COOKIE['username'])) ? $_COOKIE['username'] : '';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>任务管理系统</title>
<style type="text/css">
    body{width:750px;margin:10px auto;border:#eee 5px solid;overflow:auto;padding:8px;word-wrap:break-word;}
    textarea{width:95%;height:80px;}
    input,select{font-size:12px;}
    body,textarea{font-size:14px;font-family:Arial;line-height:22px;color:#333;}
    a{color:#168;text-decoration:none;}
    hr{height:1px;border:none;border-bottom:1px dashed #abc;}
    div{padding:2px;}
    span{color:#e55;}
    form{margin:0;}
</style>
</head>

<body>
	<a href="?" style="font-size: 20px; font-family:SimSun;">任务管理系统 —— 管理页面</a>
	<?php
        $CI =& get_instance();
        //var_dump($CI->session->userdata);
        $sessionUser= $CI->session->userdata("username");   
        if(is_administrator()){                                                                                                       
            echo '<a href="http://localhost/taskmgr/index.php/login/logout" style="float:right;" >退出</a>&nbsp <a href="?" style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
        }else if(is_user()){                                                                                 
            echo '<a href="http://localhost/taskmgr/index.php/login/logout" style="float:right;" >退出</a>&nbsp <a href="?" style="float:right;" >欢迎你, '.$sessionUser.'&nbsp&nbsp&nbsp&nbsp  </a>';
        }else{
            echo '<a href="http://localhost/taskmgr/index.php/register" style="float:right;" >注册</a>&nbsp <a href="http://localhost/taskmgr/index.php/login" style="float:right;" >登录&nbsp&nbsp  </a>';
        }

	?>
	<hr />
	<div style="margin-left:62%;">
        <?php echo form_open('admin/search'); ?>
		    <select name="searchopt">
			    <option value="content">按内容</option>
			    <option value="user">按责任人</option>
		    </select>
		    <input type="text" name="searchText"></input>
		    <input type="submit" value="搜索"></input>
        </form>
	</div>
	
    <form name='adminForm' action="" method="post">
	<?php
     
     echo '<div id="content">';
     $i=0;
     foreach($rows as $row){
        if(count($rows) >0){
            //for($i=0;$i<count($rows);$i++){
                //$row = mysql_fetch_array($result);
                $complete = ($row['iscompleted']==1)?"<span style='color:#188;font-size:18px;'>[已完成]</span>":"<span style='color:red;font-size:18px;'>[未完成]</span>";
                echo (($i%2)?'<div':'<div style="background-color:#f5f5f5;border:#eee 1px solid;"').'>';
                echo ('<input type="checkbox" name="tasklist[]" value="'.$row['taskid'].'">'.'</input>');
                echo ($complete."<span style='color:#188;font-size:18px;'>".$row['tasktitle'].'</span>');
                echo ("<span style='color:#000;float:right'>".$row['pubtime'].'&nbsp&nbsp'.urldecode($row['username']).'</span>');
                echo ('<br/>');
                echo ($row['taskcontent'].'</div>'); 
            //}
        }
        $i++; 
     }
     echo '</div>';
    ?>
	
	<hr/>
    <input type="submit" name="update1" style="float:right;" value="改为未完成 " onclick="javascript:adminForm.action='http://localhost/taskmgr/index.php/admin/touncmple';"/>
    <input type="submit" name="update2" style="float:right;" value="改为完成 " onClick="javascript:adminForm.action='http://localhost/taskmgr/index.php/admin/tocmple';"/>
    <input type="submit" name="update3" style="float:right;" value="删除" onClick="javascript:adminForm.action='http://localhost/taskmgr/index.php/admin/dlttask';"/>
    
	</form>

</body>
</html>

