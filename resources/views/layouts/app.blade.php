<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Furniture Shopping'))</title>

        {{-- --- [NEW CODE START] --- --}}
        {{-- Favicon: Ensure "favicon.png" is in your public folder --}}
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        {{-- --- [NEW CODE END] --- --}}

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- --- Bootstrap CSS --- --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        {{-- --- Font Awesome CSS --- --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        {{-- --- Tailwind CSS (from Vite, if still needed for other elements) --- --}}
        @vite(['resources/css/app.css'])

        {{-- Custom styles pushed from individual pages --}}
        @stack('styles')

        <style>
            /* Base layout for sidebar and content */
            body {
                margin: 0;
                background-color: #f0fff0; /* Consistent light green page background */
                font-family: 'figtree', sans-serif; /* Use the defined font */
                color: #000000; /* Make all body text black by default */
            }

            /* Override specific text colors from frameworks if necessary for main content */
            .text-gray-700,
            .text-gray-800,
            .text-gray-600,
            .text-muted, /* Bootstrap's muted text */
            .text-secondary, /* Bootstrap's secondary text */
            .text-dark, /* Your existing text-dark */
            .nav-link { /* Generic nav-link from Bootstrap */
                color: #000000 !important; /* Force black for these elements */
                text-decoration: none; /* Remove underline by default for all non-button links */
            }
            a:not(.btn):hover {
                color: #0d6efd !important; /* Blue on hover for general links */
                text-decoration: underline;
            }

            #wrapper {
                display: flex;
                width: 100%;
                min-height: 100vh;
            }

            /* Sidebar styling */
            #sidebar-wrapper {
                min-width: 250px;
                max-width: 250px;
                background-color: #212529; /* Dark background */
                color: #ffffff; /* Keep sidebar text white */
                position: fixed;
                height: 100vh;
                z-index: 1000;
                box-shadow: 2px 0 8px rgba(0,0,0,0.2); /* Enhanced shadow */
                transition: margin-left 0.3s ease-in-out; /* Smooth slide transition */
            }

            /* Sidebar Header */
            #sidebar-wrapper .sidebar-heading {
                padding: 1.5rem 1rem;
                font-size: 1.5rem; /* Larger font size */
                font-weight: 700; /* Bolder */
                border-bottom: 1px solid rgba(255,255,255,0.1); /* Subtle border */
                text-align: center;
                background-color: #1a1e22; /* Slightly darker header */
                color: #ffffff !important; /* Ensure header text is white */
            }

            /* Sidebar Nav Items */
            #sidebar-wrapper .list-group-item {
                background-color: transparent;
                color: rgba(255, 255, 255, 0.8) !important; /* Slightly muted white */
                border: none;
                padding: 0.8rem 1.5rem; /* More vertical padding */
                transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, transform 0.2s ease-in-out; /* Smooth hover */
                border-radius: 0; /* Remove rounding for full-width highlight */
            }
            #sidebar-wrapper .list-group-item:hover {
                background-color: rgba(255,255,255,0.1); /* Subtle hover background */
                color: #ffffff !important;
                transform: translateX(3px); /* Slight slide effect on hover */
            }
            #sidebar-wrapper .list-group-item.active {
                background-color: #0d6efd; /* Bootstrap primary blue for active */
                color: #ffffff !important;
                font-weight: 600; /* Bolder active link */
                box-shadow: inset 3px 0 0 #0a58ca; /* Left border highlight */
            }
            #sidebar-wrapper .list-group-item a {
                color: inherit; /* Inherit color from parent li */
                text-decoration: none;
                display: block; /* Make entire area clickable */
            }
            #sidebar-wrapper .list-group-item a i {
                margin-right: 12px; /* Consistent icon spacing */
                width: 20px; /* Fixed icon width */
                text-align: center;
            }
            #sidebar-wrapper .text-muted.small.fw-bold {
                color: rgba(255, 255, 255, 0.5) !important; /* Lighter grey for category heading */
                padding: 0.5rem 1.5rem 0.2rem; /* Adjusted padding */
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            #sidebar-wrapper .logout-btn-container {
                padding: 1rem 1.5rem; /* Padding for logout button container */
                border-top: 1px solid rgba(255,255,255,0.1); /* Separator */
            }
            #sidebar-wrapper .logout-btn-container .btn-danger {
                background-color: #dc3545; /* Bootstrap danger red */
                border-color: #dc3545;
                transition: background-color 0.2s ease, border-color 0.2s ease;
            }
            #sidebar-wrapper .logout-btn-container .btn-danger:hover {
                background-color: #c82333; /* Darker red on hover */
                border-color: #bd2127;
            }


            /* Content wrapper styling */
            #page-content-wrapper {
                width: 100%;
                padding-left: 250px; /* Push content to the right by sidebar width */
                min-height: 100vh;
                background-color: #f8f9fa; /* Light background for content area */
                transition: padding-left 0.3s ease-in-out; /* Smooth content shift */
            }

            /* Navbar styling within content area */
            .navbar {
                padding: .8rem 1.5rem; /* More generous padding */
                background-color: #ffffff !important;
                border-bottom: 1px solid #e9ecef; /* Lighter border */
                box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* Subtle navbar shadow */
            }
            .navbar-brand-text {
                font-weight: 700;
                color: #212529;
                font-size: 1.25rem;
            }
            .navbar-nav .nav-link {
                transition: color 0.2s ease-in-out;
                color: #000000 !important; /* Ensure top navbar links are black */
            }
            .navbar-nav .nav-link:hover {
                color: #0d6efd !important;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                #sidebar-wrapper {
                    margin-left: -250px;
                }
                #page-content-wrapper {
                    padding-left: 0;
                }
                #wrapper.toggled #sidebar-wrapper {
                    margin-left: 0;
                }
                #wrapper.toggled #page-content-wrapper {
                    padding-left: 250px;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div id="wrapper">
            {{-- --- USER SIDEBAR --- --}}
            <div id="sidebar-wrapper">
                @include('layouts.user_sidebar')
            </div>

            <div id="page-content-wrapper">
                {{-- --- Top Navbar/Header for User Interface --- --}}
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        {{-- Optional: Add a button to toggle sidebar on small screens --}}
                        <button class="navbar-toggler" type="button" id="sidebarToggle" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                {{-- User Greeting --}}
                                <li class="nav-item">
                                    @auth
                                        <span class="nav-link">Hi {{ Auth::user()->name }}</span>
                                    @endauth
                                </li>
                                {{-- Cart Icon --}}
                                <li class="nav-item">
                                    <a href="{{ route('user.cart.index') }}" class="nav-link">
                                        <i class="fas fa-shopping-cart"></i> My Cart
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                {{-- --- Page Content Area --- --}}
                <main class="container-fluid py-4">
                    @yield('content')
                </main>
            </div>
        </div>

        {{-- --- Bootstrap JavaScript Bundle (with Popper) --- --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        {{-- --- Alpine.js / Other JavaScript (from Vite) --- --}}
        @vite(['resources/js/app.js'])

        {{-- Custom scripts pushed from individual pages --}}
        @stack('scripts')

        <script>
            document.getElementById('sidebarToggle')?.addEventListener('click', function() {
                document.getElementById('wrapper').classList.toggle('toggled');
            });
        </script>
    </body>
</html>