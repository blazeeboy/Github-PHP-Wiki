SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `parent_content` int(9) DEFAULT NULL,
  `parent_section` int(9) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `user` int(9) DEFAULT NULL,
  `subsection` tinyint(4) DEFAULT '1',
  `cell` tinyint(4) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `view` longtext,
  `filter` longtext,
  `info` longtext,
  PRIMARY KEY (`id`),
  KEY `parent_content` (`parent_content`),
  KEY `parent_section` (`parent_section`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

INSERT INTO `contents` (`id`, `parent_content`, `parent_section`, `title`, `user`, `subsection`, `cell`, `sort`, `path`, `view`, `filter`, `info`) VALUES
(1, NULL, 1, NULL, 1, 1, 0, 0, NULL, NULL, NULL, 'PAGE_BODY_LOCKED'),
(3, 1, 1, 'main Scripts and Style sheets', 1, 1, 0, 0, '/Basic/Document settings.php', '', '', '{"background_image":"","repeat":"repeat-y","attachment":"fixed","horizontal_position":"left","vertical_position":"top","Resetstyle":[],"Textstyle":[],"class":"","style":"","favIcon":"","javascript_files":"assets/scripts/shCore.js\\nassets/scripts/shBrushCpp.js\\nassets/scripts/shBrushCSharp.js\\nassets/scripts/shBrushCss.js\\nassets/scripts/shBrushDelphi.js\\nassets/scripts/shBrushJava.js\\nassets/scripts/shBrushJScript.js\\nassets/scripts/shBrushPhp.js\\nassets/scripts/shBrushPython.js\\nassets/scripts/shBrushRuby.js\\nassets/scripts/shBrushSql.js\\nassets/scripts/shBrushVb.js\\nassets/scripts/shBrushXml.js","d9618":"","css_files":"assets/style/base.css\\nassets/style/theme_style.css\\nassets/style/override.css\\nassets/style/SyntaxHighlighter.css","d4365":""}'),
(4, 1, 1, 'Main page frame', 1, 1, 0, 1, '/main page.php', '', '', ''),
(5, 4, 1, '', 1, 1, 1, 0, '/theme blocks/simple block.php', '', '', '{"title":"Brief Description","contentText":"This is a brief description about your wiki\\nand a welcome text for readers."}'),
(7, 4, 1, '', 1, 1, 1, 1, '/theme blocks/pages links.php', '', '', '{"title":"Pages","limit":50}'),
(8, 4, 1, '', 1, 0, 0, 1, '/theme blocks/view page.php', '', '', ''),
(10, 4, 4, '', 1, 0, 0, 0, '/theme blocks/all pages links.php', '', '', '{"title":"Pages","limit":50}');

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

CREATE TABLE IF NOT EXISTS `meta` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `user_id` int(9) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `meta` (`id`, `user_id`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, 1, 'Admin', 'istrator', 'ADMIN', '0');

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `parent_section` int(9) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `view` longtext,
  PRIMARY KEY (`id`),
  KEY `parent_section` (`parent_section`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `sections` (`id`, `parent_section`, `name`, `sort`, `view`) VALUES
(1, NULL, NULL, 0, NULL),
(4, 1, 'Pages', 1, '');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `group_id` int(9) NOT NULL,
  `ip_address` char(16) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `users` (`id`, `group_id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `remember_code`, `created_on`, `last_login`, `active`) VALUES
(1, 1, '127.0.0.1', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, '9d029802e28cd9c768e8e62277c0df49ec65c48c', 1268889823, 1300474742, 1);


ALTER TABLE `contents`
  ADD CONSTRAINT `contents_ibfk_1` FOREIGN KEY (`parent_content`) REFERENCES `contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contents_ibfk_2` FOREIGN KEY (`parent_section`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contents_ibfk_3` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `meta`
  ADD CONSTRAINT `meta_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`parent_section`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
