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
/**
 * 分销商用户模型
 * Class Apply
 * @package app\common\model\agent
 */
class User extends BaseModel
{
    protected $name = 'agent_user';
	/**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'create_time',
        'update_time',
    ];
    /**
     * 关联会员记录表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('app\common\model\User');
    }
    /**
     * 关联推荐人表
     * @return \think\model\relation\BelongsTo
     */
    public function referee()
    {
        return $this->belongsTo('app\common\model\User', 'referee_id')
            ->field(['user_id', 'nickName']);
    }
    /**
     * 获取分销商用户信息
     * @param $user_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($user_id)
    {
        return self::get($user_id, ['user', 'referee']);
    }
    /**
     * 是否为分销商
     * @param $user_id
     * @return bool
     * @throws \think\exception\DbException
     */
    public static function isAgentUser($user_id)
    {
        $agent = self::detail($user_id);
        return !!$agent && !$agent['is_delete'];
    }
    /**
     * 新增分销商用户记录
     * @param $user_id
     * @param $data
     * @return false|int
     * @throws \think\exception\DbException
     */
    public static function add($user_id, $data)
    {
        $model = static::detail($user_id) ?: new static;
        return $model->save(array_merge([
            'user_id' => $user_id,
            'is_delete' => 0,
            'app_id' => $model::$app_id
        ], $data));
    }
    /**
     * 发放分销商佣金
     * @param $user_id
     * @param $money
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function grantMoney($user_id, $money)
    {
        // 分销商详情
        $model = static::detail($user_id);
        if (!$model || $model['is_delete']) {
            return false;
        }
        // 累积分销商可提现佣金
        $model->setInc('money', $money);
        // 记录分销商资金明细
        Capital::add([
            'user_id' => $user_id,
            'flow_type' => 10,
            'money' => $money,
            'describe' => '订单佣金结算',
            'app_id' => $model['app_id'],
        ]);
        return true;
    }
/**
     * 获取分销商用户列表
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
	
		return $this->alias('agent')
            ->field('agent.*, user.nickName, user.avatarUrl')
            ->with(['referee'])
            ->join('user','user.user_id = agent.user_id')
            ->where('agent.is_delete', '=', 0)
			 ->where($where)
            ->order(['agent.create_time' => 'desc'])->paginate(15, false,[
            'query' => \request()->request()
        ]);
		
    }
    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        return $this->save(['is_delete' => 1]);
    }
    /**
     * 提现打款成功：累积提现佣金
     * @param $user_id
     * @param $money
     * @return false|int
     * @throws \think\exception\DbException
     */
    public static function totalMoney($user_id, $money)
    {
        $model = self::detail($user_id);
        return $model->save([
            'freeze_money' => $model['freeze_money'] - $money,
            'total_money' => $model['total_money'] + $money,
        ]);
    }
	/**
     * 资金冻结
     * @param $money
     * @return false|int
     */
    public function freezeMoney($money)
    {
        return $this->save([
            'money' => $this['money'] - $money,
            'freeze_money' => $this['freeze_money'] + $money,
        ]);
    }
    /**
     * 累计分销商成员数量
     * @param $agent_id
     * @param $level
     * @return int|true
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function setMemberInc($agent_id, $level)
    {
        $fields = [1 => 'first_num', 2 => 'second_num', 3 => 'third_num'];
        $model = static::detail($agent_id);
        return $model->setInc($fields[$level]);
    }
    /**
     * 提现驳回：解冻分销商资金
     * @param $user_id
     * @param $money
     * @return false|int
     * @throws \think\exception\DbException
     */
    public static function backFreezeMoney($user_id, $money)
    {
        $model = self::detail($user_id);
        return $model->save([
            'money' => $model['money'] + $money,
            'freeze_money' => $model['freeze_money'] - $money,
        ]);
    }
}