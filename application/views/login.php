
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统登录</title>
<style type="text/css">
    body{width:300px;margin:10px auto;border:#eee 5px solid;overflow:auto;padding:8px;word-wrap:break-word;}
    textarea{width:95%;height:80px;}
    input,select{font-size:12px;}
    body,textarea{font-size:14px;font-family:Arial;line-height:22px;color:#333;}
    a{color:#168;text-decoration:none;}
    hr{height:1px;border:none;border-bottom:1px dashed #abc;}
    div{padding:10px;}
    span{color:#e55;}
    form{margin:0;}
</style>
</head>
<body>
    <img src=<?php echo base_url()."img/top.gif"?> alt="任务管理系统" /> 
    <a  style="font-size: 14px;">    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 用户登录</a>
    <br/>
    <?php echo form_open(base_url().'index.php/login/formsubmit') ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;用户姓名：<input name="username" type="text" /> <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;输入密码：<input name="password" type="password" /> <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="登录" />
    </form>
    

</body>
</html>