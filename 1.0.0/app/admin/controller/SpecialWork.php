<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/1
 * Time: 11:49
 */

namespace app\admin\controller;

use PHPExcel;
use PHPExcel_IOFactory;

class SpecialWork extends Base
{
    public function index()
    {

    }

    public function upload()
    {
        if (request()->isAjax()) {
            $data = request()->post();
            $file = request()->file('Excel');
            $filename = $HTTP_POST_FILES['Excel'] ['name'];
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $this->office($info->getExtension(), $info->getSaveName());
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
    public function _readerExcel()
    {
        $type = 'Excel2007';
        $xlsReader = PHPExcel_IOFactory::createReader($type);
        $xlsReader->setReadDataOnly(true);
        $xlsReader->setLoadSheetsOnly(true);
        $dataArray = $Sheets->getSheet(0)->toArray();
        return $dataArray;
    }


}