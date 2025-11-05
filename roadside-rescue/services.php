<?php require_once 'api/db_connect.php'; // Connect to DB ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Roadside Rescue Nashik</title>
    
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
        h1, h2, h3, h4 { font-family: var(--font-heading); color: var(--light-blue-glow); }
        .main-content { padding-top: 5rem; padding-bottom: 5rem; }
        .service-card { background-color: rgba(13, 17, 23, 0.8); border: 1px solid rgba(0, 204, 255, 0.1); border-radius: 10px; overflow: hidden; height: 100%; transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column; }
        .service-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0, 204, 255, 0.15); }
        
        /* This CSS ensures your local images look good */
        .service-card img {
            width: 100%;
            height: 200px;
            object-fit: cover; /* This scales the image nicely */
        }

        .service-card .card-content { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
        .service-card h3 { margin-bottom: 0.75rem; }
        .footer { background-color: var(--dark-bg); border-top: 1px solid rgba(0, 204, 255, 0.1); padding: 50px 0 20px; }
        .form-control { background-color: #0d1117; border: 1px solid rgba(0, 204, 255, 0.2); color: var(--text-light); }
        .form-control:focus { background-color: #0d1117; color: var(--text-light); border-color: var(--light-blue-glow); box-shadow: 0 0 15px rgba(0, 204, 255, 0.3); }
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
                        <li class="nav-item"><a class="nav-link active" href="services.php">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content container">
        <div class="text-center mb-5">
            <h1 class="display-4">Our Services</h1>
            <p class="lead mx-auto" style="max-width: 700px;">We offer a comprehensive range of roadside assistance services. Our certified professionals are ready to help you 24/7 in Nashik.</p>
        </div>
        
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <input type="text" id="service-search" class="form-control" placeholder="Search for a service...">
            </div>
        </div>

        <div class="row mt-5" id="service-list">
            <?php
            // Fetch services from the database
            $result = $conn->query("SELECT * FROM services WHERE status = 'active'");
            if ($result->num_rows > 0):
                while($row = $result->fetch_assoc()):
            ?>
            <div class="col-lg-4 col-md-6 mb-4 service-item">
                <div class="service-card">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['service_name']); ?>">
                    <div class="card-content">
                        <h3 class="service-name"><?php echo htmlspecialchars($row['service_name']); ?></h3>
                        <p class="service-desc"><?php echo htmlspecialchars($row['description']); ?></p>
                        <h4 class="mt-auto pt-2">₹<?php echo number_format($row['price'], 2); ?></h4>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <p class="text-center">No services are currently available.</p>
            <?php endif; $conn->close(); ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p>© 2025 Roadside Rescue. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // JavaScript for live search/filter
    document.getElementById('service-search').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let services = document.querySelectorAll('.service-item');
        
        services.forEach(service => {
            let serviceName = service.querySelector('.service-name').textContent.toLowerCase();
            let serviceDesc = service.querySelector('.service-desc').textContent.toLowerCase();
            
            if (serviceName.includes(filter) || serviceDesc.includes(filter)) {
                service.style.display = '';
            } else {
                service.style.display = 'none';
            }
        });
    });
    </script>
</body>
</html>