<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Alfaluiszz 11</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/Crud_CodeIgniter4/products/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Crud_CodeIgniter4/products/dataTable">Data Table</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/Crud_CodeIgniter4/products/chart">Gender</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Crud_CodeIgniter4/usercontroller">Master User</a>
                    </li>

                </ul>
                <!-- <div class="d-flex align-items-center">
                    <a href="/Crud_CodeIgniter4/products/export" class="btn btn-success ms-auto mt-3">Export to Excel</a>
                    <a href="#" class="btn btn-primary mt-3 me-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Tambah Data</a>
                </div> -->


            </div>
        </div>
    </nav>
    <?= $this->renderSection('data'); ?>
</body>

</html>