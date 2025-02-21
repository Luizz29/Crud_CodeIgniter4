<?= view('template/pages'); ?>


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




                <div class="modal" id="loadingModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <p>Importing data, please wait...</p>
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="productsTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Condition</th>
                                        <th>Options</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded here via AJAX -->
                                </tbody>
                            </table>
                        </div>
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
                    let table = $('#productsTable').DataTable({
                        "paging": true,
                        "searching": true,
                        "info": true
                    });

                    function loadProducts() {
                        $.ajax({
                            url: '<?= site_url("products/loadProducts"); ?>',
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                let rows = '';
                                $.each(data, function(index, product) {
                                    rows += `
                        <tr data-id="${product.id}">
                            <td><input type="checkbox" class="product-checkbox" value="${product.id}"></td>
                            <td>${product.name}</td>
                            <td>${product.price}</td>
                            <td>${product.description}</td>
                            <td>${product.condition}</td>
                            <td>${product.options}</td>
                            <td>${product.category}</td>
                            <td>
                                <button class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal" 
                                    data-id="${product.id}" 
                                    data-name="${product.name}" 
                                    data-price="${product.price}" 
                                    data-description="${product.description}" 
                                    data-condition="${product.condition}" 
                                    data-options="${product.options}" 
                                    data-category="${product.category}">Edit</button>
                                <form action="/Crud_CodeIgniter4/products/delete/${product.id}" method="post" class="deleteForm d-inline">
                                    <?= csrf_field(); ?>
                                    <button id="btn-delete" type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    `;
                                });
                                table.clear().destroy();
                                $('#productsTable tbody').html(rows);
                                table = $('#productsTable').DataTable({
                                    "paging": true,
                                    "searching": true,
                                    "info": true
                                });
                            }
                        });
                    }

                    loadProducts();

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
                            url: '/Crud_CodeIgniter4/products/deleteMultiple',
                            data: {
                                id: selectedIds
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert(response.message);
                                    loadProducts();
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
                            url: '/Crud_CodeIgniter4/products/store',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert(response.message);
                                    $('#addProductModal').modal('hide');
                                    $('#addProductForm')[0].reset();
                                    loadProducts();
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
                            $(`#editOptionsContainer input[value="${option.trim()}"]`).prop('checked', true);
                        });

                        // Set condition radio buttons
                        const condition = $(this).data('condition');
                        $(`#editConditionContainer input[value="${condition}"]`).prop('checked', true);

                        // Set category
                        $('#editProductCategory').val($(this).data('category'));
                    });

                    // Update Product Form Submission
                    $('#editProductForm').on('submit', function(e) {
                        e.preventDefault();
                        const formData = $(this).serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/Crud_CodeIgniter4/products/update',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    alert(response.message);
                                    $('#editProductModal').modal('hide');
                                    loadProducts();
                                } else {
                                    alert(response.errors.join("\n"));
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
                                        loadProducts();
                                    } else {
                                        alert(response.message);
                                    }
                                },
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
                            //untuk membulatkan ke  atas
                            const totalChunks = Math.ceil(products.length / chunkSize);
                            let allchunks = [];

                            function sendChunk() {
                                const start = currentChunk * chunkSize;
                                //untuk memastikan chunk terakhir tidak melebihi jumlah produk yang ada
                                const end = Math.min(start + chunkSize, products.length);
                                const chunk = products.slice(start, end);

                                if (chunk.length === 0) {
                                    $('#loadingModal').modal('hide');
                                    loadProducts();
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('chunk', JSON.stringify(chunk));
                                formData.append('chunkNumber', currentChunk);
                                formData.append('totalChunks', totalChunks);

                                $.ajax({
                                    type: 'POST',
                                    url: '/Crud_CodeIgniter4/products/importChunk',
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            currentChunk++;
                                            if (currentChunk < totalChunks) {
                                                sendChunk();
                                            } else {
                                                $('#loadingModal').modal('hide');
                                                alert('Import completed successfully!');
                                                loadProducts();
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
                });



                // Export Excel
                $('#exportExcel').on('click', function(e) {
                    e.preventDefault();
                    var offset = 0;
                    var limit = 200;
                    var allProducts = [];

                    $('#loadingModal').modal('show');

                    function fetchChunk() {
                        $.ajax({
                            url: '/Crud_CodeIgniter4/products/exportChunk/' + offset + '/' + limit,
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
            </script>
</body>

</html>