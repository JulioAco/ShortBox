<?php
function mi_acortador_crear_tabla() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'mi_acortador';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $tabla (
        id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        codigo VARCHAR(10) NOT NULL UNIQUE,
        url_larga TEXT NOT NULL,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

function mi_acortador_eliminar_tabla() {
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "mi_acortador");
}
