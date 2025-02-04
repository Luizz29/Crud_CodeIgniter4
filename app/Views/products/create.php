<h1>Create Product</h1>
<form action="/products/store" method="post">
    <label>Name:</label>
    <input type="text" name="name" required><br>

    <label>Price:</label>
    <input type="number" name="price" required><br>

    <label>Description:</label>
    <textarea name="description" required></textarea><br>

    <label>Options:</label>
    <input type="checkbox" name="options[]" value="Option 1"> Option 1
    <input type="checkbox" name="options[]" value="Option 2"> Option 2<br>

    <label>Condition:</label>
    <input type="radio" name="condition" value="New" required> New
    <input type="radio" name="condition" value="Used" required> Used<br>

    <label>Category:</label>
    <select name="category">
        <option value="Electronics">Electronics</option>
        <option value="Furniture">Furniture</option>
    </select><br>

    <button type="submit">Save</button>
</form>
