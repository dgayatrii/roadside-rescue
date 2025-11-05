<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Roadside Rescue Nashik</title>
    
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
        .main-content { padding-top: 5rem; padding-bottom: 5rem; min-height: 70vh; }
        .form-container { background-color: rgba(13, 17, 23, 0.8); border: 1px solid rgba(0, 204, 255, 0.1); border-radius: 10px; padding: 2.5rem; margin-top: 2rem; }
        .form-control { background-color: #0d1117; border: 1px solid rgba(0, 204, 255, 0.2); color: var(--text-light); padding: 0.75rem 1rem; }
        .form-control:focus { background-color: #0d1117; color: var(--text-light); border-color: var(--light-blue-glow); box-shadow: 0 0 15px rgba(0, 204, 255, 0.3); }
        .btn-custom-red { background-color: var(--accent-red); color: var(--text-light); border: none; padding: 12px 30px; font-weight: 700; border-radius: 5px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4); }
        .btn-custom-red:hover { background-color: #ff3344; transform: translateY(-3px); box-shadow: 0 8px 25px rgba(229, 9, 20, 0.6); }
        .footer { background-color: var(--dark-bg); border-top: 1px solid rgba(0, 204, 255, 0.1); padding: 50px 0 20px; }
        .alert { border-radius: 5px; }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.html">Roadside Rescue</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content container">
        <h1 class="text-center">Login to Your Account</h1>
        <p class="text-center lead mx-auto" style="max-width: 700px;">Access your dashboard to manage bookings and profile.</p>

        <div class="form-container mx-auto" style="max-width: 500px;">
            <h2 class="text-center mb-4">Login</h2>
            
            <div id="alert-container"></div>
            
            <form id="login-form">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-custom-red w-100 mt-3">Login</button>
                <p class="text-center mt-3">
                    Don't have an account? <a href="register.php" style="color: var(--light-blue-glow);">Register here</a>
                </p>
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
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const alertContainer = document.getElementById('alert-container');
            
            fetch('api/login_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    
                    setTimeout(() => {
                        if (data.role === 'admin') {
                            window.location.href = 'admin_dashboard.php';
                        } else {
                            window.location.href = 'user_dashboard.php';
                        }
                    }, 1000);
                } else {
                    alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alertContainer.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
            });
        });
    </script>
</body>
</html>