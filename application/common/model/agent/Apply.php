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
namespace app\common\model\agent;
use app\common\model\BaseModel;
use app\common\model\agent\Apply as ApplyModel;
use app\common\service\Message;
use think\facade\Request;
/**
 * 分销商申请模型
 * Class Apply
 * @package app\common\model\agent
 */
class Apply extends BaseModel
{
    protected $name = 'agent_apply';
	protected $pk = 'apply_id';
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'create_time',
        'update_time',
    ];
    /**
     * 申请状态
     * @var array
     */
    public $applyStatus = [
        10 => '待审核',
        20 => '审核通过',
        30 => '驳回',
    ];
    /**
     * 获取器：申请时间
     * @param $value
     * @return false|string
     */
    public function getApplyTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }
    /**
     * 获取器：审核时间
     * @param $value
     * @return false|string
     */
    public function getAuditTimeAttr($value)
    {
        return $value > 0 ? date('Y-m-d H:i:s', $value) : 0;
    }
    /**
     * 关联推荐人表
     * @return \think\model\relation\BelongsTo
     */
    public function referee()
    {
		
      return $this->belongsTo('app\common\model\User','referee_id')
            ->field(['user_id', 'nickName']);
    }
    /**
     * 销商申请记录详情
     * @param $where
     * @return Apply|static
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        return self::get($where);
    }
	/**
     * 获取分销商申请列表
     * @param string $search
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($search = '')
    {
		if(!empty($search)){
			$where['user.nickName|apply.real_name|apply.mobile']=['user.nickName|apply.real_name|apply.mobile', 'like', "%$search%"];
		}else{
			$where='';
		}
		return $this->alias('apply')
            ->field('apply.*, user.nickName, user.avatarUrl')
            ->with(['referee'])
			 ->where($where)
            ->join('user','user.user_id = apply.user_id')
            ->order(['apply.create_time' => 'desc'])->paginate(15, false, [
             'query' => Request::instance()->request()
        ]);
	
    }
    /**
     * 分销商入驻审核
     * @param $data
     * @return bool
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function submit($data)
    {
        if ($data['apply_status'] == '30' && empty($data['reject_reason'])) {
            $this->error = '请填写驳回原因';
            return false;
        }
        $this->startTrans();
        if ($data['apply_status'] == '20') {
            // 新增分销商用户
            User::add($this['user_id'],[
                'real_name' => $this['real_name'],
                'mobile' => $this['mobile'],
                'referee_id' => $this['referee_id'],
            ]);
        }
        // 更新申请记录
        $data['audit_time'] = time();
	
        $this->allowField(true)->save($data);
        // 发送模板消息
        (new Message)->agent($this);
        $this->commit();
        return true;
    }
	/**
     * 是否为分销商申请中
     * @param $user_id
     * @return bool
     * @throws \think\exception\DbException
     */
    public static function isApplying($user_id)
    {
        $detail = self::detail(['user_id' => $user_id]);
        return $detail ? ((int)$detail['apply_status'] === 10) : false;
    }
    /**
     * 提交申请
     * @param $user
     * @param $name
     * @param $mobile
     * @return bool
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function apply_add($user, $name, $mobile)
    {
        // 成为分销商条件
        $config = Setting::getItem('condition');
        // 数据整理
        $data = [
            'user_id' => $user['user_id'],
            'real_name' => trim($name),
            'mobile' => trim($mobile),
            'referee_id' => Referee::getRefereeUserId($user['user_id'], 1),
            'apply_type' => $config['become'],
            'apply_time' => time(),
            'app_id' => self::$app_id,
        ];
        if ($config['become'] == 10) {
            $data['apply_status'] = 10;
        } elseif ($config['become'] == 20) {
            $data['apply_status'] = 20;
        }
        return $this->add($user, $data);
    }
    /**
     * 更新分销商申请信息
     * @param $user
     * @param $data
     * @return bool
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    private function add($user, $data)
    {
        // 实例化模型
        $model = self::detail(['user_id' => $user['user_id']]) ?: $this;
        // 更新记录
        $this->startTrans();
        try {
            // $data['create_time'] = time();
            // 保存申请信息
            $model->save($data);
            // 无需审核，自动通过
            if ($data['apply_type'] == 20) {
                // 新增分销商用户记录
                User::add($user['user_id'], [
                    'real_name' => $data['real_name'],
                    'mobile' => $data['mobile'],
                    'referee_id' => $data['referee_id']
                ]);
            }
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
}