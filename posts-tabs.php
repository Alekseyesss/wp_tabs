<?php

/**
 * Displaying posts as tabs.
 *
 * Plugin Name:         Posts tabs
 * Description:         The plugin displays all posts of the same type as tabs. Use the shortcode: [tabs post_type = 'enter your post type name']. The plugin displays up to 20 posts.
 * Version:             1.0.0
 * Requires at least:   4.9
 * Requires PHP:        5.5
 * Author:              blue auditor
 * License:             MIT
 * Text Domain:         posts_tabs
 *
 * @package     posts_tabs
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}

define('TABS_PATH', plugin_dir_path(__FILE__));
define('TABS_URL', plugin_dir_url(__FILE__));
define('TABS_NONCE', 'tabs-security');

require_once(TABS_PATH . 'assets/src/Tabs.php');
require_once(TABS_PATH . 'assets/src/Ajax.php');

$tabs = new tabs\Tabs();
$ajax = new ajax\Ajax();
$tabs->hooks();
$ajax->hooks();
