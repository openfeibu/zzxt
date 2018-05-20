<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:90:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\scholarships_group\ajax_showReviewList.html";i:1522303409;s:80:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\common\group_application_val.html";i:1513607663;}*/ ?>
<?php foreach($user as $row): ?>
<tr>
    <td><?php echo $row['status_id']; ?></td>
    <td><?php echo $row['studentname']; ?></td>
<td><?php echo $row['member_list_username']; ?></td>
<td><?php echo $row['department_name']; ?><?php echo $row['profession']; ?><?php echo $row['class']; ?></td>
<td>
    <?php echo config('check_status.'.$row['check_status']); ?>
</td>

    <td>
        <div class="audit_opera">
            <a href="<?php echo $detail_url; ?>&id=<?php echo $row['status_id']; ?>" class="btn btn-info btn-sm">查看</a>
        </div>
    </td>
</tr>
<?php endforeach; ?>
<tr>
    <td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
