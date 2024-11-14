<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Use CDN to link Bootstrap and Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Product Detail</title>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Product Detail</h1>
        
        <div id="product-details"></div>

        <div class="d-flex gap-2 mt-4">
            <button id="edit-product" class="btn btn-success w-50">Edit Product</button>
            <button id="delete-product" class="btn btn-danger w-50">Delete Product</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            const productId = new URLSearchParams(window.location.search).get('id');
            console.log(productId);
            // 获取产品详情
            fetch(`{{ url('api/products') }}/${productId}`, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                }
            })

            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const products = data.data;
                    document.getElementById('product-details').innerHTML = `
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="product-name" value="${products.name}" placeholder="Enter Product Name" required>
                            <label for="product-name">Product Name</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="product-description" placeholder="Enter Product description" style="height: 100px" required>${products.description}</textarea>
                            <label for="product-description">Product Description</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="product-price" value="${products.price}" placeholder="Enter Product Price" required>
                            <label for="product-price">Product Price</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="product-quantity" value="${products.quantity}" min="1" placeholder="Enter Product Quantity" required>
                            <label for="product-quantity">Product Quantity</label>
                        </div>
                    `;
                } else {
                    alert('Error fetching product: ' + data.message);
                }
            })
            
            .catch(error => console.error('Error:', error));

            // 编辑产品
            document.getElementById('edit-product').addEventListener('click', function() {
                const newName = document.getElementById('product-name').value;
                const newDescription = document.getElementById('product-description').value;
                const newPrice = document.getElementById('product-price').value;
                const newQuantity = document.getElementById('product-quantity').value;

                if (newName && newDescription && newPrice && newQuantity) {
                    fetch(`{{ url('api/products') }}/${productId}`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            name: newName,
                            description: newDescription,
                            price: newPrice,
                            quantity: newQuantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product updated successfully');
                            // window.location.reload();
                            window.location.href = '{{ url('dashboard') }}';
                        } else {
                            alert('Error updating product: ' + data.message);
                        }
                    })
                    //.catch(error => console.log('Error:', error));
                } else {
                    alert("All fields are required.");
                }
            });

            // 删除产品
            document.getElementById('delete-product').addEventListener('click', function() {
                if (confirm("Are you sure you want to delete this product?")) {
                    fetch(`{{ url('api/products') }}/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product deleted successfully');
                            window.location.href = '{{ url('dashboard') }}';  // 返回产品列表页
                        } else {
                            alert('Error deleting product: ' + data.message);
                        }
                    })
                   .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>
</body>
</html>
