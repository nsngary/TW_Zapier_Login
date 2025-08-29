@extends('layouts.admin')

@section('title', '產品詳情')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- 頁面標題 --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">產品詳情</h1>
            <p class="text-neutral-600 mt-2">檢視產品完整資訊</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('products.edit', $product->id) }}"
               class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>編輯產品
            </a>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center px-4 py-2 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>返回列表
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- 產品圖片 --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-neutral-800 mb-4">產品圖片</h3>
                    @if($product->processed_images && count($product->processed_images) > 0)
                        <div class="space-y-4">
                            {{-- 主圖片 --}}
                            <div class="aspect-square rounded-lg overflow-hidden bg-neutral-100">
                                <img src="{{ $product->main_image }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </div>

                            {{-- 其他圖片 --}}
                            @if(count($product->processed_images) > 1)
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach(array_slice($product->processed_images, 1) as $image)
                                        <div class="aspect-square rounded-lg overflow-hidden bg-neutral-100">
                                            <img src="{{ $image }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="aspect-square rounded-lg bg-neutral-100 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-image text-4xl text-neutral-400 mb-2"></i>
                                <p class="text-neutral-500">無產品圖片</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- 產品資訊 --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-neutral-800">{{ $product->name }}</h2>
                            @if($product->sku)
                                <p class="text-neutral-500 mt-1">SKU: {{ $product->sku }}</p>
                            @endif
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 
                               ($product->status == 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $product->status_label }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- 基本資訊 --}}
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-800 mb-4">基本資訊</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-neutral-500">產品分類</dt>
                                    <dd class="text-sm text-neutral-900">{{ $product->category ?: '未分類' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-neutral-500">產品價格</dt>
                                    <dd class="text-lg font-bold text-primary-600">${{ number_format($product->price, 2) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-neutral-500">庫存數量</dt>
                                    <dd class="text-sm text-neutral-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $product->stock_status == 'in_stock' ? 'bg-green-100 text-green-800' : 
                                               ($product->stock_status == 'low_stock' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $product->stock }} 件
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        {{-- 系統資訊 --}}
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-800 mb-4">系統資訊</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-neutral-500">建立者</dt>
                                    <dd class="text-sm text-neutral-900">{{ $product->created_by ?: '未知' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-neutral-500">建立時間</dt>
                                    <dd class="text-sm text-neutral-900">{{ $product->created_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-neutral-500">最後更新</dt>
                                    <dd class="text-sm text-neutral-900">{{ $product->updated_at->format('Y-m-d H:i:s') }}</dd>
                                </div>
                                @if($product->updated_by)
                                    <div>
                                        <dt class="text-sm font-medium text-neutral-500">更新者</dt>
                                        <dd class="text-sm text-neutral-900">{{ $product->updated_by }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    {{-- 產品描述 --}}
                    @if($product->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-neutral-800 mb-3">產品描述</h3>
                            <div class="bg-neutral-50 rounded-lg p-4">
                                <p class="text-neutral-700 leading-relaxed">{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- 產品詳細內容 --}}
                    @if($product->detail)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-neutral-800 mb-3">產品詳細內容</h3>
                            <div class="bg-neutral-50 rounded-lg p-4">
                                <div class="text-neutral-700 leading-relaxed prose prose-sm max-w-none">
                                    {!! $product->detail !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- 操作按鈕 --}}
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-neutral-200">
                        <button onclick="deleteProduct({{ $product->id }})"
                                class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>刪除產品
                        </button>
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>編輯產品
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// 刪除產品功能
function deleteProduct(id) {
    if (confirm('確定要刪除這個產品嗎？此操作無法復原。')) {
        fetch(`/admin/products/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("products.index") }}';
            } else {
                alert('刪除失敗：' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('刪除失敗，請稍後再試');
        });
    }
}
</script>
@endsection
