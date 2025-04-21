<?php include('../Templates/cabecera.php'); ?>
<div class="container">
    <h2 class="text-center mt-4 mb-4">Gestión de Nómina</h2>

    <!-- Formulario de selección de tipo de nómina -->
    <form method="post" action="ControladorNomina.php?accion=generarNomina">
        <div class="mb-3">
            <label class="form-label">Tipo de Nómina:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tipoNomina" id="general" value="general" checked>
                <label class="form-check-label" for="general">General</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="tipoNomina" id="individual" value="individual">
                <label class="form-check-label" for="individual">Individual</label>
            </div>
        </div>

        <!-- Selector de empleado para nómina individual -->
        <div class="mb-3" id="selectEmpleadoDiv" style="display: none;">
            <label for="empleadoId" class="form-label">Seleccionar Empleado:</label>
            <select class="form-select" name="empleadoId" id="empleadoId">
                <?php foreach($empleados as $empleado): ?>
                    <option value="<?= $empleado->getId() ?>"><?= htmlspecialchars($empleado->getNombre() . ' ' . $empleado->getApellido()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Generar Nómina</button>
    </form>

    <script>
        document.querySelectorAll('input[name="tipoNomina"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.getElementById('selectEmpleadoDiv').style.display =
                    radio.value === 'individual' ? 'block' : 'none';
            });
        });
    </script>

    <?php if (!empty($nominas)): ?>
        <!-- Tabla para nómina general -->
        <h3 class="mt-5">Nómina General</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Empleado</th>
                    <th>Total Devengado</th>
                    <th>Total Deducciones</th>
                    <th>Total a Pagar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($nominas as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombreCompleto']) ?></td>
                    <td>$<?= number_format($item['total_devengado'],0,',','.') ?></td>
                    <td>$<?= number_format($item['total_deducciones'],0,',','.') ?></td>
                    <td><strong>$<?= number_format($item['total_pagar'],0,',','.') ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (!empty($nomina)): ?>
        <!-- Tabla para nómina individual -->
        <h3 class="mt-5">Nómina de <?= htmlspecialchars($nomina['nombreCompleto']) ?></h3>
        <table class="table table-bordered">
            <tr><th>Total Devengado</th><td>$<?= number_format($nomina['total_devengado'],0,',','.') ?></td></tr>
            <tr><th>Total Deducciones</th><td>$<?= number_format($nomina['total_deducciones'],0,',','.') ?></td></tr>
            <tr><th>Total a Pagar</th><td><strong>$<?= number_format($nomina['total_pagar'],0,',','.') ?></strong></td></tr>
        </table>
    <?php endif; ?>
</div>
<?php include('../Templates/pie.php'); ?>
