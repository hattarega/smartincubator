<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

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
    </style>
</head>
<body>

<div class="card p-4 shadow-lg" style="width: 380px;">
    <h3 class="text-center mb-4">Register</h3>

    {{-- 🔥 ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- 🔥 SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <input 
            type="text" 
            name="name" 
            class="form-control mb-3" 
            placeholder="Nama"
            value="{{ old('name') }}"
            required
        >

        <input 
            type="email" 
            name="email" 
            class="form-control mb-3" 
            placeholder="Email"
            value="{{ old('email') }}"
            required
        >

        <input 
            type="password" 
            name="password" 
            class="form-control mb-3" 
            placeholder="Password"
            required
        >

        <input 
            type="password" 
            name="password_confirmation" 
            class="form-control mb-3" 
            placeholder="Konfirmasi Password"
            required
        >

        <button class="btn btn-success w-100">Register</button>
    </form>

    <div class="text-center mt-3">
        <a href="/login" class="text-light">Sudah punya akun?</a>
    </div>
</div>

</body>
</html>