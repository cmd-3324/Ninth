@extends('layouts.app')

@section('content')

<x-guest-layout>
    {{-- Flash message --}}
    @if(session('error'))
        <div id="flash-message" class="bg-red-600 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div id="flash-message" class="bg-green-600 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @php
        $car_id = $car->car_id ?? old('car_id');
    @endphp

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-center text-2xl font-bold mb-6 text-gray-800">Purchase Your Car</h1>

            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h2 class="text-lg font-semibold mb-2">Car Details</h2>
                <p><strong>Name:</strong> {{ $car->name }}</p>
                <p><strong>Price:</strong> ${{ number_format($car->price) }}</p>
                <p><strong>Available:</strong> {{ $car->available_as }} units</p>
            </div>

            <form id="purchaseForm" method="POST" action="{{ route('purchaseform') }}" novalidate>
                @csrf
                <input type="hidden" name="car_id" value="{{ $car_id }}">

                <!-- Quantity -->
                <div class="mb-4">
                    <x-input-label for="quantity" :value="__('How Many?')" />
                    <x-text-input
                        id="quantity"
                        class="block mt-1 w-full"
                        type="number"
                        name="quantity"
                        min="1"
                        max="{{ $car->available_as }}"
                        placeholder="Enter quantity (Max: {{ $car->available_as }})"
                        :value="old('quantity', 1)"
                        required
                        oninput="validateQuantity(this)"
                    />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    <p id="quantityError" class="text-red-600 text-sm mt-1 hidden">
                        Maximum available: {{ $car->available_as }} units
                    </p>
                </div>

                <!-- Receive Location -->
                <div class="mb-4">
                    <x-input-label for="receive_location" :value="__('Receive Location')" />
                    <x-text-input id="receive_location" class="block mt-1 w-full" type="text" name="receive_location" placeholder="Enter delivery location" :value="old('receive_location')" required />
                    <x-input-error :messages="$errors->get('receive_location')" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        maxlength="170"
                        placeholder="Additional info or requests (max 170 characters)"
                        class="block mt-1 w-full rounded-md border border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 resize-vertical p-2 text-gray-700"
                    >{{ old('description') }} sfsdfsf</textarea>
                    <div id="descCounter" class="text-right text-sm text-gray-500 mt-1 select-none">0 / 170</div>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Name on Card -->
                <div class="mb-4">
                    <x-input-label for="card_name" :value="__('Name on Card')" />
                    <x-text-input
                        id="card_name"
                        class="block mt-1 w-full"
                        type="text"
                        name="card_name"
                        placeholder="John Doe"
                        :value="old('card_name')"
                        required
                        autocomplete="name"
                    />
                    <x-input-error :messages="$errors->get('card_name')" class="mt-2" />
                    <p id="nameError" class="text-red-600 text-sm mt-1 hidden">
                        Please enter a valid full name (only letters, spaces, apostrophes, and hyphens).
                    </p>
                </div>

                <!-- Card Number -->
                <div class="mb-4">
                    <x-input-label for="card_number" :value="__('Card Number')" />
                    <x-text-input
                        id="card_number"
                        class="block mt-1 w-full"
                        type="tel"
                        name="card_number"
                        placeholder="Example: 1234 5678 9012 3456"
                        maxlength="19"
                        :value="old('card_number')"
                        required
                        autocomplete="cc-number"
                    />
                    <x-input-error :messages="$errors->get('card_number')" class="mt-2" />
                </div>

                <div class="flex gap-4 mb-4">
                    <!-- Expiry Date -->
                    <div class="flex-1">
                        <x-input-label for="expiry_date" :value="__('Expiry Date')" />
                        <x-text-input
                            id="expiry_date"
                            class="block mt-1 w-full"
                            type="month"
                            name="expiry_date"
                            :value="old('expiry_date')"
                            required
                        />
                        <x-input-error :messages="$errors->get('expiry_date')" class="mt-2" />
                    </div>

                    <!-- CVV -->
                    <div class="flex-1">
                        <x-input-label for="cvv" :value="__('CVV')" />
                        <x-text-input
                            id="cvv"
                            class="block mt-1 w-full"
                            type="number"
                            name="cvv"
                            maxlength="4"
                            placeholder="123"
                            :value="old('cvv')"
                            required
                            autocomplete="cc-csc"
                        />
                        <x-input-error :messages="$errors->get('cvv')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-center">
                    <button
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-md transition duration-300"
                    >
                        Complete Purchase
                    </button>
                </div>

                <p class="text-center text-gray-500 text-xs mt-4">
                    * All payment info is securely processed.
                </p>
            </form>
        </div>
    </div>

    <!-- Custom JavaScript -->
    <script>
