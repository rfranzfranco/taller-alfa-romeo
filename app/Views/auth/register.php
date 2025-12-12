<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => 'Registro de Clientes')); ?>
    <?= $this->include('partials/head-css') ?>
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="/" class="d-inline-block auth-logo">
                                    <img src="/assets/images/logo-light.png" alt="" height="20">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Taller Mecánico Alfa Romeo</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-6">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Crear Cuenta de Cliente</h5>
                                    <p class="text-muted">Obtenga su cuenta de cliente gratuita ahora.</p>
                                </div>
                                <div class="p-2 mt-4">

                                    <?php if (session()->getFlashdata('errors')): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> Error! </strong>
                                            <ul>
                                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                    <li><?= esc($error) ?></li>
                                                <?php endforeach ?>
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form class="needs-validation" novalidate action="/register/store" method="post">
                                        <?= csrf_field() ?>

                                        <div class="mb-3">
                                            <label for="nombre_completo" class="form-label">Nombre Completo <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nombre_completo"
                                                name="nombre_completo" placeholder="Ingrese su nombre completo" required
                                                value="<?= old('nombre_completo') ?>">
                                            <div class="invalid-feedback">
                                                Por favor ingrese su nombre completo
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="ci_nit" class="form-label">CI / NIT <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="ci_nit" name="ci_nit"
                                                placeholder="Ingrese CI o NIT" required value="<?= old('ci_nit') ?>">
                                            <div class="invalid-feedback">
                                                Por favor ingrese CI o NIT
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="telefono" name="telefono"
                                                placeholder="Número de contacto" required
                                                value="<?= old('telefono') ?>">
                                            <div class="invalid-feedback">
                                                Por favor ingrese un teléfono
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="correo" class="form-label">Correo Electrónico <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="correo" name="correo"
                                                placeholder="ejemplo@correo.com" required value="<?= old('correo') ?>">
                                            <div class="invalid-feedback">
                                                Por favor ingrese un correo válido
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion"
                                                placeholder="Dirección de domicilio" value="<?= old('direccion') ?>">
                                        </div>

                                        <h6 class="fs-13 mt-4 mb-3 text-muted text-uppercase fw-semibold">Datos de
                                            Cuenta</h6>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Usuario <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Ingrese usuario" required value="<?= old('username') ?>">
                                            <div class="invalid-feedback">
                                                Por favor ingrese un usuario
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Contraseña <span
                                                    class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input"
                                                    onpaste="return false" placeholder="Ingrese contraseña"
                                                    id="password-input" name="password" required>
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                                <div class="invalid-feedback">
                                                    Por favor ingrese una contraseña
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-confirm-input">Confirmar Contraseña
                                                <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input"
                                                    onpaste="return false" placeholder="Confirme contraseña"
                                                    id="password-confirm-input" name="password_confirm" required>
                                                <div class="invalid-feedback">
                                                    Por favor confirme su contraseña
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <p class="mb-0 fs-12 text-muted fst-italic">Al registrarse acepta nuestros
                                                <a href="#"
                                                    class="text-primary text-decoration-underline fst-normal fw-medium">Términos
                                                    de Uso</a>
                                            </p>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Registrarse</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">¿Ya tienes una cuenta? <a href="/"
                                    class="fw-semibold text-primary text-decoration-underline"> Iniciar Sesión </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> Taller Alfa Romeo.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <?= $this->include('partials/vendor-scripts') ?>

    <script src="/assets/js/pages/form-validation.init.js"></script>
    <!-- password-addon init -->
    <script>
        document.getElementById('password-addon').addEventListener('click', function () {
            var passwordInput = document.getElementById("password-input");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    </script>
</body>

</html>