<footer class="bg-gray-900 text-gray-300 mt-auto">
  <!-- Back to top button -->
  <div class="container mx-auto px-6 py-4 flex justify-center">
    <a href="#top" class="niasgotop">
      <div class="elementor-icon">
        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M11.5 0L23 11.5L11.5 23L0 11.5L11.5 0Z" fill="#0069C4"/>
        </svg>
      </div>
    </a>
  </div>

  <div class="container mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">

    <!-- About Us with Email Subscription -->
    <div>
      <h3 class="text-white text-lg font-semibold mb-4">About Us</h3>
      <p class="text-sm leading-relaxed mb-4">
        MyWebsite is dedicated to providing quality content and resources to our community. We believe in knowledge, integrity, and connection.
      </p>

      <!-- Email Subscription Form -->
      <div class="mb-4">
        <h4 class="text-white text-md font-medium mb-2">Subscribe to our newsletter</h4>
        <form class="flex flex-col space-y-2">
          <input
            type="email"
            placeholder="Enter your email"
            class="px-3 py-2 bg-gray-800 border border-gray-700 rounded text-sm focus:outline-none focus:border-blue-500"
          >
          <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition duration-200"
          >
            Subscribe
          </button>
        </form>
      </div>

      <!-- Success/Error Message Temporary Window -->
      <div id="subscription-message" class="hidden p-3 rounded text-sm mb-2 transition-all duration-300">
        <!-- Messages will appear here dynamically -->
      </div>

      <div class="niasdivider mt-4"></div>
    </div>

    <!-- Quick Links -->
    <div>
      <h3 class="text-white text-lg font-semibold mb-4">Quick Links</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="/" class="hover:text-white flex items-center">
          <span class="w-2 h-2 bg-[#0069C4] rounded-full mr-2"></span>
          Home
        </a></li>
        <li><a href="{{route('aboutpage')}}" class="hover:text-white flex items-center">
          <span class="w-2 h-2 bg-[#0069C4] rounded-full mr-2"></span>
          About Us
        </a></li>
        <li><a href="/contact" class="hover:text-white flex items-center">
          <span class="w-2 h-2 bg-[#0069C4] rounded-full mr-2"></span>
          Contact Us
        </a></li>
        <li><a href="#privacy" class="hover:text-white flex items-center">
          <span class="w-2 h-2 bg-[#0069C4] rounded-full mr-2"></span>
          Privacy Policy
        </a></li>
        <li><a href="/faq" class="hover:text-white flex items-center">
          <span class="w-2 h-2 bg-[#0069C4] rounded-full mr-2"></span>
          FAQ
        </a></li>
      </ul>
    </div>

    <!-- Contact Info -->
    <div>
      <h3 class="text-white text-lg font-semibold mb-4">Contact Us</h3>
      <ul class="text-sm space-y-2">
        <li class="flex items-center">
          <span class="w-2 h-2 bg-[#0069C4] rounded-full mr-2"></span>
          Email: <a href="mailto:info@mywebsite.com" class="hover:text-white ml-1">info@mywebsite.com</a>
        </li>
        <li class="flex items-center">
          <span class="w-2 h-2 bg-[#0069C4] rounded-full mr-2"></span>
          Phone: <a href="tel:+1234567890" class="hover:text-white ml-1">+1 (234) 567-890</a>
        </li>
        <li class="flex items-start">
          <span class="w-2 h-2 bg-[#0069C4] rounded-full mr-2 mt-1"></span>
          Address: <span class="ml-1">123 Classic Lane<br>City, Country</span>
        </li>
      </ul>
    </div>

    <!-- Social Media & Map -->
    <div>
      <h3 class="text-white text-lg font-semibold mb-4">Find Us</h3>

      <!-- Social Media Icons -->
      <div class="grid grid-cols-4 gap-3 mb-4">
        <a href="https://t.me/" class="nias-social telegram">
          <div class="elementor-icon">
            <i class="fab fa-telegram-plane"></i>
          </div>
        </a>
        <a href="https://youtube.com/" class="nias-social youtube">
          <div class="elementor-icon">
            <i class="fab fa-youtube"></i>
          </div>
        </a>
        <a href="https://instagram.com/" class="nias-social">
          <div class="elementor-icon">
            <i class="fab fa-instagram"></i>
          </div>
        </a>
        <a href="https://wa.me/+" class="nias-social whatsapp">
          <div class="elementor-icon">
            <i class="fab fa-whatsapp"></i>
          </div>
        </a>
      </div>

      <!-- Map -->
      <div class="rounded overflow-hidden mt-4">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.1234567890!2d-122.4194150846817!3d37.77492977975909!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808f7e1234567890%3A0x1234567890abcdef!2sSan%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1630000000000!5m2!1sen!2sus"
          width="100%" height="120" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>

  </div>

  <!-- Bottom Bar -->
  <div class="border-t border-gray-700 mt-8">
    <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center text-sm">
      <p class="text-center md:text-left">© {{ date('Y') }} MyWebsite. All rights reserved.</p>
      <div class="mt-2 md:mt-0 space-x-4">
        <a href="/terms" class="hover:text-white">Terms of Service</a>
        <a href="/privacy" class="hover:text-white">Privacy Policy</a>
      </div>
    </div>
  </div>

  <!-- Copyright Section -->
  <div class="bg-[#0069C4] rounded-tr-[50px] shadow-lg mt-4">
    <div class="bg-[#003868] rounded-tr-[50px] p-5 text-center inset-shadow">
      <p class="text-white text-sm mb-2">All rights to this site belong to MyWebsite.</p>
      <p class="text-white text-xs">Website design and SEO by Our Team</p>
    </div>
  </div>

  <style>
    .niasgotop .elementor-icon {
      box-shadow: 0px 9px 20px 0px #0069c44f;
      border-radius: 50%;
      padding: 10px;
      background: white;
      transition: transform 0.3s ease;
    }

    .niasgotop:hover .elementor-icon {
      transform: translateY(-3px);
    }

    .niasdivider {
      position: relative;
      height: 1px;
      background-color: #E4E4E4;
      margin: 10px 0;
    }

    .niasdivider:after {
      content: "";
      right: 0;
      top: -0.2px;
      width: 36px;
      height: 1px;
      background-color: #0069c4;
      position: absolute;
    }

    .nias-social {
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: transparent;
      position: relative;
      border-radius: 7px;
      cursor: pointer;
      transition: all .3s;
      width: 40px;
      height: 40px;
    }

    .nias-social .elementor-icon {
      padding: 5px;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: transparent;
      backdrop-filter: blur(4px);
      letter-spacing: 0.8px;
      border-radius: 10px;
      transition: all .3s;
      border: 1px solid rgba(156, 156, 156, 0.466);
      color: white;
    }

    .nias-social .elementor-icon:before {
      position: absolute;
      content: "";
      width: 100%;
      height: 100%;
      background: #f09433;
      background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
      z-index: -1;
      border-radius: 9px;
      pointer-events: none;
      transition: all .3s;
    }

    .nias-social.telegram .elementor-icon:before {
      background: #24a1de;
    }

    .nias-social.youtube .elementor-icon:before {
      background: red;
    }

    .nias-social.whatsapp .elementor-icon:before {
      background: #075e54;
    }

    .nias-social:hover .elementor-icon:before {
      transform: rotate(35deg);
      transform-origin: bottom;
    }

    .nias-social:hover .elementor-icon {
      background-color: rgba(156, 156, 156, 0.466);
    }

    .inset-shadow {
      box-shadow: inset 0px 5px 30px 0px rgba(0, 0, 0, 0.11);
    }

    /* Success/Error message styles */
    .message-success {
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .message-error {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
  </style>

  <script>
    // Email subscription form handling
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form');
      const messageDiv = document.getElementById('subscription-message');

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const emailInput = form.querySelector('input[type="email"]');
        const email = emailInput.value;

        // Simple email validation
        if (!email || !email.includes('@')) {
          showMessage('Please enter a valid email address.', 'error');
          return;
        }

        // Simulate API call
        showMessage('Subscribing...', 'info');

        setTimeout(() => {
          // Simulate successful subscription
          showMessage('Thank you for subscribing!', 'success');
          emailInput.value = '';
        }, 1000);
      });

      function showMessage(text, type) {
        messageDiv.textContent = text;
        messageDiv.className = '';
        messageDiv.classList.add(type === 'success' ? 'message-success' :
                               type === 'error' ? 'message-error' : 'bg-blue-100 text-blue-800');
        messageDiv.classList.remove('hidden');

        // Auto-hide after 5 seconds
        setTimeout(() => {
          messageDiv.classList.add('hidden');
        }, 5000);
      }
    });
  </script>
</footer>
