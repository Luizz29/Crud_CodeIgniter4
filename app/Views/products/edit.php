<h1>Edit Product</h1>
<form action="/products/update/<?= $product['id'] ?>" method="post">
    <label>Name:</label>
    <input type="text" name="name" value="<?= $product['name'] ?>" required><br>

    <label>Price:</label>
    <input type="number" name="price" value="<?= $product['price'] ?>" required><br>

    <label>Description:</label>
    <textarea name="description" required><?= $product['description'] ?></textarea><br>

    <label>Options:</label>
    <input type="checkbox" name="options[]" value="Option 1" <?= in_array('Option 1', explode(',', $product['options'])) ? 'checked' : '' ?>> Option 1
    <input type="checkbox" name="options[]" value="Option 2" <?= in_array('Option 2', explode(',', $product['options'])) ? 'checked' : '' ?>> Option 2<br>

    <label>Condition:</label>
    <input type="radio" name="condition" value="New" <?= $product['condition'] == 'New' ? 'checked' : '' ?>> New
    <input type="radio" name="condition" value="Used" <?= $product['condition'] == 'Used' ? 'checked' : '' ?>> Used<br>

    <label>Category:</label>
    <select name="category">
        <option value="Electronics" <?= $product['category'] == 'Electronics' ? 'selected' : '' ?>>Electronics</option>
        <option value="Furniture" <?= $product['category'] == 'Furniture' ? 'selected' : '' ?>>Furniture</option>
    </select><br>

    <button type="submit">Update</button>
</form>
