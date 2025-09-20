<footer class="bg-gray-900 text-gray-300 mt-auto">
  <div class="container mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">

    <!-- About Us -->
    <div>
      <h3 class="text-white text-lg font-semibold mb-4">About Us</h3>
      <p class="text-sm leading-relaxed">
        MyWebsite is dedicated to providing quality content and resources to our community. We believe in knowledge, integrity, and connection.
      </p>
    </div>

    <!-- Quick Links -->
    <div>
      <h3 class="text-white text-lg font-semibold mb-4">Quick Links</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="/" class="hover:text-white">Home</a></li>
        <li><a href="{{route("aboutpage")}}" class="hover:text-white">About</a></li>
        <li><a href="/contact" class="hover:text-white">Contact</a></li>
        <li><a href="#privacy" class="hover:text-white">Privacy Policy</a></li>
        <li><a href="/faq" class="hover:text-white">FAQ</a></li>
      </ul>
    </div>

    <!-- Contact Info -->
    <div>
      <h3 class="text-white text-lg font-semibold mb-4">Contact Us</h3>
      <ul class="text-sm space-y-2">
        <li>Email: <a href="mailto:info@mywebsite.com" class="hover:text-white">info@mywebsite.com</a></li>
        <li>Phone: <a href="tel:+1234567890" class="hover:text-white">+1 (234) 567-890</a></li>
        <li>Address: <br>123 Classic Lane<br>City, Country</li>
      </ul>
    </div>

    <!-- Map (Placeholder) -->
    <div>
      <h3 class="text-white text-lg font-semibold mb-4">Find Us</h3>
      <div class="rounded overflow-hidden">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.1234567890!2d-122.4194150846817!3d37.77492977975909!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808f7e1234567890%3A0x1234567890abcdef!2sSan%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1630000000000!5m2!1sen!2sus"
          width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>

  </div>

  <!-- Bottom Bar -->
  <div class="border-t border-gray-700 mt-8">
    <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center text-sm">
      <p>&copy; {{ date('Y') }} MyWebsite. All rights reserved.</p>
      <div class="mt-2 md:mt-0 space-x-4">
        <a href="/terms" class="hover:text-white">Terms of Service</a>
        <a href="/privacy" class="hover:text-white">Privacy Policy</a>
      </div>
    </div>
  </div>
</footer>
