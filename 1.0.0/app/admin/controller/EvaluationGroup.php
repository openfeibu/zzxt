<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/18
 * Time: 15:01
 */

namespace app\admin\controller;
use think\Db;
use think\Config;
use think\Request;
use app\admin\model\Evaluation;

class EvaluationGroup extends Base
{
    private $user;
    private $time;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        //$this->user = '201555352';
		$this->class_number = $this->admin['class_number'];
        $this->time = date("Y",time());
    }

    /**
     * 获取申请学生列表(评估系统)
     */
    public function showEvaluationList() {
        //$where['ass.status'] = array('in','1,3,4');
        if(request()->isPost()) {
            $data = request()->post();
            if (!empty($data['studentname'])) {
                //学号或名字查询
                if (strlen($data['studentname']) == 11) {
                    $studentname = "studentid = '".$data['studentname']."'";
                } else {
                    $studentname = "studentname = '".$data['studentname']."'";
                }
            } else {
                $studentname = '';
            }
            //选择状态
            if (!empty($data['assess'])) {
                if ($data['assess'] == 1) {
                    $status = "status <> '".$data['assess']."'";
                }
                elseif ($data['assess'] == 2) {
                    $status = "status = '".$data['assess']."'";
                }
                else {
                    $status = '';
                }
            } else {
                $status = '';
            }

            //查询未审核人数
            $no_count = Db::table('yf_evaluation_status')
                ->alias('ass')
                ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                ->join('yf_user u', 'u.id_number = m.id_number', 'left')
			    ->where("u.class_number = '".$this->class_number."'")
                ->where("CONVERT(VARCHAR(4),DATEADD(S,ass.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
                ->where('ass.status',2)
                ->count();
            if (empty($no_count)) {
                $no_count = 0;
            }
            $yes_count = Db::table('yf_evaluation_status')
                ->alias('ass')
                ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                ->join('yf_user u', 'u.id_number = m.id_number', 'left')
			    ->where("u.class_number = '".$this->class_number."'")
                ->where("CONVERT(VARCHAR(4),DATEADD(S,ass.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
                ->where('ass.status','<>',2)
                ->count();
            if (empty($yes_count)) {
                $yes_count = 0;
            }

            $data = Db::table('yf_evaluation_status')
                ->alias('ass')
                ->join('yf_evaluation_application app','ass.evaluation_id = app.evaluation_id','left')
                ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                ->order('score desc')
                ->where($studentname)
                ->where($status)
			->where("u.class_number = '".$this->class_number."'")
                ->where("CONVERT(VARCHAR(4),DATEADD(S,ass.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
                ->field('ass.*,app.assess_fraction,app.score,app.change_fraction,u.*')
                ->paginate(20);

            $data_data = Db::table('yf_evaluation_status')
                ->alias('ass')
                ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                ->join('yf_user u', 'u.id_number = m.id_number', 'left')
				->where("u.class_number = '".$this->class_number."'")
                ->where("CONVERT(VARCHAR(4),DATEADD(S,ass.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
                ->paginate(20);

            $this->assign('no_count',$no_count);
            $this->assign('yes_count',$yes_count);
            $this->assign('user',$data);

            return $this->view->fetch('evaluation/class_review');
        }
        //查找呃
        $where = "u.class_number = '".$this->class_number."' AND CONVERT(VARCHAR(4),DATEADD(S,ass.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time";
        $data = Evaluation::getEvaluationList($where);
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

        $data_arr = $data->all();
        $data_arr = Evaluation::handleEvaluationList($data_arr);

        //查询未审核人数
        $no_count = Db::table('yf_evaluation_status')
            ->alias('ass')
            ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
			->where("u.class_number = '".$this->class_number."'")
            ->where("CONVERT(VARCHAR(4),DATEADD(S,ass.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
            ->where('ass.status',2)
            ->count();
        if (empty($no_count)) {
            $no_count = 0;
        }
        $yes_count = Db::table('yf_evaluation_status')
            ->alias('ass')
            ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
			->where("u.class_number = '".$this->class_number."'")
            ->where("CONVERT(VARCHAR(4),DATEADD(S,ass.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
            ->where('ass.status','<>',2)
            ->count();
        if (empty($yes_count)) {
            $yes_count = 0;
        }
        $this->assign('no_count',$no_count);
        $this->assign('yes_count',$yes_count);
        $this->assign('user', $data_arr);
        $this->assign('page', $show);
        return $this->view->fetch('evaluation/class_review');
    }

    /**
     * 查看学生资料(评估系统)
     */
    public function showEvaluationMaterial($id) {
        $data = Db::table('yf_evaluation_status')
            ->where('status_id', $id)
            ->find();
        if (!$data) {
            return $this->error("该学生没有填写申请表");
        }
		$evaluation_model = new Evaluation();
        $apply = $evaluation_model->getEvaluation($data['evaluation_id']);

//        if (!empty($apply['awards'])) {
//            $apply['awards'] = json_decode($apply['awards'], true);
//        } else {
//            $apply['awards'][0]['date'] = '';
//            $apply['awards'][0]['name'] = '';
//            $apply['awards'][0]['unit'] = '';
//        }
        if (!empty($apply['group_opinion'])) {
            $apply['group_opinion'] = json_decode($apply['group_opinion'], true);
        } else {
            $apply['group_opinion']['text'] = '';
            $apply['group_opinion']['name'] = '';
            $apply['group_opinion']['time'] = time();
        }

        $this->assign('status_id', $id);
        $this->assign('user', $apply);
        $this->assign('user_info', $apply);
		$apply['members'] = unserialize($apply['members']);
		$this->assign('eval_app',$apply);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);


        return $this->view->fetch('evaluation/class_add_review');
    }

    /**
     * 修改分数、填写评定结果
     */
    public function evaluationPassing(Request $request) {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $data['evaluation_status'] = $status = 7;
                unset($data['fail']);
            } else {
                $data['evaluation_status'] = $status = 3;
                unset($data['pass']);
            }
            //构造评语什么的
            $array['text'] = $data['group_opinion']['text'];
            $array['name'] = $data['group_opinion']['name'];
            $array['time'] = strtotime($data['group_opinion']['year']."-".$data['group_opinion']['month']."-".$data['group_opinion']['day']);
            $data['group_opinion'] = json_encode($array);
            //状态表的id
            $id = $data['status_id'];
            $evaluation_id = $data['evaluation_id'];
            //删除没用的
            unset($data['status_id'],$data['evaluation_id']);
            //更新
			$evaluation_model = new Evaluation();
			$eval_app = $evaluation_model->getEvaluation($evaluation_id);
            // $material_score = $evaluation_model::getMaterilaScore($evaluation_id);
            // $data['assess_fraction'] = $material_score;
			$data['score'] = intval($eval_app['assess_fraction']) + intval($data['change_fraction']) ;
            $res = Db::table('yf_evaluation_application')
                ->where('evaluation_id',$evaluation_id)
                ->update($data);
            if (!$res) {
                $this->error("提交失败");
            }
            //更新申请状态
            $res = Db::table('yf_evaluation_status')
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->where('status_id', $id)
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                $this->error('插入状态失败');
            }
            $this->success("提交成功");
        }
    }
}
