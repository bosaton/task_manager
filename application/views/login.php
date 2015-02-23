
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统登录</title>
<style type="text/css">
    body{width:750px;margin:10px auto;border:#eee 5px solid;overflow:auto;padding:8px;word-wrap:break-word;}
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
    
    <a href="?" style="font-size: 20px;">用户登录</a>
    <a href="http://localhost/taskmgr/index.php" style="float:right;" >返回</a> <a href="http://localhost/taskmgr/index.php/register" style="float:right;" >注册&nbsp&nbsp  </a><hr /> 
    <?php echo form_open('login/formsubmit'); ?>  
        用户姓名：<input name="username" type="text" value="<?php echo set_value('username'); ?>"/> <br />
        <?php echo form_error('username'); ?>
        输入密码：<input name="password" type="password" value="<?php echo set_value('password'); ?>"/> <br />
        <?php echo form_error('password'); ?>
        <input type="submit" name="submit" value="登录" />
    </form>

    <hr />
</body>
</html>