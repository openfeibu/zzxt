<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/25
 * Time: 17:35
 */

namespace app\home\controller;

use app\home\model\ScholarshipsApplyStatus;
use app\home\model\MultipleScholarship;
use app\home\model\NationalScholarship;
use tests\thinkphp\library\think\hookTest;
use think\Db;
class Publicity extends Base
{
    private $multiple;
    private $national;
    private $applyStatus;
    private $faculty;

    public function __construct()
    {
        parent::__construct();
        $this->faculty = 5;
        $this->multiple = new MultipleScholarship();
        $this->national = new NationalScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();
    }

    /**
     * 助学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function grantsPublicity($id,$type_id) {
        if (request()->isPost()){
            $data = request()->post();
            if (isset($data['department']) and !empty($data['department'])) {
                unset($data['department']);
                $open_time = Db::table('yf_set_subsidy')
                    ->where('id', 6)
                    ->find();
                $this->assign('open_time',$open_time);
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                    ->field('ms.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 3)
//                ->where('ms.publicity_begin < ' . time())
//                ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            } else {
                unset($data['school']);
                $open_time = Db::table('yf_set_subsidy')
                    ->where('id', 7)
                    ->find();
                $this->assign('open_time',$open_time);
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                    ->field('ms.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 4)
//                ->where('ms.office_begin < ' . time())
//                ->where('ms.office_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            }
            return $this->view->fetch(':student_notice/grants_notice');
        }
        if ($id == 1) {
            //院系
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 6)
                ->find();
            $this->assign('open_time',$open_time);
            if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                    ->field('ms.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 3)
    //                ->where('ms.publicity_begin < ' . time())
    //                ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            }
        } else {
            //全院
            $data = Db::table('yf_apply_scholarships_status')
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                ->field('ms.*,u.*')
                ->where('ass.fund_type', $type_id)
                ->where('ass.status', 4)
//                ->where('ms.office_begin < ' . time())
//                ->where('ms.office_end >' . time())
                ->where('u.faculty_number', $this->faculty)
                ->paginate(20);
            $this->assign('list', $data);
        }
        return $this->view->fetch(':student_notice/grants_notice');
    }

    /**
     * 国家励志奖学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function motivPublicity($id,$type_id) {
        if (request()->isPost()){
            $data = request()->post();
            if (isset($data['department']) and !empty($data['department'])) {
                unset($data['department']);
                $open_time = Db::table('yf_set_subsidy')
                    ->where('id', 6)
                    ->find();
                $this->assign('open_time',$open_time);
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                    ->field('ms.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 3)
//                ->where('ms.publicity_begin < ' . time())
//                ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            } else {
                unset($data['school']);
                $open_time = Db::table('yf_set_subsidy')
                    ->where('id', 7)
                    ->find();
                $this->assign('open_time',$open_time);
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                    ->field('ms.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 4)
//                ->where('ms.office_begin < ' . time())
//                ->where('ms.office_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            }
            return $this->view->fetch(':student_notice/motiv_notice');
        }
        if ($id == 1) {
            //全系
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 6)
                ->find();
            $this->assign('open_time',$open_time);
            if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                    ->field('ms.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 3)
//                ->where('ms.publicity_begin < ' . time())
//                ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            }
        } else {
            //全院
            $data = Db::table('yf_apply_scholarships_status')
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                ->field('ms.*,u.*')
                ->where('ass.fund_type', $type_id)
                ->where('ass.status', 3)
//                ->where('ms.office_begin < ' . time())
//                ->where('ms.office_end >' . time())
                ->where('u.faculty_number', $this->faculty)
                ->paginate(20);
            $this->assign('list', $data);
        }
        return $this->view->fetch(':student_notice/motiv_notice');
    }

    /**
     * 国家奖学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function scholarPublicity($id,$type_id) {
        if (request()->isPost()){
            $data = request()->post();
            if (isset($data['department']) and !empty($data['department'])) {
                unset($data['department']);
                $open_time = Db::table('yf_set_subsidy')
                    ->where('id', 6)
                    ->find();
                $this->assign('open_time',$open_time);
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_national_scholarship ms', 'ms.national_id = ass.national_id', 'left')
                    ->field('ms.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 3)
//                    ->where('ms.publicity_begin < ' . time())
//                    ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            } else {
                unset($data['school']);
                $open_time = Db::table('yf_set_subsidy')
                    ->where('id', 7)
                    ->find();
                $this->assign('open_time',$open_time);
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_national_scholarship ms', 'ms.national_id = ass.national_id', 'left')
                    ->field('ms.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 4)
//                    ->where('ms.office_begin < ' . time())
//                    ->where('ms.office_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            }
            return $this->view->fetch(':student_notice/scholar_notice');
        }
        if ($id == 1) {
            //全系
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 6)
                ->find();
            $this->assign('open_time',$open_time);
            if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
                $data = Db::table('yf_apply_scholarships_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_national_scholarship ns', 'ns.national_id = ass.national_id', 'left')
                    ->field('ns.*,u.*')
                    ->where('ass.fund_type', $type_id)
                    ->where('ass.status', 3)
//                ->where('ms.publicity_begin < ' . time())
//                ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
//                halt($data);
                $this->assign('list', $data);
            }
        } else {
            //全院
            $data = Db::table('yf_apply_scholarships_status')
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                ->field('ms.*,u.*')
                ->where('ass.fund_type', $type_id)
                ->where('ass.status', 3)
//                ->where('ms.office_begin < ' . time())
//                ->where('ms.office_end >' . time())
                ->where('u.faculty_number', $this->faculty)
                ->paginate(20);
            $this->assign('list', $data);
        }
        return $this->view->fetch(':student_notice/scholar_notice');
    }

    public function evaluPublicity() {
        if (request()->isPost()){
            $data = request()->post();
            if (isset($data['department']) and !empty($data['department'])) {
                unset($data['department']);
                $open_time = Db::table('yf_set_subsidy')
                    ->where('id', 6)
                    ->find();
                $this->assign('open_time',$open_time);
                $data = Db::table('yf_evaluation_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_evaluation_application ns', 'ns.evaluation_id = ass.evaluation_id', 'left')
                    ->field('ns.*,u.*')
                    ->where('ass.status', 4)
//                ->where('ms.publicity_begin < ' . time())
//                ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            } else {
                unset($data['school']);
                $open_time = Db::table('yf_set_subsidy')
                    ->where('id', 7)
                    ->find();
                $this->assign('open_time',$open_time);
                $data = Db::table('yf_evaluation_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_evaluation_application ns', 'ns.evaluation_id = ass.evaluation_id', 'left')
                    ->field('ns.*,u.*')
                    ->where('ass.status', 5)
//                ->where('ms.publicity_begin < ' . time())
//                ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            }
            return $this->view->fetch(':student_notice/evalu_notice');
        }
            //全系
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 6)
                ->find();
            $this->assign('open_time',$open_time);
            if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
                $data = Db::table('yf_evaluation_status')
                    ->alias('ass')
                    ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                    ->join('yf_evaluation_application ns', 'ns.evaluation_id = ass.evaluation_id', 'left')
                    ->field('ns.*,u.*')
                    ->where('ass.status', 4)
//                ->where('ms.publicity_begin < ' . time())
//                ->where('ms.publicity_end >' . time())
                    ->where('u.faculty_number', $this->faculty)
                    ->paginate(20);
                $this->assign('list', $data);
            }

        return $this->view->fetch(':student_notice/evalu_notice');

    }
}