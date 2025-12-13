<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => 'Iniciar Sesión')); ?>
    <?= $this->include('partials/head-css') ?>
    <style>
        .auth-page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            position: relative;
            overflow: hidden;
        }
        
        .auth-page-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="gear" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="8" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="2"/><circle cx="25" cy="25" r="3" fill="rgba(255,255,255,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23gear)"/></svg>');
            opacity: 0.5;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        
        .login-left {
            background: linear-gradient(135deg, #405189 0%, #2c3e6e 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path d="M100,20 L120,60 L160,60 L130,90 L140,130 L100,105 L60,130 L70,90 L40,60 L80,60 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: 100px;
            opacity: 0.3;
        }
        
        .car-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .login-left h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .login-left p {
            font-size: 14px;
            opacity: 1;
            text-align: center;
            line-height: 1.6;
            color: #e0e5f1;
        }
        
        .features-list {
            list-style: none;
            padding: 0;
            margin-top: 30px;
        }
        
        .features-list li {
            padding: 8px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        
        .features-list li i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .login-right {
            padding: 50px 40px;
        }
        
        .logo-taller {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-taller .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #405189 0%, #2c3e6e 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 10px 20px rgba(64, 81, 137, 0.3);
        }
        
        .logo-taller .logo-icon i {
            font-size: 35px;
            color: white;
        }
        
        .logo-taller h4 {
            color: #1a1a2e;
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 5px;
        }
        
        .logo-taller p {
            color: #6c757d;
            font-size: 13px;
        }
        
        .form-label {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 14px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #405189;
            box-shadow: 0 0 0 0.2rem rgba(64, 81, 137, 0.15);
        }
        
        .input-group-text {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            background: #f8f9fa;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #405189 0%, #2c3e6e 100%);
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(64, 81, 137, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(64, 81, 137, 0.4);
            background: linear-gradient(135deg, #364574 0%, #232f54 100%);
        }
        
        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e9ecef;
        }
        
        .register-link a {
            color: #405189;
            font-weight: 600;
        }
        
        .register-link a:hover {
            color: #2c3e6e;
        }
        
        @media (max-width: 768px) {
            .login-left {
                display: none;
            }
            .login-card {
                margin: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-page-wrapper">
        <div class="container">
            <div class="login-card">
                <div class="row g-0">
                    <!-- Panel Izquierdo - Información del Taller -->
                    <div class="col-lg-5 login-left">
                        <div class="text-center position-relative" style="z-index: 1;">
                            <div class="car-icon">
                                <i class="ri-roadster-fill"></i>
                            </div>
                            <h2>Taller Alfa Romeo</h2>
                            <p>Sistema de Gestión Integral para el control de servicios, reservas y operaciones del taller mecánico.</p>
                            
                            <ul class="features-list mt-4">
                                <li><i class="ri-calendar-check-line"></i> Gestión de Reservas y Citas</li>
                                <li><i class="ri-tools-line"></i> Control de Órdenes de Trabajo</li>
                                <li><i class="ri-car-washing-line"></i> Historial de Servicios</li>
                                <li><i class="ri-stack-line"></i> Inventario de Insumos</li>
                                <li><i class="ri-file-list-3-line"></i> Facturación y Reportes</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Panel Derecho - Formulario de Login -->
                    <div class="col-lg-7 login-right">
                        <div class="logo-taller">
                            <div class="logo-icon">
                                <i class="ri-settings-4-line"></i>
                            </div>
                            <h4>Bienvenido</h4>
                            <p>Ingrese sus credenciales para acceder al sistema</p>
                        </div>

                        <?php if (session()->getFlashdata('message')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="ri-check-double-line me-2"></i>
                                <?= session()->getFlashdata('message') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="ri-error-warning-line me-2"></i>
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="/authenticate" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="mb-4">
                                <label for="username" class="form-label">
                                    <i class="ri-user-line me-1"></i> Usuario
                                </label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Ingrese su nombre de usuario" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="password-input">
                                    <i class="ri-lock-line me-1"></i> Contraseña
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control pe-5"
                                        placeholder="Ingrese su contraseña" id="password-input" name="password"
                                        required>
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted h-100"
                                        type="button" id="password-addon">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-login w-100 text-white" type="submit">
                                    <i class="ri-login-circle-line me-2"></i> Iniciar Sesión
                                </button>
                            </div>
                        </form>

                        <div class="register-link">
                            <p class="mb-0 text-muted">
                                ¿No tienes una cuenta? 
                                <a href="/register">Regístrate como Cliente</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="text-center mt-4">
                <p class="text-white-50 mb-0" style="font-size: 13px;">
                    &copy; <script>document.write(new Date().getFullYear())</script> 
                    Taller Mecánico Alfa Romeo - Sistema de Gestión
                </p>
            </div>
        </div>
    </div>

    <?= $this->include('partials/vendor-scripts') ?>

    <!-- password-addon init -->
    <script>
        document.getElementById('password-addon').addEventListener('click', function () {
            var passwordInput = document.getElementById("password-input");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.querySelector('i').classList.remove('ri-eye-fill');
                this.querySelector('i').classList.add('ri-eye-off-fill');
            } else {
                passwordInput.type = "password";
                this.querySelector('i').classList.remove('ri-eye-off-fill');
                this.querySelector('i').classList.add('ri-eye-fill');
            }
        });
    </script>
</body>

</html>