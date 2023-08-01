<?php
/*
 * Plugin Name: My Plugin
 * Author: Skk
 * Version: 0.0.1
 * Text Domain: my-plugin
 */
if(!defined('ABSPATH')) {
    exit;
}
// news file
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'news.php';
// articles file
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'articles.php';
// members file
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'members.php';

