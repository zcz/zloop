<?php
$model = Category::model()->findByPk(3);

$nameOfTable = str_replace(array("{","}"), "", $model->tableName());
$uid = $model->getPrimarykey();

$connection = Yii::app()->db;
$sql  = "INSERT `".$nameOfTable."` ";
$sql .= "SELECT * FROM `".$connection->tablePrefix.$nameOfTable."` ";
$sql .= "WHERE `id` = ".$uid;

$command=$connection->createCommand($sql);
$rowCount=$command->execute();
?>