@extends('layouts.main')

@section('title', $product->p_name . ' - TW_Zapier')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- 麵包屑導航 --}}
    <nav class="flex items-center space-x-2 text-sm text-neutral-600 mb-6">
        <a href="{{ route('products.index') }}" class="hover:text-primary-600">產品列表</a>
        <i class="fas fa-chevron-right text-xs"></i>
        @if($product->category)
            <span>{{ $product->category->cname }}</span>
            <i class="fas fa-chevron-right text-xs"></i>
        @endif
        <span class="text-neutral-800">{{ $product->p_name }}</span>
    </nav>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- 產品圖片 --}}
        <div class="space-y-4">
            {{-- 主圖片 --}}
            <div class="aspect-square bg-white rounded-lg shadow-sm border border-neutral-200 overflow-hidden">
                @if($product->mainImage)
                    <img src="{{ asset('product_img/' . $product->mainImage->img_file) }}" 
                         alt="{{ $product->p_name }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-neutral-100">
                        <i class="fas fa-image text-neutral-400 text-6xl"></i>
                    </div>
                @endif
            </div>
            
            {{-- 縮圖列表 --}}
            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $image)
                        <div class="aspect-square bg-white rounded-lg shadow-sm border border-neutral-200 overflow-hidden cursor-pointer hover:border-primary-500 transition-colors duration-200">
                            <img src="{{ asset('product_img/' . $image->img_file) }}" 
                                 alt="{{ $product->p_name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        {{-- 產品資訊 --}}
        <div class="space-y-6">
            
            {{-- 標題和分類 --}}
            <div>
                <h1 class="text-3xl font-bold text-neutral-800 mb-2">{{ $product->p_name }}</h1>
                @if($product->category)
                    <span class="inline-block bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $product->category->cname }}
                    </span>
                @endif
            </div>
            
            {{-- 價格 --}}
            <div class="border-b border-neutral-200 pb-6">
                <div class="text-3xl font-bold text-primary-600 mb-2">
                    NT$ {{ number_format($product->p_price) }}
                </div>
                <p class="text-neutral-600">含稅價格</p>
            </div>
            
            {{-- 產品簡介 --}}
            <div class="border-b border-neutral-200 pb-6">
                <h3 class="text-lg font-semibold text-neutral-800 mb-3">產品簡介</h3>
                <p class="text-neutral-700 leading-relaxed">{{ $product->p_intro }}</p>
            </div>
            
            {{-- 購買選項 --}}
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-neutral-700">數量：</label>
                    <div class="flex items-center border border-neutral-300 rounded-lg">
                        <button onclick="decreaseQuantity()" 
                                class="px-3 py-2 text-neutral-600 hover:text-neutral-800 hover:bg-neutral-50">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" 
                               id="quantity" 
                               value="1" 
                               min="1" 
                               class="w-16 text-center border-0 focus:ring-0">
                        <button onclick="increaseQuantity()" 
                                class="px-3 py-2 text-neutral-600 hover:text-neutral-800 hover:bg-neutral-50">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                {{-- 購買按鈕 --}}
                <div class="flex space-x-3">
                    <button onclick="addToCart({{ $product->p_id }})" 
                            class="flex-1 bg-primary-500 hover:bg-primary-600 text-white py-3 px-6 rounded-lg font-semibold transition-colors duration-200">
                        <i class="fas fa-shopping-cart mr-2"></i>加入購物車
                    </button>
                    <button class="bg-accent-orange hover:bg-accent-orange/90 text-white py-3 px-6 rounded-lg font-semibold transition-colors duration-200">
                        立即購買
                    </button>
                </div>
            </div>
            
        </div>
    </div>
    
    {{-- 產品詳細內容 --}}
    @if($product->p_content)
        <div class="mt-12 bg-white rounded-lg shadow-sm border border-neutral-200 p-8">
            <h2 class="text-2xl font-bold text-neutral-800 mb-6">產品詳情</h2>
            <div class="prose prose-neutral max-w-none">
                {{-- 直接輸出 HTML 內容，不進行轉義 --}}
                {!! $product->p_content !!}
            </div>
        </div>
    @endif
    
</div>

{{-- JavaScript --}}
<script>
function increaseQuantity() {
    const input = document.getElementById('quantity');
    input.value = parseInt(input.value) + 1;
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    
    fetch(`/products/${productId}/add-to-cart`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: parseInt(quantity) })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            updateCartCount(data.cart_count);
        } else {
            showNotification('加入購物車失敗', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('發生錯誤，請稍後再試', 'error');
    });
}

// 通知函數（如果 main layout 沒有定義的話）
if (typeof showNotification === 'undefined') {
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
}

function updateCartCount(count) {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        cartCountElement.classList.add('animate-bounce');
        setTimeout(() => {
            cartCountElement.classList.remove('animate-bounce');
        }, 1000);
    }
}
</script>
@endsection
