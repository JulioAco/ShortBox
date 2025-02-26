<?php
function mi_acortador_menu() {
    add_menu_page('Mi Acortador', 'Acortador', 'manage_options',
        'mi-acortador', 'mi_acortador_pagina_admin',
        'dashicons-admin-links', 25);
}
add_action('admin_menu', 'mi_acortador_menu');

function mi_acortador_pagina_admin() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'mi_acortador';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['url_larga'])) {
        $url_larga = esc_url($_POST['url_larga']);
        $codigo = substr(md5(uniqid()), 0, 6);
        $wpdb->insert($tabla, ['codigo' => $codigo, 'url_larga' => $url_larga]);

        $url_corta = home_url('/' . $codigo);
        echo "<div class='updated'><p>Enlace corto: <a href='$url_corta' target='_blank'>$url_corta</a></p></div>";
    }

    echo '<div class="wrap"><h2>Mi Acortador de Enlaces</h2>';
    echo '<form method="post"><input type="url" name="url_larga" required>';
    echo '<button type="submit">Acortar</button></form>';

    $resultados = $wpdb->get_results("SELECT * FROM $tabla ORDER BY fecha_creacion DESC");
    if ($resultados) {
        echo '<h3>Enlaces Acortados</h3><table><tr><th>Código</th><th>URL</th><th>Acción</th></tr>';
        foreach ($resultados as $fila) {
            $url_corta = home_url('/' . $fila->codigo);
            echo "<tr><td><a href='$url_corta' target='_blank'>$fila->codigo</a></td>";
            echo "<td><a href='$fila->url_larga' target='_blank'>$fila->url_larga</a></td>";
            echo "<td><a href='?borrar={$fila->id}'>Eliminar</a></td></tr>";
        }
        echo '</table>';
    }
    echo '</div>';
}

if (isset($_GET['borrar'])) {
    global $wpdb;
    $wpdb->delete($wpdb->prefix . 'mi_acortador', ['id' => intval($_GET['borrar'])]);
    wp_redirect(admin_url('admin.php?page=mi-acortador'));
    exit;
}
