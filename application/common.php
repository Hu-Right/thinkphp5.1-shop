<?php晓明版权
/**
 * web
 * ============================================================================
 * 版权所有 2015-2020 晓明版权，并保留所有权利。
 * 网站地址: https://huxiaoming.top
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * Author: 晓明
 * Date: 2018-12-01
 */
// 应用公共函数库文件
use think\facade\Request;
use think\facade\Log;
use think\facade\Url;
use app\user\service\Auth ;
/**
 * 打印调试函数
 * @param $content
 * @param $is_die
 */
function pre($content, $is_die = true)
{
    header('Content-type: text/html; charset=utf-8');
	
    echo '<pre>' . print_r($content, true);
    $is_die && die();
}
/**
 * 验证指定url是否有访问权限
 * @param string|array $url
 * @param bool $strict 严格模式
 * @return bool
 */
function checkPrivilege($url, $strict = true)
{
    try {
        return Auth::getInstance()->checkPrivilege($url, $strict);
    } catch (\Exception $e) {
        return false;
    }
}
/**
 * 驼峰命名转下划线命名
 * @param $str
 * @return string
 */
function toUnderScore($str)
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
        return '_' . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/_{2,}/', '_', $dstr), '_');
}
/**
 * 生成密码hash值
 * @param $password
 * @return string
 */
function wymall_pass($password)
{
    return md5(md5($password) . 'wymall_ok');
}
/**
 * 获取当前域名及根路径
 * @return string
 */
function base_url()
{
	
	\Url::root('index.php?s=');
    $request = Request::instance();
    $subDir = str_replace('\\', '/', dirname($request->server('PHP_SELF')));
    return $request->scheme() . '://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
}
/**
 * 写入日志
 * @param string|array $values
 * @param string $dir
 * @return bool|int
 */
function write_log($values, $dir)
{
    if (is_array($values))
        $values = print_r($values, true);
    // 日志内容
    $content = '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $values . PHP_EOL . PHP_EOL;
    try {
        // 文件路径
        $filePath = $dir . '/logs/';
        // 路径不存在则创建
        !is_dir($filePath) && mkdir($filePath, 0755, true);
        // 写入文件
        return file_put_contents($filePath . date('Ymd') . '.log', $content, FILE_APPEND);
    } catch (\Exception $e) {
        return false;
    }
}
/**
 * 写入日志 (使用tp自带驱动记录到runtime目录中)
 * @param $value
 * @param string $type
 * @return bool
 */
function log_write($value, $type = 'wymall-info')
{
    $msg = is_string($value) ? $value : print_r($value, true);
    return Log::write($msg, $type);
}
/**
 * curl请求指定url (get)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curl($url, $data = [])
{
    // 处理get数据
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}
/**
 * curl请求指定url (post)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curlPost($url, $data = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
if (!function_exists('array_column')) {
    /**
     * array_column 兼容低版本php
     * (PHP < 5.5.0)
     * @param $array
     * @param $columnKey
     * @param null $indexKey
     * @return array
     */
    function array_column($array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = is_object($subArray) ? $subArray->$columnKey : $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $index = is_object($subArray) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $index = is_object($subArray) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = is_object($subArray) ? $subArray->$columnKey : $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}
/**
 * 多维数组合并
 * @param $array1
 * @param $array2
 * @return array
 */
function array_merge_multiple($array1, $array2)
{
	
    $merge = $array1 + $array2;
    $data = [];
    foreach ($merge as $key => $val) {
        if (
            isset($array1[$key])
            && is_array($array1[$key])
            && isset($array2[$key])
            && is_array($array2[$key])
        ) {
            $data[$key] = array_merge_multiple($array1[$key], $array2[$key]);
        } else {
            $data[$key] = isset($array2[$key]) ? $array2[$key] : $array1[$key];
        }
    }
    return $data;
}
/**
 * 二维数组排序
 * @param $arr
 * @param $keys
 * @param bool $desc
 * @return mixed
 */
function array_sort($arr, $keys, $desc = false)
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($desc) {
        arsort($key_value);
    } else {
        asort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}
/**
 * 数据导出到excel(csv文件)
 * @param $fileName
 * @param array $tileArray
 * @param array $dataArray
 */
 function export_excel($fileName,$tileArray = [],$dataArray = [])
    {
        $file_name = "order-".(date('Ymdhis',time())).".csv";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$file_name );
        header('Cache-Control: max-age=0');
        $file = fopen('php://output',"a");
        $limit = 1000;
        $calc = 0;
        foreach ($tileArray as $v){
            $tit[] = iconv('UTF-8', 'GB2312//IGNORE',$v);
        }
        fputcsv($file,$tit);
        foreach ($dataArray as $v){
            $calc++;
            if($limit == $calc){
                ob_flush();
                flush();
                $calc = 0;
            }
            foreach($v as $t){
                $tarr[] = iconv('UTF-8', 'GB2312//IGNORE',$t);
            }
            fputcsv($file,$tarr);
            unset($tarr);
        }
        unset($list);
        fclose($file);
        exit();
    }
