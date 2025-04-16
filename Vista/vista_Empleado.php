<?php
    include('../Templates/cabecera.php');
?>
    Vista Empleado
    <div class="container">
    <div class="row">
      
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

<?php
    include('../Templates/pie.php');
?>