<?php
/*
* Copyright (c) 2015 www.magebuzz.com
*/

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('youtubevideo')};
CREATE TABLE {$this->getTable('youtubevideo')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `video_id` varchar(255) NOT NULL default '',
  `video_title` varchar(255) NOT NULL default '',
  `video_description` text NOT NULL default '',
  `video_duration` int(11) NOT NULL,
  `video_view_count` int(11) NOT NULL default '0',
  `is_featured` tinyint(1) NOT NULL default '0',
  `show_on_home` tinyint(1) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();