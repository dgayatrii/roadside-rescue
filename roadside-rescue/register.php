<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Roadside Rescue Nashik</title>
    
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
        .form-container { background-color: rgba(13, 17, 23, 0.8); border: 1px solid rgba(0, 204, 255, 0.1); border-radius: 10px; padding: 2.5rem; margin-top: 2rem; }
        .form-control { background-color: #0d1117; border: 1px solid rgba(0, 204, 255, 0.2); color: var(--text-light); }
        .form-control:focus { background-color: #0d1117; color: var(--text-light); border-color: var(--light-blue-glow); box-shadow: 0 0 15px rgba(0, 204, 255, 0.3); }
        .btn-custom-red { background-color: var(--accent-red); color: var(--text-light); border: none; padding: 12px 30px; font-weight: 700; border-radius: 5px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4); }
        .btn-custom-red:hover { background-color: #ff3344; transform: translateY(-3px); box-shadow: 0 8px 25px rgba(229, 9, 20, 0.6); }
        .error-message { color: #ff4d4d; font-size: 0.85rem; margin-top: 0.25rem; display: none; }
        .form-group.error .form-control { border-color: var(--accent-red); }
        .form-group.error .error-message { display: block; }
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
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link active" href="register.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content container">
        <h1 class="text-center">Create an Account</h1>
        <p class="text-center lead mx-auto" style="max-width: 700px;">Register for an account to save your details and get faster assistance in the future.</p>

        <div class="form-container mx-auto" style="max-width: 700px;">
            <h2 class="text-center mb-4">Registration Form</h2>
            <form id="registration-form">
                <div class="form-group mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                    <div class="error-message">Please enter your full name</div>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="error-message">Please enter a valid email address</div>
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}" required>
                    <div class="error-message">Please enter a valid 10-digit phone number</div>
                </div>
                <div class="form-group mb-3">
                    <label for="vehicle" class="form-label">Vehicle Make & Model</label>
                    <input type="text" class="form-control" id="vehicle" name="vehicle" placeholder="e.g., Maruti Swift">
                    <div class="error-message">Please enter your vehicle details</div>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="error-message">Password must be at least 6 characters</div>
                </div>
                <div class="form-group mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                    <div class="error-message">Passwords do not match</div>
                </div>
                <button type="submit" class="btn btn-custom-red w-100 mt-3">Register</button>
                <p class="text-center mt-3">Already have an account? <a href="login.php" style="color: var(--light-blue-glow);">Login here</a></p>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p>© 2025 Roadside Rescue. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('registration-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic Validation
            let isValid = true;
            // ... (Add your validation logic here if needed) ...

            if (isValid) {
                const formData = new FormData(this);
                
                fetch('api/register_handler.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.href = 'login.php';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }
        });
        
        // Real-time validation
        document.getElementById('phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    </script>
</body>
</html>