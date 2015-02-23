<!DOCTYPE html>
<html style="width: 100%;height: 100%;overflow: hidden;">
    <head>
        <title>任务管理系统</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/default/easyui.css"?>>
        <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/icon.css"?>>
        <link rel="stylesheet" type="text/css" href=<?php echo base_URL()."resource/css/login.css"?>>
		<script type="text/javascript" src=<?php echo base_URL()."resource/js/jquery-1.8.0.min.js"?>></script>
        <script type="text/javascript" src=<?php echo base_URL()."resource/js/jquery.easyui.min.js"?>></script>

    </head>
    <body style="width: 100%;height: 100%;overflow: hidden;padding: 0;margin: 0;">
    
       <div id="login" class="easyui-dialog"  style="width:486px;height:300px;"   data-options="iconCls:'icon-save',resizable:true,modal:true,noheader: true,">   
            <div id='logo'> <img src='<?php echo base_URL()."resource/img/login_top.gif"?>'/> </div>
            <?php echo form_open(base_url().'index.php/login/formsubmit') ?>
                <ul id="form-body">
                    <li><label>账号</label> <input type="text" name="username"  required="required"></li>
                    <li><label>密码</label> <input type="password" name="password" required="required"></li>
                </ul>
                <button id='submit' type="submit">登录</button>
            </form>
            
           
       </div>  
    

    
    </body>
</html>