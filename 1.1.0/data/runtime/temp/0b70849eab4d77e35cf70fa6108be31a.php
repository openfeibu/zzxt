<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:89:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\\notice_front\scholarship_ajax_notice.html";i:1513580208;}*/ ?>
<?php if(count($list)): foreach($list as $row): ?>
<tr>
    <td><?php echo $row['studentname']; ?></td>
    <td><?php echo $row['id_number']; ?></td>
    <td><?php echo $row['profession']; ?><?php echo $row['class']; ?></td>
</tr>
<?php endforeach; ?>
<tr>
    <td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
<?php else: ?>
<tr>
    <td height="50" colspan="12" align="center">暂无数据</td>
</tr>
<?php endif; ?>
