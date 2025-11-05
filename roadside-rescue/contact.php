<?php
// Start the session to access session variables
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Roadside Rescue Nashik</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --accent-red: #e50914; --dark-bg: #0d1117; --light-blue-glow: #00ccff; --text-light: #e0e0e0; --font-heading: 'Orbitron', sans-serif; --font-body: 'Lato', sans-serif;
        }
        body { font-family: var(--font-body); color: var(--text-light); background-color: var(--dark-bg); overflow-x: hidden; position: relative; }
        .navbar { background-color: rgba(13, 17, 23, 0.9) !important; border-bottom: 1px solid rgba(0, 204, 255, 0.1); }
        .navbar-brand { font-family: var(--font-heading); font-weight: 900; color: var(--light-blue-glow) !important; text-shadow: 0 0 5px var(--light-blue-glow); }
        .nav-link:hover, .nav-link.active { color: var(--light-blue-glow) !important; text-shadow: 0 0 8px var(--light-blue-glow); }
        h1, h2, h3 { font-family: var(--font-heading); color: var(--light-blue-glow); }
        .main-content { padding-top: 5rem; padding-bottom: 5rem; }
        .form-container { background-color: rgba(13, 17, 23, 0.8); border: 1px solid rgba(0, 204, 255, 0.1); border-radius: 10px; padding: 2rem; }
        .form-control { background-color: #0d1117; border: 1px solid rgba(0, 204, 255, 0.2); color: var(--text-light); }
        .form-control:focus { background-color: #0d1117; color: var(--text-light); border-color: var(--light-blue-glow); box-shadow: 0 0 15px rgba(0, 204, 255, 0.3); }
        .contact-info-card { background-color: rgba(13, 17, 23, 0.8); border: 1px solid rgba(0, 204, 255, 0.1); border-radius: 10px; padding: 2rem; height: 100%; }
        .contact-info-card a { color: var(--light-blue-glow); text-decoration: none; transition: text-shadow 0.3s; }
        .contact-info-card a:hover { text-shadow: 0 0 8px var(--light-blue-glow); }
        .btn-custom-red { background-color: var(--accent-red); color: var(--text-light); border: none; padding: 12px 30px; font-weight: 700; border-radius: 5px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4); }
        .btn-custom-red:hover { background-color: #ff3344; transform: translateY(-3px); box-shadow: 0 8px 25px rgba(229, 9, 20, 0.6); }
        .footer { background-color: var(--dark-bg); border-top: 1px solid rgba(0, 204, 255, 0.1); padding: 50px 0 20px; }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.html">Roadside Rescue</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content container">
        <div class="text-center">
            <h1 class="display-4">Get In Touch</h1>
            <p class="lead mx-auto" style="max-width: 700px;">
                We're here to help you 24/7. For immediate, emergency assistance, please call our hotline. For all other inquiries, please use the form below.
            </p>
        </div>
        
        <div class="row mt-5">
            <div class="col-lg-7 mb-4">
                <div class="form-container">
                    <h2 class="mb-4">Send us a Message</h2>
                    
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert <?php echo strpos($_SESSION['message'], 'Error') !== false ? 'alert-danger' : 'alert-success'; ?>">
                            <?php 
                                echo $_SESSION['message']; 
                                unset($_SESSION['message']); // Clear the message after displaying it
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="api/contact_handler.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="userName" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="userEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control" id="message" name="userMessage" rows="6" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom-red w-100">Transmit Message</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-4">
                <div class="contact-info-card">
                     <h2 class="mb-4">Contact Info</h2>
                     <p><strong>24/7 Hotline:</strong><br><a href="tel:+911234567890" class="fs-4">+91 123-456-7890</a></p>
                     <p class="mt-4"><strong>Email:</strong><br><a href="mailto:help@roadsiderescue.example">help@roadsiderescue.example</a></p>
                     <p class="mt-4"><strong>Address:</strong><br>123 Auto Lane, Gangapur Road,<br>Nashik, Maharashtra, 422013</p>
                     <div class="mt-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d119981.3881498183!2d73.72346039989504!3d19.99113009763774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddec1f0c58f911%3A0x8209761503bce38f!2sNashik%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1678886568862!5m2!1sen!2sin" width="100%" height="250" style="border:0; border-radius: 5px;" allowfullscreen="" loading="lazy"></iframe>
                     </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
         <div class="container text-center">
            <p>© 2025 Roadside Rescue. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>