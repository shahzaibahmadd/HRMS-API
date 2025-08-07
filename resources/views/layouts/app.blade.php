<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logs Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">HRMS Logs</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="{{ route('logs.requests') }}" class="nav-link">Request Logs</a></li>
                <li class="nav-item"><a href="{{ route('logs.apis') }}" class="nav-link">API Logs</a></li>
                <li class="nav-item"><a href="{{ route('logs.errors') }}" class="nav-link">Error Logs</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<!-- Bootstrap JS Bundle (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
