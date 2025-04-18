<?php
    include('Templates/cabecera.php');
?>
<div class="container">
    <div class="row">
        <!-- Primera columna -->
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-header">Datos Tarjeta ID</div>
                <div class="card-body">
                    <form class="fIdentificacion mt-3 mb-3" action="" method="post">
                        <div class="mb-3">
                            <label for="cedula" class="form-label">No de Cédula</label>
                            <input type="text" class="form-control" name="cedula" id="cedula" placeholder="">
                            <small class="form-text text-muted">Inserte aquí el <strong>Número de
                                    Cédula</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="selectTipoCedula" class="form-label">Tipo de Documento</label>
                            <select class="form-select form-select-lg" name="selectTipoCedula" id="selectTipoCedula">
                                <option selected>Select one</option>
                                <option value="1">Cédula de Ciudadanía</option>
                            </select>
                            <small class="form-text text-muted">Inserte aquí el <strong>Tipo de
                                    Documento</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="selectCiudad" class="form-label">Ciudad de Expedición</label>
                            <select class="form-select form-select-lg" name="selectCiudad" id="selectCiudad">
                                <option selected>Select one</option>
                                <option value="1">Bogotá</option>
                            </select>
                            <small class="form-text text-muted">Inserte aquí la <strong>Ciudad de
                                    Expedición</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="selectNacionalidad" class="form-label">Nacionalidad</label>
                            <select class="form-select form-select-lg" name="selectNacionalidad"
                                id="selectNacionalidad">
                                <option selected>Select one</option>
                                <option value="1">Colombia</option>
                            </select>
                            <small class="form-text text-muted">Inserte aquí el <strong>País de
                                    Nacimiento</strong></small>
                        </div>
                        <div class="btn-group" role="group" aria-label="Button group name">
                            <button type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                            <button type="reset" class="btn btn-primary">
                                Borrar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Segunda columna -->
        <div class="col-md-4 mt-3">
            <div class="card">
                <div class="card-header">Datos Personales</div>
                <div class="card-body">
                    <form class="fInscripcion mt-3 mb-3" action="" method="post">
                        <div class="mb-3">
                            <label for="primerNombre" class="form-label">Primer Nombre</label>
                            <input type="text" class="form-control" name="primerNombre" id="primerNombre"
                                placeholder="">
                            <small class="form-text text-muted">Inserte aquí el <strong>Primer nombre</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="segundoNombre" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control" name="segundoNombre" id="segundoNombre"
                                placeholder="">
                            <small class="form-text text-muted">Inserte aquí el <strong>Segundo nombre</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="primerApellido" class="form-label">Primer Apellido</label>
                            <input type="text" class="form-control" name="primerApellido" id="primerApellido"
                                placeholder="">
                            <small class="form-text text-muted">Inserte aquí el <strong>Primer apellido</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="segundoApellido" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" name="segundoApellido" id="segundoApellido"
                                placeholder="">
                            <small class="form-text text-muted">Inserte aquí el <strong>Segundo
                                    apellido</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Email</label>
                            <input type="email" class="form-control" name="correo" id="correo" placeholder="">
                            <small class="form-text text-muted">Inserte aquí el <strong>Email</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Número de Teléfono</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="">
                            <small class="form-text text-muted">Inserte aquí el <strong>Teléfono</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="selectTrabajo" class="form-label">Cargo</label>
                            <select class="form-select form-select-lg" name="selectTrabajo" id="selectTrabajo">
                                <option selected>Select one</option>
                                <option value="1">Gerente</option>
                                <!-- Agrega más cargos aquí -->
                            </select>
                            <small class="form-text text-muted">Inserte aquí el <strong>Cargo</strong></small>
                        </div>
                        <div class="mb-3">
                            <label for="fechaNac" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fechaNac" id="fechaNac">
                            <small class="form-text text-muted">Inserte aquí la <strong>Fecha de
                                    nacimiento</strong></small>
                        </div>
                        <div class="btn-group" role="group" aria-label="Button group name">
                            <button type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                            <button type="reset" class="btn btn-primary">
                                Borrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tercera columna vacía (puedes llenarla después si necesitas) -->
        <div class="col-md-4 mb-3 mt-3">
            <div class="card">
                <div class="card-header">Tipo de Contrato</div>
                <div class="card-body">
                    <form class="fInscripcion mt-3 mb-3" action="" method="post">
                        <div class="mb-3">
                            <label for="primerNombre" class="form-label">Primer Nombre</label>
                            <input type="text" class="form-control" name="primerNombre" id="primerNombre"
                                placeholder="">
                            <small class="form-text text-muted">Inserte aquí el <strong>Primer nombre</strong></small>
                        </div>
                        <div class="btn-group" role="group" aria-label="Button group name">
                            <button type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                            <button type="reset" class="btn btn-primary">
                                Borrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php
    include('Templates/pie.php');
?>