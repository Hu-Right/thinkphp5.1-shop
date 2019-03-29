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
use app\common\exception\BaseException;
use think\facade\Cache;
use think\Db;
/**
 * 微信小程序模型
 * Class App
 * @package app\common\model
 */
class App extends BaseModel
{
	protected $name = 'app';
    protected $pk = 'app_id';
	protected $hidden = [
        'id',
        'app_name',
        'appid',
        'service_image_id',
        'phone_image_id',
        'mchid',
        'apikey',
        'create_time',
        'update_time'
    ];
    /**
     * 小程序导航
     * @return \think\model\relation\HasOne
     */
    public function navbar()
    {
        return $this->hasOne('AppNavbar');
    }
    /**
     * 小程序页面
     * @return \think\model\relation\HasOne
     */
    public function diyPage()
    {
        return $this->hasOne('AppPage');
    }
    /**
     * 在线客服图标
     * @return \think\model\relation\BelongsTo
     */
    public function serviceImage()
    {
        return $this->belongsTo('uploadFile', 'service_image_id');
    }
    /**
     * 电话客服图标
     * @return \think\model\relation\BelongsTo
     */
    public function phoneImage()
    {
        return $this->belongsTo('uploadFile', 'phone_image_id');
    }
    /**
     * 获取小程序信息
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
		
        return self::get([], ['serviceImage', 'phoneImage']);
		
    }
    /**
     * 从缓存中获取小程序信息
     * @param null $app_id
     * @return mixed|null|static
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    public static function getAppCache($app_id = null)
    {
		
        if (is_null($app_id)) {
            $self = new static();
            $app_id = $self::$app_id;
        }
        if (!$data = Cache::get('app_' . $app_id)) {
            $data = self::get($app_id, ['serviceImage', 'phoneImage', 'navbar']);
			
            if (empty($data)) throw new BaseException(['msg' => '未找到当前小程序信息']);
            Cache::set('app_' . $app_id, $data);
        }
		
        return $data;
    }
    /**
     * 创建小程序
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function add($data)
    {
        Db::startTrans();
        // 添加小程序记录
        $this->save($data);
        // 商城默认设置
        $Setting = new Setting;
        $Setting->insertDefault($data['app_id'], $data['app_name']);
        // 新增商家用户信息
        $StoreUser = new StoreUser;
        $StoreUser->insertDefault($data['app_id']);
        // 新增小程序默认帮助
        $Help = new AppHelp;
        $Help->insertDefault($data['app_id']);
        // 新增小程序导航栏默认设置
        $Navbar = new AppNavbar;
        $Navbar->insertDefault($data['app_id'], $data['app_name']);
        // 新增小程序diy配置
        $Page = new AppPage;
        $Page->insertDefault($data['app_id']);
        Db::commit();
        return true;
    }
	 /**
     * 更新小程序设置
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        // 在线客服图标
        $service_image = isset($data['service_image']) ? $data['service_image'] : null;
        $data['service_image_id'] = $this->uploadImage(
            $this->app_id,
            $this->service_image_id,
            $service_image,
            'service'
        );
        // 电话客服图标
        $phone_image = isset($data['phone_image']) ? $data['phone_image'] : null;
        $data['phone_image_id'] = $this->uploadImage(
            $this->app_id,
            $this->phone_image_id,
            $phone_image,
            'service.phone'
        );
        // 删除app缓存
        self::deleteCache();
        return $this->allowField(true)->save($data) !== false ?: false;
    }
    /**
     * 记录图片信息
     * @param $app_id
     * @param $oldFileId
     * @param $newFileName
     * @param $fromType
     * @return int|mixed
     */
    private function uploadImage($app_id, $oldFileId, $newFileName, $fromType)
    {
//        $UploadFile = new UploadFile;
        $UploadFileUsed = new UploadFileUsed;
        if ($oldFileId > 0) {
            // 获取原图片path
            $oldFileName = UploadFile::getFileName($oldFileId);
            // 新文件与原来路径一致, 代表用户未修改, 不做更新
            if ($newFileName === $oldFileName)
                return $oldFileId;
            // 删除原文件使用记录
            $UploadFileUsed->remove('service', $oldFileId);
        }
        // 删除图片
        if (empty($newFileName)) return 0;
        // 查询新文件file_id
        $fileId = UploadFile::getFildIdByName($newFileName);
        // 添加文件使用记录
        $UploadFileUsed->add([
            'id' => $fileId,
            'app_id' => $app_id,
            'from_type' => $fromType
        ]);
        return $fileId;
    }
    /**
     * 删除app缓存
     * @return bool
     */
    public static function deleteCache()
    {
        return Cache::rm('app_' . self::$app_id);
    }
}