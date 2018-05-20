<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:90:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\scholarship_team\counselor_ajax_review.html";i:1522091835;s:80:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\common\group_application_val.html";i:1513607663;}*/ ?>
<?php if(is_array($user) || $user instanceof \think\Collection || $user instanceof \think\Paginator): if( count($user)==0 ) : echo "" ;else: foreach($user as $k=>$row): ?>
<tr>
    <td><?php echo $row['status_id']; ?></td>

    <td><?php echo $row['studentname']; ?></td>
<td><?php echo $row['member_list_username']; ?></td>
<td><?php echo $row['department_name']; ?><?php echo $row['profession']; ?><?php echo $row['class']; ?></td>
<td>
    <?php echo config('check_status.'.$row['check_status']); ?>
</td>

    <td>
        <textarea name="faculty_opinion[text]" class="tab_opinion text" style="height:60px;" <?php if(!in_array($row['check_status'],[1,2])): ?>disabled<?php endif; ?>><?php echo $row['faculty_opinion']['text']; ?></textarea>
    </td>
    <td>
        <div class="audit_opera">
            <div action="<?php echo url('admin/ScholarshipHandle/MultipleFacultyFill'); ?>" class="passingDiv2" method="post">
                <input type="hidden" name="status_id" value="<?php echo $row['status_id']; ?>" />
                <div class="audit_opera">
                    <button class="btn btn-info btn-sm btn-success" type="submit" name="pass" <?php if(!in_array($row['check_status'],[1,2])): ?>disabled<?php endif; ?>>通过</button>
                </div>
                <div class="audit_opera">
                    <button class="btn btn-info btn-sm btn-danger" type="submit" name="fail" <?php if(!in_array($row['check_status'],[1,2])): ?>disabled<?php endif; ?> value="1">不通过</button>
                </div>
                <a href="<?php echo url('admin/Counselor/showMaterial',['id'=>$row['status_id'],'type_id'=>$type_id]); ?>" class="btn btn-info btn-sm">查看</a>
            </div>
        </div>
    </td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
    <td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
