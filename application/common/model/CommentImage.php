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
 * 商品图片模型
 * Class CommentImage
 * @package app\common\model
 */
class CommentImage extends BaseModel
{
    protected $name = 'comment_image';
    protected $updateTime = false;
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'app_id',
        'create_time',
    ];
    /**
     * 关联文件库
     * @return \think\model\relation\BelongsTo
     */
    public function file()
    {	
        return $this->belongsTo('UploadFile', 'image_id', 'id')
            ->bind(['file_path', 'file_name', 'file_url']);
    }
}