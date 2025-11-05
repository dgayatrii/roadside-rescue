<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Roadside Rescue</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --accent-red: #e50914; --dark-bg: #0d1117; --light-blue-glow: #00ccff; --text-light: #e0e0e0; --font-heading: 'Orbitron', sans-serif; --font-body: 'Lato', sans-serif;
        }
        body { font-family: var(--font-body); color: var(--text-light); background-color: var(--dark-bg); overflow-x: hidden; position: relative; }
        h1, h2, h3 { font-family: var(--font-heading); color: var(--light-blue-glow); }
        .main-content { padding-top: 5rem; padding-bottom: 5rem; min-height: 70vh; }
        .form-container { background-color: rgba(13, 17, 23, 0.8); border: 1px solid rgba(0, 204, 255, 0.1); border-radius: 10px; padding: 2.5rem; margin-top: 2rem; }
        .form-control { background-color: #0d1117; border: 1px solid rgba(0, 204, 255, 0.2); color: var(--text-light); padding: 0.75rem 1rem; }
        .form-control:focus { background-color: #0d1117; color: var(--text-light); border-color: var(--light-blue-glow); box-shadow: 0 0 15px rgba(0, 204, 255, 0.3); }
        .btn-custom-red { background-color: var(--accent-red); color: var(--text-light); border: none; padding: 12px 30px; font-weight: 700; border-radius: 5px; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(229, 9, 20, 0.4); }
        .btn-custom-red:hover { background-color: #ff3344; transform: translateY(-3px); box-shadow: 0 8px 25px rgba(229, 9, 20, 0.6); }
        .alert { border-radius: 5px; }
    </style>
</head>
<body>
    <main class="main-content container d-flex align-items-center justify-content-center">
        <div class="form-container" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4">Admin Login</h2>
            
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
            </form>
        </div>
    </main>

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
                if (data.success && data.role === 'admin') {
                    alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    setTimeout(() => {
                        window.location.href = 'admin_dashboard.php';
                    }, 1000);
                } else if (data.success && data.role !== 'admin') {
                     alertContainer.innerHTML = `<div class="alert alert-danger">Not an admin account.</div>`;
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