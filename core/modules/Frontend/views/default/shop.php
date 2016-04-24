<?php
/* @var $this yii\web\View */
$this->title = $shop['title'];
?>

<div class="col-lg-3">
    <?php foreach ($group as $row): ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                    <?= $row->title ?>
                </div>
            </div>
            <div class="panel-body">
                <?php $category = app\modules\Dashbord\models\Category::findAll(['group_id' => $row->id]) ?>
                <ul>
                <?php foreach ($category as $value) : ?>
                    <li>
                        <?= $value->title?>
                        <ul>
                            <?php $item = app\modules\Dashbord\models\Item::findAll(['category_id' => $value->id]) ?>
                             <?php foreach ($item as $values) : ?>
                            <li><?= $values->title?></li>
                            <?php endforeach;?>
                            
                        </ul>
                    </li>
                <?php endforeach;?>
                </ul>
            </div>
        </div>

<?php endforeach; ?>
</div>



<div class="col-lg-9">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                asd
            </div>
        </div>
        <div class="panel-body">
            asd
        </div>
    </div>

</div>
