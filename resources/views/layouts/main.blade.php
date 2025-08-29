@php
use Illuminate\Support\Facades\Gate;
@endphp
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'TW_Zapier 自動化流程平台')</title>
    
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('logo/fav.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    {{-- TailwindCSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fbfaf8',
                            100: '#ece9df',
                            200: '#ddd4ca',
                            300: '#c7b8a8',
                            400: '#b09a85',
                            500: '#86735E',
                            600: '#7a6654',
                            700: '#665548',
                            800: '#54463d',
                            900: '#463a33',
                        },
                        accent: {
                            red: '#C2474A',
                            orange: '#C07F56',
                            crimson: '#C23928',
                            tan: '#D19872',
                            pink: '#EC7687',
                            brown: '#662D10',
                            olive: '#644F29',
                            gray: '#6C604D',
                            amber: '#A86F4B',
                            ball: '#bd743a'
                        },
                        neutral: {
                            50: '#fbfaf8',
                            100: '#f5f5f4',
                            200: '#e7e5e4',
                            300: '#d6d3d1',
                            400: '#a8a29e',
                            500: '#78716c',
                            600: '#57534e',
                            700: '#44403c',
                            800: '#292524',
                            900: '#1c1917',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-neutral-50 font-sans">
    
    {{-- 導航列 --}}
    <nav class="bg-white shadow-sm border-b border-neutral-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                {{-- Logo 和標題 --}}
                <div class="flex items-center">
                    <img src="{{ asset('logo/logoSmall.png') }}" alt="TW_Zapier" class="w-8 h-8 mr-3">
                    <h1 class="text-xl font-bold text-neutral-800">TW_Zapier</h1>
                </div>
                
                {{-- 導航選單 --}}
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('products.index') }}" 
                       class="text-neutral-600 hover:text-primary-600 px-3 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('products.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <i class="fas fa-box mr-2"></i>產品
                    </a>
                    <a href="{{ route('cart.index') }}" 
                       class="text-neutral-600 hover:text-primary-600 px-3 py-2 rounded-lg transition-colors duration-200 {{ request()->routeIs('cart.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                        <i class="fas fa-shopping-cart mr-2"></i>購物車
                        <span class="cart-count bg-primary-500 text-white text-xs rounded-full px-2 py-1 ml-1">0</span>
                    </a>
                </div>
                
                {{-- 使用者選單 --}}
                <div class="flex items-center space-x-4">
                    @if(Gate::allows('has-any-permission'))
                        {{-- 已登入且有權限的管理員 --}}
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-neutral-600">
                                <i class="fas fa-user-circle mr-1"></i>{{ session('admin_username') }}
                            </span>
                            <a href="{{ route('admin.index') }}"
                               class="text-neutral-600 hover:text-primary-600 px-3 py-2 rounded-lg transition-colors duration-200">
                                <i class="fas fa-user-cog mr-2"></i>管理後台
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-neutral-600 hover:text-red-600 px-3 py-2 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>登出
                                </button>
                            </form>
                        </div>
                    @elseif(Gate::allows('access-admin'))
                        {{-- 已登入但無權限的使用者 --}}
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-neutral-600">
                                <i class="fas fa-user-circle mr-1"></i>{{ session('admin_username') }}
                            </span>
                            <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-neutral-600 hover:text-red-600 px-3 py-2 rounded-lg transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>登出
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- 未登入的訪客 --}}
                        <a href="{{ route('admin.login') }}"
                           class="text-neutral-600 hover:text-primary-600 px-3 py-2 rounded-lg transition-colors duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>管理登入
                        </a>
                    @endif
                </div>
                
            </div>
        </div>
    </nav>
    
    {{-- 主要內容區 --}}
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    {{-- 頁腳 --}}
    <footer class="bg-white border-t border-neutral-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                {{-- 公司資訊 --}}
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('logo/logoSmall.png') }}" alt="TW_Zapier" class="w-8 h-8 mr-3">
                        <h3 class="text-lg font-bold text-neutral-800">TW_Zapier</h3>
                    </div>
                    <p class="text-neutral-600 mb-4">
                        針對各地區主流應用打造專屬整合節點，協助使用者在無需編寫程式碼的情況下，快速整合各地區常見應用服務，達到企業內部效率提升、降低人力成本、促進流程自動化等目標。
                    </p>
                </div>
                
                {{-- 快速連結 --}}
                <div>
                    <h4 class="text-sm font-semibold text-neutral-800 mb-4">快速連結</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('products.index') }}" class="text-neutral-600 hover:text-primary-600">產品列表</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-neutral-600 hover:text-primary-600">購物車</a></li>
                        <li><a href="{{ route('admin.login') }}" class="text-neutral-600 hover:text-primary-600">管理後台</a></li>
                    </ul>
                </div>
                
                {{-- 聯絡資訊 --}}
                <div>
                    <h4 class="text-sm font-semibold text-neutral-800 mb-4">聯絡我們</h4>
                    <ul class="space-y-2 text-neutral-600">
                        <li><i class="fas fa-envelope mr-2"></i>info@tw-zapier.com</li>
                        <li><i class="fas fa-phone mr-2"></i>+886-2-1234-5678</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i>台北市信義區</li>
                    </ul>
                </div>
                
            </div>
            
            <div class="border-t border-neutral-200 mt-8 pt-8 text-center text-sm text-neutral-500">
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
        
        // 通用通知函數
        window.showNotification = function(message, type = 'info', duration = 3000) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'error' ? 'bg-red-500 text-white' : 
                type === 'warning' ? 'bg-yellow-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${
                        type === 'success' ? 'fa-check-circle' : 
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
        
        // 更新購物車數量
        window.updateCartCount = function(count) {
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = count;
                cartCountElement.classList.add('animate-bounce');
                setTimeout(() => {
                    cartCountElement.classList.remove('animate-bounce');
                }, 1000);
            }
        };
    </script>
    
    @stack('scripts')
    
</body>
</html>
