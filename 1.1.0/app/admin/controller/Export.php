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
use app\admin\model\MemberList;
use app\home\model\ScholarshipsApplyStatus;
use app\home\model\MultipleScholarship;
use app\home\model\NationalScholarship;
use app\home\model\Scholarships;
use app\admin\model\User as UserModel;
use app\admin\model\Evaluation;
use app\admin\model\ClassCode as ClassCodeModel;

class Export extends Base
{
	public function __construct()
    {
		parent::__construct();
        $this->multiple = new MultipleScholarship();
		$this->national = new NationalScholarship();
		$this->scholarships = new Scholarships();
        $this->applyStatus = new ScholarshipsApplyStatus();
		$this->evaluation = new Evaluation();
		$this->classCode = new ClassCodeModel();
    }
	public function exportGrantsTablePdf()
	{
		require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/TCPDF.php');
		$pdf = new \tcpdf\TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor("广州飞步科技");
		$pdf->SetTitle("助学金申请表");
		$pdf->SetSubject('资助系统');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(6, 2,0);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(false);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//$pdf->SetFont('stsongstdlight', '', 13);

		$id = input('id');
		$id = 4;
		$type_id = 3;
		$apply = $this->scholarships->getScholarship($type_id,$id);

		$pdf->AddPage();
		$pdf->setPageMark();
		$this->assign('user',$apply);
		$this->assign('type_id',$type_id);
		$content = $this->fetch('common_table/scholarship');
		
		$pdf->writeHTML($content, true, false, false, false, '');

		$pdf->lastPage();
		$pdf->Output($apply['studentname']."助学金申请表" . '.pdf', 'D');
		exit;
	}
	
}