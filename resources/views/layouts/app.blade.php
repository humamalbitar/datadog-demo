<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager - Datadog Demo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">
                <i class="fas fa-tasks"></i> Task Manager
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('tasks.index') }}">All Tasks</a>
                <a class="nav-link" href="{{ route('tasks.create') }}">New Task</a>
                <a class="nav-link" href="/api/tasks/stats" target="_blank">API Stats</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Datadog RUM Script for monitoring -->
    <script>
        (function(h,o,u,n,d) {
            h=h[d]=h[d]||{q:[],onReady:function(c){h.q.push(c)}}
            d=o.createElement(u);d.async=1;d.src=n
            n=o.getElementsByTagName(u)[0];n.parentNode.insertBefore(d,n)
        })(window,document,'script','https://www.datadoghq-browser-agent.com/us5/v4/datadog-rum.js','DD_RUM')
        
        window.DD_RUM.onReady(function() {
            window.DD_RUM.init({
                clientToken: 'pub3f1e3b8e4c1d43e9b8a7f6e5d4c3b2a1', // You'll need to get this from Datadog
                applicationId: '12345678-1234-1234-1234-123456789012', // You'll need to get this from Datadog  
                site: 'us5.datadoghq.com',
                service: 'datadog-demo',
                env: '{{ config("app.env") }}',
                version: '1.0.0',
                sessionSampleRate: 100,
                sessionReplaySampleRate: 20,
                trackUserInteractions: true,
                trackResources: true,
                trackLongTasks: true,
                defaultPrivacyLevel: 'mask-user-input',
            });
            
            // Track page views
            window.DD_RUM.addAction('page_view', {
                page: window.location.pathname,
                timestamp: new Date().toISOString()
            });
        });

        // Track button clicks
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON' || e.target.classList.contains('btn')) {
                if (typeof window.DD_RUM !== 'undefined') {
                    window.DD_RUM.addAction('button_click', {
                        element: e.target.textContent.trim(),
                        page: window.location.pathname
                    });
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
