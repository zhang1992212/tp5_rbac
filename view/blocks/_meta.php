<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo get_file('lib/html5.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_file('lib/respond.min.js'); ?>"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo get_file('h-ui/css/H-ui.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_file('h-ui.admin/css/H-ui.admin.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_file('lib/Hui-iconfont/1.0.8/iconfont.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_file('h-ui.admin/skin/default/skin.css'); ?>" id="skin" />
<link rel="stylesheet" type="text/css" href="<?php echo get_file('h-ui.admin/css/style.css'); ?>" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js'); ?>" ></script>
<script>DD_belatedPNG.fix('*');</script><![endif]-->
    <title>H-ui.admin v3.0</title>
    <meta name="keywords" content="H-ui.admin v3.0,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.0，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<?php
function get_file($file){
    $directory =  \think\Config::get('tp5_rbac.style_directory');
    if(empty($directory)){
        return url('index/openFile', '', '') . '/geek/' . $file;
    }else{
        $file       = strtr($file, '_', DS);
        return $directory.$file;
    }
}
?>