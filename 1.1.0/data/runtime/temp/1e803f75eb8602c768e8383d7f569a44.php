<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\counselor\counselor_ajax_review.html";i:1522827854;s:80:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\common\group_application_val.html";i:1513607663;}*/ ?>
<?php if(is_array($user) || $user instanceof \think\Collection || $user instanceof \think\Paginator): if( count($user)==0 ) : echo "" ;else: foreach($user as $k=>$row): ?>
<tr>
    <td>
        <?php if(!in_array($row['check_status'],[1,2])): ?>
        <?php echo $row['status_id']; else: ?>
        <label class="pos-rel">
            <input name="n_id[]" id="navid" class="ace" type="checkbox" value="<?php echo $row['status_id']; ?>">
            <span class="lbl"><?php echo $row['status_id']; ?></span>
        </label>
        <?php endif; ?>
    </td>

    <td><?php echo $row['studentname']; ?></td>
<td><?php echo $row['member_list_username']; ?></td>
<td><?php echo $row['department_name']; ?><?php echo $row['profession']; ?><?php echo $row['class']; ?></td>
<td>
    <?php echo config('check_status.'.$row['check_status']); ?>
</td>

    <td>
        <?php if(!in_array($row['check_status'],[1,2])): ?>
        <?php echo $row['group_opinion']['text']; else: ?>
        <select class="form-control tab_select text" name="group_opinion[text]">
            <?php foreach(\think\Config::get('scholarships_opinion') as $k => $v): ?>
            <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>
    </td>
    <td>
        <div class="audit_opera">
            <div action="<?php echo url('admin/ScholarshipHandle/MultipleCounselorFill'); ?>" class="passingDiv2" method="post">
                <input type="hidden" name="status_id" value="<?php echo $row['status_id']; ?>" />
                <div class="audit_opera">
                    <button class="btn btn-info btn-sm btn-success" type="submit" name="pass" <?php if(!in_array($row['check_status'],[1,2])): ?>disabled<?php endif; ?>>通过</button>
                </div>
                <div class="audit_opera">
                    <button class="btn btn-info btn-sm btn-danger" type="submit" name="fail" <?php if(!in_array($row['check_status'],[1,2])): ?>disabled<?php endif; ?> value="1">不通过</button>
                </div>
                <a href="<?php echo $detail_url; ?>&id=<?php echo $row['status_id']; ?>" class="btn btn-info btn-sm">查看</a>
            </div>
        </div>
    </td>
</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
    <td align="left" class="hidden-xs center" href="<?php echo url('admin/ScholarshipHandle/MultipleCounselorAllFill'); ?>">
        <button id="passSubmit" class="btn btn-purple btn-sm hidden-xs" name="pass">通过&nbsp;</button>
        <button id="failSubmit" class="btn btn-danger  btn-sm hidden-xs" name="fail">不通过</button>
    </td>
    <td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
