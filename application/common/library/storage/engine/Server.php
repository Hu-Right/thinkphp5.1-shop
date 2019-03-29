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
use think\Exception;
use think\facade\Request;
/**
 * 存储引擎抽象类
 * Class server
 * @package app\common\library\storage\drivers
 */
abstract class Server
{
    protected $file;
    protected $error;
    protected $fileName;
    protected $fileInfo;
    /**
     * 构造函数
     * Server constructor.
     * @throws Exception
     */
    protected function __construct()
    {
        // 接收上传的文件
        $this->file = Request::instance()->file('iFile');
        if (empty($this->file)) {
            throw new Exception('未找到上传文件的信息');
        }
        // 生成保存文件名
        $this->fileName = $this->buildSaveName();
        // 文件信息
        $this->fileInfo = $this->file->getInfo();
    }
    /**
     * 文件上传
     * @return mixed
     */
    abstract protected function upload();
    /**
     * 返回上传后文件路径
     * @return mixed
     */
    abstract public function getFileName();
    /**
     * 返回文件信息
     * @return mixed
     */
    public function getFileInfo()
    {
        return $this->fileInfo;
    }
    /**
     * 返回错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
    /**
     * 生成保存文件名
     */
    private function buildSaveName()
    {
        // 要上传图片的本地路径
        $realPath = $this->file->getRealPath();
        // 扩展名
        $ext = pathinfo($this->file->getInfo('name'), PATHINFO_EXTENSION);
        // 自动生成文件名
        return date('YmdHis') . substr(md5($realPath), 0, 5)
            . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '.' . $ext;
    }
}