<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use \think\Request;

$basename = Request::instance()->root();
if (pathinfo($basename, PATHINFO_EXTENSION) == 'php') {
    $basename = dirname($basename);
}
$configs= [
  // +----------------------------------------------------------------------
  // | 应用设置
  // +----------------------------------------------------------------------

  // 应用命名空间
    'app_namespace'          => 'app',
  // 应用调试模式
    'app_debug'              => false,
  // 应用Trace
    'app_trace'              => false,
  // 应用模式状态
    'app_status'             => '',
  // 是否支持多模块
    'app_multi_module'       => true,
  // 入口自动绑定模块
    'auto_bind_module'       => false,
  // 注册的根命名空间
    'root_namespace'         => [],
  // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
  // 默认输出类型
    'default_return_type'    => 'html',
  // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
  // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
  // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
  // 默认时区
    'default_timezone'       => 'PRC',
  // 是否开启多语言
    'lang_switch_on'         => false,
  // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
  // 默认语言
    'default_lang'           => 'zh-cn',
  // 应用类库后缀
    'class_suffix'           => false,
  // 控制器类后缀
    'controller_suffix'      => false,

  // +----------------------------------------------------------------------
  // | 模块设置
  // +----------------------------------------------------------------------

  // 默认模块名
    'default_module'         => 'home',
  // 禁止访问模块
    'deny_module_list'       => ['common'],
  // 默认控制器名
    'default_controller'     => 'Index',
  // 默认操作名
    'default_action'         => 'index',
  // 默认验证器
    'default_validate'       => '',
  // 默认的空控制器名
    'empty_controller'       => 'Error',
  // 操作方法后缀
    'action_suffix'          => '',
  // 自动搜索控制器
    'controller_auto_search' => false,

  // +----------------------------------------------------------------------
  // | URL设置
  // +----------------------------------------------------------------------

  // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
  // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
  // pathinfo分隔符
    'pathinfo_depr'          => '/',
  // URL伪静态后缀
    'url_html_suffix'        => 'html',
  // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
  // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
  // 是否开启路由
    'url_route_on'           => true,
  // 路由使用完整匹配
    'route_complete_match'   => false,
  // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
  // 是否强制使用路由
    'url_route_must'         => false,
  // 域名部署
    'url_domain_deploy'      => false,
  // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
  // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
  // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
  // 表单请求类型伪装变量
    'var_method'             => '_method',
  // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
  // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
  // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
  // 请求缓存有效期
    'request_cache_expire'   => null,

  // +----------------------------------------------------------------------
  // | 模板设置
  // +----------------------------------------------------------------------

    'template'               => [
      // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
      // 模板路径
        'view_path'    => '',
      // 模板后缀
        'view_suffix'  => 'html',
      // 模板文件名分隔符
        'view_depr'    => DS,
      // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
      // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
      // 标签库标签开始标记
        'taglib_begin' => '{',
      // 标签库标签结束标记
        'taglib_end'   => '}',
    ],
    'view_replace_str' => [
        '__ROOT__'   => $basename,
        '__DATA__'   => $basename . '/data',
        '__PUBLIC__' => $basename . '/public',
        '__UPLOAD__'=> $basename . '/data/upload',
    ],
  // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => ROOT_PATH . 'public/yfcmf/dispatch_jump.html',

  // +----------------------------------------------------------------------
  // | 异常及错误设置
  // +----------------------------------------------------------------------

  // 异常页面的模板文件
    'exception_tmpl'         => ROOT_PATH . 'public/yfcmf/error.html',

  // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
  // 显示错误信息
    'show_error_msg'         => false,
  // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

  // +----------------------------------------------------------------------
  // | 日志设置
  // +----------------------------------------------------------------------

    'log'                    => [
      // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'File',
      // 日志保存目录
        'path'  => LOG_PATH,
      // 日志记录级别
        'level' => [],
    ],

  // +----------------------------------------------------------------------
  // | Trace设置 开启 app_trace 后 有效
  // +----------------------------------------------------------------------
    'trace'                  => [
      // 内置Html Console 支持扩展
        'type' => 'Html',
    ],

  // +----------------------------------------------------------------------
  // | 缓存设置
  // +----------------------------------------------------------------------

    'cache'                  => [
      // 驱动方式
        'type'   => 'File',
      // 缓存保存目录
        'path'   => CACHE_PATH,
      // 缓存前缀
        'prefix' => '',
      // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],

  // +----------------------------------------------------------------------
  // | 会话设置
  // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
      // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
      // SESSION 前缀
        'prefix'         => 'think',
      // 驱动方式 支持redis memcache memcached
        'type'           => '',
      // 是否自动开启 SESSION
        'auto_start'     => true,
    ],

  // +----------------------------------------------------------------------
  // | Cookie设置
  // +----------------------------------------------------------------------
    'cookie'                 => [
      // cookie 名称前缀
        'prefix'    => '',
      // cookie 保存时间
        'expire'    => 3600*24*7,
      // cookie 保存路径
        'path'      => '/',
      // cookie 有效域名
        'domain'    => '',
      //  cookie 启用安全传输
        'secure'    => false,
      // httponly设置
        'httponly'  => '',
      // 是否使用 setcookie
        'setcookie' => true,
    ],

  //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 10,
    ],
	//数据库备份设置
	'db_path'     => './data/backup/',     //数据库备份路径必须以 / 结尾；
	'db_part'     => '20971520',  //该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M
	'db_compress' => '1',         //压缩备份文件需要PHP环境支持gzopen,gzwrite函数        0:不压缩 1:启用压缩
	'db_level'    => '9',         //压缩级别   1:普通   4:一般   9:最高
	//数据加密
	'data_auth_key'=>'GLZpriHMdRo5Slmau9zeFxkhIBNwPEOyW6104UT3',
	//验证码
	'verify'=>[
		'fontSize' => 20,
		'fontttf'=>'4.ttf',
		'imageH' => 42,
		'imageW' => 250,
		'length' => 5,
		'useCurve' => false,
	],
	'status_stu' => [
        '1' => '班级评议中',
        '2' => '班级评议中',
        '3' => '学院评议中',
        '4' => '等待公示',
        '5' => '认定通过',
        '6' => '班级已否决',
        '7' => '班级已否决',
        '8' => '学院已否决',
        '9' => '认定不通过',
    ],
    'evaluation_status' => [
        '1' => '班级评议中',
        //'2' => '班级评议中',
        '3' => '学院评议中',
        '4' => '等待公示',
        '5' => '认定通过',
        //'6' => '班级已否决',
        '7' => '班级已否决',
        '8' => '学院已否决',
        '9' => '认定不通过',
    ],
    'check_status' => [
        '1' => '班级评议中',
        //'2' => '班级评议中',
        '3' => '学院评议中',
        '4' => '等待公示',
        '5' => '认定通过',
        //'6' => '班级已否决',
        '7' => '班级已否决',
        '8' => '学院已否决',
        '9' => '认定不通过',
    ],
    'application_type' => [
        '1' => '奖学金',
        '2' => '励志奖学金',
        '3' => '助学金',
    ],
    'eval_opinion' =>  [
        '该学生家庭情况属实，符合困难认定标准',
        '该学生家庭情况不实，与困难认定标准不符',
        '该学生家庭情况较严重，应适当加分',
        '该学生家庭情况较轻微，应适当减分',
    ],
    'eval_opinion2' =>  [
        '该学生家庭情况属实',
        '该学生家庭情况不实',
    ],
    'scholarships_opinion' =>  [
        '该学生情况属实',
        '该学生情况不实',
    ],
];
//动态设置
if(file_exists($file=ROOT_PATH."data/conf/config.php")){
  $configs=array_merge($configs,include ($file));
}
//调试模式,错误模板保持TP默认
if($configs['app_debug']){
    $configs['dispatch_success_tmpl']= THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl';
    $configs['dispatch_error_tmpl']= THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl';
    $configs['exception_tmpl']= THINK_PATH . 'tpl' . DS . 'think_exception.tpl';
}
return  $configs;
