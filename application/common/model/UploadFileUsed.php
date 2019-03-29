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
/**
 * 已上传文件使用记录表MO型
 * Class UploadFileUsed
 * @package app\common\model
 */
class UploadFileUsed extends BaseModel
{
    protected $name = 'upload_file_used';
	protected $updateTime = false;
    /**
     * 新增记录
     * @param $data
     * @return false|int
     */
    public function add($data) {
        return $this->save($data);
    }
    /**
     * 移除记录
     * @param $from_type
     * @param $file_id
     * @param null $from_id
     * @return int
     */
    public function remove($from_type, $file_id, $from_id = null)
    {
        $where = compact('from_type', 'id');
        !is_null($from_id) && $where['from_id'] = $from_id;
        return $this->where($where)->delete();
    }
}