<?php
    include('../Templates/cabecera.php');
?>

<div class="col-md-5">
    <form class="fInscripcion mt-5 mb-5" action="" method="post">
    <div class="mb-3">
        <label for="" class="form-label">Primer Nombre</label>
        <input
            type="text"
            class="form-control"
            name="primerNombre"
            id="primerNombre"
            aria-describedby="helpId"
            placeholder=""
        />
        <small id="helpId" class="form-text text-muted">Inserte aqui el <strong>Primer nombre</strong></small>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Segundo Nombre</label>
        <input
            type="text"
            class="form-control"
            name="segundNombre"
            id="segundoNombre"
            aria-describedby="helpId"
            placeholder=""
        />
        <small id="helpId" class="form-text text-muted">Inserte aqui el <strong>Segundo nombre</strong></small>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Primer Apellido</label>
        <input
            type="text"
            class="form-control"
            name="primerApellido"
            id="primerApellido"
            aria-describedby="helpId"
            placeholder=""
        />
        <small id="helpId" class="form-text text-muted">Inserte aqui el <strong>Primer apellido</strong></small>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Segundo Apellido</label>
        <input
            type="text"
            class="form-control"
            name="segundoApellido"
            id="segundoApellido"
            aria-describedby="helpId"
            placeholder=""
        />
        <small id="helpId" class="form-text text-muted">Inserte aqui el <strong>Segundo apellido</strong></small>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Email</label>
        <input
            type="text"
            class="form-control"
            name="correo"
            id="correo"
            aria-describedby="helpId"
            placeholder=""
        />
        <small id="helpId" class="form-text text-muted">Inserte aqui el <strong>Email</strong></small>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Numero de telefono</label>
        <input
            type="text"
            class="form-control"
            name="telefono"
            id="telefono"
            aria-describedby="helpId"
            placeholder=""
        />
        <small id="helpId" class="form-text text-muted">Inserte aqui el <strong>Telefono</strong></small>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Cargo</label>
        <select
            class="form-select form-select-lg"
            name="selectTrabajo"
            id="selectTrabajo"
        >
            <option selected>Select one</option>
            <option value="1">Gerente</option>
            <option value="2">Sub Gerente</option>
            <option value="3">Coordinador Agro</option>
            <option value="4">Asistente varios</option>
            <option value="5">Contador</option>
            <option value="6">Coordinador Administrativo</option>
            <option value="7">Mayordomo</option>
            <option value="8">Auxiliar de Mayordomo</option>
            <option value="9">Servicios Generales</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Fecha de Nacimiento</label>
        <input type="date" 
            class="form-control"
            name="fechaNac"
            id="fechaNac"
            aria-describedby="helpId">
    </div>
    </form>
    
</div>
<div class="col-md-7">

</div>

<?php
    include('../Templates/pie.php');
?>