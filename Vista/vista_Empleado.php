<?php
    include('Templates/cabecera.php');
?>

<div class="container">
    <div class="row">

        <form action="fEditar md-5">
            <div class="card mt-5">
                <div class="card-header">Editar Empleado</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Centro Costo</th>
                                <th>Cargo</th>
                                <th>Sueldo</th>
                                <th>Identificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaNomina as $nomina): ?>
                            <tr>
                                <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                                <td><?= htmlspecialchars($empleado['centrocosto']) ?></td>
                                <td>$<?= number_format($empleado['cargo'], 0, ',', '.') ?></td>
                                <td>$<?= number_format($empleado['sueldo'], 0, ',', '.') ?></td>
                                <td>$<?= number_format($empleado['identificacion'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">
                EnviarCambios
            </button>
            <button type="reset" class="btn btn-primary">
                Borrar
            </button>
        </form>


        <?php
    include('Templates/pie.php');
?>