<?php include('../Templates/cabecera.php');?>
<div class="container">
    <h2 class="text-center mt-4 mb-4">Listado de Nómina</h2>
    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Salario</th>
                <th>Días Laborados</th>
                <th>Salud</th>
                <th>Pensión</th>
                <th>Total Devengado</th>
                <th>Total Deducciones</th>
                <th>Total a Pagar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaNomina as $nomina): ?>
                <tr>
                    <td><?= htmlspecialchars($nomina['nombre']) ?></td>
                    <td><?= htmlspecialchars($nomina['cargo']) ?></td>
                    <td>$<?= number_format($nomina['salario'], 0, ',', '.') ?></td>
                    <td><?= $nomina['dias_laborados'] ?></td>
                    <td>$<?= number_format($nomina['salud'], 0, ',', '.') ?></td>
                    <td>$<?= number_format($nomina['pension'], 0, ',', '.') ?></td>
                    <td>$<?= number_format($nomina['total_devengado'], 0, ',', '.') ?></td>
                    <td>$<?= number_format($nomina['total_deducciones'], 0, ',', '.') ?></td>
                    <td><strong>$<?= number_format($nomina['total_pagar'], 0, ',', '.') ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('../Templates/pie.php');?>