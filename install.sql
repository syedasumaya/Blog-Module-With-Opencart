CREATE TABLE IF NOT EXISTS `oc_blog` (
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_description` text NOT NULL,
  `blog_category` int(11) NOT NULL,
  `blog_tags` varchar(255) NOT NULL,
  `blog_hits` int(11) NOT NULL DEFAULT '0',
  `blog_comments` int(11) NOT NULL DEFAULT '0',
  `blog_featured` tinyint(2) NOT NULL DEFAULT '0',
  `blog_related` varchar(255) NOT NULL,
  `blog_seo_keyword` varchar(255) NOT NULL,
  `blog_creator` int(11) NOT NULL,
  `blog_created_date` datetime NOT NULL,
  `blog_modified_date` datetime NOT NULL,
  `blog_status` tinyint(2) NOT NULL DEFAULT '0',
  `blog_image` varchar(255) NOT NULL,
  `blog_sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `oc_blog_category` (
  `blog_category_id` int(11) NOT NULL,
  `blog_category_description` varchar(255) NOT NULL,
  `blog_category_sort_order` int(11) NOT NULL,
  `blog_category_seo_keyword` varchar(255) NOT NULL,
  `blog_category_name` varchar(255) NOT NULL,
  `blog_category_status` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `oc_blog_comment` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_blog_id` int(11) NOT NULL,
  `comment_user_id` int(11) NOT NULL COMMENT 'if already customer',
  `comment_user_name` varchar(255) NOT NULL,
  `comment_user_email` varchar(255) NOT NULL,
  `comment_created_date` datetime NOT NULL,
  `comment_modified_date` datetime NOT NULL,
  `comment_status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;