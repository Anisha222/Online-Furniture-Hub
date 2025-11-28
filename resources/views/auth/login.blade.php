<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furnihub Login/Register</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Color Definitions (Matching the original E-Leave Portal look) */
        :root {
            --primary-bg: #f5f7fa;   
            --card-bg: #ffffff;      
            --input-bg: #f8f9fa;     
            --input-border-default: #dee2e6; 
            --input-border-focus: #5d5dff; 
            --button-color: #343a40; 
            --text-dark: #212529;    
            --link-color: #6c757d;   
            --link-hover-color: #0d6efd; 
        }

        /* General Body and Layout */
        body {
            background-color: var(--primary-bg); 
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--text-dark); 
            padding: 20px;
            overflow: auto;
        }

        /* Header and Title */
        .portal-header { 
            margin-bottom: 2.5rem; 
            text-align: center;
            /* Added transition for smoother layout change */
            transition: margin-bottom 0.3s ease; 
        }
        .portal-header h1 { 
            font-size: 2.2rem; 
            font-weight: 700; 
            color: var(--text-dark);
            margin-top: 1.5rem; 
            letter-spacing: -0.5px; 
            /* Added transition for smoother title movement */
            transition: margin-top 0.3s ease;
        }
        
        /* LOGO CONTAINER STYLES (for hiding/showing) */
        .portal-logo-container {
            transition: opacity 0.3s ease, height 0.3s ease;
            overflow: hidden; /* Important for hiding content smoothly */
            height: auto;
            opacity: 1;
        }

        /* LOGO SIZE INCREASED HERE (180px -> 220px) */
        .portal-header img { 
            max-width: 220px; /* Increased image size */
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 50%;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05); 
        }

        /* Login Card */
        .auth-card-container { max-width: 440px; width: 100%; }
        .login-card { background: var(--card-bg); border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); border: none; padding: 2.5rem 3rem; }

        /* Form Labels/Inputs (Keeping User-Friendly styles) */
        .form-label { font-weight: 600; color: var(--text-dark); font-size: 0.95rem; margin-bottom: 0.4rem;}
        .form-control { background-color: var(--input-bg); border: 1px solid var(--input-border-default); padding: 0.9rem 1.1rem; border-radius: 10px; transition: all 0.3s ease;}
        .form-control:focus { background-color: #ffffff; border-color: var(--input-border-focus); box-shadow: 0 0 0 0.25rem rgba(93, 93, 255, 0.2); }
        .form-check-input { width: 1.1em; height: 1.1em; border-radius: 4px; border: 1px solid #ced4da; cursor: pointer;}
        .form-check-input:checked { background-color: var(--button-color); border-color: var(--button-color);}

        /* Footer Layout */
        .auth-footer { display: block; margin-top: 1rem; }
        .remember-me-row { margin-bottom: 1.5rem; }
        .link-button-row { display: flex; justify-content: flex-end; align-items: center; }
        
        .register-link { color: var(--link-color); text-decoration: none; font-size: 0.95rem; font-weight: 500; margin-right: 15px; white-space: nowrap; cursor: pointer;}
        .register-link:hover { color: var(--link-hover-color); text-decoration: underline;}

        .btn-submit { background-color: var(--button-color); border-color: var(--button-color); color: #ffffff; padding: 0.75rem 1.5rem; font-weight: 600; font-size: 1rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); flex-shrink: 0; }
        .btn-submit:hover { background-color: #495057; border-color: #495057; transform: translateY(-1px); box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);}
        
        /* Styles for Register Form (Hiding Remember Me and adjusting footer) */
        #register-form .remember-me-row { display: none; }
        #register-form .link-button-row { margin-top: 0; justify-content: space-between; }


        /* REGISTER STATE MODIFICATIONS (For hiding the logo and tightening the header) */
        .register-active .portal-logo-container {
            height: 0 !important;
            opacity: 0 !important;
            margin-bottom: 0 !important;
        }
        .register-active .portal-header {
            margin-bottom: 1.5rem; /* Reduced margin above card */
        }
        .register-active .portal-header h1 {
            margin-top: 0; /* Title moved up */
        }
    </style>
</head>
<body id="main-body">

    <div class="portal-header">
        <!-- Logo is now bigger -->
        <div id="logo-container" class="portal-logo-container">
            <h1 id="portal-title">Furnihub Login</h1>
             <img src="../images/F-Logo.png" alt="Furnihub Logo">
        </div>
    </div>

    <div class="auth-card-container">
        <div class="login-card">
            
            <!-- Login Form -->
            <form id="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus placeholder="name@example.com">
                </div>
                
                <!-- Password Field -->
                <div class="mb-4"> 
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>
                
                <!-- Footer (Two-Row Layout) -->
                <div class="auth-footer">
                    
                    <!-- TOP ROW: Remember Me Checkbox -->
                    <div class="remember-me-row">
                        <div class="form-check m-0">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>
                    
                    <!-- BOTTOM ROW: Register Link and Log In Button -->
                    <div class="link-button-row">
                        <!-- Register Account Link -->
                        <span id="show-register" class="register-link">Register Now!</span>
                        
                        <!-- Log In Button -->
                        <button type="submit" class="btn btn-submit">
                            LOG IN
                        </button>
                    </div>
                </div>
            </form>

            <!-- Register Form (Initially Hidden) -->
            <form id="register-form" method="POST" action="{{ route('register') }}" style="display: none;">
                @csrf
                
                <!-- Name Field -->
                <div class="mb-3">
                    <label for="reg-name" class="form-label">Full Name</label>
                    <input id="reg-name" type="text" class="form-control" name="name" required autocomplete="name" autofocus placeholder="Enter your full name">
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label for="reg-email" class="form-label">Email</label>
                    <input id="reg-email" type="email" class="form-control" name="email" required autocomplete="email" placeholder="name@example.com">
                </div>
                
                <!-- Password Field -->
                <div class="mb-3"> 
                    <label for="reg-password" class="form-label">Password</label>
                    <input id="reg-password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="Choose a password">
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-4"> 
                    <label for="reg-password-confirm" class="form-label">Confirm Password</label>
                    <input id="reg-password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password">
                </div>
                
                <!-- Footer (Two-Row Layout) -->
                <div class="auth-footer">
                     <!-- This row is hidden by CSS -->
                    <div class="remember-me-row">
                        <div class="form-check m-0"></div> 
                    </div>
                    
                    <!-- BOTTOM ROW: Login Link and Register Button -->
                    <div class="link-button-row">
                        <!-- Login Link -->
                        <span id="show-login" class="register-link">Already have an account?</span>
                        
                        <!-- Register Button -->
                        <button type="submit" class="btn btn-submit">
                            REGISTER
                        </button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>

    <!-- JavaScript for Form Toggling -->
    <script>
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const titleElement = document.getElementById('portal-title');
        const mainBody = document.getElementById('main-body');
        const logoContainer = document.getElementById('logo-container');

        document.getElementById('show-register').addEventListener('click', function(e) {
            e.preventDefault();
            
            // 1. Swap forms
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            
            // 2. Update Header/Logo
            titleElement.textContent = 'Furnihub Register';
            mainBody.classList.add('register-active'); // Hides logo via CSS class
        });
        
        document.getElementById('show-login').addEventListener('click', function(e) {
            e.preventDefault();
            
            // 1. Swap forms
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
            
            // 2. Update Header/Logo
            titleElement.textContent = 'Furnihub Login';
            mainBody.classList.remove('register-active'); // Shows logo via CSS class
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>