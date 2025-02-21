<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background-color: transparent;
            border-bottom: none;
            padding: 25px 25px 0px 25px;
        }

        .card-title {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 0;
        }

        .card-body {
            padding: 25px;
        }

        .form-label {
            color: #6c757d;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            padding: 12px;
            font-size: 14px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #6c757d;
            box-shadow: none;
        }

        .input-group-text {
            background-color: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .btn-primary {
            background-color: #2c3e50;
            border: none;
            padding: 12px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #34495e;
            transform: translateY(-1px);
        }

        .register-link {
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .register-link:hover {
            color: #2c3e50;
        }

        .input-group:focus-within .input-group-text {

            border-color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="card-title">Welcome Back</h5>
                        <p class="text-muted small mt-2">Please login to your account</p>
                    </div>
                    <div class="card-body">
                        <form id="loginForm" action="/Crud_CodeIgniter4/Auth/Login" method="post">
                            <div class="mb-4">
                                <label for="inputUsername" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control" id="inputUsername" placeholder="Enter your username" name="usernm" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="inputPassword" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control" id="inputPassword" placeholder="Enter your password" name="password" required>
                                </div>
                            </div>
                            <div class="d-grid mb-4">
                                <button type="submit" name="login" class="btn btn-primary">Sign In</button>
                            </div>
                            <div class="text-center">
                                <a href="/register" class="register-link">Don't have an account? Register here</a>
                            </div>
                            <div id="alert" class="alert alert-danger mt-3" style="display: none;"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Jika status sukses, arahkan ke halaman dashboard
                            window.location.href = 'usercontroller';
                        } else {
                            // Jika ada error, tampilkan pesan kesalahan
                            $('#alert').text(response.message).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Menangani error jika ada
                        $('#alert').text('An error occurred: ' + error).show();
                    }
                });
            });
        });
    </script>
</body>

</html>