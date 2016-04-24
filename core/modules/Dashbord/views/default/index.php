<div class="Dashbord-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        <?= \yii\bootstrap\Html::a('Shop', 'shop') ?>|
        <?= \yii\bootstrap\Html::a('User', 'user') ?>|
        <?= \yii\bootstrap\Html::a('Group', 'group') ?>|
        <?= \yii\bootstrap\Html::a('Category', 'category') ?>|
        <?= \yii\bootstrap\Html::a('CategoryItem', 'categoryItem') ?>|
        <?= \yii\bootstrap\Html::a('Product', 'product') ?>|
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
