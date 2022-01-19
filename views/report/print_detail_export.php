<?php
use app\models\Job;
use app\components\ExcelGrid;

ExcelGrid::widget([
    'dataProvider' => $dataProvider,
		'extension'=>'xlsx',
		'filename'=>'export_job_report',
		'properties' =>[
		'title' 	=> Yii::t('app','maintenance_stat'),
		],
]);
?>

<?php
/*
    echo ExportMenu::widget(
    ['dataProvider'=>$dataExport]);?>
<p></p>
    <?=GridView::widget([
            'dataProvider' => $dataExport,
            'layout'=>'{items}',

    ]);*/
?>
