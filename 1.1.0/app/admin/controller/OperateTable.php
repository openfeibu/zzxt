<?php

namespace app\admin\controller;

use think\Request;
use think\Db;
use think\Validate;
class OperateTable extends Base
{
    //sqlsqr2008所有的字段类型。希望没错
    private $field_type = [
        'bit','int', 'smalint', 'tinyint', 'decimal', 'numeric', 'money',
        'smallmoney', 'float', 'real', 'datetime', 'smalldatetime', 'timestamp',
        'uniqueidentifier', 'char', 'varchar', 'text', 'nchar', 'nvarchar',
        'ntext', 'binary', 'varbinary', 'image','nvarchar(MAX)','ntext(MAX)','char(MAX)'
    ];

    /**
     * 显示所有的字段
     * @return mixed
     */
    public function showField()
    {
        $arr = Db::table('yf_identify_model')
            ->select();
        foreach ($arr as $key => $row) {
            switch ($row['option_type']){
                case 'radio':
                    $arr[$key]['option_type'] = '单选框';break;
                case 'checkbox':
                    $arr[$key]['option_type'] = '多选框';break;
                case 'select':
                    $arr[$key]['option_type'] = '下拉文本框';break;
                case 'text':
                    $arr[$key]['option_type'] = '文本';break;
                case 'file' :
                    $arr[$key]['option_type'] = "单文件";break;
            }
            if (!is_numeric($row['score'])) {
                $arr[$key]['score'] = json_decode($row['score'], true);
            }
            array_pop($arr[$key]);
        }

        $this->assign('list', $arr);
        return $this->fetch();
//        $a = "primary key";
    }

    /**
     * 显示修改字段的页面
     * @param $id
     * @return mixed
     */
    public function checkField($id)
    {
        $data = Db::table('yf_identify_model')
            ->where('field', $id)
            ->find();
        $data['is_null'] == 1 ? $data['is_null'] = '是':$data['is_null'] = '否';
        $data['score'] = json_decode($data['score'], true);
        $string = '';
        foreach ($data['score'] as $key => $row) {
            if (!isset($row['option_score'])) {
                $string .= trim($key)."|".$row."|\n";
                continue;
            }
            $string .= trim($key)."|".$row['option_score'].",";
            foreach ($row as $kk => $vv) {
                if ($kk !== "option_score" and count($row)>=2 and $kk !== '')
                $string .= $kk."|";
            }
            $string = substr($string,0,strlen($string)-1);
            $string .= "\n";
        }
        $data['score'] = $string;
        $this->assign('row', $data);
        return $this->fetch();
    }

    /**
     * 修改表结构
     * @param Request $request
     */
    public function updateField(Request $request)
    {
        $data = $request->post();

        //如果全为空。则报错
        if (empty($data['field']) or empty($data['field']) or empty($data['field_length'])) {
            return $this->error("填写完整");
        }
        //验证字段类型
        if (!in_array($data['field_type'], $this->field_type)){
            return $this->error("字段类型非法");
        }
        //提交的是是
        if (isset($data['is_null'])) {
            $data['is_null'] = 1;
        } else {
            $data['is_null'] = 0;
        }
        $array = [];
        //二级选项的修改
        if (!empty($data['score'])) {
            $data['score'] = $this->dellScore($data['score']);
        }
        $bool = Db::table('identify_model')
            ->where('field', $data['field'])
            ->update($data);
        if ($bool) {
            //修改学生端的相关字段
            $boole = $this->updateUserIdentifyTable($data['field'],$data['field_type'],$data['field_length'],$data['is_null']);
            return $this->redirect('/admin/operate_table/showfield');
        }
    }

    /**
     * 更新表的结构
     * @param $field 字段名
     * @param $type 类型
     * @param $length 长度
     * @param int $is_null 是否为null
     * @param boolean $add
     * @return bool|void
     */
    public function updateUserIdentifyTable($field, $type, $length, $is_null = 0, $add = false)
    {
        //判断是增加还是修改
        if ($add) {
            $sql ="ALTER TABLE [yf_user_identify] ADD $field $type($length)";
            if ($is_null == 1) {
                $sql .= " not null";
            }
            try {
                Db::execute($sql);
            } catch (PDOException $e) {
                return $this->error("有致命错误，请联系管理员。错误编号：".$e->getCode());
            }
            return true;
        }

        //如果是not null的话。
        if ($is_null == 1) {
            if (strpos($type,'('))
                $sql = "alter table yf_user_identify alter COLUMN $field $type NOT NULL";
             else
                 $sql = "alter table yf_user_identify alter COLUMN $field $type($length) NOT NULL";
        } else {
            if (strpos($type,'('))
                $sql = "alter table yf_user_identify alter COLUMN $field $type";
            else
                $sql = "alter table yf_user_identify alter COLUMN $field $type($length)";
        }
        try {
            //执行修改表的结构
            $bool = Db::execute($sql);
        } catch (PDOException $e){
            //如果有异常，返回异常
            return $this->error("有致命错误，请联系管理员。错误编号：".$e->getCode());
        }
        return true;
    }

