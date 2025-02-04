<?= $this->extend('template/pages'); ?>
<?= $this->section('data'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <h1 class="mt-3 mx-auto">Data Table</h1>
                <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Tambah Data</a>
                <?= form_open_multipart('products/import', ['id' => 'importForm']) ?>
                <?= csrf_field(); ?>
                <label for="excelFile">Upload File Excel:</label>
                <input type="file" name="excelFile" id="excelFile" required>
                <button type="submit" class="btn btn-primary mt-3">Import</button>
                <?= form_close() ?>
                <?= form_open('products/deleteMultiple', ['class' => 'formhapus', 'id' => 'deleteMultipleForm']) ?>
                <?= csrf_field(); ?>
                <input type="hidden" name="id[]" id="selectedProductIds">
                <button type="submit" class="btn btn-primary" id="tombolHapusBanyak">
                    <i class="fa fa-trash-o"></i> HAPUS BANYAK
                </button>
                <?= form_close() ?>
                <button id="exportExcel" class="btn btn-success mt-3">Export to Excel</button>
                <div id="loadingGif" class="loader" role="status" style="display: none;"></div>
                <!-- Modal -->
                <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only"></span>
                                </div>
                                <p>Loading, please wait...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Nama</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Condition</th>
                            <th>Options</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr data-id="<?= $product['id']; ?>">
                                <td><input type="checkbox" class="product-checkbox" value="<?= $product['id']; ?>"></td>
                                <td><?= $product['name']; ?></td>
                                <td><?= $product['price']; ?></td>
                                <td><?= $product['description']; ?></td>
                                <td><?= $product['condition']; ?></td>
                                <td><?= $product['options']; ?></td>
                                <td><?= $product['category']; ?></td>
                                <td>
                                    <button class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal"
                                        data-id="<?= $product['id']; ?>"
                                        data-name="<?= $product['name']; ?>"
                                        data-price="<?= $product['price']; ?>"
                                        data-description="<?= $product['description']; ?>"
                                        data-condition="<?= $product['condition']; ?>"
                                        data-options="<?= $product['options']; ?>"
                                        data-category="<?= $product['category']; ?>">Edit</button>
                                    <form action="/CRUD_AUTOCHEM/products/delete/<?= $product['id']; ?>" method="post" class="deleteForm d-inline">
                                        <?= csrf_field(); ?>
                                        <button id="btn-delete" type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal Add Product -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Tambah Data Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price:</label>
                            <input type="number" class="form-control" id="productPrice" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description:</label>
                            <textarea class="form-control" id="productDescription" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Condition:</label><br>
                            <input type="radio" name="condition" value="New"> New<br>
                            <input type="radio" name="condition" value="Used"> Used<br>
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Category:</label>
                            <select class="form-select" id="productCategory" name="category" required>
                                <option value="" disabled>Select a category</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Clothing">Clothing</option>
                                <option value="Furniture">Furniture</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Product -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Data Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <?= csrf_field(); ?>
                        <input type="hidden" id="editProductId" name="id">

                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Price:</label>
                            <input type="number" class="form-control" id="editProductPrice" name="price" required>
                        </div>

                        <div class="mb-3">
                            <label>Available Options:</label><br>
                            <div id="editOptionsContainer">
                                <input type="checkbox" name="options[]" value="Option 1"> Option 1<br>
                                <input type="checkbox" name="options[]" value="Option 2"> Option 2<br>
                                <input type="checkbox" name="options[]" value="Option 3"> Option 3<br>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Description:</label>
                            <textarea class="form-control" id="editProductDescription" name="description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Condition:</label><br>
                            <div id="editConditionContainer">
                                <input type="radio" name="condition" value="New"> New<br>
                                <input type="radio" name="condition" value="Used"> Used<br>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editProductCategory" class="form-label">Category:</label>
                            <select class="form-select" id="editProductCategory" name="category" required>
                                <option value="" disabled>Select a category</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Clothing">Clothing</option>
                                <option value="Furniture">Furniture</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable only once
            let table = $('#example').DataTable({
                "paging": true,
                "searching": true,
                "info": true
            });

            $('#selectAll').click(function() {
                if ($(this).is(':checked')) {
                    $('.product-checkbox').prop('checked', true);
                } else {
                    $('.product-checkbox').prop('checked', false);
                }
            });

            $('#deleteMultipleForm').on('submit', function(e) {
                e.preventDefault();
                let selectedIds = [];
                $('.product-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    alert('Tidak ada produk yang dipilih untuk dihapus.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '/CRUD_AUTOCHEM/products/deleteMultiple',
                    data: {
                        id: selectedIds
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            // Remove the deleted rows from the DataTable
                            selectedIds.forEach(function(id) {
                                table.row($(tr[data-id="${id}"])).remove().draw();
                            });
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            });

            // Add Product Form Submission
            $('#addProductForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/CRUD_AUTOCHEM/products/store',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            table.row.add([
                                '<input type="checkbox" class="product-checkbox" value="' + response.data.id + '">', // Checkbox column
                                response.data.name,
                                response.data.price,
                                response.data.description,
                                response.data.condition,
                                response.data.options ? response.data.options : '-',
                                response.data.category,
                                '<button class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal" data-id="' + response.data.id + '" data-name="' + response.data.name + '" data-price="' + response.data.price + '" data-description="' + response.data.description + '" data-condition="' + response.data.condition + '" data-options="' + response.data.options + '" data-category="' + response.data.category + '">Edit</button>' +
                                '<form action="/CRUD_AUTOCHEM/products/delete/' + response.data.id + '" method="post" class="deleteForm d-inline">' +
                                '<?= csrf_field(); ?>' +
                                '<button id="btn-delete" type="submit" class="btn btn-danger btn-sm">Delete</button>' +
                                '</form>'
                            ]).draw(false);
                            $('#addProductModal').modal('hide');
                            $('#addProductForm')[0].reset();
                        } else {
                            alert(response.errors);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                });
            });

            // Edit Product Modal
            $(document).on('click', '.edit-btn', function() {
                const id = $(this).data('id');
                $('#editProductId').val(id);
                $('#editProductName').val($(this).data('name'));
                $('#editProductPrice').val($(this).data('price'));
                $('#editProductDescription').val($(this).data('description'));

                // Set options checkboxes
                const options = $(this).data('options').split(',');
                $('#editOptionsContainer input[type="checkbox"]').prop('checked', false);
                options.forEach(option => {
                    $(#editOptionsContainer input[value="${option.trim()}"]).prop('checked', true);
                });

                // Set condition radio buttons
                const condition = $(this).data('condition');
                $(#editConditionContainer input[value="${condition}"]).prop('checked', true);

                // Set category
                $('#editProductCategory').val($(this).data('category'));
            });

            // Update Product Form Submission
            $('#editProductForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '/CRUD_AUTOCHEM/products/update',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            // Find the row in the DataTable and update it
                            const rowId = $('#editProductId').val();
                            const row = table.row($(tr[data-id="${rowId}"]));
                            row.data([
                                '<input type="checkbox" class="product-checkbox" value="' + rowId + '">', // Checkbox column
                                response.data.name,
                                response.data.price,
                                response.data.description,
                                response.data.condition,
                                response.data.options ? response.data.options : '-',
                                response.data.category,
                                '<button class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal" data-id="' + rowId + '" data-name="' + response.data.name + '" data-price="' + response.data.price + '" data-description="' + response.data.description + '" data-condition="' + response.data.condition + '" data-options="' + response.data.options + '" data-category="' + response.data.category + '">Edit</button>' +
                                '<form action="/CRUD_AUTOCHEM/products/delete/' + rowId + '" method="post" class="deleteForm d-inline">' +
                                '<?= csrf_field(); ?>' +
                                '<button id="btn-delete" type="submit" class="btn btn-danger btn-sm">Delete</button>' +
                                '</form>'
                            ]).draw(false);
                            $('#editProductModal').modal('hide');
                        } else {
                            alert(response.errors);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                });
            });

            // Delete Product Form Submission
            $(document).on('submit', '.deleteForm', function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message);
                                table.row($(this).closest('tr')).remove().draw();
                            } else {
                                alert(response.message);
                            }
                        }.bind(this),
                        error: function() {
                            alert('Terjadi kesalahan saat menghapus data.');
                        }
                    });
                }
            });


            //import
            $('#importForm').on('submit', function(e) {
                e.preventDefault();

                const file = document.querySelector('input[type="file"]').files[0];
                if (!file) {
                    alert('Please select a file first.');
                    return;
                }

                $('#loadingModal').modal('show');

                const reader = new FileReader();
                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    const products = XLSX.utils.sheet_to_json(firstSheet);

                    const chunkSize = 200;
                    let currentChunk = 0;
                    const totalChunks = Math.ceil(products.length / chunkSize);

                    function sendChunk() {
                        const start = currentChunk * chunkSize;
                        const end = Math.min(start + chunkSize, products.length);
                        const chunk = products.slice(start, end);

                        if (chunk.length === 0) {
                            $('#loadingModal').modal('hide');
                            return;
                        }

                        const formData = new FormData();
                        formData.append('chunk', JSON.stringify(chunk));
                        formData.append('chunkNumber', currentChunk);
                        formData.append('totalChunks', totalChunks);

                        $.ajax({
                            type: 'POST',
                            url: '/CRUD_AUTOCHEM/products/importChunk',
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    response.data.forEach(function(product) {
                                        table.row.add([
                                            '<input type="checkbox" class="product-checkbox" value="' + product.id + '">',
                                            product.name,
                                            product.price,
                                            product.description,
                                            product.condition,
                                            product.options ? product.options : '-',
                                            product.category,
                                            '<button class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal" data-id="' + product.id + '" data-name="' + product.name + '" data-price="' + product.price + '" data-description="' + product.description + '" data-condition="' + product.condition + '" data-options="' + product.options + '" data-category="' + product.category + '">Edit</button>' +
                                            '<form action="/CRUD_AUTOCHEM/products/delete/' + product.id + '" method="post" class="deleteForm d-inline">' +
                                            '<?= csrf_field(); ?>' +
                                            '<button id="btn-delete" type="submit" class="btn btn-danger btn-sm">Delete</button>' +
                                            '</form>'
                                        ]).draw(false);
                                    });

                                    currentChunk++;

                                    
                                    const progress = Math.round((currentChunk / totalChunks) * 100);
                                    $('#importProgress').text(progress + '%');

                                    if (currentChunk < totalChunks) {
                                        sendChunk();
                                    } else {
                                        $('#loadingModal').modal('hide');
                                        alert('Import completed successfully!');
                                    }
                                } else {
                                    $('#loadingModal').modal('hide');
                                    alert('Error in chunk ' + currentChunk + ': ' + response.errors);
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#loadingModal').modal('hide');
                                console.error('Error importing chunk:', status, error);
                                alert('Error occurred while importing data. Check console for details.');
                            }
                        });
                    }

                   
                    sendChunk();
                };

                reader.onerror = function(error) {
                    $('#loadingModal').modal('hide');
                    console.error('Error reading file:', error);
                    alert('Error reading file. Please try again.');
                };

                reader.readAsArrayBuffer(file);
            });



            //import
            $('#exportExcel').on('click', function(e) {
                e.preventDefault();
                var offset = 0;
                var limit = 200;
                var allProducts = [];

                $('#loadingModal').modal('show');

                function fetchChunk() {
                    $.ajax({
                        url: '/CRUD_AUTOCHEM/products/exportChunk/' + offset + '/' + limit,
                        type: 'GET',
                        success: function(response) {
                            console.log('Chunk fetched:', response);
                            if (response.length > 0) {
                                allProducts = allProducts.concat(response);
                                offset += limit;
                                fetchChunk();
                            } else {
                                createAndDownloadExcel(allProducts);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching chunk:', status, error);
                            alert('Terjadi kesalahan saat mengekspor data.');
                        }
                    });
                }

                function createAndDownloadExcel(allProducts) {
                    var workbook = XLSX.utils.book_new();
                    var worksheetData = [
                        ['Name', 'Price', 'Description', 'Condition', 'Options', 'Category']
                    ];

                    allProducts.forEach(function(product) {
                        worksheetData.push([
                            product.name,
                            product.price,
                            product.description,
                            product.condition,
                            product.options,
                            product.category
                        ]);
                    });

                    var worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
                    XLSX.utils.book_append_sheet(workbook, worksheet, 'Products');
                    XLSX.writeFile(workbook, 'latihan_chunk.xlsx');

                    $('#loadingModal').modal('hide');
                }

                fetchChunk();
            });
        });
    </script>
</body>

</html>