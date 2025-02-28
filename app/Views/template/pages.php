<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= base_url("public/css/marketplace.css") ?>">


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
                        <a class="nav-link active" aria-current="page" href="<?= base_url('products') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('products/dataTable') ?>">Data Table</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('products/chart') ?>">Gender</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('usercontroller') ?>">Master User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('marketplace') ?>">Marketplace</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?= $this->renderSection('data'); ?>
</body>

</html>