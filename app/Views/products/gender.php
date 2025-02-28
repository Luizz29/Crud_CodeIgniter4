<?= view('template/pages'); ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie Chart dengan Chart.js</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables 1.x -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        /*mengatur ukuran chart*/
        .chart-container {
            width: 50%;
            max-width: 300px;
            margin: auto;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }

        /* Container utama */
        .filter-box {
            display: flex;
            gap: 12px;
            align-items: center;
            background: transparent;
            padding: 12px 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Style untuk input dan select */
        .input-field,
        .select-field {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        .input-field:hover,
        .select-field:hover {
            border-color: #4CAF50;
        }

        /* Tombol filter */
        .filter-button {
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .filter-button:hover {
            background: linear-gradient(135deg, #45a049, #2e7d32);
            transform: scale(1.05);
        }

        :root {
            --bg-color: #ffffff;
            --text-color: #000000;
            --card-bg: #f8f9fa;
        }

        .dark-mode {
            --bg-color: #212529;
            --text-color: #ffffff;
            --card-bg: #495057;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background 0.3s, color 0.3s;
        }


        .card {
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /*agar posisi switch di pojok kanan atas*/
        .toggle-switch {
            position: absolute;
            top: 15px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        /*style slider on of dark mode*/
        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        /*agar background pie chart berwarna dark saat mode gelap aktif*/
        .dark-mode .card {
            background-color: #212529 !important;
            color: white;
        }


        /*agar jarak dari paling kiri menjadi jauh*/
        .ms-10 {
            margin-left: 12.3rem;
        }


        /*agar modal berwarna gelap saat mode gelap aktif*/
        .dark-mode .modal-content {
            background-color: #343a40 !important;
            /* Warna dark */
            color: white !important;
        }

        .dark-mode .modal-header,
        .dark-mode .modal-footer {
            border-color: rgba(255, 255, 255, 0.2);
        }

        /*agar input username berwarna gelap saat mode gelap aktif*/
        .dark-mode .form-control {
            background-color: #343a40 !important;
            color: white !important;
            border-color: #6c757d;
        }

        .dark-mode .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .dark-mode .form-label {
            color: white !important;
        }

        /*end input gelap*/

        /*agar input tanggal berwarna gelap saat mode gelap aktif*/
        .dark-mode .input-field,
        .dark-mode .select-field {
            background: #333;
            /* Warna hitam */
            color: white;
            /* Warna teks */
            border: 1px solid #666;
        }

        .dark-mode .input-field::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /*end input tanggal gelap*/

        /*data table agar berwarna gelap saat mode gelap aktif*/
        /* Mode gelap untuk tabel DataTables */
        .dark-mode table.dataTable {
            background-color: #222 !important;
            color: white !important;
            border-color: #333 !important;
        }

        /* Warna background untuk baris di dalam tabel */
        .dark-mode table.dataTable tbody tr {
            background-color: #333 !important;
            color: white !important;
        }

        /* Warna background untuk header tabel */
        .dark-mode table.dataTable thead {
            background-color: #111 !important;
            color: white !important;
        }

        /* Warna background untuk border tabel */
        .dark-mode table.dataTable tbody td {
            background-color: #333 !important;
            color: white !important;
        }

        /* Warna untuk hover */
        .dark-mode table.dataTable tbody tr:hover {
            background-color: #444 !important;
        }

        /*end data table gelap*/

        #grafik-pie-chart {
            font-family: serif;
            color: red;
        }

        /*button keren*/
        .button-85 {
            padding: 0.6em 2em;
            border: none;
            outline: none;
            color: rgb(255, 255, 255);
            background: #111;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 10px;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .button-85:before {
            content: "";
            background: linear-gradient(45deg,
                    #ff0000,
                    #ff7300,
                    #000000,
                    #48ff00,
                    #00ffd5,
                    #002bff,
                    #7a00ff,
                    #ff00c8,
                    #ff0000);
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 400%;
            z-index: -1;
            filter: blur(5px);
            -webkit-filter: blur(5px);
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            animation: glowing-button-85 20s linear infinite;
            transition: opacity 0.3s ease-in-out;
            border-radius: 10px;
        }

        @keyframes glowing-button-85 {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 400% 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        .button-85:after {
            z-index: -1;
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: #222;
            left: 0;
            top: 0;
            border-radius: 10px;
        }

        .dark-mode .deleteAlert {
            background: #333 !important;
            color: white !important;
        }
    </style>
</head>

<body>

    <div class="toggle-switch">
        <span>🔆</span>
        <label class="switch">
            <input type="checkbox" id="modeSwitch">
            <span class="slider"></span>
        </label>
        <span>🌙</span>
    </div>

    <input type="hidden" id="chartData" value="<?= $chartData ?>">



    <!-- <div class="card mt-5">
        <h3 class="text-center">Grafik Pie Chart</h3>
        <div class="chart-container">
            <canvas id="myPieChart"></canvas>
        </div>
    </div> -->

    <input type="hidden" id="chartData" value="<?= $chartData ?>">

    <!-- HTML !-->
    <button class="button-85 ms-10 mt-5" data-bs-toggle="modal" data-bs-target="#addGenderModal">Tambah Data</button>

    <svg class="mx-auto d-block" width="200" height="150" viewBox="0 0 400 150">
        <text x="20" y="100" font-family="Times New Roman" font-size="80" font-weight="bold"
            stroke="red" stroke-width="2" fill="black">
            Pie Chart
        </text>
    </svg>

    <div class="chart-container mt-5">
        <canvas id="myPieChart"></canvas>
    </div>

    <!-- Modal Add Gender -->
    <div class="modal fade" id="addGenderModal" tabindex="-1" aria-labelledby="addGenderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGenderModalLabel">Tambah Data Produk</h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addGenderForm">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lakiLaki" value="Laki-laki" required>
                                <label class="form-check-label" for="lakiLaki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" required>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Product -->
    <div class="modal fade" id="editGenderModal" tabindex="-1" aria-labelledby="editGenderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGenderModalLabel">Edit Data Gender</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editGenderForm">
                        <?= csrf_field(); ?>
                        <input type="hidden" id="editGenderId" name="id">

                        <div class="mb-3">
                            <label for="editusername" class="form-label">username:</label>
                            <input type="text" class="form-control" id="editGenderName" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="lakiLakiedit" value="Laki-laki" required>
                                <label class="form-check-label" for="lakiLaki">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuanedit" value="Perempuan" required>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="filter mb-5 ms-10 ">
        <input type="date" class="input-field" id="inpt-date-start">
        <input type="date" class="input-field" id="inpt-date-end">
        <select class="select-field" id="filter-gender">
            <option value="">Semua</option>
            <option value="laki-laki" id="filter-laki">Laki-laki</option>
            <option value="perempuan" id="filter-perempuan">Perempuan</option>
        </select>
    </div>

    <label class="ms-10">
        <input type="checkbox" id="selectAll"> Pilih Semua
    </label>

    <!-- Tombol Bulk Delete -->
    <button id="bulkDelete" class="btn btn-danger ms-3">Delete Multiple Data</button>

    <button class="button-85 ms-3">Cari</button>


    <div class="container mt-3">
        <table id="genderTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th width=1%>Select </th>
                    <th width=1%>No </th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Jenis</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Tanggal Diupdate</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded here via AJAX -->
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            let table = $('#genderTable').DataTable({
                "paging": true,
                "searching": true,
                "info": true
            });

            $('.select-field').on('change', function() {
                let selectedGender = $(this).val(); // Ambil nilai dari dropdown

                if (selectedGender === '') {
                    table.search('').columns().search('').draw();
                } else {
                    table.column(3).search('^' + selectedGender + '$', true, false).draw();
                }
            });

            function loadGender() {
                $.ajax({
                    url: '<?= site_url("gender/loadGender"); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let rows = '';
                        $.each(data.data, function(index, gender) {
                            rows += `
                            <tr data-id="${gender.id}">
                                <td><input type="checkbox" class="gender-checkbox" value="${gender.id}"></td>
                                <td>${index + 1}</td>
                                <td>${gender.username}</td>
                                <td>${gender.jenis}</td>
                                <td>${gender.created_at}</td>
                                <td>${gender.updated_at}</td>
                                <td>
                                    <button class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editGenderModal" 
                                        data-id="${gender.id}" 
                                        data-username="${gender.username}" 
                                        data-jenis="${gender.jenis}">Edit</button>
                                    <form action="/Crud_CodeIgniter4/gender/deleteGender/${gender.id}" method="post" class="deleteForm d-inline">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>`;
                        });

                        table.clear().destroy();
                        $('#genderTable tbody').html(rows);
                        table = $('#genderTable').DataTable({
                            "paging": true,
                            "searching": true,
                            "info": true
                        });
                    }
                });
            }

            loadGender();

            // Tambahkan fungsi untuk mengaktifkan dan menonaktifkan dark mode
            function aktifkanDarkMode() {
                $("body").addClass("dark-mode");
                $("#genderTable").addClass("dark-mode");
                $(".dataTables_paginate").addClass("dark-mode");
            }

            function nonaktifkanDarkMode() {
                $("body").removeClass("dark-mode");
                $("#genderTable").removeClass("dark-mode");
                $(".dataTables_paginate").removeClass("dark-mode");
            }

            // Cek jika dark mode aktif
            if (localStorage.getItem("dark-mode") === "enabled") {
                aktifkanDarkMode();
            }

            $("#modeSwitch").on("change", function() {
                if (this.checked) {
                    localStorage.setItem("dark-mode", "enabled");
                    aktifkanDarkMode();
                } else {
                    localStorage.setItem("dark-mode", "disabled");
                    nonaktifkanDarkMode();
                }
            });

            // Checkbox Select All
            $("#selectAll").on("click", function() {
                $(".gender-checkbox").prop("checked", this.checked);
                toggleDeleteButton();
            });

            // Checkbox Individu
            $(document).on("change", ".gender-checkbox", function() {
                let totalCheckbox = $(".gender-checkbox").length;
                let checkedCheckbox = $(".gender-checkbox:checked").length;
                $("#selectAll").prop("checked", checkedCheckbox === totalCheckbox);
                toggleDeleteButton();
            });

            function toggleDeleteButton() {
                let selectedCount = $(".gender-checkbox:checked").length;
                $("#bulkDelete").toggle(selectedCount > 1);
            }

            // Bulk Delete
            $("#bulkDelete").on("click", function() {
                let selectedIds = $(".gender-checkbox:checked").map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length <= 1) {
                    Swal.fire("Pilih minimal 2 data untuk dihapus!", "", "warning");
                    return;
                }

                Swal.fire({
                    title: "Yakin ingin menghapus?",
                    text: "Data yang terhapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?= site_url('gender/bulkDelete'); ?>",
                            type: "POST",
                            data: {
                                ids: selectedIds
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    Swal.fire("Terhapus!", response.message, "success");
                                    loadGender();
                                    updateChart();
                                    $("#selectAll").prop("checked", false);
                                } else {
                                    Swal.fire("Gagal!", response.message, "error");
                                }
                            },
                            error: function() {
                                Swal.fire("Error!", "Terjadi kesalahan saat menghapus data.", "error");
                            }
                        });
                    }
                });
            });

            function updateChart() {
                $.ajax({
                    url: '<?= site_url('gender/genderChartData'); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            myPieChart.data.labels = response.data.labels;
                            myPieChart.data.datasets[0].data = response.data.datasets[0].data;
                            myPieChart.update();
                        }
                    }
                });
            }

            let ctx = document.getElementById('myPieChart').getContext('2d');
            let data = <?= $chartData ?>;

            let myPieChart = new Chart(ctx, {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });


            //deleteData
            $(document).on('submit', '.deleteForm', function(e) {
                e.preventDefault();
                let form = $(this); // Simpan form yang diklik

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    background: '#343a40',
                    color: '#fff',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: form.attr('action'),
                            data: form.serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message,
                                        icon: 'success',
                                        background: '#343a40',
                                        color: '#fff',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    loadGender();
                                    updateChart();
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });


            // Tambah Data
            $('#addGenderForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('gender/addGender'); ?>',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire("Good job!", "Data berhasil ditambahkan!", "success").then(() => {
                                $('#addGenderModal').modal('hide');
                                $('#addGenderForm')[0].reset();
                                loadGender();
                                updateChart();
                            });
                        } else {
                            Swal.fire("Gagal!", "Terjadi kesalahan saat menambahkan data!", "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Terjadi kesalahan saat mengirim data.", "error");
                    }
                });
            });

            // Edit Data
            $(document).on("click", ".edit-btn", function() {
                let id = $(this).data("id");
                let username = $(this).data("username");
                let jenis = $(this).data("jenis");

                $("#editGenderId").val(id);
                $("#editGenderName").val(username);

                if (jenis === "Laki-laki") {
                    $("#lakiLakiedit").prop("checked", true);
                } else if (jenis === "Perempuan") {
                    $("#perempuanedit").prop("checked", true);
                }
            });

            $('#editGenderForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('gender/genderEdit'); ?>',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire("Berhasil!", "Data berhasil diubah!", "success").then(() => {
                                $('#editGenderModal').modal('hide');
                                $('#editGenderForm')[0].reset();
                                loadGender();
                                updateChart();
                            });
                        } else {
                            Swal.fire("Gagal!", "Terjadi kesalahan saat mengubah data!", "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Terjadi kesalahan saat mengirim data.", "error");
                    }
                });
            });

            // Mode Gelap
            const modeSwitch = $("#modeSwitch");

            // Cek jika dark mode aktif saat halaman dimuat
            if (localStorage.getItem("dark-mode") === "enabled") {
                $("body").addClass("dark-mode");
                $(".modal-content").addClass("dark-mode");
                $("#inpt-date-start, #inpt-date-end, #filter-gender").addClass("dark-mode"); // Tambahkan class ke input
                $("#genderTable").addClass("dark-mode");
                $("#deleteAlert").addClass("dark-mode");

                modeSwitch.prop("checked", true);
            }

            // Event listener saat mode diubah
            modeSwitch.on("change", function() {
                if (this.checked) {
                    $("body").addClass("dark-mode");
                    $(".modal-content").addClass("dark-mode");
                    $("#inpt-date-start, #inpt-date-end, #filter-gender").addClass("dark-mode");
                    $("#genderTable").addClass("dark-mode");
                    $("#deleteAlert").addClass("dark-mode");
                    localStorage.setItem("dark-mode", "enabled");
                } else {
                    $("body").removeClass("dark-mode");
                    $(".modal-content").removeClass("dark-mode");
                    $("#inpt-date-start, #inpt-date-end, #filter-gender").removeClass("dark-mode");
                    $("#genderTable").removeClass("dark-mode");
                    $("#deleteAlert").removeClass("dark-mode");
                    localStorage.setItem("dark-mode", "disabled");
                }
            });
        });
    </script>

</body>

</html>