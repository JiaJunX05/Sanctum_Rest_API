<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Use CDN to link Bootstrap and Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container text-center mt-5">
        <div class="row">
            <div class="col">
                <h1 class="pb-2 mb-4 text-primary-emphasis border-bottom border-danger" style="font-weight: 700;">Products Management</h1>
                <form action="{{ url('api/products') }}" method="post" id="add-product-form">
                    @csrf
    
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product Name" required>
                        <label for="name">Product Name</label>
                    </div>
    
                    <div class="form-floating mb-3 mt-3">
                        <textarea class="form-control" placeholder="Enter Product Description" id="description" name="description" style="height: 100px"></textarea>
                        <label for="description">Product Description</label>
                    </div>
    
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter Product Price" required>
                        <label for="price">Product Price</label>
                    </div>
    
                    <div class="form-floating mb-3 mt-3">
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" placeholder="Enter Product Quantity" required>
                        <label for="quantity">Product Quantity</label>
                    </div>
    
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
    
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');

            if (!token) {
                alert('You need to login first.');
                window.location.href = '{{ url('/') }}';
                return;
            }

            document.getElementById('add-product-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const name = document.getElementById('name').value;
                const description = document.getElementById('description').value;
                const price = document.getElementById('price').value;
                const quantity = document.getElementById('quantity').value;

                fetch('{{ url('api/products') }}', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name,
                        description: description,
                        price: price,
                        quantity: quantity
                    })
                })

                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product added successfully.');
                        window.location.href = '{{ url('dashboard') }}';
                    } else {
                        alert('Error adding product: ' + data.message);
                    }
                })

                .catch(error => console.error('Error:', error));
            });
        });
    </script>

</body>
</html>