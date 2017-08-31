<?php
/**
 * Created by PhpStorm.
 * User: cai76
 * Date: 2017/7/28
 * Time: 10:28
 */

namespace app\home\controller;

use think\Db;
class UploadByAjax extends Base
{
    private $fiel =[];

    public function show()
    {
        $data = Db::table("identify_model")
            ->where('enable', 1)
            ->select();
        foreach ($data as $key => $row ){
            $data[$key]['cailiao'] = [];
            $data[$key]['score'] = json_decode($row['score'], true);
            foreach ($data[$key]['score'] as $k => $v) {
                foreach ($v as $kk => $vv) {
                    if ($kk !== "option_score")
                    array_push($data[$key]['cailiao'],$kk);
                }
            }
        }
        $this->assign('list',$data);
        return $this->view->fetch('./test');
    }


    public function uploads()
    {
        // 获取表单上传文件
        $files = request()->file();
        $post = request()->post();
        dump($files);
        halt($post);
        $time = date('Y', time());
        $data = Db::table("user_identify")
            ->where('user_id', $this->user_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->find();
//        dump($data);
        foreach($files as $key => $file){
            $field = explode('|', $key);
            $fie['field_name'] = $field[0];
            $fie['field_cailiao'] = $field[1];
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file[0]->move(ROOT_PATH . 'public' . DS . 'uploads'.DS."materials");
            if($info){
//                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                $this->fiel[$field[0]][$fie['field_cailiao']] = $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
        $this->fiel[$field[0]]=json_encode($this->fiel[$field[0]]);
        $model = Db::table('user_identify')
            ->where('user_id', $this->user_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->update($this->fiel);
        dump($model);
    }
}