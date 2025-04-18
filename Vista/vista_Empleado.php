<?php
    include('Templates/cabecera.php');
?>

<div class="container">
    <div class="row">

        <form action="fEditar md-5 mt-5">
            <div class="card">
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

        </form>


        <?php
    include('Templates/pie.php');
?>