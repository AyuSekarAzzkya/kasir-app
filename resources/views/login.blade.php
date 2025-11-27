<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background: linear-gradient(to bottom right, #1A2035, #1A2035); height: 100vh;">

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">

        <div class="card shadow-lg border-0" style="width: 420px; border-radius: 12px;">
            <div class="card-body p-5">

                <h4 class="text-center mb-4 fw-semibold">Login</h4>

                @if (session('failed'))
                    <div class="alert alert-danger">
                        {{ session('failed') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="m-0 p-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.auth') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control p-3"
                            placeholder="Email address" style="border-radius: 8px;">
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" class="form-control p-3" placeholder="Password"
                            style="border-radius: 8px;">
                    </div>

                    <button type="submit" class="btn w-100 fw-bold py-2"
                        style="background-color:#0d6efd; color:white; border-radius: 6px;">
                        Login
                    </button>

                </form>

            </div>
        </div>

    </div>

</body>

</html>
