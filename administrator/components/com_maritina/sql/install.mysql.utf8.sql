CREATE TABLE IF NOT EXISTS `#__maritina_form` (
	`id` int(11) NOT NULL auto_increment, 
	`title` VARCHAR(200) NOT NULL, 
	`alias` VARCHAR(200) NOT NULL, 
	`asset_id` INTEGER UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.', 
	`introtext` TEXT NOT NULL, 
	`fulltext` TEXT NOT NULL, 
	`created` DATETIME NOT NULL, 
	`ordering` INT(11) NOT NULL, 
	`metakey` TEXT NOT NULL, 
	`metadesc` TEXT NOT NULL, 
	`hits` INT(11) NOT NULL, 
	`created_by` INT(11) NOT NULL, 
	`published` INT(2) NOT NULL, 
	`params` TEXT NOT NULL, 
	`catid` INT(11) NOT NULL, 
	UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `#__maritina_refresh` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `time` INT(0) NOT NULL,
    `riga_data_list` text NOT NULL,
    `klaipeda_data_list` text NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



