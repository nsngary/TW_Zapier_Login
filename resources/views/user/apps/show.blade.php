@extends('layouts.user')

@section('title', $app->name . ' - TW_Zapier')

@section('content')
<!-- Breadcrumb -->
<div class="bg-white border-b border-neutral-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <a href="{{ route('user.apps.index') }}" class="text-neutral-500 hover:text-neutral-700 transition-colors duration-200">
                        <i class="fas fa-th-large mr-2"></i>應用程式
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-neutral-400 mx-2"></i>
                        <a href="{{ route('user.apps.index', ['category' => $app->category]) }}"
                           class="text-neutral-500 hover:text-neutral-700 transition-colors duration-200">
                            {{ $app->category }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-neutral-400 mx-2"></i>
                        <span class="text-neutral-900 font-medium">{{ $app->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- App Header -->
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- App Icon and Basic Info -->
            <div class="lg:col-span-5">
                <div class="flex items-start space-x-6">
                    @if($app->images && count($app->images) > 0)
                        <img src="{{ $app->images[0] }}"
                             alt="{{ $app->name }}"
                             class="w-20 h-20 rounded object-cover border border-neutral-200">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-br from-accent-orange to-accent-amber rounded flex items-center justify-center border border-neutral-200">
                            <i class="fas fa-cube text-white text-2xl"></i>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <h1 class="text-3xl font-bold text-neutral-900 mb-2">{{ $app->name }}</h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="inline-flex items-center px-3 py-1 border border-primary-200 text-sm font-medium bg-primary-100 text-primary-800">
                                {{ $app->category }}
                            </span>
                            @if($app->price == 0)
                                <span class="inline-flex items-center px-3 py-1 border border-green-200 text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>免費
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 border border-blue-200 text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-dollar-sign mr-1"></i>${{ number_format($app->price, 0) }}
                                </span>
                            @endif
                        </div>
                        <p class="text-lg text-neutral-600 leading-relaxed">{{ $app->description }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-8 lg:mt-0 lg:col-span-7">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('user.apps.integrations', $app->id) }}"
                       target="_blank"
                       class="inline-flex items-center justify-center px-6 py-3 bg-accent-orange hover:bg-accent-amber text-white font-medium border border-accent-orange hover:border-accent-amber transition-colors duration-200">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        查看整合詳情
                    </a>
                    <button
                        onclick="toggleWishlist({{ $app->id }}, this)"
                        class="wishlist-btn inline-flex items-center justify-center px-6 py-3 bg-white hover:bg-neutral-50 text-neutral-700 font-medium border border-neutral-300 hover:border-neutral-400 transition-colors duration-200 {{ $isWishlisted ? 'wishlisted' : '' }}"
                        data-product-id="{{ $app->id }}"
                        data-wishlisted="{{ $isWishlisted ? 'true' : 'false' }}"
                        title="{{ $isWishlisted ? '移除收藏' : '加入收藏' }}">
                        <i class="fas fa-heart mr-2 {{ $isWishlisted ? 'text-accent-red' : '' }}"></i>
                        <span class="btn-text">{{ $isWishlisted ? '已收藏' : '加入收藏' }}</span>
                    </button>
                </div>
                
                <!-- Quick Stats -->
                <div class="mt-8 grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-neutral-50 border border-neutral-200">
                        <div class="text-2xl font-bold text-neutral-900">{{ $app->stock }}</div>
                        <div class="text-sm text-neutral-600">可用連接數</div>
                    </div>
                    <div class="text-center p-4 bg-neutral-50 border border-neutral-200">
                        <div class="text-2xl font-bold text-neutral-900">{{ $app->sku }}</div>
                        <div class="text-sm text-neutral-600">應用程式編號</div>
                    </div>
                    <div class="text-center p-4 bg-neutral-50 border border-neutral-200">
                        <div class="text-2xl font-bold text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="text-sm text-neutral-600">已驗證</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 使用應用程式詳細資訊模板 --}}
@include('components.app-details', ['app' => $app])

@endsection

@push('scripts')
<script>
    // 心願清單功能
    function toggleWishlist(productId, button) {
        const btnText = button.querySelector('.btn-text');
        const btnIcon = button.querySelector('i');
        const isWishlisted = button.dataset.wishlisted === 'true';
        const originalText = btnText.textContent;

        // 設置載入狀態
        button.disabled = true;
        btnText.textContent = '處理中...';
        btnIcon.className = 'fas fa-spinner fa-spin mr-2';

        // 準備 CSRF token
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!token) {
            showMessage('系統錯誤：缺少安全令牌', 'error');
            resetButton(button, originalText, isWishlisted);
            return;
        }

        // 根據當前狀態決定要執行的操作
        const url = isWishlisted ? '{{ route("user.cart.remove") }}' : '{{ route("user.cart.add") }}';
        const method = isWishlisted ? 'DELETE' : 'POST';

        // 發送 AJAX 請求
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 切換狀態
                if (isWishlisted) {
                    // 移除收藏成功
                    btnText.textContent = '加入收藏';
                    btnIcon.className = 'fas fa-heart mr-2';
                    btnIcon.classList.remove('text-accent-red');
                    button.classList.remove('wishlisted');
                    button.dataset.wishlisted = 'false';
                    button.title = '加入收藏';
                } else {
                    // 加入收藏成功
                    btnText.textContent = '已收藏';
                    btnIcon.className = 'fas fa-heart mr-2 text-accent-red';
                    button.classList.add('wishlisted');
                    button.dataset.wishlisted = 'true';
                    button.title = '移除收藏';
                }
                button.disabled = false;
                showMessage(data.message, 'success');
            } else {
                // 處理錯誤
                showMessage(data.message, 'error');
                resetButton(button, originalText, isWishlisted);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('網路錯誤，請稍後再試', 'error');
            resetButton(button, originalText, isWishlisted);
        });
    }

    function resetButton(button, originalText, isWishlisted) {
        const btnText = button.querySelector('.btn-text');
        const btnIcon = button.querySelector('i');

        button.disabled = false;
        btnText.textContent = originalText;

        if (isWishlisted) {
            btnIcon.className = 'fas fa-heart mr-2 text-accent-red';
        } else {
            btnIcon.className = 'fas fa-heart mr-2';
            btnIcon.classList.remove('text-accent-red');
        }
    }

    function showMessage(message, type) {
        // 創建訊息元素
        const messageDiv = document.createElement('div');
        messageDiv.className = `fixed top-15 right-4 z-50 px-6 py-3 rounded-xs shadow-lg transition-all duration-300 transform translate-x-full`;

        if (type === 'success') {
            messageDiv.classList.add('bg-green-500', 'text-white');
            messageDiv.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
        } else {
            messageDiv.classList.add('bg-red-500', 'text-white');
            messageDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-2"></i>${message}`;
        }

        document.body.appendChild(messageDiv);

        // 顯示動畫
        setTimeout(() => {
            messageDiv.classList.remove('translate-x-full');
        }, 100);

        // 自動隱藏
        setTimeout(() => {
            messageDiv.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(messageDiv);
            }, 300);
        }, 3000);
    }
</script>
@endpush
