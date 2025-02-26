<?php
class MiAcortadorTest extends WP_UnitTestCase {
    function test_codigo_generado() {
        $codigo = mi_acortador_generar_codigo(6);
        $this->assertEquals(6, strlen($codigo));
    }
}
