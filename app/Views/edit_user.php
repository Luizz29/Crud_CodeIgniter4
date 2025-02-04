<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit User</h1>
        <form action="/user/update/<?= $user['userid'] ?>" method="post">
            <div class="mb-3">
                <label for="usernm" class="form-label">Username</label>
                <input type="text" class="form-control" id="usernm" name="usernm" value="<?= $user['usernm'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (Baru)</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
