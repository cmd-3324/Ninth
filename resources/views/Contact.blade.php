<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - CarMarket</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
    <style>
        .contact-card {
            transition: all 0.3s ease;
        }
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .qr-code {
            width: 150px;
            height: 150px;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="/" class="text-xl font-bold">CarMarket</a>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ url('/all') }}" class="hover:text-blue-200 transition duration-200">Cars</a>
                    {{-- <a href="{{ url('/buy') }}" class="hover:text-blue-200 transition duration-200">Buy Car</a>
                    <a href="{{ url('/sell') }}" class="hover:text-blue-200 transition duration-200">Sell Car</a>
                    <a href="{{ url('/tools') }}" class="hover:text-blue-200 transition duration-200">Tools</a> --}}
                    <a href="{{ url('/about') }}" class="hover:text-blue-200 transition duration-200">About Us</a>
                    <a href="{{ url('/contact') }}" class="hover:text-blue-200 transition duration-200 font-bold underline">Contact Us</a>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="md:hidden" id="mobile-menu-button">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </div>

                    <div class="relative">
                        @auth
                            <div class="flex items-center space-x-3 cursor-pointer group" id="user-menu-button">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center border-2 border-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ Auth::user()->UserName }}</span>
                                <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <img src="{{ Auth::user()->Avatar }}" alt="Profle-Image" >
                                    {{-- <path stroke-linecap="round" stroke-linejoin: "round" stroke-width="2" d="M19 9l-7 7-7-7"></path> --}}
                                </svg>
                            </div>

                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block hover:block z-50">
                                <a href="{{ route('profile-go', ['user_id' => Auth::id()]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">👤 Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">🚪 Logout</button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center space-x-3 cursor-pointer group" id="guest-menu-button">
                                <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center border-2 border-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>

                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block hover:block z-50">
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">🔑 Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">📝 Register</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 text-white py-6 px-8">
                <h1 class="text-3xl font-bold">Dear {{ $username ?? 'Valued Customer' }},</h1>
                <p class="mt-2 text-blue-100">Get connected with us through multiple channels</p>
            </div>

            <div class="p-8">
                <!-- QR Code Section -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-12">
                    <div class="mb-6 md:mb-0 md:mr-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Scan to Connect</h2>
                        <p class="text-gray-600 mb-4">Scan this QR code to quickly save our contact information or visit our website.</p>
                        <div class="qr-code" id="qrcode"></div>
                    </div>

                    <div class="flex-1">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contact Information</h2>
                        <div class="space-y-4">
                            <div class="flex items-center contact-card p-4 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-phone text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Phone Numbers</h3>
                                    <p class="text-gray-600">+1 (555) 123-4567</p>
                                    <p class="text-gray-600">+1 (555) 987-6543</p>
                                </div>
                            </div>

                            <div class="flex items-center contact-card p-4 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-envelope text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Email Address</h3>
                                    <p class="text-gray-600">programmers378@gmail.com</p>
                                </div>
                            </div>

                            <div class="flex items-center contact-card p-4 bg-gray-50 rounded-lg">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800">Office Address</h3>
                                    <p class="text-gray-600">123 Automotive Avenue, Car City, CC 12345</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Send Us a Message</h2>

                    <form id="contactForm" class="space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Your Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Your Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Generate QR Code
        document.addEventListener('DOMContentLoaded', function() {
            // Generate QR code
            const qrElement = document.getElementById('qrcode');
            QRCode.toCanvas(qrElement, 'mailto:programmers378@gmail.com', {
                width: 150,
                margin: 1,
                color: {
                    dark: '#000000',
                    light: '#ffffff'
                }
            }, function(error) {
                if (error) console.error(error);
            });

            // Form submission handling
            document.getElementById('contactForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const email = document.getElementById('email').value;
                const message = document.getElementById('message').value;

                // Here you would typically send this data to your server
                // For frontend demonstration, we'll show an alert
                alert(`Message would be sent to programmers378@gmail.com\nFrom: ${email}\nMessage: ${message}`);

                // Reset form
                this.reset();
            });
        });
    </script>
</body>
</html>
