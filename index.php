<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <title>EyeBook</title>
    <!-- Google Font: Inter -->
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <header class="header">
      <nav class="navbar">
        <div class="logo">EyeBook</div>
        <div class="login-dropdown">
          <button class="dropdown-toggle" onclick="toggleDropdown()">
            Logins
          </button>
          <ul class="dropdown-menu">
            <li><a href="views/student/login.php">Student</a></li>
            <li><a href="views/faculty/login.php">Faculty</a></li>
            <li><a href="views/spoc/login.php">SPOC</a></li>
            <li><a href="views/admin/login.php">Admin</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <section class="hero">
      <div class="hero-content">
        <h1 class="hero-title">Welcome to EyeBook</h1>
        <p class="hero-text">
          A Next-Generation LMS for Seamless Learning Experience. Connect,
          Learn, and Grow with Virtual Meetings, Chatbots, and SCORM Support.
        </p>
        <!-- <a href="#demo" class="hero-btn">Get Started</a> -->
      </div>
    </section>

    <section id="features" class="features-section">
      <div class="container">
        <h2 class="section-title">Key Features</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Virtual Meetings</h3>
            <p>Host and attend meetings directly on EyeBook.</p>
          </div>
          <div class="feature-card">
            <h3>Chatbot Assistance</h3>
            <p>Get instant help with our integrated AI chatbot.</p>
          </div>
          <div class="feature-card">
            <h3>SCORM Integration</h3>
            <p>Track and manage learning content easily with SCORM.</p>
          </div>
        </div>
      </div>
    </section>

    <footer class="footer">
      <p>&copy; 2024 EyeBook. All Rights Reserved.</p>
    </footer>

    <script>
      function toggleDropdown() {
        const dropdown = document.querySelector('.dropdown-menu');
        dropdown.classList.toggle('show');
      }

      document.addEventListener('click', function (event) {
        const dropdown = document.querySelector('.dropdown-menu');
        const toggleButton = document.querySelector('.dropdown-toggle');

        if (!toggleButton.contains(event.target) && !dropdown.contains(event.target)) {
          dropdown.classList.remove('show');
        }
      });
    </script>
    <style>
      /* General Styles */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
      }

      body {
        background-color: #f8f9fa;
        color: #333;
        line-height: 1.6;
      }

      a {
        text-decoration: none;
        color: inherit;
      }

      ul {
        list-style-type: none;
      }

      /* Navbar */
      .header {
        background-color: #4a90e2;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
      }

      .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
      }

      .navbar .logo {
        font-size: 1.75rem;
        font-weight: 700;
      }

      .navbar .logo:hover {
        color: #e9ecef;
      }

      /* Dropdown */
      .login-dropdown {
        position: relative;
      }

      .dropdown-toggle {
        background-color: #ff6b6b;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.2s ease;
      }

      .dropdown-toggle:hover {
        background-color: #ff4757;
        transform: scale(1.05);
      }

      .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin-top: 0.5rem;
        padding: 0.5rem 0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 100;
        display: none;
      }

      .dropdown-menu.show {
        display: block;
      }

      .dropdown-menu li {
        padding: 0.75rem 1.5rem;
      }

      .dropdown-menu li a {
        font-size: 1rem;
        color: #333;
        transition: color 0.3s ease, transform 0.2s ease;
      }

      .dropdown-menu li a:hover {
        color: #4a90e2;
        transform: scale(1.05);
      }

      /* Hero Section */
      .hero {
        background: linear-gradient(to right, #4a90e2, #5a68d1);
        padding: 5rem 2rem;
        color: white;
        text-align: center;
      }

      .hero-title {
        font-size: 3rem;
        margin-bottom: 1.5rem;
        transition: font-size 0.3s ease;
      }

      .hero-text {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        line-height: 1.5;
      }

      .hero-btn {
        background-color: #ff6b6b;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
      }

      .hero-btn:hover {
        background-color: #ff4757;
      }

      /* Features Section */
      .features-section {
        background-color: #fff;
        padding: 4rem 2rem;
        text-align: center;
      }

      .features-grid {
        display: flex;
        gap: 2rem;
        justify-content: center;
        margin-top: 2rem;
      }

      .feature-card {
        background-color: #f0f4f8;
        padding: 2rem;
        border-radius: 10px;
        width: 100%;
        max-width: 300px;
      }

      .feature-card h3 {
        margin-bottom: 1rem;
        font-size: 1.5rem;
        color: #333;
      }

      .feature-card p {
        font-size: 1rem;
        color: #555;
      }

      /* Footer */
      .footer {
        background-color: #333;
        color: white;
        padding: 1rem 2rem;
        text-align: center;
      }

      .footer p {
        font-size: 1rem;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .features-grid {
          flex-direction: column;
        }

        .login-dropdown {
          position: static;
          margin-top: 1rem;
        }

        .dropdown-menu {
          position: static;
          width: 100%;
        }

        .dropdown-toggle {
          width: 100%;
        }

        .hero-title {
          font-size: 2.5rem;
        }
      }
    </style>
  </body>
</html>
