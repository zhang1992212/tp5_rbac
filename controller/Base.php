<?php


namespace geek1992\tp5_rbac\controller;

use think\Config;
use think\Controller;
use think\Request;

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('VIEW_PATH') or define('VIEW_PATH', __DIR__ . DS .'..'.DS .'view'. DS);
defined('STATIC_PATH') or define('STATIC_PATH', DS.'public'.DS.'..'.DS .'vendor'.DS.'geek1992'.DS.'tp5_rbac'.DS.'view'. DS);

/**
 * @author: Geek <zhangjinlei01@bilibili.com>
 */
class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();
//        halt(STATIC_PATH);
        $this->assign('layout',VIEW_PATH);
        $this->view->engine->layout(VIEW_PATH  . 'layout.html');

    }

    public function _initialize()
    {
        $this->assign('admin_info', $admin_info = ['role_name'=>'a','name'=>'a']);
        $this->assign('menu_list', $menu_new_list= []);
    }
    
    public function myFetch($name = '', $vars = [], $replace = [], $config = [])
    {
        return parent::fetch(VIEW_PATH . $name . '.' . Config::get('url_html_suffix'), $vars = [], $replace = ['__ADMIN_STATIC__' => STATIC_PATH], $config = []);
    }




    /**
     * 注册样式文件
     */
    public function openFile(Request $request){
        $text       = '';
        $file       = explode('geek', $request->path());
        $extension  = substr(strrchr($file[1], '.'), 1);
        
        switch ($extension)
        {
            case 'css':
                $text = 'text/css';
                break;
            case 'js':
                $text = 'text/js';
                break;
            case  'woff':
                $text = 'woff';
                break;
            case  'png':
                $text = 'png';
                break;
            default:
                return false;
        }

        $pach = VIEW_PATH.'static/'.substr($file[1], 1);
        $file = file_get_contents($pach);
        return response($file, 200, ['Content-Length' => strlen($file)])->contentType($text);
    }
}