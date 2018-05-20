<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/student_notice\evalu_ajax_notice.html";i:1524079119;}*/ ?>
<?php if(count($list)): foreach($list as $row): ?>
<tr class="line-table-height <?php if($row['member_list_id'] == $user['member_list_id']): ?>tr_active<?php endif; ?>" >
    <td class="k-s-content content"><?php echo $row['member_list_nickname']; ?></td>
    <td class="k-s-content content"><?php echo $row['id_number']; ?></td>
    <td class="k-s-content content"><?php echo $row['class_name']; ?></td>
    <td class="k-s-content content"><?php echo $row['score']; ?></td>
    <td class="k-s-content content"><?php echo $row['rank']; ?></td>
</tr>
<?php endforeach; ?>
<tr>
    <td max-height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
<?php else: ?>
<tr>
    <td max-height="50" colspan="12" align="center">暂无数据</td>
</tr>
<?php endif; ?>
