<nav class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            {{-- Logo --}}
            <a href="/" class="text-xl font-bold">CarMarket</a>

            {{-- Search Form --}}
            <form action="{{ route('Search_car_page') }}" method="GET" class="flex items-center space-x-2">
                @csrf
                <label for="searchTerm" class="sr-only">Search</label>
                <input
                    value="{{ old('searchTerm', $searchTerm ?? '') }}"
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
                <button class="md:hidden" id="mobile-menu-button">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                {{-- User Dropdown --}}
                <div class="relative">
                    @auth
                        {{-- Logged-in User Dropdown --}}
                        <div class="flex items-center space-x-3 cursor-pointer group" id="user-menu-button">
                            {{-- User Icon with Profile Image --}}
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center border-2 border-white overflow-hidden">
                                @if(Auth::user()->Avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->Avatar) }}" alt="Profile" class="h-full w-full object-cover">
                                @else
                                    {{-- Show default avatar if no profile image --}}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>

                            {{-- Username Display --}}
                            <span class="font-medium">{{ Auth::user()->UserName }}</span>

                            {{-- Dropdown Arrow --}}
                            <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        {{-- Dropdown Menu for Logged-in Users --}}
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block hover:block z-50">
                            <a href="{{ route('profile-go', ['user_id' => Auth::user()->UserID]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">👤 Manage Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">🚪 Logout</button>
                            </form>
                        </div>

                    @else
                        {{-- Guest User Icon with Dropdown --}}
                        <div class="flex items-center space-x-3 cursor-pointer group" id="guest-menu-button">
                            {{-- User Icon for Guest --}}
                            <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center border-2 border-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="font-medium">Guest</span>
                            {{-- Dropdown Arrow --}}
                            <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        {{-- Dropdown Menu for Guest --}}
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block hover:block z-50">
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">🔑 Login</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-100">📝 Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Mobile Menu (Hidden by default) --}}
        <div class="md:hidden hidden mt-4 pb-4" id="mobile-menu">
            <div class="flex flex-col space-y-3">
                <a href="{{ url('/all') }}" class="hover:text-blue-200 transition duration-200">Cars</a>
                <a href="{{ route('aboutpage') }}" class="hover:text-blue-200 transition duration-200">About Us</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-200 transition duration-200">Contact Us</a>

                {{-- Mobile Auth Links --}}
                @auth
                    <a href="{{ route('profile-go', ['user_id' => Auth::user()->UserID]) }}" class="hover:text-blue-200 transition duration-200">👤 Manage Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200 transition duration-200">🚪 Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-200 transition duration-200">🔑 Login</a>
                    <a href="{{ route('register') }}" class="hover:text-blue-200 transition duration-200">📝 Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- JavaScript for mobile menu --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // User dropdown functionality
    const userMenu = document.getElementById('user-menu-button');
    const guestMenu = document.getElementById('guest-menu-button');

    if (userMenu) {
        userMenu.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('hidden');
        });
    }

    if (guestMenu) {
        guestMenu.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('hidden');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.absolute');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && !dropdown.previousElementSibling.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Close mobile menu if clicking outside
        if (mobileMenu && !mobileMenu.contains(event.target) && mobileMenuButton && !mobileMenuButton.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Animated placeholder for search input
    const input = document.getElementById('searchTerm');
    if (input) {
        const placeholders = ['Search Toyota...', 'Search BMW...', 'Search Mercedes...'];
        let current = 0;
        let index = 0;
        let isDeleting = false;
        let delay = 200;

        function typePlaceholder() {
            let text = placeholders[current];
            if (!isDeleting) {
                input.placeholder = text.substring(0, index + 1);
                index++;
                if (index === text.length) {
                    isDeleting = true;
                    delay = 1500; // wait before deleting
                } else {
                    delay = 200;
                }
            } else {
                input.placeholder = text.substring(0, index - 1);
                index--;
                if (index === 0) {
                    isDeleting = false;
                    current = (current + 1) % placeholders.length;
                    delay = 500;
                } else {
                    delay = 100;
                }
            }
            setTimeout(typePlaceholder, delay);
        }

        typePlaceholder();
    }
});

// Prevent backspace from navigating back
document.addEventListener('keydown', function (e) {
    if (e.key === 'Backspace') {
        const target = e.target;
        const tagName = target.tagName.toLowerCase();
        const isEditable = target.isContentEditable;

        if (tagName !== 'input' && tagName !== 'textarea' && !isEditable) {
            e.preventDefault();
        }
    }
});
</script>
