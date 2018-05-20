<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:82:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\evaluation\faculty_ajax_review.html";i:1522372096;s:73:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\common\evaluation_val.html";i:1515025175;}*/ ?>
<?php foreach($user as $num => $row): ?>
<tr>
    <td>
        <?php if(in_array($row['evaluation_status'],[3,9])): ?>
        <label class="pos-rel">
            <input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $row['evaluation_id']; ?>">
            <span class="lbl"></span>
        </label>
        <?php endif; ?>
        <?php echo $row['evaluation_id']; ?>
    </td>
    <td><?php echo $row['studentname']; ?></td>
<td><?php echo $row['studentid']; ?></td>
<td><?php echo $row['profession']; ?></td>
<td><?php echo $row['assess_fraction']; ?></td>
<td><?php echo $row['change_fraction']; ?></td>
<td><?php echo $row['score']; ?></td>
<td><?php echo $row['rank']; ?></td>
<td class="status">
    <?php echo config('evaluation_status.'.$row['status']); ?>
</td>

    <td>
        <?php if(!in_array($row['evaluation_status'],[3,9])): ?>
        <?php echo $row['faculty_opinion']['text']; else: ?>
        <select class="form-control tab_select text" name="faculty_opinion[text]">
            <?php foreach(\think\Config::get('eval_opinion2') as $k => $v): ?>
            <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>
    </td>
    <td class="tab_content">
        <form action="<?php echo url('admin/EvaluationHandle/faculty'); ?>" class="passingForm2" method="post">
        <input type="hidden" name="user_name" value="<?php echo session('admin_auth.admin_username'); ?>">
        <input type="hidden" name="status_id" value="<?php echo $row['status_id']; ?>" />
        <div class="audit_opera">
            <button class="btn btn-info btn-sm btn-success" type="submit" name="pass" <?php if(!in_array($row['evaluation_status'],[3,9])): ?>disabled<?php endif; ?> >通过</button>
        </div>
        <div class="audit_opera">
            <button class="btn btn-info btn-sm btn-danger" type="submit" name="fail" <?php if(!in_array($row['evaluation_status'],[3,9])): ?>disabled<?php endif; ?> value="1">不通过</button>
        </div>

        <div class="audit_opera">
            <a href="<?php echo url('admin/FacultyGroup/showEvaluationMaterial',['id'=>$row['status_id']]); ?>" class="btn btn-info btn-sm">查看</a>
        </div>
        </form>
    </td>

</tr>
<?php endforeach; ?>
<tr>
    <td align="left" class="hidden-xs center" href="<?php echo url('admin/EvaluationHandle/facultyAll'); ?>">
        <button id="passSubmit" class="btn btn-purple btn-sm hidden-xs" name="pass">通过&nbsp;</button>
        <button id="failSubmit" class="btn btn-danger  btn-sm hidden-xs" name="fail">不通过</button>
    </td>
    <td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
