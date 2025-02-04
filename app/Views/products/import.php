<?= $this->extend('template/pages');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="<?= base_url('products/import') ?>" method="post" enctype="multipart/form-data">
    <label for="excelFile">Upload File Excel:</label>
    <input type="file" name="excelFile" id="excelFile" required>
    <button type="submit">Import</button>
</form>

</body>
</html>