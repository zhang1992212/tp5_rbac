<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
    <?php
    function get_file($file)
    {
        $directory = \think\Config::get('tp5_rbac.style_directory');
        if (empty($directory)) {
            return url('index/openFile', explode('/', $file));
        }
        $file = strtr($file, '_', DS);

        return $directory.$file;
    }
    ?>
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo get_file('lib/html5shiv.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_file('lib/respond.min.js'); ?>"></script>

<![endif]-->
<link href="<?php echo get_file('h-ui/css/H-ui.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo get_file('h-ui.admin/css/H-ui.admin.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo get_file('lib/Hui-iconfont/1.0.8/iconfont.css'); ?>" rel="stylesheet" type="text/css" />

<!--[if IE 6]>
<script type="text/javascript" src="<?php echo get_file('lib/DD_belatedPNG_0.0.8a-min.js'); ?>" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>空白页</title>
</head>
<body>
<div class="pd-20">
  这是一个空白页
</div>
<script type="text/javascript" src="<?php echo get_file('lib/jquery/1.9.1/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_file('lib/layer/2.4/layer.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_file('lib/jquery.validation/1.14.0/jquery.validate.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_file('lib/jquery.validation/1.14.0/validate-methods.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_file('lib/jquery.validation/1.14.0/messages_zh.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_file('h-ui/js/H-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo get_file('h-ui.admin/js/H-ui.admin.js'); ?>"></script>
</body>
</html>