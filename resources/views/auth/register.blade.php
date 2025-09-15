<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('phone_number')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Location Selection -->
        <div class="mt-4">
            <x-input-label for="Location" :value="__('Location')" />

            <!-- Country Dropdown -->
            <div class="mb-2">
                <select id="country" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    <option value="">Select Country</option>
                    <option value="USA">United States</option>
                    <option value="Canada">Canada</option>
                    <option value="UK">United Kingdom</option>
                    <option value="Germany">Germany</option>
                    <option value="France">France</option>
                    <option value="Japan">Japan</option>
                    <option value="Australia">Australia</option>
                </select>
            </div>

            <!-- Province/State Dropdown -->
            <div class="mb-2">
                <select id="province" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled required>
                    <option value="">Select Province/State</option>
                </select>
            </div>

            <!-- City Dropdown -->
            <div class="mb-2">
                <select id="city" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled required>
                    <option value="">Select City</option>
                </select>
            </div>

            <!-- Hidden input for combined location value -->
            <input type="hidden" id="location" name="Location" value="{{ old('Location') }}" />

            <!-- Selected location display -->
            <div id="selected-location" class="mt-3 p-3 bg-gray-50 rounded-md text-sm text-gray-600">
                No location selected
            </div>

            <x-input-error :messages="$errors->get('Location')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Avatar Upload -->
        <div class="mt-4">
            <x-input-label for="avatar" :value="__('Profile Picture')" />

            <!-- Image preview -->
            <div class="mt-2 mb-3" id="avatar-preview" style="display: none;">
                <img id="avatar-preview-image" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300" src="" alt="Avatar preview">
            </div>

            <!-- File input -->
            <div class="flex items-center space-x-4">
                <label for="avatar" class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-upload mr-2"></i>{{ __('Choose Image') }}
                </label>

                <x-text-input
                    id="avatar"
                    class="hidden"
                    type="file"
                    name="avatar"
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    onchange="previewImage(this)"
                />
                <span id="file-name" class="text-sm text-gray-600">{{ __('No file chosen') }}</span>
            </div>

            <p class="text-sm text-gray-500 mt-1">{{ __('Maximum size: 2MB. Allowed formats: JPG, PNG, GIF') }}</p>
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('password')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full password-input"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <span class="showBtn absolute left-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500" style="display: none;">
                    نمایش
                </span>
            </div>
            
            <!-- Password Strength Indicator -->
            <div class="indicator mt-2" style="display: none; height: 10px; display: flex; align-items: center; justify-content: space-between;">
                <span class="weak" style="position: relative; height: 100%; width: 100%; background: lightgrey; border-radius: 5px;"></span>
                <span class="medium" style="position: relative; height: 100%; width: 100%; background: lightgrey; border-radius: 5px; margin: 0 3px;"></span>
                <span class="strong" style="position: relative; height: 100%; width: 100%; background: lightgrey; border-radius: 5px;"></span>
            </div>
            <div class="text text-sm mt-1" style="display: none; margin-bottom: -10px;"></div>
            
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <span class="showBtnConfirm absolute left-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500" style="display: none;">
                    نمایش
                </span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4" id="submitButton">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- JavaScript for Location Selection, Image Preview and Password Strength -->
    <script>
        // Password strength checker
        const indicator = document.querySelector(".indicator");
        const passwordInput = document.querySelector(".password-input");
        const passwordConfirmInput = document.querySelector("input[name='password_confirmation']");
        const weak = document.querySelector(".weak");
        const medium = document.querySelector(".medium");
        const strong = document.querySelector(".strong");
        const text = document.querySelector(".text");
        const showBtn = document.querySelector(".showBtn");
        const showBtnConfirm = document.querySelector(".showBtnConfirm");
        const submitButton = document.getElementById("submitButton");
        let regExpWeak = /[a-z]/;
        let regExpMedium = /\d+/;
        let regExpStrong = /.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/;
        let currentPasswordStrength = 0;

        function checkPasswordStrength() {
            if(passwordInput.value != ""){
                indicator.style.display = "flex";
                showBtn.style.display = "block";
                
                // Reset all classes
                weak.classList.remove("active");
                medium.classList.remove("active");
                strong.classList.remove("active");
                text.classList.remove("weak", "medium", "strong");
                
                if(passwordInput.value.length <= 3 && (passwordInput.value.match(regExpWeak) || passwordInput.value.match(regExpMedium) || passwordInput.value.match(regExpStrong))) {
                    currentPasswordStrength = 1;
                    weak.classList.add("active");
                    text.style.display = "block";
                    text.textContent = "Your password is too weak";
                    text.classList.add("weak");
                    submitButton.disabled = true;
                }
                else if(passwordInput.value.length >= 6 && ((passwordInput.value.match(regExpWeak) && passwordInput.value.match(regExpMedium)) || (passwordInput.value.match(regExpMedium) && passwordInput.value.match(regExpStrong)) || (passwordInput.value.match(regExpWeak) && passwordInput.value.match(regExpStrong)))) {
                    currentPasswordStrength = 2;
                    medium.classList.add("active");
                    text.textContent = "Your password is medium";
                    text.classList.add("medium");
                    submitButton.disabled = false;
                }
                else if(passwordInput.value.length >= 6 && passwordInput.value.match(regExpWeak) && passwordInput.value.match(regExpMedium) && passwordInput.value.match(regExpStrong)) {
                    currentPasswordStrength = 3;
                    weak.classList.add("active");
                    medium.classList.add("active");
                    strong.classList.add("active");
                    text.textContent = "Your password is strong";
                    text.classList.add("strong");
                    submitButton.disabled = false;
                }
                else {
                    currentPasswordStrength = 0;
                    text.style.display = "none";
                    submitButton.disabled = false;
                }
                
                // Check if passwords match
                checkPasswordMatch();
            } else {
                indicator.style.display = "none";
                text.style.display = "none";
                showBtn.style.display = "none";
                submitButton.disabled = false;
            }
        }
        
        function checkPasswordMatch() {
            if (passwordConfirmInput.value && passwordInput.value !== passwordConfirmInput.value) {
                text.style.display = "block";
                text.textContent = "Passwords do not match";
                text.className = "text weak";
                submitButton.disabled = true;
            } else if (passwordConfirmInput.value && currentPasswordStrength === 1) {
                text.style.display = "block";
                text.textContent = "Your password is too weak";
                text.className = "text weak";
                submitButton.disabled = true;
            } else if (passwordConfirmInput.value && passwordInput.value === passwordConfirmInput.value && currentPasswordStrength > 1) {
                submitButton.disabled = false;
            }
        }

        // Show/hide password functionality
        showBtn.addEventListener('click', function(){
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showBtn.textContent = "مخفی کردن";
                showBtn.style.color = "#23ad5c";
            } else {
                passwordInput.type = "password";
                showBtn.textContent = "نمایش";
                showBtn.style.color = "#64748b";
            }
        });
        
        showBtnConfirm.addEventListener('click', function(){
            if (passwordConfirmInput.type === "password") {
                passwordConfirmInput.type = "text";
                showBtnConfirm.textContent = "مخفی کردن";
                showBtnConfirm.style.color = "#23ad5c";
            } else {
                passwordConfirmInput.type = "password";
                showBtnConfirm.textContent = "نمایش";
                showBtnConfirm.style.color = "#64748b";
            }
        });

        // Add event listeners to password inputs
        if (passwordInput) {
            passwordInput.addEventListener('input', checkPasswordStrength);
        }
        
        if (passwordConfirmInput) {
            passwordConfirmInput.addEventListener('input', checkPasswordMatch);
            passwordConfirmInput.addEventListener('input', function() {
                if (this.value) {
                    showBtnConfirm.style.display = "block";
                } else {
                    showBtnConfirm.style.display = "none";
                }
            });
        }

        // Form submission validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (currentPasswordStrength === 1) {
                e.preventDefault();
                alert('Please choose a stronger password. Weak passwords are not allowed.');
                return false;
            }
            
            if (passwordInput.value !== passwordConfirmInput.value) {
                e.preventDefault();
                alert('Passwords do not match. Please confirm your password correctly.');
                return false;
            }
        });

        // Location data and functions (unchanged from your original code)
        const locationData = {
            'USA': {
                'California': ['Los Angeles', 'San Francisco', 'San Diego'],
                'New York': ['New York City', 'Buffalo', 'Rochester'],
                'Texas': ['Houston', 'Dallas', 'Austin']
            },
            'Canada': {
                'Ontario': ['Toronto', 'Ottawa', 'Mississauga'],
                'Quebec': ['Montreal', 'Quebec City', 'Laval'],
                'British Columbia': ['Vancouver', 'Victoria', 'Surrey']
            },
            'UK': {
                'England': ['London', 'Manchester', 'Birmingham'],
                'Scotland': ['Edinburgh', 'Glasgow', 'Aberdeen'],
                'Wales': ['Cardiff', 'Swansea', 'Newport']
            },
            'Germany': {
                'Bavaria': ['Munich', 'Nuremberg', 'Augsburg'],
                'Berlin': ['Berlin'],
                'North Rhine-Westphalia': ['Cologne', 'Düsseldorf', 'Dortmund']
            },
            'France': {
                'Île-de-France': ['Paris', 'Versailles', 'Boulogne-Billancourt'],
                "Provence-Alpes-Côte d'Azur": ['Marseille', 'Nice', 'Toulon'],
                'Auvergne-Rhône-Alpes': ['Lyon', 'Grenoble', 'Saint-Étienne']
            },
            'Japan': {
                'Tokyo': ['Tokyo', 'Shibuya', 'Shinjuku'],
                'Osaka': ['Osaka', 'Sakai', 'Higashiosaka'],
                'Kyoto': ['Kyoto', 'Uji', 'Maizuru']
            },
            'Australia': {
                'New South Wales': ['Sydney', 'Newcastle', 'Wollongong'],
                'Victoria': ['Melbourne', 'Geelong', 'Ballarat'],
                'Queensland': ['Brisbane', 'Gold Coast', 'Cairns']
            }
        };

        // DOM elements
        const countrySelect = document.getElementById('country');
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const locationInput = document.getElementById('location');
        const selectedLocationDiv = document.getElementById('selected-location');

        // Country change event
        countrySelect.addEventListener('change', function() {
            const country = this.value;

            // Reset province and city
            provinceSelect.innerHTML = '<option value="">Select Province/State</option>';
            citySelect.innerHTML = '<option value="">Select City</option>';
            provinceSelect.disabled = !country;
            citySelect.disabled = true;

            if (country) {
                // Add provinces for selected country
                for (const province in locationData[country]) {
                    const option = document.createElement('option');
                    option.value = province;
                    option.textContent = province;
                    provinceSelect.appendChild(option);
                }
                provinceSelect.disabled = false;
            }

            updateLocationString();
        });

        // Province change event
        provinceSelect.addEventListener('change', function() {
            const country = countrySelect.value;
            const province = this.value;

            // Reset city
            citySelect.innerHTML = '<option value="">Select City</option>';
            citySelect.disabled = !province;

            if (country && province) {
                // Add cities for selected province
                locationData[country][province].forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
                citySelect.disabled = false;
            }

            updateLocationString();
        });

        // City change event
        citySelect.addEventListener('change', function() {
            updateLocationString();
        });

        // Update location string and display
        function updateLocationString() {
            const country = countrySelect.value;
            const province = provinceSelect.value;
            const city = citySelect.value;

            let locationString = '';

            if (city) locationString = `${country}-${province}-${city}`;
            else if (province) locationString = `${country}-${province}`;
            else if (country) locationString = country;

            // Update hidden input
            locationInput.value = locationString;

            // Update display
            if (locationString) {
                selectedLocationDiv.innerHTML = `
                    <p class="text-green-600 font-medium">Selected Location:</p>
                    <div class="flex items-center mt-1">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">${locationString}</span>
                        <button type="button" onclick="clearLocation()" class="ml-2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            } else {
                selectedLocationDiv.innerHTML = '<p class="text-gray-500">No location selected</p>';
            }
        }

        // Clear location selection
        function clearLocation() {
            countrySelect.value = '';
            provinceSelect.innerHTML = '<option value="">Select Province/State</option>';
            citySelect.innerHTML = '<option value="">Select City</option>';
            provinceSelect.disabled = true;
            citySelect.disabled = true;
            locationInput.value = '';
            selectedLocationDiv.innerHTML = '<p class="text-gray-500">No location selected</p>';
        }

        // Image preview function
        function previewImage(input) {
            const preview = document.getElementById('avatar-preview');
            const previewImage = document.getElementById('avatar-preview-image');
            const fileName = document.getElementById('file-name');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Check file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('{{ __("File size must be less than 2MB") }}');
                    input.value = '';
                    return;
                }

                // Check file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('{{ __("Please select a valid image file (JPG, PNG, GIF)") }}');
                    input.value = '';
                    return;
                }

                // Show file name
                fileName.textContent = file.name;

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);

            } else {
                preview.style.display = 'none';
                fileName.textContent = '{{ __("No file chosen") }}';
            }
        }

        // Initialize form with old input if available
        document.addEventListener('DOMContentLoaded', function() {
            const oldLocation = "{{ old('Location') }}";
            if (oldLocation) {
                const parts = oldLocation.split('-');
                if (parts.length >= 3) {
                    // Full location (country-province-city)
                    const country = parts[0];
                    const province = parts[1];
                    const city = parts[2];

                    if (locationData[country] && locationData[country][province]) {
                        countrySelect.value = country;

                        // Add provinces for selected country
                        for (const prov in locationData[country]) {
                            const option = document.createElement('option');
                            option.value = prov;
                            option.textContent = prov;
                            provinceSelect.appendChild(option);
                        }
                        provinceSelect.disabled = false;
                        provinceSelect.value = province;

                        // Add cities for selected province
                        locationData[country][province].forEach(ct => {
                            const option = document.createElement('option');
                            option.value = ct;
                            option.textContent = ct;
                            citySelect.appendChild(option);
                        });
                        citySelect.disabled = false;
                        citySelect.value = city;
                    }
                } else if (parts.length === 2) {
                    // Only country and province
                    const country = parts[0];
                    const province = parts[1];

                    if (locationData[country] && locationData[country][province]) {
                        countrySelect.value = country;

                        // Add provinces for selected country
                        for (const prov in locationData[country]) {
                            const option = document.createElement('option');
                            option.value = prov;
                            option.textContent = prov;
                            provinceSelect.appendChild(option);
                        }
                        provinceSelect.disabled = false;
                        provinceSelect.value = province;
                    }
                } else if (parts.length === 1) {
                    // Only country
                    const country = parts[0];
                    if (locationData[country]) {
                        countrySelect.value = country;

                        // Add provinces for selected country
                        for (const province in locationData[country]) {
                            const option = document.createElement('option');
                            option.value = province;
                            option.textContent = province;
                            provinceSelect.appendChild(option);
                        }
                        provinceSelect.disabled = false;
                    }
                }

                updateLocationString();
            }
        });
    </script>

    <style>
        .indicator span.active:before {
            position: absolute;
            content: '';
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            border-radius: 5px;
        }
        .indicator span.weak:before {
            background-color: #ff4757;
        }
        .indicator span.medium:before {
            background-color: orange;
        }
        .indicator span.strong:before {
            background-color: #23ad5c;
        }
        .text.weak {
            color: #ff4757;
        }
        .text.medium {
            color: orange;
        }
        .text.strong {
            color: #23ad5c;
        }
        .showBtn, .showBtnConfirm {
            font-size: 14px;
            font-weight: 600;
            user-select: none;
        }
    </style>
</x-guest-layout>