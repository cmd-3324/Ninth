<nav class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            {{-- Logo --}}
            <a href="/" class="text-xl font-bold">CarMarket</a>

            {{-- Search Form --}}
            <form action="{{ route('Search_car_page') }}" method="GET" class="flex items-center space-x-2">
                <label for="searchTerm" class="sr-only">Search</label>
                <input
                    value="{{ request('searchTerm') }}"
                    id="searchTerm"
                    name="searchTerm"
                    type="text"
                    placeholder="Search For Car Brands..."
                    class="px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-black bg-white"
                />
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition-colors"
                >
                    Go!
                </button>
            </form>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ url('/all') }}" class="hover:text-blue-200 transition duration-200">Cars</a>
                <a href="{{ route('aboutpage') }}" class="hover:text-blue-200 transition duration-200">About Us</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-200 transition duration-200">Contact Us</a>
            </div>

            {{-- User Menu Section --}}
            <div class="flex items-center space-x-4">
                {{-- Mobile Menu Button --}}
                <button class="md:hidden" id="mobile-menu-button" aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                {{-- User Dropdown --}}
                <div class="relative">
                    @auth
                        {{-- Logged-in User --}}
                        <button id="user-menu-button" class="flex items-center space-x-3 cursor-pointer">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center border-2 border-white overflow-hidden">
                                @if(Auth::user()->Avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->Avatar) }}" alt="Profile" class="h-full w-full object-cover">
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <span class="font-medium">{{ Auth::user()->UserName }}</span>
                            <svg class="w-4 h-4 transition-transform" id="user-menu-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-50">
                            <a href="{{ route('profile-go', ['user_id' => Auth::user()->UserID]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">👤 Manage Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">🚪 Logout</button>
                            </form>
                        </div>
                    @else
                        {{-- Guest --}}
                        <button id="guest-menu-button" class="flex items-center space-x-3 cursor-pointer">
                            <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center border-2 border-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Guest</span>
                            <svg class="w-4 h-4 transition-transform" id="guest-menu-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="guest-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-50">
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">🔑 Login</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">📝 Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Mobile menu
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const expanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !expanded);
        });
    }

    // User dropdown
    const userBtn = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    if (userBtn && userDropdown) {
        userBtn.addEventListener('click', () => userDropdown.classList.toggle('hidden'));
    }

    // Guest dropdown
    const guestBtn = document.getElementById('guest-menu-button');
    const guestDropdown = document.getElementById('guest-dropdown');
    if (guestBtn && guestDropdown) {
        guestBtn.addEventListener('click', () => guestDropdown.classList.toggle('hidden'));
    }
});
</script>
