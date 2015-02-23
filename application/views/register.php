<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户注册</title>
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
    
    <a href="?" style="font-size: 20px;">用户注册</a>
    <a href="http://localhost/taskmgr/index.php" style="float:right;" >返回</a><hr />
    <?php echo form_open('register/formsubmit'); ?>
        用户姓名：<input name="username" type="text" value="<?php echo set_value('username'); ?>"/> <br />
            <?php echo form_error('username'); ?>
        输入密码：<input name="password" type="password" value="<?php echo set_value('password'); ?>"/> <br />
            <?php echo form_error('password')?>
        确认密码：<input name="rpassword" type="password" value="<?php echo set_value('rpassword'); ?>" /> <br />
            <?php echo form_error('rpassword');?>
        所属单位：<input name="department" type="text" value="<?php echo set_value('department'); ?>"/> <br />
            <?php echo form_error('department');?>
        <input name="submit" type="submit" value="注册" />
    </form>

    <hr />
</body>
</html>