<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Use Tailwind CSS or Bootstrap/Custom CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Base Body and Layout to center the card - NOW WHITE BACKGROUND */
        body {
            /* Changed to solid white background as requested by the user */
            background-color: #ffffff; 
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            /* Changed page text color to dark for visibility on white background */
            color: #212529; 
        }

        /* Card Container (Mimics x-guest-layout wrapper) - REMAINS WHITE */
        .auth-card-wrapper {
            max-width: 440px; /* Width adjustment */
            width: 100%;
            background-color: #ffffff;
            border-radius: 12px; /* Rounded corners */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(0, 0, 0, 0.05); /* Soft shadow and border */
            padding: 2.5rem; /* Increased padding */
        }

        /* Main Heading: Forgot password? - REMAINS DARK (inside white card) */
        .forgot-header {
            font-size: 1.8rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        /* Sub-text: Remember your password? Login here - REMAINS DARK (inside white card) */
        .sub-text {
            font-size: 0.95rem;
            color: #6c757d;
            margin-bottom: 2rem;
            text-align: center;
        }
        .sub-text a {
            color: #007bff; /* Blue for 'Login here' */
            font-weight: 500;
            text-decoration: none;
        }
        .sub-text a:hover {
            text-decoration: underline;
        }

        /* Form Label: Email address - REMAINS DARK (inside white card) */
        .form-label-custom {
            font-weight: 700; /* Bold */
            color: #212529; /* Darker text */
            font-size: 1rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Input Field - REMAINS LIGHT */
        .form-control-custom {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da; /* Standard border color */
            border-radius: 8px; /* Rounded input corners */
            font-size: 1rem;
            box-shadow: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control-custom:focus {
            border-color: #5c84ff; /* A slightly softer blue border on focus */
            outline: none;
            box-shadow: 0 0 0 3px rgba(92, 132, 255, 0.2); /* Subtle blue glow */
        }

        /* Reset Password Button - REMAINS BLUE */
        .btn-reset-password {
            width: 100%;
            background-color: #3b71fe; /* Primary Blue from the image */
            border-color: #3b71fe;
            color: #ffffff;
            padding: 0.85rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            margin-top: 2rem; /* Spacing before the button */
            transition: background-color 0.2s, border-color 0.2s;
        }
        .btn-reset-password:hover {
            background-color: #0056b3; 
            border-color: #0056b3;
        }

        /* Adjustments for the original Blade structure elements */
        .mb-4.text-sm.text-gray-600 {
            display: none; /* Hide the default explanatory text */
        }
        .mt-4 {
            margin-top: 0 !important; /* Remove default top margin from the button container */
        }
    </style>
</head>
<body>

    <div class="auth-card-wrapper">

        <!-- Header Section -->
        <h1 class="forgot-header">Forgot password?</h1>
        <p class="sub-text">
            Remember your password? <a href="{{ route('login') }}">Login here</a>
        </p>

        <!-- The original explanatory text is hidden, as the image uses the sub-text -->
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <!-- Replaced x-input-label with a custom label for bold look -->
                <label for="email" class="form-label-custom">Email address</label>
                <!-- Assuming x-text-input outputs an input with class 'block mt-1 w-full' -->
                <!-- We apply our custom class to override its appearance -->
                <x-text-input 
                    id="email" 
                    class="form-control-custom" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                />
                <!-- Error messages display below the input -->
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <!-- Replaced x-primary-button with a custom button for blue color and size -->
                <button type="submit" class="btn-reset-password">
                    Reset password <!-- Changed button text to match the image -->
                </button>
            </div>
        </form>
        
    </div>

</body>
</html>