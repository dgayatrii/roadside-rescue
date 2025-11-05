<?php
require_once 'api/db_connect.php'; // UPDATED PATH

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'user') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch user bookings (using the VIEW from your SQL for more data)
$bookings_query = "SELECT * FROM booking_summary WHERE user_id = ? ORDER BY booking_date DESC";
$stmt = $conn->prepare($bookings_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result();

// Fetch available services
$services_query = "SELECT * FROM services WHERE status = 'active' ORDER BY service_name";
$services = $conn->query($services_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Roadside Rescue</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --accent-red: #e50914; --dark-bg: #0d1117; --light-blue-glow: #00ccff; --text-light: #e0e0e0; --font-heading: 'Orbitron', sans-serif; --font-body: 'Lato', sans-serif;
        }
        body { font-family: var(--font-body); color: var(--text-light); background-color: var(--dark-bg); min-height: 100vh; }
        .navbar { background-color: rgba(13, 17, 23, 0.95) !important; border-bottom: 1px solid rgba(0, 204, 255, 0.2); }
        .navbar-brand { font-family: var(--font-heading); font-weight: 900; color: var(--light-blue-glow) !important; text-shadow: 0 0 5px var(--light-blue-glow); }
        .nav-link:hover { color: var(--light-blue-glow) !important; text-shadow: 0 0 8px var(--light-blue-glow); }
        h1, h2, h3 { font-family: var(--font-heading); color: var(--light-blue-glow); }
        .card { background-color: rgba(13, 17, 23, 0.8); border: 1px solid rgba(0, 204, 255, 0.2); border-radius: 10px; margin-bottom: 2rem; }
        .card-header { background-color: rgba(0, 204, 255, 0.1); border-bottom: 1px solid rgba(0, 204, 255, 0.2); font-weight: bold; }
        .btn-custom-red { background-color: var(--accent-red); color: var(--text-light); border: none; padding: 10px 25px; font-weight: 700; border-radius: 5px; transition: all 0.3s ease; }
        .btn-custom-red:hover { background-color: #ff3344; transform: translateY(-2px); }
        .status-badge { padding: 5px 10px; border-radius: 5px; font-size: 0.85rem; color: #000; }
        .status-pending { background-color: #ffc107; }
        .status-assigned { background-color: #17a2b8; color: #fff; }
        .status-completed { background-color: #28a745; color: #fff; }
        .status-cancelled { background-color: #dc3545; color: #fff; }
        .form-control, .form-select { background-color: #1a1a1a; border: 1px solid rgba(0, 204, 255, 0.3); color: var(--text-light); }
        .form-control:focus, .form-select:focus { background-color: #1a1a1a; color: var(--text-light); border-color: var(--light-blue-glow); box-shadow: 0 0 10px rgba(0, 204, 255, 0.3); }
        .table { color: var(--text-light); } .table thead { background-color: rgba(0, 204, 255, 0.1); }
        .modal-content { background-color: #1a1a1a; border: 1px solid rgba(0, 204, 255, 0.3); }
        .modal-header { border-bottom: 1px solid rgba(0, 204, 255, 0.2); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.html">Roadside Rescue</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><span class="nav-link">Welcome, <?php echo htmlspecialchars($user_name); ?></span></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-4">User Dashboard</h1>
        <button class="btn btn-custom-red mb-4" data-bs-toggle="modal" data-bs-target="#newBookingModal">+ New Booking Request</button>

        <div class="card">
            <div class="card-header"><h3 class="mb-0">My Bookings</h3></div>
            <div class="card-body">
                <?php if ($bookings->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Mechanic</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($booking = $bookings->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['location']); ?></td>
                                <td><?php echo date('d M Y, h:i A', strtotime($booking['booking_date'])); ?></td>
                                <td><span class="status-badge status-<?php echo $booking['status']; ?>"><?php echo ucfirst($booking['status']); ?></span></td>
                                <td><?php echo htmlspecialchars($booking['mechanic_name'] ?? 'Not assigned'); ?></td>
                                <td>₹<?php echo number_format($booking['price'], 2); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-center py-4">No bookings yet. Create your first booking!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newBookingModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">New Booking Request</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <form id="bookingForm">
                        <div class="mb-3">
                            <label for="service_id" class="form-label">Select Service</label>
                            <select class="form-select" id="service_id" name="service_id" required>
                                <option value="">Choose a service...</option>
                                <?php $services->data_seek(0); while ($service = $services->fetch_assoc()): ?>
                                <option value="<?php echo $service['id']; ?>">
                                    <?php echo htmlspecialchars($service['service_name']); ?> - ₹<?php echo $service['price']; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3"><label for="location" class="form-label">Location</label><input type="text" class="form-control" id="location" name="location" placeholder="Enter your current location" required></div>
                        <div class="mb-3"><label for="vehicle_details" class="form-label">Vehicle Details</label><input type="text" class="form-control" id="vehicle_details" name="vehicle_details" placeholder="e.g., Maruti Swift, MH-15-AB-1234"></div>
                        <div class="mb-3"><label for="issue_description" class="form-label">Issue Description</label><textarea class="form-control" id="issue_description" name="issue_description" rows="3" placeholder="Describe your problem..." required></textarea></div>
                        <button type="submit" class="btn btn-custom-red w-100">Submit Booking Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('api/booking_handler.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Booking created successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    </script>
</body>
</html>