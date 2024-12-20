<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once '../components/head.php'; ?>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
    <header>
        <?php include_once '../components/header.php'; ?>
    </header>

    <main class="lands-view">
        <div class="container__login-sign">
            <div class="container__left">
                <form action="../php/create.client.php" method="POST" class="form-sign" style="display: none;">
                    <h1>Crea tu cuenta</h1>
                    <span>Ingresa tus datos, para ver tu seguimiento de tus productos</span>
                    <div class="form-group-sign">
                        <div class="square-for-icon">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                        <input type="text" name="name-client-sign" id="name-client-sign" placeholder="Nombre *">
                    </div>

                    <div class="form-group-sign">
                        <div class="square-for-icon">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                        <input type="text" name="last-name1-client-sign" id="last-name-client-sign" placeholder="Apellidos Paterno*">
                    </div>

                    <div class="form-group-sign">
                        <div class="square-for-icon">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                        <input type="text" name="last-name2-client-sign" id="last-name-client-sign" placeholder="Apellidos Materno*">
                    </div>

                    <div class="form-group-sign">
                        <div class="square-for-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input type="email" name="email-client-sign" id="email-client-sign" placeholder="Correo *">
                    </div>

                    <div class="form-group-sign">
                        <div class="square-for-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <input type="tel" name="phone-client-sign" id="phone-client-sign" placeholder="Teléfono *">
                    </div>

                    <div class="form-group-sign">
                        <div class="square-for-icon">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <input type="password" name="password-client-sign" id="password-client-sign" placeholder="Contraseña *">
                    </div>

                    <div class="form-group-sign">
                        <div class="square-for-icon">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <input type="password" name="confirm-password-client-sign" id="confirm-password-client-sign" placeholder="Confirmar contraseña *">
                    </div>

                    <div class="form-group-sign-check">
                        <input type="checkbox" name="terms-and-conditions" id="terms-and-conditions">
                        <label for="terms-and-conditions">He leído y acepto los términos y condiciones</label>
                    </div>

                    <div class="form-group-sign-check">
                        <input type="checkbox" name="newsletter" id="newsletter">
                        <label for="newsletter">Suscribirme al Newsletter</label>
                    </div>

                    <button type="submit" class="btn-sign">Registrarme</button>

                    <a href="">Términos y condiciones</a>

                    <a href="#"><strong>¿Ya tienes cuenta?</strong></a>
                    <a href="#" id="Creartucuenta">Ingresar</a>
                </form>

                <div class="sign-screen" style="display: block;">
                    <h2>Acceder a tu cuenta</h2>
                    <span>Ingresa tus datos para ver el seguimiento de tus productos</span>

                    <form action="../php/access.user.php" method="POST" class="form-login">
                        <div class="form-group-sign">
                            <div class="square-for-icon">
                                <i class="fa-solid fa-circle-user"></i>
                            </div>
                            <input type="email" name="email-client-sign-in" id="email-client-sign-in" placeholder="Correo *">
                        </div>

                        <div class="form-group-sign">
                            <div class="square-for-icon">
                                <i class="fa-solid fa-key"></i>
                            </div>
                            <input type="password" name="password-client-sign-in" id="password-client-sign-in" placeholder="Contraseña *">
                        </div>

                        <button type="submit" class="btn-sign space-top">Ingresar</button>

                        <div class="info-sign">
                            <a href="">Términos y condiciones</a>
                        </div>

                        <div class="info-sign">
                            <a href="#"><strong>¿Aun no tienes cuenta?</strong></a>
                        </div>

                        <div class="info-sign">
                            <a href="#" id="ocultarIniciarsesion">Registrarme</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="container__right">
                <img src="./back1.jpg" alt="Imagen de registro">
            </div>
        </div>
    </main>
    <div class="divider-sections-black"></div>
    <footer>
        <?php include_once '../components/footer.php'; ?>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const signUpForm = document.querySelector('.form-sign');
            const signInForm = document.querySelector('.sign-screen');
            const showSignInLink = document.querySelector('#Creartucuenta');
            const showSignUpLink = document.querySelector('#ocultarIniciarsesion');

            // Inicialmente mostrar el formulario de "Acceder a tu cuenta"
            signUpForm.style.display = 'none';
            signInForm.style.display = 'block';

            showSignInLink.addEventListener('click', function(event) {
                event.preventDefault();
                signUpForm.style.display = 'none';
                signInForm.style.display = 'block';
            });

            showSignUpLink.addEventListener('click', function(event) {
                event.preventDefault();
                signUpForm.style.display = 'block';
                signInForm.style.display = 'none';
            });
        });
    </script>
</body>

</html>