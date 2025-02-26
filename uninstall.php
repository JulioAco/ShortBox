<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;

global $wpdb;
$tabla = $wpdb->prefix . 'mi_acortador';
$wpdb->query("DROP TABLE IF EXISTS $tabla");
