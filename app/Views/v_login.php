<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LVSH7+qWBhZWWRmNXkIBI+AkfU5Z0HHB9WlIwInupOohx2y6cl7JVO0J9smEkpVQ" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: #333;
        }

        .card-header {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            background-color: #2575fc;
            color: #fff;
            border-radius: 15px 15px 0 0;
        }

        .btn-primary {
            background-color: #6a11cb;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4c0a9f;
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(106, 17, 203, 0.7);
        }
    </style>
</head>

<body>
    <div class="container col-lg-4 col-md-6 col-sm-8">
        <div class="card">
            <div class="card-header">
                LOGIN
            </div>
            <div class="card-body">
                <form action="/auth/login" method="post">
                    <div class="mb-3">
                        <label for="inputUsername" class="form-label">
                            <i class="bi bi-person-fill"></i> Username
                        </label>
                        <input type="text" class="form-control" id="inputUsername" placeholder="Enter your username" name="usernm" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">
                            <i class="bi bi-lock-fill"></i> Password
                        </label>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Enter your password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="login" class="btn btn-primary">Login</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="/register" class="text-decoration-none">Don't have an account? Register here</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6lcWo48E6FVxAQGjxMTKD8HI1zj0fQHEeZ9GUYoCfKr5" crossorigin="anonymous"></script>
</body>

</html>
