@extends('layouts.main')

@section('title', '購物車 - TW_Zapier')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- 頁面標題 --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-neutral-800 mb-2">購物車</h1>
        <p class="text-neutral-600">檢視您選購的商品</p>
    </div>
    
    @if(!empty($cart) && count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- 購物車商品列表 --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6">
                        <div class="flex items-center space-x-4">
                            
                            {{-- 商品圖片 --}}
                            <div class="w-20 h-20 bg-neutral-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item['image'])
                                    <img src="{{ asset('product_img/' . $item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-neutral-400"></i>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- 商品資訊 --}}
                            <div class="flex-1">
                                <h3 class="font-semibold text-neutral-800 mb-1">{{ $item['name'] }}</h3>
                                <p class="text-primary-600 font-medium">NT$ {{ number_format($item['price']) }}</p>
                            </div>
                            
                            {{-- 數量控制 --}}
                            <div class="flex items-center space-x-2">
                                <button onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" 
                                        class="w-8 h-8 flex items-center justify-center border border-neutral-300 rounded-lg hover:bg-neutral-50 {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <span class="w-12 text-center font-medium">{{ $item['quantity'] }}</span>
                                <button onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" 
                                        class="w-8 h-8 flex items-center justify-center border border-neutral-300 rounded-lg hover:bg-neutral-50">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                            
                            {{-- 小計 --}}
                            <div class="text-right">
                                <p class="font-semibold text-neutral-800">
                                    NT$ {{ number_format($item['price'] * $item['quantity']) }}
                                </p>
                            </div>
                            
                            {{-- 刪除按鈕 --}}
                            <button onclick="removeFromCart({{ $id }})" 
                                    class="text-red-500 hover:text-red-700 p-2">
                                <i class="fas fa-trash"></i>
                            </button>
                            
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- 訂單摘要 --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6 sticky top-6">
                    <h2 class="text-xl font-semibold text-neutral-800 mb-4">訂單摘要</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-neutral-600">
                            <span>商品總計</span>
                            <span>NT$ {{ number_format($total) }}</span>
                        </div>
                        <div class="flex justify-between text-neutral-600">
                            <span>運費</span>
                            <span>免運費</span>
                        </div>
                        <hr class="border-neutral-200">
                        <div class="flex justify-between text-lg font-semibold text-neutral-800">
                            <span>總計</span>
                            <span>NT$ {{ number_format($total) }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <button class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-200">
                            前往結帳
                        </button>
                        <a href="{{ route('products.index') }}" 
                           class="block w-full text-center bg-neutral-100 hover:bg-neutral-200 text-neutral-700 py-3 px-4 rounded-lg font-medium transition-colors duration-200">
                            繼續購物
                        </a>
                        <button onclick="clearCart()" 
                                class="w-full text-red-600 hover:text-red-700 py-2 text-sm font-medium">
                            清空購物車
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
        
    @else
        {{-- 空購物車 --}}
        <div class="text-center py-16">
            <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-12 max-w-md mx-auto">
                <i class="fas fa-shopping-cart text-neutral-300 text-6xl mb-6"></i>
                <h2 class="text-xl font-semibold text-neutral-800 mb-3">購物車是空的</h2>
                <p class="text-neutral-600 mb-6">還沒有選購任何商品，快去挑選喜歡的商品吧！</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-block bg-primary-500 hover:bg-primary-600 text-white py-3 px-6 rounded-lg font-semibold transition-colors duration-200">
                    開始購物
                </a>
            </div>
        </div>
    @endif
    
</div>

{{-- JavaScript --}}
<script>
function updateQuantity(productId, newQuantity) {
    if (newQuantity < 1) return;
    
    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id: productId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showNotification('更新失敗', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('發生錯誤，請稍後再試', 'error');
    });
}

function removeFromCart(productId) {
    if (!confirm('確定要移除這個商品嗎？')) return;
    
    fetch(`/cart/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showNotification('移除失敗', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('發生錯誤，請稍後再試', 'error');
    });
}

function clearCart() {
    if (!confirm('確定要清空購物車嗎？')) return;
    
    fetch('/cart', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showNotification('清空失敗', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('發生錯誤，請稍後再試', 'error');
    });
}

// 通知函數
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
</script>
@endsection
