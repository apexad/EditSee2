<?php
require('classes/mysqli.php');

$filename = 'es-config.php';

if (!file_exists($filename)) {

$es_main_url = "";
$es_server = "localhost";
$es_username = "editsee_user";
$es_password = "";
$es_database = "new_editsee";
$es_prefix = "es_";

// Create connection
$conn = new EditSeeMySQLi($es_server, $es_username, $es_password, $es_database);

// config table
$conn->query("CREATE TABLE IF NOT EXISTS `".$es_prefix."config` (
  `option` varchar(32) NOT NULL,
  `data` varchar(255) NOT NULL,
  PRIMARY KEY (`option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$conn->query("INSERT INTO `" . $es_prefix . "config` (`option`, `data`) VALUES
('es_description', 'A brand new EditSee site'),
('es_main_url', '" . $es_main_url . "'),
('es_title', 'New EditSee'),
('es_posts_per_page', '5'),
('es_homepage', '!posts!'),
('es_postpage', 'posts'),
('es_email_comments', '0'),
('es_show_post_author', '0');");

// comments table
$conn->query("CREATE TABLE IF NOT EXISTS `".$es_prefix."comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `linked_post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");

$conn->query("INSERT INTO `".$es_prefix."comments` (`comment_id`, `linked_post_id`, `name`, `email`, `comment`, `date_entered`, `date_deleted`, `deleted`) VALUES
(1, 1, 'sample', 'sample@editsee.com', 'This is a sample comment!', '2011-07-17 10:08:15', '0000-00-00 00:00:00', 0);");

// custom table
$conn->query("CREATE TABLE IF NOT EXISTS `".$es_prefix."custom` (
  `section` varchar(32) NOT NULL,
  `label` varchar(255) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`section`,`label`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$conn->query("INSERT INTO `".$es_prefix."custom` (`section`, `label`, `data`) VALUES
('footer', 'Custom Footer', '');");

//links table
$conn->query("CREATE TABLE IF NOT EXISTS `".$es_prefix."links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_order` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `title` varchar(140) NOT NULL,
  `nofollow` tinyint(1) NOT NULL,
  `target` varchar(6) NOT NULL,
  `date_deleted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`link_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");

$conn->query("INSERT INTO `".$es_prefix."links` (`link_order`, `url`, `title`, `nofollow`, `target`, `date_deleted`, `deleted`) VALUES
(1, 'http://editsee.com/', 'EditSee', 0, '_self', '0000-00-00 00:00:00', 0);");

// post table
$conn->query("CREATE TABLE IF NOT EXISTS `".$es_prefix."post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(140) NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `urltag` varchar(140) NOT NULL,
  `comments` tinyint(1) NOT NULL,
  `type` char(4) NOT NULL,
  `in_nav` tinyint(1) NOT NULL,
  `page_order` int(11) NOT NULL,
  `draft` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_deleted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `urltag` (`type`,`urltag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");

$conn->query("INSERT INTO `".$es_prefix."post` (`user_id`, `title`, `featured_image`, `content`, `urltag`, `comments`, `type`, `in_nav`, `page_order`, `draft`,
`date_entered`,
`date_deleted`, `deleted`) VALUES
(1, 'Hello World', '', '<p>This is your first EditSee post.  Be sure to change it!</p>', 'hello-world', 0, 'post', 0, 0, 0, '2011-04-30 22:00:00', '0000-00-00 00:00:00', 0),
(1, 'About', '', '<p>This is an about page.  Tell the world about yourself, or change it.</p>', 'about', 0, 'page', 1, 1, 0, '2011-04-30 22:00:00', '0000-00-00 00:00:00', 0)");

// tags table
$conn->query("CREATE TABLE IF NOT EXISTS `".$es_prefix."tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `type` varchar(3) NOT NULL COMMENT '''cat'' or ''tag''',
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_and_type` (`tag`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;");

$conn->query("INSERT INTO `".$es_prefix."tags` (`tag_id`, `tag`, `type`) VALUES
(1, 'General', 'cat');");

// post_tags table
$conn->query("CREATE TABLE IF NOT EXISTS `".$es_prefix."post_tags` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `type` varchar(3) NOT NULL COMMENT '''cat'' or ''tag''',
  PRIMARY KEY (`post_id`,`tag_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$conn->query("INSERT INTO `".$es_prefix."post_tags` (`post_id`, `tag_id`, `type`) VALUES
(1, 1, 'cat'),(2, 1, 'cat');");

// write config file
$es_config_contents = '<?php
/* EditSee config file */
$es_server    = '."'$es_server';".'
$es_username  = '."'$es_username';".'
$es_password  = '."'$es_password';".'
$es_database  = '."'$es_database';".'
$es_prefix    = '."'$es_prefix';".'
?>
';
file_put_contents('es_config.php', $es_config_contents);
}
?>
