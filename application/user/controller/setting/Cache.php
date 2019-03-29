<?
// +----------------------------------------------------------------------
// | User 
// +----------------------------------------------------------------------
// | 版权所有 2015-2020 晓明版权，并保留所有权利。
// +----------------------------------------------------------------------
// | 网站地址: https://huxiaoming.top
// +----------------------------------------------------------------------
// | 这不是一个自由软件！您只能在不用于商业目的的前提下使用本程序
// +----------------------------------------------------------------------
// | 不允许对程序代码以任何形式任何目的的再发布
// +----------------------------------------------------------------------
// | Author: 胡晓明    Date: 2018-12-01
// +----------------------------------------------------------------------
namespace app\user\controller\setting;
use app\user\controller\Controller;
use think\facade\Cache as Driver;
/**
 * 清理缓存
 * Class Index
 * @package app\user\controller
 */
class Cache extends Controller
{
    /**
     * 清理缓存
     * @param bool $isForce
     * @return mixed
     */
    public function clear($isForce = false)
    {
        if ($this->request->isAjax()) {
            $data = $this->postData('cache');
            $this->rmCache($data['keys'], isset($data['isForce']) ? !!$data['isForce'] : false);
            return $this->renderSuccess('操作成功');
        }
        return $this->fetch('clear', [
            'cacheList' => $this->getItems(),
            'isForce' => !!$isForce ?: config('app_debug'),
        ]);
    }
    /**
     * 数据缓存项目
     * @return array
     */
    private function getItems()
    {
        $app_id = $this->store['app']['app_id'];
        return [
            'setting' => [
                'type' => 'cache',
                'key' => 'setting_' . $app_id,
                'name' => '商城设置'
            ],
            'category' => [
                'type' => 'cache',
                'key' => 'category_' . $app_id,
                'name' => '商品分类'
            ],
            'app' => [
                'type' => 'cache',
                'key' => 'app_' . $app_id,
                'name' => '小程序设置'
            ],
            'temp' => [
                'type' => 'file',
                'name' => '临时图片',
                'dirPath' => [
                    'web' => WEB_PATH . 'temp/'. $app_id ,
                    'runtime' => RUNTIME_PATH .  '/image/' .  $app_id 
                ]
            ],
        ];
    }
    /**
     * 删除缓存
     * @param $keys
     * @param bool $isForce
     */
    private function rmCache($keys, $isForce = false)
    {
        if ($isForce === true) {
            Driver::clear();
        } else {
            $cacheList = $this->getItems();
            $keys = array_intersect(array_keys($cacheList), $keys);
            foreach ($keys as $key) {
                $item = $cacheList[$key];
                if ($item['type'] === 'cache') {
                    Driver::has($item['key']) && Driver::rm($item['key']);
                } elseif ($item['type'] === 'file') {
                    $this->deltree($item['dirPath']);
                }
            }
        }
    }
    /**
     * 删除目录下所有文件
     * @param $dirPath
     * @return bool
     */
    private function deltree($dirPath)
    {
        if (is_array($dirPath)) {
            foreach ($dirPath as $path)
                $this->deleteFolder($path);
        } else {
            return $this->deleteFolder($dirPath);
        }
        return true;
    }
    /**
     * 递归删除指定目录下所有文件
     * @param $path
     * @return bool
     */
    private function deleteFolder($path)
    {
        if (!is_dir($path))
            return false;
        // 扫描一个文件夹内的所有文件夹和文件
        foreach (scandir($path) as $val) {
            // 排除目录中的.和..
            if (!in_array($val, ['.', '..'])) {
                // 如果是目录则递归子目录，继续操作
                if (is_dir($path . $val)) {
                    // 子目录中操作删除文件夹和文件
                    $this->deleteFolder($path . $val . DS);
                    // 目录清空后删除空文件夹
                    rmdir($path . $val . DS);
                } else {
                    // 如果是文件直接删除
                    unlink($path . $val);
                }
            }
        }
        return true;
    }
}