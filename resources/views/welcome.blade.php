<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Book appointments online at our clinic. Easy scheduling, experienced doctors, quality healthcare.">
        <title>{{ config('app.name', 'Clinic Booking') }} - Your Health, Our Priority</title>
        <script src="https://cdn.tailwindcss.com"></script>
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#eff6ff',
                                100: '#dbeafe',
                                200: '#bfdbfe',
                                300: '#93c5fd',
                                400: '#60a5fa',
                                500: '#3b82f6',
                                600: '#2563eb',
                                700: '#1d4ed8',
                                800: '#1e40af',
                                900: '#1e3a8a',
                            },
                            medical: {
                                50: '#f0fdf4',
                                100: '#dcfce7',
                                500: '#22c55e',
                                600: '#16a34a',
                            }
                        },
                        animation: {
                            'float': 'float 6s ease-in-out infinite',
                            'fade-in-up': 'fadeInUp 0.8s ease-out',
                        },
                        keyframes: {
                            float: {
                                '0%, 100%': { transform: 'translateY(0)' },
                                '50%': { transform: 'translateY(-20px)' },
                            },
                            fadeInUp: {
                                '0%': { opacity: '0', transform: 'translateY(20px)' },
                                '100%': { opacity: '1', transform: 'translateY(0)' },
                            }
                        }
                    }
                }
            }
        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-hospital text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Clinic
                        </span>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#services" class="text-gray-600 hover:text-primary-600 transition-colors font-medium">Services</a>
                        <a href="#about" class="text-gray-600 hover:text-primary-600 transition-colors font-medium">About</a>
                        <a href="#doctors" class="text-gray-600 hover:text-primary-600 transition-colors font-medium">Doctors</a>
                        <a href="#how-it-works" class="text-gray-600 hover:text-primary-600 transition-colors font-medium">How It Works</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/30">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-primary-600 font-semibold hover:text-primary-700 transition-colors">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/30">
                                Get Started
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 text-gray-600" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden hidden bg-white border-t" id="mobile-menu">
                <div class="px-4 py-4 space-y-3">
                    <a href="#services" class="block py-2 text-gray-600 hover:text-primary-600">Services</a>
                    <a href="#about" class="block py-2 text-gray-600 hover:text-primary-600">About</a>
                    <a href="#doctors" class="block py-2 text-gray-600 hover:text-primary-600">Doctors</a>
                    <a href="#how-it-works" class="block py-2 text-gray-600 hover:text-primary-600">How It Works</a>
                    <hr class="border-gray-200">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block py-2 text-primary-600 font-semibold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block py-2 text-primary-600 font-semibold">Sign In</a>
                        <a href="{{ route('register') }}" class="block py-2 text-primary-600 font-semibold">Get Started</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center pt-20 overflow-hidden">
            <!-- Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary-50 via-white to-blue-50"></div>
            <div class="absolute top-20 right-0 w-[600px] h-[600px] bg-primary-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
            <div class="absolute bottom-20 left-0 w-[500px] h-[500px] bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: -3s;"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="text-center lg:text-left animate-fade-in-up">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-medium mb-6">
                            <span class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                            Trusted by 10,000+ Patients
                        </div>
                        
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Quality Healthcare
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-blue-600">
                                Made Simple
                            </span>
                        </h1>
                        
                        <p class="mt-6 text-lg text-gray-600 max-w-xl mx-auto lg:mx-0">
                            Book appointments with experienced doctors instantly. 
                            Manage your health records, schedule visits, and receive 
                            quality care—all in one place.
                        </p>

                        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-all shadow-xl shadow-primary-500/30 flex items-center justify-center gap-2">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="px-8 py-4 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-all shadow-xl shadow-primary-500/30 flex items-center justify-center gap-2">
                                    <i class="fas fa-calendar-plus"></i>
                                    Book Appointment
                                </a>
                                <a href="#doctors" class="px-8 py-4 bg-white text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-lg border border-gray-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-user-md"></i>
                                    View Doctors
                                </a>
                            @endauth
                        </div>

                        <!-- Stats -->
                        <div class="mt-12 grid grid-cols-3 gap-6 justify-center lg:justify-start">
                            <div class="text-center lg:text-left">
                                <p class="text-3xl font-bold text-primary-600">50+</p>
                                <p class="text-sm text-gray-500">Expert Doctors</p>
                            </div>
                            <div class="text-center lg:text-left">
                                <p class="text-3xl font-bold text-primary-600">10K+</p>
                                <p class="text-sm text-gray-500">Happy Patients</p>
                            </div>
                            <div class="text-center lg:text-left">
                                <p class="text-3xl font-bold text-primary-600">15+</p>
                                <p class="text-sm text-gray-500">Specialties</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Image/Illustration -->
                    <div class="hidden lg:block relative">
                        <div class="relative w-full max-w-lg mx-auto">
                            <!-- Main Card -->
                            <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100 relative z-10">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-16 h-16 bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-user-md text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">Dr. Sarah Johnson</h3>
                                        <p class="text-gray-500">Cardiologist</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-calendar-check text-green-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">Next Available</p>
                                            <p class="text-sm text-gray-500">Today at 2:30 PM</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-star text-primary-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">Rating</p>
                                            <p class="text-sm text-gray-500">4.9 (256 reviews)</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="mt-6 block w-full py-3 bg-primary-600 text-white text-center font-semibold rounded-xl hover:bg-primary-700 transition-colors">
                                    Book Now
                                </a>
                            </div>
                            
                            <!-- Floating Elements -->
                            <div class="absolute -top-6 -right-6 bg-white rounded-2xl shadow-xl p-4 animate-float">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Booking Confirmed</p>
                                        <p class="text-xs text-gray-500">Appointment #1234</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-xl p-4 animate-float" style="animation-delay: -2s;">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-shield-alt text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">Secure & Private</p>
                                        <p class="text-xs text-gray-500">HIPAA Compliant</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Our Services</span>
                    <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">Comprehensive Healthcare</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        We offer a wide range of medical services to meet all your healthcare needs
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Service 1 -->
                    <div class="group p-6 bg-gray-50 rounded-2xl hover:bg-primary-50 transition-all duration-300 border border-transparent hover:border-primary-200">
                        <div class="w-14 h-14 bg-primary-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-primary-600 transition-colors">
                            <i class="fas fa-stethoscope text-primary-600 text-xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">General Medicine</h3>
                        <p class="text-gray-600 text-sm">Comprehensive primary care for all ages, including preventive care and health screenings.</p>
                    </div>

                    <!-- Service 2 -->
                    <div class="group p-6 bg-gray-50 rounded-2xl hover:bg-primary-50 transition-all duration-300 border border-transparent hover:border-primary-200">
                        <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-600 transition-colors">
                            <i class="fas fa-heartbeat text-green-600 text-xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Cardiology</h3>
                        <p class="text-gray-600 text-sm">Heart health services including ECGs, stress tests, and cardiovascular consultations.</p>
                    </div>

                    <!-- Service 3 -->
                    <div class="group p-6 bg-gray-50 rounded-2xl hover:bg-primary-50 transition-all duration-300 border border-transparent hover:border-primary-200">
                        <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-purple-600 transition-colors">
                            <i class="fas fa-brain text-purple-600 text-xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Neurology</h3>
                        <p class="text-gray-600 text-sm">Expert care for brain and nervous system conditions with advanced diagnostics.</p>
                    </div>

                    <!-- Service 4 -->
                    <div class="group p-6 bg-gray-50 rounded-2xl hover:bg-primary-50 transition-all duration-300 border border-transparent hover:border-primary-200">
                        <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-orange-600 transition-colors">
                            <i class="fas fa-bone text-orange-600 text-xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Orthopedics</h3>
                        <p class="text-gray-600 text-sm">Bone, joint, and muscle care including sports injuries and joint replacements.</p>
                    </div>

                    <!-- Service 5 -->
                    <div class="group p-6 bg-gray-50 rounded-2xl hover:bg-primary-50 transition-all duration-300 border border-transparent hover:border-primary-200">
                        <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-pink-600 transition-colors">
                            <i class="fas fa-baby text-pink-600 text-xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Pediatrics</h3>
                        <p class="text-gray-600 text-sm">Specialized healthcare for infants, children, and adolescents.</p>
                    </div>

                    <!-- Service 6 -->
                    <div class="group p-6 bg-gray-50 rounded-2xl hover:bg-primary-50 transition-all duration-300 border border-transparent hover:border-primary-200">
                        <div class="w-14 h-14 bg-cyan-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-cyan-600 transition-colors">
                            <i class="fas fa-syringe text-cyan-600 text-xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Vaccinations</h3>
                        <p class="text-gray-600 text-sm">Complete immunization services for children and adults.</p>
                    </div>

                    <!-- Service 7 -->
                    <div class="group p-6 bg-gray-50 rounded-2xl hover:bg-primary-50 transition-all duration-300 border border-transparent hover:border-primary-200">
                        <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-red-600 transition-colors">
                            <i class="fas fa-ambulance text-red-600 text-xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Emergency Care</h3>
                        <p class="text-gray-600 text-sm">24/7 emergency medical services for critical situations.</p>
                    </div>

                    <!-- Service 8 -->
                    <div class="group p-6 bg-gray-50 rounded-2xl hover:bg-primary-50 transition-all duration-300 border border-transparent hover:border-primary-200">
                        <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-indigo-600 transition-colors">
                            <i class="fas fa-microscope text-indigo-600 text-xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Lab Services</h3>
                        <p class="text-gray-600 text-sm">Comprehensive laboratory testing with quick results.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About/Mission Section -->
        <section id="about" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-primary-200 rounded-2xl"></div>
                        <div class="relative bg-white rounded-3xl shadow-2xl p-8">
                            <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=600&h=400&fit=crop" alt="Our Clinic" class="w-full rounded-2xl object-cover h-64">
                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <div class="text-center p-4 bg-primary-50 rounded-xl">
                                    <p class="text-2xl font-bold text-primary-600">15+</p>
                                    <p class="text-sm text-gray-600">Years Experience</p>
                                </div>
                                <div class="text-center p-4 bg-green-50 rounded-xl">
                                    <p class="text-2xl font-bold text-green-600">98%</p>
                                    <p class="text-sm text-gray-600">Patient Satisfaction</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">About Us</span>
                        <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">Our Mission</h2>
                        <p class="mt-4 text-lg text-gray-600">
                            At {{ config('app.name', 'Clinic Booking') }}, we believe that quality healthcare should be accessible to everyone. 
                            Our mission is to simplify the healthcare experience by providing a seamless online booking 
                            platform that connects patients with experienced medical professionals.
                        </p>
                        <p class="mt-4 text-gray-600">
                            We are committed to delivering compassionate, patient-centered care in a modern and 
                            comfortable environment. Our team of dedicated healthcare professionals works tirelessly 
                            to ensure every patient receives the attention and treatment they deserve.
                        </p>

                        <div class="mt-8 space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Patient-Centered Care</h4>
                                    <p class="text-gray-600 text-sm">Your health and comfort are our top priorities</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Expert Doctors</h4>
                                    <p class="text-gray-600 text-sm">Board-certified professionals with years of experience</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fas fa-check text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Easy Online Booking</h4>
                                    <p class="text-gray-600 text-sm">Schedule appointments anytime, anywhere</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">How It Works</span>
                    <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">Book Your Appointment in 3 Easy Steps</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        We've made it simple to get the healthcare you need
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="relative text-center">
                        <div class="w-20 h-20 bg-primary-100 rounded-3xl flex items-center justify-center mx-auto mb-6 relative">
                            <i class="fas fa-user-plus text-primary-600 text-3xl"></i>
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Create Account</h3>
                        <p class="text-gray-600">Sign up for free and create your personal health profile in just a few minutes.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative text-center">
                        <div class="w-20 h-20 bg-primary-100 rounded-3xl flex items-center justify-center mx-auto mb-6 relative">
                            <i class="fas fa-search text-primary-600 text-3xl"></i>
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Choose Doctor</h3>
                        <p class="text-gray-600">Browse our qualified doctors, view their profiles, and select the right specialist for your needs.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative text-center">
                        <div class="w-20 h-20 bg-primary-100 rounded-3xl flex items-center justify-center mx-auto mb-6 relative">
                            <i class="fas fa-calendar-check text-primary-600 text-3xl"></i>
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Book Appointment</h3>
                        <p class="text-gray-600">Select your preferred date and time, confirm your booking, and receive instant confirmation.</p>
                    </div>
                </div>

                <div class="text-center mt-12">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-all shadow-xl shadow-primary-500/30">
                            <i class="fas fa-tachometer-alt"></i>
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-all shadow-xl shadow-primary-500/30">
                            <i class="fas fa-rocket"></i>
                            Get Started Now
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Featured Doctors Section -->
        <section id="doctors" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Our Doctors</span>
                    <h2 class="mt-2 text-3xl sm:text-4xl font-bold text-gray-900">Meet Our Expert Physicians</h2>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        Our team of experienced doctors is dedicated to providing you with the best care
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Doctor 1 -->
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="h-48 bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                            <i class="fas fa-user-md text-white text-6xl opacity-50"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Dr. Sarah Johnson</h3>
                            <p class="text-primary-600 font-medium text-sm">Cardiologist</p>
                            <div class="mt-3 flex items-center gap-2">
                                <div class="flex text-yellow-400 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">(256 reviews)</span>
                            </div>
                            <p class="mt-3 text-sm text-gray-600">15+ years experience in cardiovascular care and preventive medicine.</p>
                        </div>
                    </div>

                    <!-- Doctor 2 -->
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                            <i class="fas fa-user-md text-white text-6xl opacity-50"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Dr. Michael Chen</h3>
                            <p class="text-primary-600 font-medium text-sm">General Physician</p>
                            <div class="mt-3 flex items-center gap-2">
                                <div class="flex text-yellow-400 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-sm text-gray-500">(189 reviews)</span>
                            </div>
                            <p class="mt-3 text-sm text-gray-600">Expert in family medicine and chronic disease management.</p>
                        </div>
                    </div>

                    <!-- Doctor 3 -->
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-user-md text-white text-6xl opacity-50"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Dr. Emily Rodriguez</h3>
                            <p class="text-primary-600 font-medium text-sm">Pediatrician</p>
                            <div class="mt-3 flex items-center gap-2">
                                <div class="flex text-yellow-400 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">(312 reviews)</span>
                            </div>
                            <p class="mt-3 text-sm text-gray-600">Specializing in child development and pediatric care.</p>
                        </div>
                    </div>

                    <!-- Doctor 4 -->
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                            <i class="fas fa-user-md text-white text-6xl opacity-50"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Dr. James Wilson</h3>
                            <p class="text-primary-600 font-medium text-sm">Orthopedist</p>
                            <div class="mt-3 flex items-center gap-2">
                                <div class="flex text-yellow-400 text-sm">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm text-gray-500">(198 reviews)</span>
                            </div>
                            <p class="mt-3 text-sm text-gray-600">Sports medicine and joint replacement specialist.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-600 font-semibold rounded-xl border-2 border-primary-600 hover:bg-primary-50 transition-colors">
                            View All in Dashboard
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-600 font-semibold rounded-xl border-2 border-primary-600 hover:bg-primary-50 transition-colors">
                            View All Doctors
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-primary-600 to-blue-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">Ready to Take Control of Your Health?</h2>
                <p class="mt-4 text-xl text-primary-100">
                    Join thousands of patients who trust us with their healthcare needs
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-white text-primary-600 font-semibold rounded-xl hover:bg-gray-100 transition-colors">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-primary-600 font-semibold rounded-xl hover:bg-gray-100 transition-colors">
                            Create Free Account
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-transparent text-white font-semibold rounded-xl border-2 border-white hover:bg-white/10 transition-colors">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Brand -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-hospital text-white"></i>
                            </div>
                            <span class="text-lg font-bold">{{ config('app.name', 'Clinic Booking') }}</span>
                        </div>
                        <p class="text-gray-400 text-sm">Making quality healthcare accessible to everyone through modern technology.</p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#services" class="hover:text-primary-400 transition-colors">Services</a></li>
                            <li><a href="#about" class="hover:text-primary-400 transition-colors">About Us</a></li>
                            <li><a href="#doctors" class="hover:text-primary-400 transition-colors">Doctors</a></li>
                            <li><a href="#how-it-works" class="hover:text-primary-400 transition-colors">How It Works</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="font-semibold mb-4">Contact</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-primary-400"></i>
                                123 Medical Center Dr
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-phone text-primary-400"></i>
                                (555) 123-4567
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-envelope text-primary-400"></i>
                                info@clinic.com
                            </li>
                        </ul>
                    </div>

                    <!-- Hours -->
                    <div>
                        <h4 class="font-semibold mb-4">Working Hours</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex justify-between">
                                <span>Mon - Fri</span>
                                <span>8:00 AM - 8:00 PM</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Saturday</span>
                                <span>9:00 AM - 5:00 PM</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Sunday</span>
                                <span>Emergency Only</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Clinic Booking') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('shadow-md');
                } else {
                    navbar.classList.remove('shadow-md');
                }
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        // Close mobile menu if open
                        document.getElementById('mobile-menu').classList.add('hidden');
                    }
                });
            });
        </script>
    </body>
</html>
