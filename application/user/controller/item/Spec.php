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
namespace app\user\controller\item;
use app\user\controller\Controller;
use app\common\model\Spec as SpecModel;
use app\common\model\SpecValue as SpecValueModel;
/**
 * 商品规格控制器
 * Class Spec
 * @package app\common\controller
 */
class Spec extends Controller
{
    /* @var SpecModel $SpecModel */
    private $SpecModel;
    /* @var SpecValueModel $SpecModel */
    private $SpecValueModel;
    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        $this->SpecModel = new SpecModel;
        $this->SpecValueModel = new SpecValueModel;
    }
    /**
     * 添加规则组
     * @param $spec_name
     * @param $spec_value
     * @return array
     */
    public function addSpec($spec_name, $spec_value)
    {
        $specId = $this->SpecModel->getSpecIdByName($spec_name);
        // 判断规格组是否存在
        if (!$specId) {
            // 新增规格组and规则值
            $SpecModel= $this->SpecModel->add($spec_name);
            $SpecValueModel=$this->SpecValueModel->add($SpecModel['spec_id'], $spec_value);
            if ($SpecModel && $SpecValueModel)
                return $this->renderSuccess('', '', [
                    'spec_id' => (int)$SpecModel['spec_id'],
                    'spec_value_id' => (int)$SpecValueModel['spec_value_id'],
                ]);
            return $this->renderError();
        }
        // 判断规格值是否存在
        if ($specValueId = $this->SpecValueModel->getSpecValueIdByName($specId, $spec_value)) {
            return $this->renderSuccess('', '', [
                'spec_id' => (int)$specId,
                'spec_value_id' => (int)$specValueId,
            ]);
        }
        // 添加规则值
        if ($SpecValueModel=$this->SpecValueModel->add($specId, $spec_value))
            return $this->renderSuccess('', '', [
                'spec_id' => (int)$specId,
                'spec_value_id' => (int)$SpecValueModel['id'],
            ]);
        return $this->renderError();
    }
    /**
     * 添加规格值
     * @param $spec_id
     * @param $spec_value
     * @return array
     */
    public function addSpecValue($spec_id, $spec_value)
    {
        // 判断规格值是否存在
        $specValueId = $this->SpecValueModel->getSpecValueIdByName($spec_id, $spec_value);
        if ($specValueId) {
            return $this->renderSuccess('', '', [
                'spec_value_id' => (int)$specValueId,
            ]);
        }
        // 添加规则值
        $SpecValueModel=$this->SpecValueModel->add($spec_id, $spec_value);
        if ($SpecValueModel){
			
            return $this->renderSuccess('', '', [
                'spec_value_id' => (int)$SpecValueModel['spec_value_id'],
            ]);
		}
        return $this->renderError();
    }
}