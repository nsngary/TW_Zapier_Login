@php
    use Illuminate\Support\Facades\Gate;
@endphp
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TW_Zapier 後端管理系統')</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('logo/fav.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .Header-module_logo_xO2bWOoS:focus-visible {
            outline: .125rem solid #695be8;
            outline-offset: 8px
        }
    </style>
</head>

<body class="bg-neutral-50 font-sans">
{{-- 使用動態 Header 組件 --}}
@include('layouts.dynamic-header')



    {{-- 主要內容區 --}}
    <main class="min-h-screen py-6">
        @yield('content')
    </main>

    {{-- 頁腳 --}}
    <footer class="bg-white border-t border-neutral-200 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-neutral-500">
                © {{ date('Y') }} TW_Zapier. 版權所有 | 自動化流程平台
            </div>
        </div>
    </footer>

    {{-- 全域 JavaScript --}}
    <script>
        // CSRF Token 設定
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };

        // 設定 AJAX 預設 headers
        if (typeof axios !== 'undefined') {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        // 通用通知函數
        window.showNotification = function (message, type = 'info', duration = 3000) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                    type === 'warning' ? 'bg-yellow-500 text-white' :
                        'bg-blue-500 text-white'
                }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' :
                    type === 'error' ? 'fa-exclamation-triangle' :
                        type === 'warning' ? 'fa-exclamation-circle' :
                            'fa-info-circle'
                } mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // 顯示動畫
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // 自動隱藏
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, duration);
        };
    </script>

    @stack('scripts')

</body>

</html>