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
namespace app\common\library\storage\engine;
/**
 * 本地文件驱动
 * Class Local
 * @package app\common\library\storage\drivers
 */
class Local extends Server
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 上传图片文件
     * @return array|bool
     */
    public function upload()
    {
        // 上传目录
        $uplodDir = WEB_PATH . 'uploads';
        // 验证文件并上传
        $info = $this->file->validate(['size' => 4 * 1024 * 1024, 'ext' => 'jpg,jpeg,png,gif'])
            ->move($uplodDir, $this->fileName);
        if (empty($info)) {
            $this->error = $this->file->getError();
            return false;
        }
        return true;
    }
    /**
     * 返回文件路径
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}