function left(){
	return [
		'index' => [
			'name' => '首页',
			'icon' => 'icon-home',
			'index' => 'index/index',
		],
		'user' => [
			'name' => '用户',
			'icon' => 'icon-user',
			'index' => 'user/index',
		],
		'item' => [
			'name' => '商品',
			'icon' => 'icon-goods',
			'index' => 'item/index',
			'submenu' => [
				[
					'name' => '商品分类',
					'index' => 'item.category/index',
					'uris' => [
						'item.category/index',
						'item.category/add',
						'item.category/edit',
					],
				],
				
				[
					'name' => '商品列表',
					'index' => 'item/index',
					'uris' => [
						'item/index',
						'item/add',
						'item/edit'
					],
				],
				[
					'name' => '回收站',
					'index' => 'item/end',
					'uris' => [
						'item/end',
						'item/add'
					],
				],
				[
					'name' => '商品评价',
					'index' => 'item.comment/index',
					'uris' => [
						'item.comment/index',
						'item.comment/detail',
					],
				]
			],
		],
		'order' => [
			'name' => '订单',
			'icon' => 'icon-order',
			'index' => 'order/delivery_list',
			'submenu' => [
				[
					'name' => '待发货',
					'index' => 'order/delivery_list',
				],
				[
					'name' => '待收货',
					'index' => 'order/receipt_list',
				],
				[
					'name' => '待付款',
					'index' => 'order/pay_list',
				],
				[
					'name' => '已完成',
					'index' => 'order/complete_list',
				],
				[
					'name' => '已取消',
					'index' => 'order/cancel_list',
				],
				[
					'name' => '全部订单',
					'index' => 'order/all_list',
				],
			]
		],
		
		'market' => [
			'name' => '营销',
			'icon' => 'icon-marketing',
			'index' => 'market.coupon/index',
			'submenu' => [
				[
					'name' => '优惠券',
					'active' => true,
					'submenu' => [
						[
							'name' => '优惠券列表',
							'index' => 'market.coupon/index',
							'uris' => [
								'market.coupon/index',
								'market.coupon/add',
								'market.coupon/edit',
							]
						],
						[
							'name' => '领取记录',
							'index' => 'market.coupon/receive'
						],
					]
				],
			],
		],
		'app' => [
			'name' => '小程序',
			'icon' => 'icon-wxapp',
			'color' => '#36b313',
			'index' => 'app/setting',
			'submenu' => [
				[
					'name' => '小程序设置',
					'index' => 'app/setting',
				],
				
				[
					'name' => '帮助中心',
					'index' => 'app.help/index',
					'uris' => [
						'app.help/index',
						'app.help/add',
						'app.help/edit'
					]
				],
			],
		],
		'tpl' => [
			'name' => '模板',
			'icon' => 'icon-camera',
			'index' => 'tpl/index',
			'submenu' => [
				[
					'name' => '页面管理',
					'active' => true,
					'submenu' => [
						[
							'name' => '页面设计',
							'index' => 'tpl/index',
							'uris' => [
								'tpl/index',
								'tpl/add',
								'tpl/edit',
							]
						],
						[
							'name' => '分类模板',
							'index' => 'tpl/category'
						],
						[
							'name' => '页面链接',
							'index' => 'tpl/links'
						]
					]
				],
			]
		],
		'apps' => [
			'name' => '分销',
			'icon' => 'icon-qrcode',
			'is_svg' => true,   // 多色图标
			'index' => 'apps.agent.apply/index',
			'submenu' => [
				[
					'name' => '分销中心',
					'active' => true,
					'submenu' => [
						[
							'name' => '入驻申请',
							'index' => 'apps.agent.apply/index',
						],
						[
							'name' => '分销商用户',
							'index' => 'apps.agent.user/index',
						],
						[
							'name' => '分销订单',
							'index' => 'apps.agent.order/index',
						],
						[
							'name' => '提现申请',
							'index' => 'apps.agent.withdraw/index',
						],
						[
							'name' => '分销设置',
							'index' => 'apps.agent.setting/index',
						],
						[
							'name' => '分销海报',
							'index' => 'apps.agent.setting/qrcode',
						],
					]
				]
			]
		],
		'store' => [
			'name' => '管理员',
			'icon' => 'icon-refresh',
			'index' => 'store.user/index',
			'submenu' => [
				[
					'name' => '管理员列表',
					'index' => 'store.user/index',
					'uris' => [
						'store.user/index',
						'store.user/add',
						'store.user/edit',
						'store.user/delete',
					],
				],
				[
					'name' => '角色管理',
					'index' => 'store.role/index',
					'uris' => [
						'store.role/index',
						'store.role/add',
						'store.role/edit',
						'store.role/delete',
					],
				],
			]
		],
		'setting' => [
			'name' => '设置',
			'icon' => 'icon-setting',
			'index' => 'setting/store',
			'submenu' => [
				[
					'name' => '商城设置',
					'index' => 'setting/store',
				],
				[
					'name' => '交易设置',
					'index' => 'setting/trade',
				],
				[
					'name' => '配送设置',
					'index' => 'setting.delivery/index',
					'uris' => [
						'setting.delivery/index',
						'setting.delivery/add',
						'setting.delivery/edit',
					],
				],
				[
					'name' => '物流公司',
					'index' => 'setting.express/index',
					'uris' => [
						'setting.express/index',
						'setting.express/add',
						'setting.express/edit',
					],
				],
				[
					'name' => '短信通知',
					'index' => 'setting/sms'
				],
				[
					'name' => '模板消息',
					'index' => 'setting/tplmsg',
					'uris' => [
						'setting/tplmsg',
						'setting.help/tplmsg'
					],
				],
				[
					'name' => '上传设置',
					'index' => 'setting/storage',
				],
				[
					'name' => '其他',
					'active' => true,
					'submenu' => [
						[
							'name' => '清理缓存',
							'index' => 'setting.cache/clear'
						],
						[
							'name' => '环境检测',
							'index' => 'setting.science/index'
						],
					]
				]
			],
		],
	];
}