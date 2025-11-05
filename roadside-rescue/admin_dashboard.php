<?php
require_once 'api/db_connect.php'; // UPDATED PATH

// Protect this page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php'); // Or your admin_login.php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --dark-bg: #0d1117; --light-blue-glow: #00ccff; --text-light: #e0e0e0; }
        body { background-color: var(--dark-bg); color: var(--text-light); }
        .navbar-brand, h1, h2, h3 { color: var(--light-blue-glow); font-family: 'Orbitron', sans-serif; }
        .table { color: var(--text-light); }
        .form-control, .form-select { background-color: #212529; color: var(--text-light); border-color: #444; }
        .form-control:focus, .form-select:focus { background-color: #212529; color: var(--text-light); border-color: var(--light-blue-glow); box-shadow: none; }
        .nav-tabs .nav-link { color: var(--text-light); }
        .nav-tabs .nav-link.active { color: var(--light-blue-glow); background-color: #212529; border-color: var(--light-blue-glow); }
        .status-badge { padding: 5px 10px; border-radius: 5px; font-size: 0.85rem; color: #000; }
        .status-pending { background-color: #ffc107; }
        .status-assigned { background-color: #17a2b8; color: #fff; }
        .status-completed { background-color: #28a745; color: #fff; }
        .status-cancelled { background-color: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>

        <ul class="nav nav-tabs" id="adminTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#bookings" type="button" role="tab">Manage Bookings</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab">Manage Services</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">View Users</button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabContent">
            
            <div class="tab-pane fade show active" id="bookings" role="tabpanel">
                <h2 class="mt-4">Manage Bookings</h2>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Mechanic</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="bookings-table-body">
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="services" role="tabpanel">
                <h2 class="mt-4">Manage Services (CRUD)</h2>
                <form id="service-form" class="card bg-dark text-light p-4 mb-4">
                    <input type="hidden" id="service-id" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Service Name</label>
                            <input type="text" class="form-control" id="service-name" name="service_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price (e.g., 500.00)</label>
                            <input type="number" step="0.01" class="form-control" id="service-price" name="price" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="service-desc" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image URL</label>
                        <input type="text" class="form-control" id="service-image" name="image_url" placeholder="e.g., images/battery.png">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="service-status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Service</button>
                        <button type="button" class="btn btn-secondary" id="clear-form-btn">Clear Form</button>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="services-table-body"></tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="users" role="tabpanel">
                <h2 class="mt-4">View Users (Participants)</h2>
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Vehicle</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceForm = document.getElementById('service-form');
            const clearFormBtn = document.getElementById('clear-form-btn');
            const serviceTBody = document.getElementById('services-table-body');
            const serviceIdField = document.getElementById('service-id');
            const serviceNameField = document.getElementById('service-name');
            const serviceDescField = document.getElementById('service-desc');
            const servicePriceField = document.getElementById('service-price');
            const serviceImageField = document.getElementById('service-image');
            const serviceStatusField = document.getElementById('service-status');
            const usersTBody = document.getElementById('users-table-body');
            const bookingsTBody = document.getElementById('bookings-table-body');

            loadServices();
            loadUsers();
            loadBookings();

            function loadBookings() {
                fetch('api/admin/booking_crud.php?action=getAll')
                    .then(res => res.json())
                    .then(data => {
                        bookingsTBody.innerHTML = '';
                        if (data.success) {
                            data.data.forEach(booking => {
                                bookingsTBody.innerHTML += `
                                    <tr id="booking-${booking.id}">
                                        <td>${booking.customer_name}</td>
                                        <td>${booking.service_name}</td>
                                        <td>${booking.location}</td>
                                        <td>${new Date(booking.booking_date).toLocaleString()}</td>
                                        <td>
                                            <select class="form-select form-select-sm" name="status" style="width: 120px;">
                                                <option value="pending" ${booking.status === 'pending' ? 'selected' : ''}>Pending</option>
                                                <option value="assigned" ${booking.status === 'assigned' ? 'selected' : ''}>Assigned</option>
                                                <option value="completed" ${booking.status === 'completed' ? 'selected' : ''}>Completed</option>
                                                <option value="cancelled" ${booking.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="mechanic_name" value="${booking.mechanic_name || ''}">
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-success" onclick="updateBooking(${booking.id})">Save</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteBooking(${booking.id})">Del</button>
                                        </td>
                                    </tr>`;
                            });
                        }
                    });
            }

            window.updateBooking = function(id) {
                const row = document.getElementById(`booking-${id}`);
                const status = row.querySelector('select[name="status"]').value;
                const mechanic = row.querySelector('input[name="mechanic_name"]').value;
                const formData = new FormData();
                formData.append('id', id);
                formData.append('status', status);
                formData.append('mechanic_name', mechanic);

                fetch('api/admin/booking_crud.php?action=update', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        loadBookings();
                    }
                });
            }
            
            window.deleteBooking = function(id) {
                if (confirm('Are you sure you want to delete this booking?')) {
                    fetch(`api/admin/booking_crud.php?action=delete&id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) loadBookings();
                    });
                }
            }

            function loadServices() {
                fetch('api/admin/service_crud.php?action=getAll')
                    .then(res => res.json())
                    .then(data => {
                        serviceTBody.innerHTML = '';
                        if (data.success) {
                            data.data.forEach(service => {
                                serviceTBody.innerHTML += `
                                    <tr>
                                        <td>${service.service_name}</td>
                                        <td>₹${service.price}</td>
                                        <td><span class="badge bg-${service.status === 'active' ? 'success' : 'secondary'}">${service.status}</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" onclick="editService(${service.id})">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteService(${service.id})">Delete</button>
                                        </td>
                                    </tr>`;
                            });
                        }
                    });
            }

            serviceForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(serviceForm);
                const id = serviceIdField.value;
                const action = id ? 'update' : 'create';
                
                fetch(`api/admin/service_crud.php?action=${action}`, { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        clearServiceForm();
                        loadServices();
                    }
                });
            });

            window.editService = function(id) {
                fetch(`api/admin/service_crud.php?action=get&id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            serviceIdField.value = data.data.id;
                            serviceNameField.value = data.data.service_name;
                            serviceDescField.value = data.data.description;
                            servicePriceField.value = data.data.price;
                            serviceImageField.value = data.data.image_url;
                            serviceStatusField.value = data.data.status;
                            new bootstrap.Tab(document.getElementById('services-tab')).show();
                            window.scrollTo(0, 0);
                        } else {
                            alert(data.message);
                        }
                    });
            }

            window.deleteService = function(id) {
                if (confirm('Are you sure you want to delete this service?')) {
                    fetch(`api/admin/service_crud.php?action=delete&id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        if (data.success) loadServices();
                    });
                }
            }
            
            function clearServiceForm() {
                serviceForm.reset();
                serviceIdField.value = '';
            }
            clearFormBtn.addEventListener('click', clearServiceForm);

            function loadUsers() {
                fetch('api/admin/user_crud.php?action=getAll')
                    .then(res => res.json())
                    .then(data => {
                        usersTBody.innerHTML = '';
                        if (data.success) {
                            data.data.forEach(user => {
                                usersTBody.innerHTML += `
                                    <tr>
                                        <td>${user.id}</td>
                                        <td>${user.fullname}</td>
                                        <td>${user.email}</td>
                                        <td>${user.phone}</td>
                                        <td>${user.vehicle || ''}</td>
                                        <td>${user.role}</td>
                                    </tr>`;
                            });
                        }
                    });
            }
        });
    </script>
</body>
</html>