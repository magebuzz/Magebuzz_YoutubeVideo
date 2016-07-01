<?php
/*
 * @copyright   Copyright ( c ) 2015 www.magebuzz.com
 */
$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('youtubevideo_product')};
CREATE TABLE {$this->getTable('youtubevideo_product')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(11)  NOT NULL ,
  `video_id` int(11)  NOT NULL ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();