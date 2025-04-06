<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4">

                </div>
                <div class="col-md-4 mt-5">
                    <form action="Secciones/index.php" method="post">
                        <div class="card">
                            <div class="card-header">Inicio de sesion</div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <label for="" class="form-label">Usuario</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="usuario"
                                        id="usuario"
                                        aria-describedby="helpId"
                                        placeholder=""
                                    />
                                    <small id="helpId" class="form-text text-muted">Escriba su usuario</small>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        name="contrasenia"
                                        id="contrasenia"
                                        aria-describedby="helpId"
                                        placeholder="password"
                                    />
                                    <small id="helpId" class="form-text text-muted">Ingrese su contraseña</small>
                                </div>

                                <div class="mb-3">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-block"
                                        id="btnLogin"
                                    >
                                        Iniciar sesion
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
