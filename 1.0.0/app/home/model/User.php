<?php
namespace app\home\model;

use think\Model;
use think\Db;

class User extends Model
{
    protected $table = 'yf_user';
    protected $hidden = ['password'];

/*
    protected $field = ['id', 'candidate_number', 'studentid', 'studentname',
        'id_number', 'gender', 'birthday', 'political', 'nation', 'type', 'learning_way',
        'grade', 'class', 'professional_cetegory', 'profession', 'education', 'school_system',
        'admission_date', 'department_name', 'is_rural_student','current_grade'];*/
	protected $field = ['id', 'studentid', 'studentname',
        'id_number', 'gender', 'birthday', 'political', 'nation',
        'grade', 'class', 'profession',
        'admission_date', 'department_name', 'is_rural_student','current_grade','class_name'];
    protected $resultSetType = 'array';

    public function getAll($uid)
    {
        $data = $this->where('studentid',$uid)
            ->field($this->field)
            ->select();
        return $data;
    }
	public function get_user($id_number)
	{
		$data = $this->where('id_number',$id_number)
            ->field($this->field)
            ->find();
		$data['sex'] = get_sex($data['id_number']);
		$data['date'] = get_birth($data['id_number']);
        return $data;
	}

}
