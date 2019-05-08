
<?php
function get_file($file)
{
    $directory = \think\Config::get('tp5_rbac.style_directory');
    if (empty($directory)) {
        return urldecode(url('index/openFile', ['geek' => $file]));
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
<link href="<?php echo get_file('h-ui.admin/css/H-ui.login.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo get_file('h-ui.admin/css/style.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo get_file('lib/Hui-iconfont/1.0.8/iconfont.css'); ?>" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo get_file('lib/DD_belatedPNG_0.0.8a-min.js'); ?>" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->