<?php
namespace geek1992\tp5_rbac;
require __DIR__  . '/vendor/autoload.php';
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('VIEW_PATH') or define('VIEW_PATH', __DIR__ . DS .'view'. DS);

class Index {
    const  PATH                 = __DIR__;
    public $log                 = true;
    public $noNeedCheckRules    = [];           //不需要检查的路由规则
    private $module;
    private $request;
    private $param;
    private $controller;
    private $action;

    public function __construct()
    {
        $this->request      = \think\Request::instance();
        $this->param        = $this->request->param();
        $this->module       = $this->request->module();
        $this->controller   = $this->request->controller();
        $this->action       = $this->request->action();
    }

    /**
     * 加载控制器方法
     * @access public
     * @param  string  $name 方法名
     * @return mixed
     */
    public function autoload($name){

        $controller = new \geek1992\tp5_rbac\controller\Rbac($this->request);
        $this->controller = 'auth';
        if(strtolower($this->controller) == 'auth' && method_exists($controller,$name)){

            return  call_user_func([$controller, $name]);
        }
        return false;
    }
}