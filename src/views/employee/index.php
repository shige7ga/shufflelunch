<h2><?php echo $formTitle ?></h2>
<?php if ($errors) : ?>
    <?php foreach ($errors as $error) : ?>
        <ul>
            <li><?php echo $error ?></li>
        </ul>
    <?php endforeach ?>
<?php endif ?>
<form action='<?php echo $formAction ?>' method="post">
    <div>
        <label for="empNo">社員番号：</label>
        <input type="number" id="empNo" name="empNo" value="<?php echo $inputEmpInfo['empNo'] ?>">
    </div>
    <?php if ($actionName !== 'delete') : ?>
        <div>
            <label for="empName">社員名：</label>
            <input type="text" id="empName" name="empName" value="<?php echo $inputEmpInfo['empName'] ?>">
        </div>
    <?php endif ?>
    <input type="submit" value="<?php echo $formButton ?>">
</form>
<h2>社員一覧</h2>
<ul>
    <?php foreach ($employees as $employee) : ?>
        <li><?php echo $employee['emp_no'] . '：' . $employee['emp_name'] ?></li>
    <?php endforeach ?>
</ul>
