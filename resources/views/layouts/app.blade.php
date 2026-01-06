<!DOCTYPE html>
<html>
<head>
    <title>Rental Mobil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="">Rental Mobil</a>
        <div class="ms-auto">
            <span class="text-white me-3">{{ auth()->user()->name }}</span>
            <form action="" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-danger">Logout</button>
            </form>
        </div>
    </div>
</nav>

@yield('content')

</body>
</html>
