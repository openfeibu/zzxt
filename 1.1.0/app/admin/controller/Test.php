<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;
use think\Cache;
use think\helper\Time;
use app\admin\model\News as NewsModel;
use app\admin\model\MemberList;
use app\admin\model\Evaluation;

class Test extends Base
{
	public function index()
    {
        return $this->fetch();
    }
	public function import()
	{
		$member_model = new MemberList();
		$evaluation_model = new Evaluation();
		if (! empty ( $_FILES ['file_stu'] ['name'] )){
            $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
			$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
			$file_type = $file_types [count ( $file_types ) - 1];
			/*判别是不是.xls文件，判别是不是excel文件*/
			if ($file_type != "xls" && $file_type != "xlsx"){
				$this->error ( '不是Excel文件，重新上传',url('admin/Import/index'));
			}
			/*设置上传路径*/
			$savePath = ROOT_PATH. 'public/excel/';
			/*以时间来命名上传的文件*/
			$str = time ();
			$file_name = $str . "." . $file_type;
			if (! copy ( $tmp_file, $savePath . $file_name )){
				$this->error ('上传失败',url('admin/Import/index'));
			}
			$res = readWithSuffix ( $savePath . $file_name ,$file_type);
			if (!$res){
				$this->error ('数据处理失败',url('admin/Import/index'));
			}
			foreach($res as $key => $val)
			{
				$grade_name = trim($val[2]);
				$grade = DB::name('evaluation_grade')->where('name',$grade_name)->value('id');
				if(!$grade)
				{
					//$this->error($val[0].$val[1]."数据不正确");
					var_dump($val[0].$val[1]."困难认定字段不正确");
				}else{
					
					$res[$key][3] = $grade;
					$member_list_id = DB::name('member_list')->alias('m')
						->join('yf_user u', 'u.id_number = m.id_number', 'left')
						->where('u.studentid',trim($val[0]))
						->value('member_list_id');
					if(!$member_list_id)
					{
						var_dump($val[0].$val[1]."不存在，请检查学号是否正确");
					}else{
						
						$evaluation = $evaluation_model->getMemberEvaluation($member_list_id);
						if(!$evaluation)
						{
							var_dump($val[0].$val[1]."未申请，请检查");
						}else
						{
							/*
							$array = array();
							$evdata = array();
							$array['name'] = '林淑贤';
							$array['time'] = time();
							if($grade == $evaluation['faculty_poor_grade'])
							{
								$array['text'] = '同意学院评级';
							}else{
								$array['text'] = '不同意学院评级';
							}
							$evdata['school_opinion'] = json_encode($array);
							$evdata['school_poor_grade'] = $grade;
							$evdata['evaluation_status'] = 5;
							Db::name("evaluation_application")
								->where('evaluation_id', $evaluation['evaluation_id'])
								->update($evdata);
							Db::name('evaluation_status')
								->where('evaluation_id', $evaluation['evaluation_id'])
								->update([
									'update_at' => time(),
									'status' => $evdata['evaluation_status']
								]);
							*/	
						}
					}	
				
				}
 			}
			var_dump($res);exit;
		}
	}
}