const form = document.getElementById('purchaseForm');
const expiryInput = document.getElementById('expiry_date');

form.addEventListener('submit', function (e) {
  const val = expiryInput.value;
  if (!val) {
    expiryInput.setCustomValidity('Expiry date is required');
    expiryInput.reportValidity();
    e.preventDefault();
    return;
  }

  const [year, month] = val.split('-').map(Number);
  const now = new Date();
  const currYear = now.getFullYear();
  const currMonth = now.getMonth() + 1;

  if (year < currYear || (year === currYear && month < currMonth)) {
    expiryInput.setCustomValidity('Expiry date cannot be before current month');
    expiryInput.reportValidity();
    e.preventDefault();
    return;
  }
  if (year > currYear + 4 || (year === currYear + 4 && month > currMonth)) {
    expiryInput.setCustomValidity('Expiry date cannot be more than 4 years in the future');
    expiryInput.reportValidity();
    e.preventDefault();
    return;
  }

  expiryInput.setCustomValidity(''); // Clear errors if valid
});

        document.addEventListener('DOMContentLoaded', function () {
            const cardInput = document.getElementById('card_number');
            cardInput?.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '').substring(0, 16);
                let formattedValue = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formattedValue += ' ';
                    }
                    formattedValue += value[i];
                }
                e.target.value = formattedValue;
            });

            const nameInput = document.getElementById('card_name');
            const nameError = document.getElementById('nameError');

            function validateName(name) {
                const regex = /^[a-zA-Z]+([ '-][a-zA-Z]+)+$/;
                return regex.test(name.trim());
            }

            nameInput?.addEventListener('blur', () => {
                const isValid = validateName(nameInput.value);
                if (!isValid) {
                    nameInput.classList.add('invalid');
                    nameError.classList.remove('hidden');
                } else {
                    nameInput.classList.remove('invalid');
                    nameError.classList.add('hidden');
                }
            });

            const description = document.getElementById('description');
            const descCounter = document.getElementById('descCounter');

            // Initialize counter on load
            descCounter.textContent = `${description.value.length} / 170`;

            description?.addEventListener('input', () => {
                const length = description.value.length;
                descCounter.textContent = `${length} / 170`;
            });

            // Quantity validation
            let invalidAttempts = 0;
            const maxInvalidAttempts = 2;

            function validateQuantity(input) {
                const maxQuantity = parseInt(input.max);
                const enteredValue = parseInt(input.value);
                const quantityError = document.getElementById('quantityError');

                if (enteredValue > maxQuantity) {
                    input.value = maxQuantity; // Reset to max value
                    quantityError.classList.remove('hidden');
                    invalidAttempts++;

                    // If user tries too many times, disable the input
                    if (invalidAttempts >= maxInvalidAttempts) {
                        input.disabled = true;
                        setTimeout(() => {
                            input.disabled = false;
                            invalidAttempts = 0; // Reset after a delay
                        }, 3000); // Re-enable after 3 seconds
                    }
                } else {
                    quantityError.classList.add('hidden');
                    invalidAttempts = 0; // Reset counter on valid input
                }
            }

            // Also add form submission validation
            document.getElementById('purchaseForm')?.addEventListener('submit', function(e) {
                const quantityInput = document.getElementById('quantity');
                const maxQuantity = parseInt(quantityInput.max);
                const enteredValue = parseInt(quantityInput.value);

                if (enteredValue > maxQuantity) {
                    e.preventDefault();
                    quantityInput.value = maxQuantity;
                    document.getElementById('quantityError').classList.remove('hidden');
                    // Focus on the quantity field
                    quantityInput.focus();
                }
            });

            const form = document.getElementById('purchaseForm');
            form?.addEventListener('submit', (e) => {
                if (!validateName(nameInput.value)) {
                    e.preventDefault();
                    nameInput.classList.add('invalid');
                    nameError.classList.remove('hidden');
                    nameInput.focus();
                }
            });

            // Flash message handling
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>

    <style>
        /* Custom styles for invalid inputs */
        input.invalid, textarea.invalid {
            border-color: #e74c3c !important;
            background-color: #fdecea !important;
        }
    </style>
</x-guest-layout>

@endsection
