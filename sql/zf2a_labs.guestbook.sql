CREATE TABLE `guestbook_entry` (
  `entry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_name` varchar(255) NOT NULL,
  `entry_email` varchar(255) NOT NULL,
  `entry_website` varchar(255) NOT NULL,
  `entry_message` text NOT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
