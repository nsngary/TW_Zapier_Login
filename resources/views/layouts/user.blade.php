<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TW_Zapier - 自動化流程平台')</title>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #ffffff;
        }
        .app-hover {
            transition: all 0.2s ease;
        }
        .app-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }
        .border-hover:hover {
            border-color: #86735E;
        }
        .bg-accent-orange:hover {
            background-color: #86735E !important;
        }

        /* Dropdown animations */
        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Smooth transitions */
        .transition-transform {
            transition: transform 0.2s ease;
        }
    </style>
</head>
<body class="bg-white min-h-screen">
    {{-- 使用動態 Header 組件 --}}
    @include('layouts.dynamic-header')

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-neutral-200 mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-accent-orange rounded flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-sm"></i>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900">TW_Zapier</h3>
                    </div>
                    <p class="text-neutral-600 text-sm leading-relaxed">
                        台灣自動化流程平台，連接您最愛的應用程式，讓工作更有效率。
                        無需編程知識，輕鬆建立強大的自動化工作流程。
                    </p>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-neutral-900 mb-4">產品</h4>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li><a href="{{ route('user.apps.index') }}" class="hover:text-primary-600 transition-colors duration-200">應用程式</a></li>
                        <li><a href="#" class="hover:text-primary-600 transition-colors duration-200">工作流程</a></li>
                        <li><a href="#" class="hover:text-primary-600 transition-colors duration-200">模板</a></li>
                        <li><a href="#" class="hover:text-primary-600 transition-colors duration-200">整合服務</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-neutral-900 mb-4">支援</h4>
                    <ul class="space-y-2 text-sm text-neutral-600">
                        <li><a href="#" class="hover:text-primary-600 transition-colors duration-200">說明中心</a></li>
                        <li><a href="#" class="hover:text-primary-600 transition-colors duration-200">API 文件</a></li>
                        <li><a href="#" class="hover:text-primary-600 transition-colors duration-200">社群論壇</a></li>
                        <li><a href="#" class="hover:text-primary-600 transition-colors duration-200">聯絡我們</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-neutral-200 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-neutral-500">© 2025 TW_Zapier. 版權所有 | 自動化流程平台</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-neutral-400 hover:text-neutral-500 transition-colors duration-200">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-neutral-400 hover:text-neutral-500 transition-colors duration-200">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-neutral-400 hover:text-neutral-500 transition-colors duration-200">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="text-neutral-400 hover:text-neutral-500 transition-colors duration-200">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // 自動隱藏成功訊息
        setTimeout(function() {
            const successMsg = document.getElementById('success-message');
            if (successMsg) successMsg.remove();
        }, 5000);

        // 自動隱藏錯誤訊息
        setTimeout(function() {
            const errorMsg = document.getElementById('error-message');
            if (errorMsg) errorMsg.remove();
        }, 8000);
    </script>
    
    @stack('scripts')
</body>
</html>
