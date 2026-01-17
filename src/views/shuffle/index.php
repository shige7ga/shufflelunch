<h2><?php echo $formTitle ?></h2>
<p><form action="/employee" method="post"><button>社員を登録する</button></form></p>
<p><form action="/shuffle" method="post"><button>シャッフルする</button></form></p>
<h2>シャッフル結果</h2>
<?php for ($i = 0; $i < count($groups); $i++) : ?>
    <?php $groupNo = $i + 1; ?>
    <h3><?php echo 'グループ' . $groupNo ?></h3>
    <ul>
        <?php foreach ($groups[$i] as $group) : ?>
            <li><?php echo $group['emp_no'] . '：' . $group['emp_name'] ?></li>
        <?php endforeach ?>
    </ul>
<?php endfor ?>
