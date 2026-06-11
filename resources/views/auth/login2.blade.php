<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #020617, #0f172a);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 20px;
            background: rgba(255,255,255,0.05);
            color: white;
            backdrop-filter: blur(10px);
        }

        .form-control {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.2);
            color: white;
            box-shadow: none;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.6);
        }
    </style>
</head>
<body>

<div class="card p-4 shadow-lg" style="width: 380px;">
    <h3 class="text-center mb-4">Login</h3>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <input 
            type="email" 
            name="email" 
            class="form-control mb-3" 
            placeholder="Email"
            required
        >

        <input 
            type="password" 
            name="password" 
            class="form-control mb-3" 
            placeholder="Password"
            required
        >

        <button class="btn btn-primary w-100">Login</button>
    </form>

    <div class="text-center mt-3">
        <a href="/register" class="text-light">Belum punya akun?</a>
    </div>
</div>

</body>
</html>