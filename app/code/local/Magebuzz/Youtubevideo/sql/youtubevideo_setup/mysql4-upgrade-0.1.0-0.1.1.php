<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('youtubevideo'), 'playlist_id', 'varchar(255)');
$installer->getConnection()->addColumn($this->getTable('youtubevideo'), 'user_id', 'varchar(255)');

$installer->endSetup();