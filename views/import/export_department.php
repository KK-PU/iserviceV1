<?php
use app\components\ExcelGrid;
ExcelGrid::widget([
    'dataProvider' => $dataProvider,
		'extension'=>'xlsx',
		'filename'=>'department',
		'properties' =>[
			'title' 	=> 'department',
		],
]);
?>
