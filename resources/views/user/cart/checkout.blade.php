@extends('layouts.user')

@section('title', '結帳 - TW_Zapier')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('user.cart.index') }}" 
                       class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        返回心願清單
                    </a>
                    <div class="text-gray-300">|</div>
                    <h1 class="text-3xl font-bold text-gray-900">結帳</h1>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Summary -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">訂單明細</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-6">
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
                                        </div>

                                        <!-- Price -->
                                        <div class="flex-shrink-0 text-right">
                                            @if($item->product->price == 0)
                                                <span class="text-lg font-semibold text-green-600">免費</span>
                                            @else
                                                <span class="text-lg font-semibold text-gray-900">
                                                    ${{ number_format($item->product->price, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">服務條款</h3>
                        <div class="text-sm text-gray-600 space-y-2">
                            <p>• 購買後您將獲得應用程式的使用權限</p>
                            <p>• 免費應用程式可立即使用，付費應用程式需要完成付款流程</p>
                            <p>• 所有購買均受到我們的服務條款和隱私政策約束</p>
                            <p>• 如有任何問題，請聯繫我們的客服團隊</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-8">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">付款摘要</h3>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">應用程式數量</span>
                                    <span class="font-medium">{{ $cartItems->count() }} 個</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">小計</span>
                                    <span class="font-medium">${{ number_format($totalAmount, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">稅費</span>
                                    <span class="font-medium">$0.00</span>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4 mb-6">
                                <div class="flex justify-between text-lg font-semibold">
                                    <span>總計</span>
                                    <span class="text-accent-orange">${{ number_format($totalAmount, 2) }}</span>
                                </div>
                            </div>

                            <!-- Checkout Form -->
                            <form action="{{ route('user.cart.process') }}" method="POST" id="checkoutForm">
                                @csrf
                                
                                <div class="mb-6">
                                    <label class="flex items-center">
                                        <input type="checkbox" id="agreeTerms" required 
                                               class="rounded border-gray-300 text-accent-orange focus:ring-accent-orange">
                                        <span class="ml-2 text-sm text-gray-600">
                                            我同意 <a href="#" class="text-accent-orange hover:underline">服務條款</a> 
                                            和 <a href="#" class="text-accent-orange hover:underline">隱私政策</a>
                                        </span>
                                    </label>
                                </div>
                                
                                <button type="submit" id="checkoutBtn"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-accent-orange hover:bg-accent-ball text-white font-medium rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-lock mr-2"></i>
                                    <span id="btnText">確認購買</span>
                                </button>
                                
                                <p class="text-xs text-gray-500 mt-3 text-center">
                                    您的付款資訊將被安全加密處理
                                </p>
                            </form>
                        </div>
                    </div>

                    <!-- Security Info -->
                    <div class="mt-6 bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">安全保障</h4>
                                <p class="text-xs text-gray-600">使用 SSL 加密技術保護您的資料安全</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('checkoutForm').addEventListener('submit', function(e) {
                const btn = document.getElementById('checkoutBtn');
                const btnText = document.getElementById('btnText');
                const agreeTerms = document.getElementById('agreeTerms');
                
                if (!agreeTerms.checked) {
                    e.preventDefault();
                    alert('請先同意服務條款和隱私政策');
                    return;
                }
                
                // 設置載入狀態
                btn.disabled = true;
                btnText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>處理中...';
                
                // 表單會自動提交，不需要阻止
            });
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
