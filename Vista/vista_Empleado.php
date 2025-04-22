<?php include('Templates/cabecera.php'); ?>

<div class="container">
    <div class="row">
        <form action="fEditar.php" method="POST">
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
                            <?php foreach ($empleados as $empleado): ?>
                                <tr>
                                    <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                                    <td><?= htmlspecialchars($empleado['centrocosto']) ?></td>
                                    <td><?= htmlspecialchars($empleado['cargo']) ?></td>
                                    <td>$<?= number_format($empleado['sueldo'], 0, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($empleado['identificacion']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Enviar Cambios</button>
            <button type="reset" class="btn btn-secondary">Borrar</button>
        </form>
    </div>
</div>

<?php include('Templates/pie.php'); ?>
