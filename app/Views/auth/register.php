<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => 'Registro de Clientes')); ?>
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
            padding: 30px 0;
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
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
        }
        
        .register-left {
            background: linear-gradient(135deg, #405189 0%, #2c3e6e 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
        }
        
        .register-left::before {
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
            font-size: 70px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .register-left h2 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .register-left p {
            font-size: 14px;
            opacity: 0.9;
            text-align: center;
            line-height: 1.6;
        }
        
        .benefits-list {
            list-style: none;
            padding: 0;
            margin-top: 25px;
            width: 100%;
        }
        
        .benefits-list li {
            padding: 10px 15px;
            font-size: 13px;
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            margin-bottom: 10px;
        }
        
        .benefits-list li i {
            margin-right: 12px;
            font-size: 20px;
            color: #6ae0bd;
        }
        
        .register-right {
            padding: 40px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .logo-taller {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .logo-taller .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #405189 0%, #2c3e6e 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            box-shadow: 0 8px 16px rgba(64, 81, 137, 0.3);
        }
        
        .logo-taller .logo-icon i {
            font-size: 28px;
            color: white;
        }
        
        .logo-taller h4 {
            color: #1a1a2e;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .logo-taller p {
            color: #6c757d;
            font-size: 12px;
        }
        
        .form-label {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 13px;
            margin-bottom: 6px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 10px 14px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #405189;
            box-shadow: 0 0 0 0.2rem rgba(64, 81, 137, 0.15);
        }
        
        .section-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #405189;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 20px 0 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 8px;
            font-size: 16px;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #405189 0%, #2c3e6e 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(64, 81, 137, 0.3);
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(64, 81, 137, 0.4);
            background: linear-gradient(135deg, #364574 0%, #232f54 100%);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .login-link a {
            color: #405189;
            font-weight: 600;
        }
        
        .login-link a:hover {
            color: #2c3e6e;
        }
        
        .terms-text {
            font-size: 11px;
            color: #6c757d;
        }
        
        .terms-text a {
            color: #405189;
        }
        
        @media (max-width: 991px) {
            .register-left {
                display: none;
            }
            .register-card {
                margin: 20px;
            }
        }
        
        /* Custom scrollbar */
        .register-right::-webkit-scrollbar {
            width: 6px;
        }
        
        .register-right::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .register-right::-webkit-scrollbar-thumb {
            background: #405189;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="auth-page-wrapper">
        <div class="container">
            <div class="register-card">
                <div class="row g-0">
                    <!-- Panel Izquierdo - Información -->
                    <div class="col-lg-4 register-left">
                        <div class="text-center position-relative" style="z-index: 1;">
                            <div class="car-icon">
                                <i class="ri-user-add-line"></i>
                            </div>
                            <h2>Únete al Taller</h2>
                            <p>Regístrate como cliente y accede a todos los beneficios de nuestro sistema de gestión.</p>
                            
                            <ul class="benefits-list mt-4">
                                <li>
                                    <i class="ri-calendar-check-line"></i>
                                    <span>Agenda citas en línea fácilmente</span>
                                </li>
                                <li>
                                    <i class="ri-history-line"></i>
                                    <span>Consulta el historial de tus vehículos</span>
                                </li>
                                <li>
                                    <i class="ri-notification-3-line"></i>
                                    <span>Recibe notificaciones de estado</span>
                                </li>
                                <li>
                                    <i class="ri-file-list-3-line"></i>
                                    <span>Accede a tus facturas digitales</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Panel Derecho - Formulario de Registro -->
                    <div class="col-lg-8 register-right">
                        <div class="logo-taller">
                            <div class="logo-icon">
                                <i class="ri-user-add-fill"></i>
                            </div>
                            <h4>Crear Cuenta de Cliente</h4>
                            <p>Complete el formulario para registrarse en el sistema</p>
                        </div>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="ri-error-warning-line me-2"></i>
                                <strong>Error de validación:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form class="needs-validation" novalidate action="/register/store" method="post">
                            <?= csrf_field() ?>

                            <!-- Datos Personales -->
                            <div class="section-title">
                                <i class="ri-user-3-line"></i> Datos Personales
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre_completo" class="form-label">
                                        Nombre Completo <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="nombre_completo"
                                        name="nombre_completo" placeholder="Ingrese su nombre completo" required
                                        value="<?= old('nombre_completo') ?>">
                                    <div class="invalid-feedback">Por favor ingrese su nombre completo</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="ci_nit" class="form-label">
                                        CI / NIT <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="ci_nit" name="ci_nit"
                                        placeholder="Ingrese CI o NIT" required value="<?= old('ci_nit') ?>">
                                    <div class="invalid-feedback">Por favor ingrese CI o NIT</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label">
                                        Teléfono <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="telefono" name="telefono"
                                        placeholder="Número de contacto" required value="<?= old('telefono') ?>">
                                    <div class="invalid-feedback">Por favor ingrese un teléfono</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="correo" class="form-label">
                                        Correo Electrónico <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" id="correo" name="correo"
                                        placeholder="ejemplo@correo.com" required value="<?= old('correo') ?>">
                                    <div class="invalid-feedback">Por favor ingrese un correo válido</div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                    placeholder="Dirección de domicilio (opcional)" value="<?= old('direccion') ?>">
                            </div>

                            <!-- Datos de Cuenta -->
                            <div class="section-title">
                                <i class="ri-shield-user-line"></i> Datos de Cuenta
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="username" class="form-label">
                                        Usuario <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Elija un nombre de usuario" required value="<?= old('username') ?>">
                                    <div class="invalid-feedback">Por favor ingrese un usuario</div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="password-input">
                                        Contraseña <span class="text-danger">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control pe-5"
                                            placeholder="Mínimo 5 caracteres" id="password-input" name="password" required>
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted h-100"
                                            type="button" id="password-addon">
                                            <i class="ri-eye-fill align-middle"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">Por favor ingrese una contraseña</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="password-confirm-input">
                                        Confirmar Contraseña <span class="text-danger">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control pe-5"
                                            placeholder="Repita la contraseña" id="password-confirm-input" name="password_confirm" required>
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted h-100"
                                            type="button" id="password-confirm-addon">
                                            <i class="ri-eye-fill align-middle"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">Por favor confirme su contraseña</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <p class="terms-text mb-0">
                                    <i class="ri-checkbox-circle-line text-success me-1"></i>
                                    Al registrarse acepta nuestros 
                                    <a href="#" class="text-decoration-underline">Términos de Uso</a> y 
                                    <a href="#" class="text-decoration-underline">Política de Privacidad</a>
                                </p>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-register w-100 text-white" type="submit">
                                    <i class="ri-user-add-line me-2"></i> Crear Mi Cuenta
                                </button>
                            </div>
                        </form>

                        <div class="login-link">
                            <p class="mb-0 text-muted">
                                ¿Ya tienes una cuenta? 
                                <a href="/">Iniciar Sesión</a>
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

    <script src="/assets/js/pages/form-validation.init.js"></script>
    <!-- password toggle -->
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
        
        document.getElementById('password-confirm-addon').addEventListener('click', function () {
            var passwordInput = document.getElementById("password-confirm-input");
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