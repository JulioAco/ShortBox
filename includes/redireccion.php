<?php
function mi_acortador_redireccion() {
    global $wpdb;
    $codigo = trim($_SERVER['REQUEST_URI'], '/');

    if (!empty($codigo)) {
        $tabla = $wpdb->prefix . 'mi_acortador';
        $url = $wpdb->get_var($wpdb->prepare("SELECT url_larga FROM $tabla WHERE codigo = %s", $codigo));

        if ($url) {
            wp_redirect($url, 301);
            exit;
        }
    }
}
add_action('init', 'mi_acortador_redireccion');
