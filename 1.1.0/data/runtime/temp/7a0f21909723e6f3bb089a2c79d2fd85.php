<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:91:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\student_office\ajax_showApplicationList.html";i:1526649037;s:80:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\common\group_application_val.html";i:1513607663;}*/ ?>
<?php $num = 1;foreach($user as $row): ?>
<tr>
    <td>
        <?php if($row['check_status'] != 9): ?>
        <label class="pos-rel">
            <input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $row['status_id']; ?>">
            <span class="lbl"></span>
        </label>
        <?php endif; ?>
        <?php echo $row['status_id']; ?>
    </td>
    <td><?php echo $row['studentname']; ?></td>
<td><?php echo $row['member_list_username']; ?></td>
<td><?php echo $row['department_name']; ?><?php echo $row['profession']; ?><?php echo $row['class']; ?></td>
<td>
    <?php echo config('check_status.'.$row['check_status']); ?>
</td>

    <td class="tab_content">
        <div action="<?php echo url('admin/ScholarshipHandle/MultipleStudentOfficeFill'); ?>" class="passingDiv" method="post">
            <input type="hidden" name="status_id" value="<?php echo $row['status_id']; ?>" />
            <!-- <div class="audit_opera"> -->
                <!-- <button class="btn btn-info btn-sm btn-success" type="submit" name="pass" <?php if($row['check_status'] != 4): ?>disabled<?php endif; ?>>通过</button> -->
            <!-- </div> -->
            <div class="audit_opera">
                <button class="btn btn-info btn-sm btn-danger" type="submit" name="fail" <?php if($row['check_status'] == 9): ?>disabled<?php endif; ?> value="1">不通过</button>
            </div>
            <div class="audit_opera">
                <a href="<?php echo $detail_url; ?>&id=<?php echo $row['status_id']; ?>" class="btn btn-info btn-sm">查看</a>
            </div>
        </div>
    </td>
</tr>
<?php endforeach; ?>
<tr>
    <td align="left" class="hidden-xs center" href="<?php echo url('admin/ScholarshipHandle/MultipleStudentOfficeFillAll'); ?>">
        <!-- <button id="passSubmit" class="btn btn-purple btn-sm hidden-xs" name="pass">通过&nbsp;</button> -->
        <button id="failSubmit" class="btn btn-danger  btn-sm hidden-xs" name="fail">不通过</button>
    </td>
    <td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
