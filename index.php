<?php
include 'funciones.php';

$error = false;
$config = include 'config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    if (isset($_POST['apellido'])) {
        $consultaSQL = "SELECT * FROM estudiante WHERE apellido LIKE '%" . $_POST['apellido'] . "%'";
    } else {
        $consultaSQL = "SELECT * FROM estudiante";
    }

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $alumnos = $sentencia->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}

$titulo = isset($_POST['apellido']) ? 'Lista de alumnos(' . $_POST['apellido'] . ')' : 'Lista de alumnos';
?>

<?php include "templates/header.php"; ?>

<?php
if ($error) {
?>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
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
            <a href="crear.php" class="btn btn-primary mt-4">Crear alumno</a>
            <hr>
            <form method="post" class="form-inline">
                <div class="form-group mr-3">
                    <input type="text" id="apellido" name="apellido" placeholder="Buscar por apellido" class="form-control">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3">Lista de alumnos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Identificacion</th>
                        <th>Genero</th>
                        <th>Nombre del padre</th>
                        <th>Telefono</th>
                        <th>Telefono del acudiente</th>
                        <th>EPS</th>
                        <th>Grado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($alumnos && $sentencia->rowCount() > 0) {
                        foreach ($alumnos as $fila) {
                    ?>
                            <tr>
                                <td><?php echo escapar($fila["id"]); ?></td>
                                <td><?php echo escapar($fila["nombre"]); ?></td>
                                <td><?php echo escapar($fila["apellido"]); ?></td>
                                <td><?php echo escapar($fila["identificacion"]); ?></td>
                                <td><?php echo escapar($fila["genero"]); ?></td>
                                <td><?php echo escapar($fila["nombre_padre"]); ?></td>
                                <td><?php echo escapar($fila["nombre_madre"]); ?></td>
                                <td><?php echo escapar($fila["telefono"]); ?></td>
                                <td><?php echo escapar($fila["telefono_acudiente"]); ?></td>
                                <td><?php echo escapar($fila["eps"]); ?></td>
                                <td><?php echo escapar($fila["grado"]); ?></td>
                                <td>
                                    <a href="<?= 'borrar.php?id=' . escapar($fila["id"]) ?>">🗑️Borrar</a>
                                    <a href="<?= 'editar.php?id=' . escapar($fila["id"]) ?>">✏️Editar</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "templates/footer.php"; ?>