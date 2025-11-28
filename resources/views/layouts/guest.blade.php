<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- --- Bootstrap CSS --- --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        {{-- --- Font Awesome CSS --- --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Custom styling for the logo image */
            .custom-guest-logo {
                width: 80px;  /* Matches w-20 in Tailwind */
                height: 80px; /* Matches h-20 in Tailwind */
                object-fit: contain; /* Ensures the logo scales correctly without cropping */
                /* Optional: Add a small margin below the logo to separate it from the card */
                margin-bottom: 0.5rem; 
            }
            
            /* Custom styling for the guest layout */
            body {
                background-color: #ffffff !important; /* Set a clean white background */
            }
            /* Main container: Centered, occupying full screen height */
            .min-h-screen.flex.flex-col.sm\:justify-center.items-center.pt-6.sm\:pt-0 {
                background-color: #ffffff !important; /* Ensure the main div also has white background */
            }
            /* Styling for the card containing the form */
            .w-full.sm:max-w-md.mt-6.px-6.py-4.bg-white.shadow-md.overflow-hidden.sm:rounded-lg {
                box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* Softer shadow */
                border-radius: 10px; /* Rounded corners */
            }
            /* General button styling (adjust selector if your login button has a specific class) */
            .btn-primary { /* Assuming your login form's button uses btn-primary class or similar */
                background-color: #007bff; /* Standard blue */
                border-color: #007bff;
                transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #0056b3;
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            /* Styling for links like "Don't have an account?" and "Forgot password?" */
            a {
                color: #007bff; /* Standard blue */
                text-decoration: none;
                transition: color 0.2s ease;
            }
            a:hover {
                color: #0056b3;
                text-decoration: underline;
            }
            /* Text color for form labels, headers etc. */
            .text-gray-900 {
                color: #212529; /* Darker text for readability on white background */
            }
            .text-gray-500 {
                color: #6c757d; /* Muted gray for secondary text */
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- Main Centered Container --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- Logo Area --}}
            <div>
                <a href="/">
                    <!-- CUSTOM LOGO REPLACEMENT: References public/image/logo.jpg -->
                    <img src="{{ asset('image/logo.jpg') }}" alt="{{ config('app.name', 'My Project Logo') }}" class="custom-guest-logo">
                </a>
            </div>

            {{-- Form Card Area --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        
        {{-- Scripts --}}
        @stack('scripts')
    </body>
</html>