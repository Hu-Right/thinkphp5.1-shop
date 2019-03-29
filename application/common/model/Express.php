<?
// +----------------------------------------------------------------------
// | Common 
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
namespace app\common\model;
use think\facade\Request;
use app\common\library\express\Kuaidi100;
/**
 * 物流公司模型
 * Class Express
 * @package app\common\model
 */
class Express extends BaseModel
{
    protected $name = 'express';
	protected $pk = 'express_id';
    /**
     * 获取全部
     * @return mixed
     */
    public static function getAll()
    {
        $model = new static;
        return $model->order(['sort' => 'asc'])->select();
    }
    /**
     * 获取列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->order(['sort' => 'asc'])
            ->paginate(15, false, [
                'query' => Request::instance()->request()
            ]);
    }
    /**
     * 物流公司详情
     * @param $express_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($express_id)
    {
        return self::get($express_id);
    }
    /**
     * 获取物流动态信息
     * @param $express_name
     * @param $express_code
     * @param $express_no
     * @return array|bool
     */
    public function dynamic($express_name, $express_code, $express_no)
    {
        $data = [
            'express_name' => $express_name,
            'express_no' => $express_no
        ];
        // 实例化快递100类
        $config = Setting::getItem('store');
        $Kuaidi100 = new Kuaidi100($config['kuaidi100']);
        // 请求查询接口
        $data['list'] = $Kuaidi100->query($express_code, $express_no);
        if ($data['list'] === false) {
            $this->error = $Kuaidi100->getError();
            return false;
        }
        return $data;
    }
 /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['app_id'] = self::$app_id;
        return $this->allowField(true)->save($data);
    }
    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        return $this->allowField(true)->save($data);
    }
    /**
     * 删除记录
     * @return bool|int
     */
    public function remove()
    {
        // 判断当前物流公司是否已被订单使用
        $Order = new Order;
        if ($orderCount = $Order->where(['express_id' => $this['express_id']])->count()) {
            $this->error = '当前物流公司已被' . $orderCount . '个订单使用，不允许删除';
            return false;
        }
        return $this->delete();
    }
}