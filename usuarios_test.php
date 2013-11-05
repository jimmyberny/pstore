<?php
require_once( 'admin.php' );
require_once( 'sql_util.php');

$res = array(
    "usuarios" => array(
        array(
            "id" => "hola",
            "nombre" => "james",
            "paterno" => "newton",
            "materno" => "sir",
            "usuario" => "jimmy",
            "contra" => "superman"
        ),
        array(
            "id" => "batman",
            "nombre" => "del futuro",
            "paterno" => "Bruce",
            "materno" => "Wayne",
            "usuario" => "batman",
            "contra" => "batman"
        )
    )
);

header("Content-Type: text/javascript");
echo json_encode($res);

function list_usuarios() {
    $au = query_all($table);
    
}
?>
