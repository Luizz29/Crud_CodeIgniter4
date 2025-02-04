<?= $this->extend('template/pages'); ?>
<?= $this->section('data'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Master User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-10 mx-auto">
                <h1 class="text-center">Master User</h1>

                <div class="text-end mt-4">
                    <button class="btn btn-danger" id="logoutBtn">Logout</button>
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" id="addUserBtn">Tambah Pengguna</button>
                </div>

                <h2 class="mt-4">Data Pengguna</h2>
                <table class="table table-striped mt-3" id="userTable">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nama Pengguna</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="userid" name="userid">
                        <div class="mb-3">
                            <label for="usernm" class="form-label">Nama Pengguna:</label>
                            <input type="text" id="usernm" name="usernm" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function loadUsers() {
                $.ajax({
                    url: '<?= site_url("usercontroller/getUsers"); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let rows = '';
                        $.each(data, function(index, user) {
                            rows += `
                                <tr>
                                    <td>${user.userid}</td>
                                    <td>${user.usernm}</td>
                                    <td>${user.password}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm editBtn" data-id="${user.userid}" data-name="${user.usernm}" data-pass="">Edit</button>
                                        <button class="btn btn-danger btn-sm deleteBtn" data-id="${user.userid}">Hapus</button>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#userTable tbody').html(rows);
                    }
                });
            }

            loadUsers();

            $('#addUserBtn').click(function() {
                $('#userForm')[0].reset();
                $('#userid').val('');
                $('#userModalLabel').text('Tambah Pengguna');
            });

            $('#userForm').on('submit', function(e) {
                e.preventDefault();

                let formData = {
                    userid: $('#userid').val(),
                    usernm: $('#usernm').val(),
                    password: $('#password').val()
                };

                let url = formData.userid ? '<?= site_url("usercontroller/updateUser"); ?>' : '<?= site_url("usercontroller/addUser"); ?>';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            loadUsers();
                            $('#userModal').modal('hide');
                            Swal.fire('Berhasil', 'Data Berhasil Disimpan', 'success');
                        } else {
                            Swal.fire('Gagal', response.message, 'error');
                        }
                    }
                });
            });

            $('#userTable').on('click', '.editBtn', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let pass = $(this).data('pass');
                $('#userid').val(id);
                $('#usernm').val(name);
                $('#password').removeAttr('required');
                $('#userModalLabel').text('Edit Pengguna');
                $('#userModal').modal('show');
            });

            $('#userTable').on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                          
                    $.ajax({
                        url: '<?= site_url("usercontroller/deleteUser"); ?>',
                        type: 'POST',
                        data: {
                            userid: id
                        },
                        success: function(response) {
                            loadUsers();
                        }
                    });

                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });
                
            });

            $('#logoutBtn').click(function() {
                $.ajax({
                    url: '<?= site_url("auth/logout"); ?>',
                    type: 'GET',
                    success: function(response) {
                        window.location.href = '/CRUD_AUTOCHEM/login';
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>