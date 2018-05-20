<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\evaluation\counselor_ajax_review.html";i:1522372172;}*/ ?>
<?php foreach($user as $num => $row): ?>

<tr>
    <td>
        <?php if(in_array($row['evaluation_status'],[1,2])): ?>
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
    <td ><input name="change_fraction" value="<?php echo $row['change_fraction']; ?>" class="change_fraction" style="width:40px" <?php if(!in_array($row['evaluation_status'],[1,2])): ?>disabled<?php endif; ?>></td>
    <td class="score"><?php echo $row['score']; ?></td>
    <td class="rank"><?php echo $row['rank']; ?></td>
    <td class="status">
        <?php echo config('evaluation_status.'.$row['status']); ?>
    </td>

    <td >
        <?php if(!in_array($row['evaluation_status'],[1,2])): ?>
        <?php echo $row['group_opinion']['text']; else: ?>
        <select class="form-control tab_select text" name="group_opinion[text]" >
            <?php foreach(\think\Config::get('eval_opinion') as $k => $v): ?>
            <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>
    </td>
    <td class="tab_content">
        <form action="<?php echo url('admin/EvaluationHandle/counselor'); ?>" method="post" class="passingForm2">
            <input type="hidden" name="status_id" value="<?php echo $row['status_id']; ?>" />
            <input type="hidden" name="evaluation_id" value="<?php echo $row['evaluation_id']; ?>" />
            <div class="audit_opera">
                <button class="btn btn-info btn-sm btn-success" type="submit" <?php if(!in_array($row['evaluation_status'],[1,2])): ?>disabled<?php endif; ?> name="pass">通过</button>
            </div>
            <div class="audit_opera">
                <button class="btn btn-info btn-sm btn-danger" type="submit" <?php if(!in_array($row['evaluation_status'],[1,2])): ?>disabled<?php endif; ?> name="fail" value="1">不通过</button>
            </div>

        <div class="audit_opera">
            <a href="<?php echo url('admin/Counselor/showEvaluationMaterial',['id'=>$row['status_id']]); ?>" class="btn btn-info btn-sm">查看</a>
        </div>
        </form>
    </td>
</tr>

<?php endforeach; ?>
<tr>
    <td align="left" class="hidden-xs center" href="<?php echo url('admin/EvaluationHandle/counselorAll'); ?>">
        <button id="passSubmit" class="btn btn-purple btn-sm hidden-xs" name="pass">通过&nbsp;</button>
        <button id="failSubmit" class="btn btn-danger  btn-sm hidden-xs" name="fail">不通过</button>
    </td>
    <td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