    /**
     * 为学生端添加字段
     */
    public function addField(Request $request)
    {
        $data = $request->post();
        $msg = [
            'field.require' => '字段名不能为空',
            'field.unique' => '该字段名已经存在，请重新填写',
            'score.require' => '二级选项不能为空',
            'name.require' => '名字不能为空',
            'option_type.require' => '选项类型不能为空'
        ];
        $validate = new Validate([
            'field' => 'require',
            'field_type' => 'require',
            'score' => 'require',
            'name' => 'require',
            'option_type' => 'require'
        ], $msg);
        //检察是否未填写
        if (!$validate->check($data)) {
            return [
                'code' => 400,
                'msg' => $validate->getError()
            ];
        }
        //将是改为1，否为0
        if (isset($data['is_null'])) {
            $data['is_null'] = 1;
        } else {
            $data['is_null'] = 0;
        }
        //将选项转为json格式
        $data['score'] = $this->dellScore($data['score']);
        if (is_array($data['score'])){
            return $data['score'];
        }
        $bool = Db::table('identify_model')
            ->insert($data);
        if (!$bool) {
            return [
                'code' => 400,
                'msg' => '插入失败'
            ];
        }
        $this->updateUserIdentifyTable($data['field'], $data['field_type'], $data['field_length'], $data['is_null'], true);
        return [
            'code' => 200,
        ];
    }


    /**
     * 处理棘手的二级栏目
     * @param $data
     * @return string
     */
    public function dellScore($data)
    {
        if (Request::instance()->isAjax()){
            if (!strpos($data, '|')){
                return [
                    'code' => 400,
                    'msg' => "选项填写有误。请按照对应的格式填写。"
                ];exit;
            }
        }
        if (!empty($data)) {
            //先将回车的\n转化为<br />这样比较好处理
            $count = explode('<br />', nl2br(trim($data)));
            //当大于等于2条
            if (count($count) >= 2) {
                foreach ($count as $row) {
                    //转化|
                    $bool = strpos(trim($row),",");
                    if ($bool) {
                        $arr = explode(',', trim($row));
                    } else {
                        $arr = explode('，', trim($row));
                    }
                    $score = explode('|', trim($arr[0]));
                    $array[$score[0]] = [
                        'option_score' => $score[1],
                    ];
                    if (isset($arr[1])) {
                        $cailiao = explode('|', $arr[1]);
                        foreach ($cailiao as $val){
                            $array[$score[0]][$val] = '';
                        }
                    }

                }
            } else {
                //单条
                $temp = explode('<br />', nl2br(trim($data)));
                $bool = strpos(trim($temp),",");
                if ($bool) {
                    $arr = explode(',', trim($temp));
                } else {
                    $arr = explode('，', trim($temp));
                }
                $score = explode('|', $temp[0]);
                $cailiao = explode("|", $temp[1]);
                $array[$score[0]] = [
                    'option_score' => $score[1]
                ];
                foreach ($cailiao as $val) {
                    $array[$score[0]][$val] ="";
                }
            }
        }
        //转化为json格式。便于储存在数据库中
        return json_encode($array);
    }

    /**
     * 删除
     * @param $field
     */
    public function delete($field)
    {
        if (empty($field)) {
            return $this->error("gg");
        }
        $bool = Db::table('yf_identify_model')->where('field', $field)->find();
        if (!$bool) {
            return $this->error('不存在此字段名');
        }
        $bool = Db::table('yf_identify_model')->where('field', $field)->delete();
        if (!$bool) {
            return $this->error("系统发生错误");
        }
        //删除这个字段
        $sql = "ALTER TABLE [user_identify] DROP COLUMN $field";
        try {
            Db::execute($sql);
        } catch (PDOException $e) {
            return $this->error("有致命错误，请联系管理员。错误编号：" . $e->getCode());
        }
        return $this->success("删除成功");
    }
}