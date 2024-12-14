@extends('main_resources.index')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-50">
    <div class="max-w-lg w-full bg-white p-8 rounded-2xl shadow-lg transform transition-all duration-300 hover:shadow-2xl mt-5">
        <!-- Logo Section -->
        <div class="flex justify-center mb-8">
            <a href="/" class="text-indigo-600 font-extrabold text-3xl tracking-wide">FindBoard</a>
        </div>

        <form method="POST" action="{{ route('register') }}" id="signupForm">
            @csrf
            <div class="space-y-5">
                <!-- Full Name Field -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-600">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" 
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-800 @error('name') border-red-500 @enderror" placeholder="John Doe">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-600">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-800 @error('email') border-red-500 @enderror" placeholder="email@example.com">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-600">Phone</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" 
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-800 @error('phone') border-red-500 @enderror" placeholder="123-456-7890">
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Field -->
                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-600">Address</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" 
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-800 @error('address') border-red-500 @enderror" placeholder="123 Main St">
                    @error('address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                        <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-600">Password</label>
                    <input id="password" type="password" name="password" 
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-800 @error('password') border-red-500 @enderror" 
                        placeholder="Enter password">
                    <div id="passwordErrors" class="mt-2 space-y-1"></div>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-600">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                        class="w-full px-4 py-2 mt-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-800 @error('password_confirmation') border-red-500 @enderror" 
                        placeholder="Enter password">
                    @error('password_confirmation')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        I agree to the 
                        <button type="button" class="text-indigo-600 underline hover:text-indigo-900" onclick="toggleModal()">Terms and Conditions</button>.
                    </label>
                </div>
                @error('terms')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
                

                <!-- Submit Button -->
                <button type="submit" id="submitButton"
                    class="w-full py-3 mt-6 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 focus:outline-none disabled:bg-gray-400 disabled:cursor-not-allowed transition-all duration-300"
                    disabled>
                    Sign Up
                </button>
            </div>
        </form>

        <!-- Log In Link -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">Already have an account? 
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Log in</a>
            </p>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div id="termsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-3/4 max-h-[70vh] p-6 rounded-lg shadow-lg overflow-y-auto relative">
        <button id="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl">
            &times;
        </button>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Terms and Conditions</h2>
        <p class="text-sm text-gray-600">
            Welcome to FindBoard! By creating an account and using our platform, you agree to the following terms and conditions:
        </p>
        
        <h3 class="text-md font-bold mt-4 text-gray-800">1. Acceptance of Terms</h3>
        <p class="text-sm text-gray-600">
            By accessing or using FindBoard, you acknowledge that you have read, understood, and agree to be bound by these terms. If you do not agree, please refrain from using our platform.
        </p>
        
        <h3 class="text-md font-bold mt-4 text-gray-800">2. User Responsibilities</h3>
        <p class="text-sm text-gray-600">
            - You must provide accurate and complete information during registration.  
            - You are solely responsible for the activity under your account and must keep your login details confidential.  
            - You agree not to use the platform for any unlawful or harmful activities.
        </p>
        
        <h3 class="text-md font-bold mt-4 text-gray-800">3. Platform Use</h3>
        <p class="text-sm text-gray-600">
            - FindBoard is a platform designed to connect landlords with tenants. We do not own or manage any properties listed on the platform.  
            - We reserve the right to remove listings or accounts that violate our terms or policies.
        </p>
        
        <h3 class="text-md font-bold mt-4 text-gray-800">4. Privacy and Data Usage</h3>
        <p class="text-sm text-gray-600">
            - Your personal information is collected and used in accordance with our Privacy Policy.  
            - We may use your data to improve our services but will never share your information without your consent.
        </p>
        
        <h3 class="text-md font-bold mt-4 text-gray-800">5. Limitation of Liability</h3>
        <p class="text-sm text-gray-600">
            - FindBoard is not responsible for any disputes, damages, or losses arising from transactions or communications between users.  
            - Use of the platform is at your own risk, and we make no guarantees regarding the accuracy of property listings.
        </p>
        
        <h3 class="text-md font-bold mt-4 text-gray-800">6. Changes to Terms</h3>
        <p class="text-sm text-gray-600">
            We reserve the right to update or modify these terms at any time. Continued use of the platform after changes implies acceptance of the revised terms.
        </p>
        
        <h3 class="text-md font-bold mt-4 text-gray-800">7. Contact Us</h3>
        <p class="text-sm text-gray-600">
            For any questions or concerns about these Terms and Conditions, please contact us at support@findboard.com.
        </p>
        
        <div class="mt-4 flex justify-end">
            <button onclick="toggleModal()" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none">
                Close
            </button>
        </div>
    </div>
</div>

{{-- <script>
    // Enable/Disable the Submit Button based on the checkbox
    const termsCheckbox = document.getElementById('terms');
    const submitButton = document.getElementById('submitButton');

    termsCheckbox.addEventListener('change', function () {
        submitButton.disabled = !this.checked;
    });

    // Toggle Modal Visibility
    function toggleModal() {
        const modal = document.getElementById('termsModal');
        modal.classList.toggle('hidden');
    }
</script> --}}

<script>
    // JavaScript for toggling the modal visibility
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('termsModal');
        const closeModalButton = document.getElementById('closeModal');
        const showModalButton = document.getElementById('showTermsModal'); // Assume you have a button with this ID to open the modal

        // Show the modal
        if (showModalButton) {
            showModalButton.addEventListener('click', function () {
                modal.classList.remove('hidden');
            });
        }

        // Close the modal
        closeModalButton.addEventListener('click', function () {
            modal.classList.add('hidden');
        });

        // Close modal when clicking outside of it
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>

{{-- <script>
    function validatePassword() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("password_confirmation").value;
        const submitButton = document.getElementById("submitButton");

        // Password rules with descriptions
        const rules = [
            { regex: /.{8,}/, description: "At least 8 characters" },
            { regex: /[A-Z]/, description: "At least one uppercase letter" },
            { regex: /[a-z]/, description: "At least one lowercase letter" },
            { regex: /[0-9]/, description: "At least one number" },
            { regex: /[!@#$%^&*_]/, description: "At least one special character (!@#$%^&*)" }
        ];

        // Check each rule and generate feedback
        const feedback = rules.map(rule => {
            const isValid = rule.regex.test(password);
            return `<p class="${isValid ? 'text-green-600' : 'text-red-600'} text-sm">${isValid ? '✔' : '✘'} ${rule.description}</p>`;
        });

        // Check if passwords match
        const matchMessage = password === confirmPassword
            ? '<p class="text-green-600 text-sm">✔ Passwords match</p>'
            : '<p class="text-red-600 text-sm">✘ Passwords do not match</p>';
        
        // Update the feedback container
        const errorContainer = document.getElementById("passwordErrors");
        errorContainer.innerHTML = [...feedback, matchMessage].join("");

        // Enable submit button only if all rules are valid and passwords match
        const allValid = rules.every(rule => rule.regex.test(password)) && password === confirmPassword;
        submitButton.disabled = !allValid;
    }

    // Attach event listeners for real-time feedback
    document.getElementById("password").addEventListener("input", validatePassword);
    document.getElementById("password_confirmation").addEventListener("input", validatePassword);
</script> --}}
<script>
    // Function to validate the password rules and passwords match
    function validatePassword() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("password_confirmation").value;
        const submitButton = document.getElementById("submitButton");

        // Password rules with descriptions
        const rules = [
            { regex: /.{8,}/, description: "At least 8 characters" },
            { regex: /[A-Z]/, description: "At least one uppercase letter" },
            { regex: /[a-z]/, description: "At least one lowercase letter" },
            { regex: /[0-9]/, description: "At least one number" },
            { regex: /[!@#$%^&*_]/, description: "At least one special character (!@#$%^&*)" }
        ];

        // Check each rule and generate feedback
        const feedback = rules.map(rule => {
            const isValid = rule.regex.test(password);
            return `<p class="${isValid ? 'text-green-600' : 'text-red-600'} text-sm">${isValid ? '✔' : '✘'} ${rule.description}</p>`;
        });

        // Check if passwords match
        const matchMessage = password === confirmPassword
            ? '<p class="text-green-600 text-sm">✔ Passwords match</p>'
            : '<p class="text-red-600 text-sm">✘ Passwords do not match</p>';

        // Update the feedback container
        const errorContainer = document.getElementById("passwordErrors");
        errorContainer.innerHTML = [...feedback, matchMessage].join("");

        // Enable/Disable submit button based on validation and checkbox
        updateSubmitButtonState(rules.every(rule => rule.regex.test(password)) && password === confirmPassword);
    }

    // Function to update submit button state
    function updateSubmitButtonState(isPasswordValid) {
        const termsCheckbox = document.getElementById("terms");
        const submitButton = document.getElementById("submitButton");

        // Submit button is enabled only if both conditions are met
        submitButton.disabled = !(isPasswordValid && termsCheckbox.checked);
    }

    // Handle terms checkbox change
    document.getElementById("terms").addEventListener("change", function () {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("password_confirmation").value;

        // Check if password is valid according to the rules
        const rules = [
            { regex: /.{8,}/ },
            { regex: /[A-Z]/ },
            { regex: /[a-z]/ },
            { regex: /[0-9]/ },
            { regex: /[!@#$%^&*_]/ }
        ];
        const isPasswordValid = rules.every(rule => rule.regex.test(password)) && password === confirmPassword;

        // Update submit button state
        updateSubmitButtonState(isPasswordValid);
    });

    // Attach event listeners for real-time feedback
    document.getElementById("password").addEventListener("input", validatePassword);
    document.getElementById("password_confirmation").addEventListener("input", validatePassword);

    // Toggle Modal Visibility
    function toggleModal() {
        const modal = document.getElementById("termsModal");
        modal.classList.toggle("hidden");
    }
</script>


@endsection
