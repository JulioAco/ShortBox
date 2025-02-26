<?php
/*
Plugin Name: Mi Acortador de Enlaces
Plugin URI: https://tudominio.com
Description: Plugin para acortar enlaces con tu dominio.
Version: 1.0
Author: Tu Nombre
Author URI: https://tudominio.com
License: GPL2
*/

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/database.php';
require_once plugin_dir_path(__FILE__) . 'includes/redireccion.php';
require_once plugin_dir_path(__FILE__) . 'admin/menu.php';

register_activation_hook(__FILE__, 'mi_acortador_crear_tabla');
register_deactivation_hook(__FILE__, 'mi_acortador_eliminar_tabla');
