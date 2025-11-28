{{-- resources/views/layouts/user.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Furniture Shopping')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome CSS (for icons) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- Tailwind CSS (from Vite, if still needed for other elements) --}}
    @vite(['resources/css/app.css'])

    {{-- Custom styles pushed from individual pages --}}
    @stack('styles')

    <style>
        /* Base layout for sidebar and content */
        body {
            margin: 0;
            background-color: #f8f9fa; /* Consistent light grey page background for content area */
            font-family: 'figtree', sans-serif;
            display: flex; /* Makes the body a flex container to hold sidebar and content side-by-side */
            min-height: 100vh; /* Ensures body takes full viewport height */
        }

        #wrapper {
            display: flex;
            width: 100%;
        }

        /* Sidebar styling */
        #sidebar-wrapper {
            min-width: 250px;
            max-width: 250px;
            background-color: #212529; /* Dark background */
            color: #ffffff;
            position: sticky; /* Makes sidebar stick on scroll */
            top: 0;
            height: 100vh; /* Full viewport height */
            z-index: 1000;
            box-shadow: 2px 0 8px rgba(0,0,0,0.2);
            transition: margin-left 0.3s ease-in-out;
            display: flex; /* Make sidebar content flexible */
            flex-direction: column;
        }

        /* Sidebar Header (Furniture Shopping title) */
        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1rem;
            font-size: 1.5rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            background-color: #1a1e22;
        }

        /* Sidebar Nav Items */
        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: rgba(255, 255, 255, 0.8);
            border: none;
            padding: 0.8rem 1.5rem;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, transform 0.2s ease-in-out;
            border-radius: 0;
        }
        #sidebar-wrapper .list-group-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: #ffffff;
            transform: translateX(3px);
        }
        #sidebar-wrapper .list-group-item.active {
            background-color: #0d6efd;
            color: #ffffff;
            font-weight: 600;
            box-shadow: inset 3px 0 0 #0a58ca;
        }
        #sidebar-wrapper .list-group-item a {
            color: inherit;
            text-decoration: none;
            display: block;
        }
        #sidebar-wrapper .list-group-item a i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        #sidebar-wrapper .text-muted.small.fw-bold {
            color: rgba(255, 255, 255, 0.5) !important;
            padding: 0.5rem 1.5rem 0.2rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        #sidebar-wrapper .logout-btn-container {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        #sidebar-wrapper .logout-btn-container .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
        #sidebar-wrapper .logout-btn-container .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2127;
        }

        /* Content wrapper styling */
        #page-content-wrapper {
            width: 100%;
            padding-left: 0; /* Content starts directly, padding for content is handled inside @yield('content') */
            flex-grow: 1; /* Allows content to take remaining width */
        }

        /* Responsive adjustments for sidebar */
        @media (max-width: 768px) {
            #wrapper #sidebar-wrapper {
                margin-left: -250px;
                position: fixed;
                height: 100vh;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }
            #wrapper.toggled #page-content-wrapper {
                margin-left: 250px; /* Push content over when sidebar is toggled */
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        {{-- --- USER SIDEBAR --- --}}
        <div id="sidebar-wrapper">
            @include('layouts.user_sidebar') {{-- Your actual sidebar content, includes categories etc. --}}
        </div>

        <div id="page-content-wrapper">
            {{-- This layout does NOT have a top navigation bar --}}
            <main class="container-fluid"> {{-- Main content starts here, pages can add their own padding --}}
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Bootstrap JavaScript Bundle (with Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Alpine.js / Other JavaScript (from Vite) --}}
    @vite(['resources/js/app.js'])
    {{-- Custom scripts pushed from individual pages --}}
    @stack('scripts')

    <script>
        // Simple JavaScript for sidebar toggle (optional, for responsive)
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('wrapper').classList.toggle('toggled');
        });
    </script>
</body>
</html>