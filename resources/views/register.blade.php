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
    <div class="container text-center position-absolute top-50 start-50 translate-middle">
        <div class="col justify-content-center mb-4">
            <img src="https://static-00.iconduck.com/assets.00/laravel-icon-995x1024-dk77ahh4.png" alt="" class="img-fluid" style="width: 100px;">
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">

            <!-- Success Alert -->
            @if(session("success"))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session("success") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif   

                <h1 class="pb-2 mb-4 text-primary-emphasis border-bottom border-danger" style="font-weight: 700;">Sign Up</h1>
                <form action="{{ url('api/register') }}" method="post" id="register-form">
                    <!-- csrf is used to protect the form from cross-site request forgery attacks -->
                    @csrf
                    
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        <label for="name">Name</label>
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="form-floating mb-3 mt-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        <label for="password">Password</label>
                    </div>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary w-100 mt-3 mb-3" name="submit">SIGN UP</button>
                
                    <div class="col mt-3">
                        <p class="text-secondary" style="font-size: 20px;">Already have an account? <a href="{{ route('login') }}" style="text-decoration: none; color: red;">Sign In</a></p>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <script>
        document.getElementById('register-form').addEventListener('submit', function(event) {
            event.preventDefault();
    
            const formData = new FormData(this);
    
            fetch('{{ url('api/register') }}', {
                method: 'POST',
                headers: {
                    'Content-type' : 'application/json'
                },
                body: JSON.stringify({
                    name: formData.get('name'),
                    email: formData.get('email'),
                    password: formData.get('password'),
                    password_confirmation: formData.get('password_confirmation')
                }),
            })
    
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Registration successful.');
                } else {
                    alert('Registraion failed.' + data.message);
                }
            })
    
            .catch(error => console.error('Error:' , error));
    
        });
    </script>

</body>
</html>
