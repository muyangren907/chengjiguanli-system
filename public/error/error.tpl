﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
{css href="/static/H-ui.admin_v3.1.3.1/H-ui.admin/static/h-ui/css/H-ui.min.css" /}
{css href="/static/H-ui.admin_v3.1.3.1/H-ui.admin/static/h-ui.admin/css/H-ui.admin.css" /}
{css href="/static/H-ui.admin_v3.1.3.1/H-ui.admin/lib/Hui-iconfont/1.0.8/iconfont.css" /}
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>系统提示</title>
</head>
<body>
<section class="container-fluid page-404 minWP text-c">
	<p class="error-title"><i class="Hui-iconfont va-m" style="font-size:80px">&#xe688;</i>
		<span class="va-m"> 系统提示</span>
	</p>
	<p class="error-description"><?php echo(strip_tags($msg));?></p>
	<!-- <p class="error-info">您可以： -->
		<div id= "hrel"></div>
	</p>
</section>
{js href="/static/H-ui.admin_v3.1.3.1/H-ui.admin/lib/jquery/1.9.1/jquery.min.js"}
{js href="/static/H-ui.admin_v3.1.3.1/H-ui.admin/static/h-ui/js/H-ui.min.js"}
{js href="/static/H-ui.admin_v3.1.3.1/H-ui.admin/static/h-ui.admin/js/H-ui.admin.js"}
 <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">

	// 根据页面位置给出不同链接
	$(function(){
		// 页面加载
		if( window.top == window.self ){
           // location.href = "/";
           $('#hrel').html("您可以：&lt;<a href='javascript:;' onclick='topurl()' class='ml-20 c-primary'> 去首页</a>\
           			<span class='ml-10 mr-10'>|</span><a href='javascript:;' onclick='loginurl()'\ class='c-primary mr-20'>登录页面</a>\
           	&gt;");
	    }else{
	        // removeIframe();
	        $('#hrel').html("您可以：&lt;<a href='javascript:;' onclick='tebclose()' class='ml-20 mr-20 c-primary'> 关闭此页面</a>&gt;");
	    }
	})


	// 跳转到首页
	function topurl()
	{
        location.href = "/";
     }


     // 跳转到上一页
     function loginurl()
     {
     	location.href = '/login';
     }


     // 关闭页面
     function tebclose()
     {
     	removeIframe();
     }

</script>
</body>
</html>