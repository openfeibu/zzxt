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


   
}