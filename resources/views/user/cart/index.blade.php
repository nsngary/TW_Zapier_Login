@extends('layouts.user')

@section('title', '我的心願清單 - TW_Zapier')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">我的心願清單</h1>
                        <p class="text-gray-600 mt-2">管理您感興趣的應用程式</p>
                    </div>
                    <a href="{{ route('user.apps.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-accent-orange hover:bg-accent-ball text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        繼續瀏覽應用程式
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900">
                                    收藏的應用程式 ({{ $cartItems->count() }})
                                </h2>
                            </div>
                            
                            <div class="divide-y divide-gray-200">
                                @foreach($cartItems as $item)
                                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                                        <div class="flex items-start space-x-4">
                                            <!-- App Icon -->
                                            <div class="flex-shrink-0">
                                                @if($item->product->images && count($item->product->images) > 0)
                                                    <img src="{{ $item->product->images[0] }}" alt="{{ $item->product->name }}"
                                                         class="w-16 h-16 rounded-xl object-cover shadow-sm">
                                                @else
                                                    <div class="w-16 h-16 bg-gradient-to-br from-accent-orange to-accent-ball rounded-xl flex items-center justify-center shadow-sm">
                                                        <i class="fas fa-cube text-white text-xl"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- App Info -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                                    {{ $item->product->name }}
                                                </h3>
                                                <p class="text-sm text-gray-500 mb-2">{{ $item->product->category }}</p>
                                                <p class="text-sm text-gray-600 line-clamp-2">{{ $item->product->description }}</p>
                                                
                                                <div class="flex items-center space-x-4 mt-3">
                                                    @if($item->product->price == 0)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            免費
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            ${{ number_format($item->product->price, 0) }}
                                                        </span>
                                                    @endif
                                                    
                                                    <span class="text-xs text-gray-500">
                                                        加入時間：{{ $item->created_at->format('Y/m/d') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex-shrink-0 flex flex-col space-y-2">
                                                <a href="{{ route('user.apps.show', $item->product->id) }}" 
                                                   class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-eye mr-2"></i>
                                                    查看詳情
                                                </a>
                                                
                                                <button onclick="removeFromCart({{ $item->product->id }}, this)"
                                                        class="inline-flex items-center px-3 py-2  text-gray-700 hover:text-accent-crimson text-sm font-medium rounded-lg transition-colors duration-200">
                                                    <i class="fas fa-trash mr-2"></i>
                                                    
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-8">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">訂單摘要</h3>
                                
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">應用程式數量</span>
                                        <span class="font-medium">{{ $cartItems->count() }} 個</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">總金額</span>
                                        <span class="font-medium">${{ number_format($totalAmount, 2) }}</span>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4 mb-6">
                                    <div class="flex justify-between text-lg font-semibold">
                                        <span>總計</span>
                                        <span class="text-accent-orange">${{ number_format($totalAmount, 2) }}</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('user.cart.checkout') }}" 
                                   class="w-full inline-flex items-center justify-center px-6 py-3 bg-accent-orange hover:bg-accent-ball text-white font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    前往結帳
                                </a>
                                
                                <p class="text-xs text-gray-500 mt-3 text-center">
                                    點擊結帳即表示您同意我們的服務條款
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 border border-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-heart text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">您的心願清單是空的</h3>
                    <p class="text-gray-600 mb-6">開始瀏覽應用程式，將感興趣的項目加入心願清單</p>
                    <a href="{{ route('user.apps.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-accent-orange hover:bg-accent-ball text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        瀏覽應用程式
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function removeFromCart(productId, button) {
                if (!confirm('確定要從心願清單中移除此應用程式嗎？')) {
                    return;
                }
                
                const originalText = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>處理中...';
                
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                fetch('{{ route("user.cart.remove") }}', {
                    method: 'DELETE',
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
                        // 重新載入頁面以更新列表
                        location.reload();
                    } else {
                        alert(data.message);
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('網路錯誤，請稍後再試');
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            }
        </script>
    @endpush

    @push('styles')
        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    @endpush
@endsection
