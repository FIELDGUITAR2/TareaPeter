<?php
    include('Templates/cabecera.php');
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Bienvenido al sistema
        </div>
        
        <div class="card-body">
            <h5 class="card-title">¿Qué desea hacer?</h5>
            <div class="d-grid gap-3 mt-4">

                <a href="crear_Eliminar.php" class="btn btn-success btn-lg">Crear o Eliminar Empleado</a>
                <a href="vista_Empleado.php" class="btn btn-info btn-lg">Editar Empleado</a>
                <a href="vista_Nomina.php" class="btn btn-warning btn-lg">Nómina</a>
                
            </div>
        </div>
    </div>
</div>

<?php
    include('Templates/pie.php');
?>

