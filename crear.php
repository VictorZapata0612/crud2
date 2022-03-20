<?php

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrd'])) {
    die();
}

if (isset($_POST['submit'])) {
    $resultado = [
        'error' => false,
        'mensaje' => 'El alumno ' . escapar($_POST['nombre']) . ' ha sido agregado con exito'
    ];

    $config = include 'config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $estudiante = array(
            "nombre"               => $_POST['nombre'],
            "apellido"             => $_POST['apellido'],
            "identificacion"       => $_POST['identificacion'],
            "genero"         => $_POST['genero'],
            "nombre_padre"         => $_POST['nombre_padre'],
            "nombre_madre"         => $_POST['nombre_madre'],
            "telefono"             => $_POST['telefono'],
            "telefono_acudiente"   => $_POST['telefono_acudiente'],
            "eps"                  => $_POST['eps'],
            "grado"                => $_POST['grado'],
        );

        $consultaSQL = "INSERT INTO estudiante (nombre, apellido,genero, identificacion, nombre_padre, nombre_madre, telefono, telefono_acudiente, eps, grado)";
        $consultaSQL .= "VALUES (:" . implode(', :', array_keys($estudiante)) . ")";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute($estudiante);
    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}
?>

<?php include "templates/header.php"; ?>

<?php
if (isset($resultado)) {
?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                    <?= $resultado['mensaje'] ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Crea un alumno</h2>
            <hr>
            <form method="post">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control">
                </div>

                <div class="form-group">
                    <label for="identificacion">Identificacion</label>
                    <input type="text" name="identificacion" id="identificacion" class="form-control">
                </div>

                <div class="form-group">
                    <label for="genero">Genero</label>
                    <input type="text" name="genero" id="genero" class="form-control">
                </div>

                <div class="form-group">
                    <label for="nombre_padre">Nombre del padre</label>
                    <input type="text" name="nombre_padre" id="nombre_padre" class="form-control">
                </div>

                <div class="form-group">
                    <label for="nombre_madre">Nombre de la madre</label>
                    <input type="text" name="nombre_madre" id="nombre_madre" class="form-control">
                </div>

                <div class="form-group">
                    <label for="nombre">Telefono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control">
                </div>

                <div class="form-group">
                    <label for="telefono_acudiente">Telefono del acudiente</label>
                    <input type="text" name="telefono_acudiente" id="telefono_acudiente" class="form-control">
                </div>

                <div class="form-group">
                    <label for="eps">EPS</label>
                    <input type="text" name="eps" id="eps" class="form-control">
                </div>

                <div class="form-group">
                    <label for="grado">Grado</label>
                    <input type="text" name="grado" id="grado" class="form-control">
                </div>


                <div class="form-group">
                    <input hidden="csrf" type="hidden" class="btn btn-primary" value="<?php echo escapar($_SESSION['csrf']); ?>">
                    <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
                    <a href="index.php" class="btn btn-primary">Regresar al inicio</a>

                </div>

        </div>
    </div>
</div>

<?php include "templates/footer.php"; ?>