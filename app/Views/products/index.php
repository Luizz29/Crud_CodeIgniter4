<?= $this->extend('template/pages'); ?>
<?= $this->section('data'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-sm-10">
            <h1 class="mt-3 mx-auto">Data Produk</h1>
            <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Tambah Data</a>
            <form id="importForm" action="<?= base_url('products/import') ?>" method="post" enctype="multipart/form-data" class="mt-3">
                <?= csrf_field(); ?>
                <label for="excelFile">Upload File Excel:</label>
                <input type="file" name="excelFile" id="excelFile" required>
                <button type="submit" class="btn btn-primary">Import</button>
                <a href="#" id="exportExcelBtn" class="btn btn-success mt-0">Export Excel</a>
            </form>
            <input type="text" id="searchInput" class="form-control mt-3" placeholder="Cari produk...">
            <table class="table mt-3" id="productTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Kondisi</th>
                        <th>Opsi</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

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
                        <label>Available Options:</label><br>
                        <div id="editOptionsContainer">
                            <input type="checkbox" name="options[]" value="Option 1"> Option 1<br>
                            <input type="checkbox" name="options[]" value="Option 2"> Option 2<br>
                            <input type="checkbox" name="options[]" value="Option 3"> Option 3<br>
                        </div>
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
                            <input type="checkbox" id="editOption1" name="options[]" value="Option 1"> Option 1<br>
                            <input type="checkbox" id="editOption2" name="options[]" value="Option 2"> Option 2<br>
                            <input type="checkbox" id="editOption3" name="options[]" value="Option 3"> Option 3<br>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editProductDescription" class="form-label">Description:</label>
                        <textarea class="form-control" id="editProductDescription" name="description" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Condition:</label><br>
                        <div id="editConditionContainer">
                            <input type="radio" id="editConditionNew" name="condition" value="New"> New<br>
                            <input type="radio" id="editConditionUsed" name="condition" value="Used"> Used<br>
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
   
<script>
$(document).ready(function() {
        loadProducts();

        $('#addProductForm').on('submit', addProduct);
        $(document).on('click', '.edit-btn', editProduct);
        $('#editProductForm').on('submit', updateProduct);
        $(document).on('click', '.delete-btn', deleteProduct);
        $('#searchInput').on('keyup', searchProducts);
        $('#importForm').on('submit', importProducts);
        $('#exportExcelBtn').on('click', exportProducts);

        function loadProducts() {
            $.ajax({
                url: '<?= base_url('products/loadProducts') ?>',
                type: 'GET',
                success: function(response) {
                    $('#productTable tbody').empty();
                    response.forEach(function(product) {
                        $('#productTable tbody').append(`
                            <tr data-id="${product.id}">
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
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${product.id}">Hapus</button>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat data produk.');
                }
            });
        }

        function addProduct(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('products/store') ?>',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#addProductModal').modal('hide');
                        loadProducts();
                    } else {
                        let errorMessage = 'Gagal menambah produk: ';
                        if (Array.isArray(response.errors)) {
                            errorMessage += response.errors.join(', ');
                        } else if (typeof response.errors === 'object') {
                            errorMessage += Object.values(response.errors).join(', ');
                        } else {
                            errorMessage += response.errors;
                        }
                        alert(errorMessage);
                        loadProducts();
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menambah produk.');
                }
            });
        }

        function editProduct() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var price = $(this).data('price');
            var description = $(this).data('description');
            var condition = $(this).data('condition');
            var options = $(this).data('options').split(','); 
            var category = $(this).data('category');

            $('#editProductId').val(id);
            $('#editProductName').val(name);
            $('#editProductPrice').val(price);
            $('#editProductDescription').val(description);

            if (condition === 'New') {
                $('#editConditionNew').prop('checked', true);
            } else {
                $('#editConditionUsed').prop('checked', true);
            }

  
            $('#editOptionsContainer input[type="checkbox"]').each(function() {
                $(this).prop('checked', options.includes($(this).val()));
            });

            $('#editProductCategory').val(category);
        }

        function updateProduct(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('products/update') ?>',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#editProductModal').modal('hide');
                        loadProducts();
                    } else {
                        let errorMessage = 'Gagal memperbarui produk: ';
                        if (Array.isArray(response.errors)) {
                            errorMessage += response.errors.join(', ');
                        } else if (typeof response.errors === 'object') {
                            errorMessage += Object.values(response.errors).join(', ');
                        } else {
                            errorMessage += response.errors;
                        }
                        alert(errorMessage);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui produk.');
                }
            });
        }

        function deleteProduct() {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                $.ajax({
                    url: '<?= base_url('products/delete') ?>/' + id,
                    type: 'POST',
                    data: {
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            loadProducts();
                        } else {
                            alert('Gagal menghapus produk: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus produk.');
                    }
                });
            }
        }

        function searchProducts() {
            var query = $(this).val();
            $.ajax({
                url: '<?= base_url('products/search') ?>',
                type: 'GET',
                data: {
                    query: query
                },
                success: function(response) {
                    $('#productTable tbody').empty();
                    response.data.forEach(function(product) {
                        $('#productTable tbody').append(`
                        <tr data-id="${product.id}">
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
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${product.id}">Hapus</button>
                            </td>
                        </tr>
                    `);
                    });
                },
                error: function() {
                    alert('Terjadi kesalahan saat mencari produk.');
                }
            });
        }

        function importProducts(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('products/import') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        loadProducts();
                    } else {
                        alert('Gagal mengimpor data: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengimpor data.');
                }
            });
        }

    
function exportProducts(e) {
    e.preventDefault();
    var offset = 0;
    var limit = 200;
    var allProducts = [];

    function fetchChunk() {
        $.ajax({
            url: '<?= base_url('products/exportChunk') ?>/' + offset + '/' + limit,
            type: 'GET',
            success: function(response) {
                if (response.length > 0) {
                    allProducts = allProducts.concat(response);
                    offset += limit;
                    fetchChunk(); 
                } else {
                    createAndDownloadExcel(allProducts);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengekspor data.');
            }
        });
    }

    function createAndDownloadExcel(allProducts) {
        var workbook = XLSX.utils.book_new();
        var worksheetData = [['Name', 'Price', 'Description', 'Condition', 'Options', 'Category']];

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
        XLSX.writeFile(workbook, 'products.xlsx');
    }

    fetchChunk();
}

</script>

<?= $this->endSection(); ?>