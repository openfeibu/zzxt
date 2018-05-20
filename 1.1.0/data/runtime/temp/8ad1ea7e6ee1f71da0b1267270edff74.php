<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\evaluation\class_ajax_review.html";i:1514991728;s:73:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\common\evaluation_val.html";i:1515025175;}*/ ?>
<?php foreach($user as $num => $row): ?>
<tr>
    <td><?php echo $row['evaluation_id']; ?></td>
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
        <div class="audit_opera">
            <a href="<?php echo url('admin/EvaluationGroup/showEvaluationMaterial',['id'=>$row['status_id']]); ?>" class="btn btn-info btn-sm">查看</a>
        </div>
    </td>
</tr>
<?php endforeach; ?>
<tr>
    <td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
