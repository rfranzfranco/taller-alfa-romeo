<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => 'Iniciar Sesión')); ?>
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
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Bienvenido!</h5>
                                    <p class="text-muted">Inicie sesión para continuar.</p>
                                </div>
                                <div class="p-2 mt-4">

                                    <?php if (session()->getFlashdata('message')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong> Éxito! </strong> <?= session()->getFlashdata('message') ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> Error! </strong> <?= session()->getFlashdata('error') ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <form action="/authenticate" method="post">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Usuario</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Ingrese nombre de usuario" required>
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <!-- <a href="auth-pass-reset-basic" class="text-muted">Forgot password?</a> -->
                                            </div>
                                            <label class="form-label" for="password-input">Contraseña</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5"
                                                    placeholder="Ingrese contraseña" id="password-input" name="password"
                                                    required>
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Iniciar Sesión</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">¿No tienes una cuenta? <a href="/register"
                                    class="fw-semibold text-primary text-decoration-underline"> Regístrate (Clientes)
                                </a> </p>
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