<?php
// Incluye la clase Libro y CrudLibro usando rutas absolutas
require_once __DIR__ . '/../modelo/crud_libro.php';
require_once __DIR__ . '/../modelo/libro.php';

$crud  = new CrudLibro();
$libro = new Libro();

// Si el elemento insertar no viene nulo, inserta un libro
if (isset($_POST['insertar'])) {
    $libro->setNombre($_POST['nombre']);
    $crud->insertar($libro);
    header('Location: ../Vista/index.php');

// Si el elemento actualizar no viene nulo, actualiza el libro
} elseif (isset($_POST['actualizar'])) {
    $libro->setId($_POST['id']);
    $libro->setNombre($_POST['nombre']);
    $crud->actualizar($libro);
    header('Location: ../Vista/index.php');

// Si la variable accion enviada por GET es 'e', elimina el libro
} elseif (isset($_GET['accion']) && $_GET['accion'] === 'e') {
    $crud->eliminar((int) $_GET['id']);
    header('Location: ../Vista/index.php');

// Si la variable accion enviada por GET es 'a', va a la página actualizar
} elseif (isset($_GET['accion']) && $_GET['accion'] === 'a') {
    header('Location: ../Vista/actualizar.php?id=' . (int) $_GET['id']);
}

exit();
?>