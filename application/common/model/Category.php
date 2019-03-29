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
use think\facade\Cache;
/**
 * 商品分类模型
 * Class Category
 * @package app\common\model
 */
class Category extends BaseModel
{
    protected $name = 'category';
	protected $pk = 'Category_id';
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'app_id',
//        'create_time',
        'update_time'
    ];
    /**
     * 分类图片
     * @return \think\model\relation\HasOne
     */
    public function image()
    {	
        return $this->hasOne('uploadFile', 'id', 'image_id');
		
    }
    /**
     * 所有分类
     * @return mixed
     */
    public static function getALL()
    {
        $model = new static;
        if (!Cache::get('category_' . self::$app_id)) {
			$data = $model->with(['image'])->order(['sort' => 'asc'])->select();
            $all = !empty($data) ? $data->toArray() : [];
			
            $tree = [];
            foreach ($all as $first) {
                if ($first['parent_id'] !== 0) continue;
                $twoTree = [];
                foreach ($all as $two) {
                    if ($two['parent_id'] !== $first['category_id']) continue;
                    $threeTree = [];
                    foreach ($all as $three)
                        $three['parent_id'] === $two['category_id']
                        && $threeTree[$three['category_id']] = $three;
                    !empty($threeTree) && $two['child'] = $threeTree;
                    $twoTree[$two['category_id']] = $two;
                }
                if (!empty($twoTree)) {
                    array_multisort(array_column($twoTree, 'sort'), SORT_ASC, $twoTree);
                    $first['child'] = $twoTree;
                }
                $tree[$first['category_id']] = $first;
            }
            Cache::set('category_' . self::$app_id, compact('all', 'tree'));
        }
        return Cache::get('category_' . self::$app_id);
    }
    /**
     * 获取所有分类
     * @return mixed
     */
    public static function getCacheAll()
    {	
		
        return self::getALL()['all'];
    }
    /**
     * 获取所有分类(树状结构)
     * @return mixed
     */
    public static function getCacheTree()
    {
        return self::getALL()['tree'];
	
    }
    /**
     * 获取指定分类下的所有子分类id
     * @param $parent_id
     * @param array $all
     * @return array
     */
    public static function getSubCategoryId($parent_id, $all = [])
    {
		
        $arrIds = [$parent_id];
        empty($all) && $all = self::getCacheAll();
        foreach ($all as $key => $item) {
            if ($item['parent_id'] == $parent_id) {
                unset($all[$key]);
                $subIds = self::getSubCategoryId($item['category_id'], $all);
                !empty($subIds) && $arrIds = array_merge($arrIds, $subIds);
            }
        }
        return $arrIds;
    }
	/**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['app_id'] = self::$app_id;
//        if (!empty($data['image'])) {
//            $data['image_id'] = UploadFile::getFildIdByName($data['image']);
//        }
        $this->deleteCache();
        return $this->allowField(true)->save($data);
    }
    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
		
        $this->deleteCache();
        return $this->allowField(true)->save($data);
    }
    /**
     * 删除商品分类
     * @param $category_id
     * @return bool|int
     */
    public function remove($category_id)
    {
        // 判断是否存在商品
        if ($itemCount = (new Item)->getitemTotal(['category_id' => $category_id])) {
            $this->error = '该分类下存在' . $itemCount . '个商品，不允许删除';
            return false;
        }
        // 判断是否存在子分类
        if ((new self)->where(['parent_id' => $category_id])->count()) {
            $this->error = '该分类下存在子分类，请先删除';
            return false;
        }
        $this->deleteCache();
        return $this->delete();
    }
    /**
     * 删除缓存
     * @return bool
     */
    private function deleteCache()
    {
        return Cache::rm('category_' . self::$app_id);
    }
}