@extends('layouts.admin')

@section('title', '產品管理')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- 頁面標題和新增按鈕 --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">產品管理</h1>
            <p class="text-neutral-600 mt-2">管理系統產品資料與庫存</p>
        </div>
        <button onclick="openAddProductModal()"
               class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md transition-colors duration-200 shadow-sm">
            <i class="fas fa-plus mr-2"></i>新增產品
        </button>
    </div>

    {{-- 搜尋和篩選區域 --}}
    <div class="bg-white rounded-md shadow-sm border border-neutral-200 p-6 mb-6">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- 搜尋框 --}}
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">搜尋產品</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="搜尋產品名稱、SKU或描述..."
                           class="w-full pl-10 pr-4 py-2.5 border border-neutral-200 rounded-md focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-neutral-400"></i>
                    </div>
                </div>
            </div>

            {{-- 分類篩選 --}}
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">產品分類</label>
                <select name="category" class="w-full px-3 py-2.5 border border-neutral-200 rounded-md focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">所有分類</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 狀態篩選 --}}
            <div>
                <label class="block text-sm font-medium text-neutral-700 mb-2">產品狀態</label>
                <select name="status" class="w-full px-3 py-2.5 border border-neutral-200 rounded-md focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">所有狀態</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>啟用</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>停用</option>
                    <option value="discontinued" {{ request('status') == 'discontinued' ? 'selected' : '' }}>停產</option>
                </select>
            </div>

            {{-- 搜尋按鈕 --}}
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>查詢
                </button>
            </div>
        </form>
    </div>

    {{-- 產品列表 --}}
    <div class="bg-white rounded-md shadow-sm border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">產品資訊</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">分類</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">價格</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">庫存</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">狀態</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">操作</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-neutral-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($product->main_image)
                                            <img class="h-12 w-12 rounded-md object-cover"
                                                 src="{{ $product->main_image }}"
                                                 alt="{{ $product->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-md bg-neutral-200 flex items-center justify-center">
                                                <i class="fas fa-image text-neutral-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900">{{ $product->name }}</div>
                                        @if($product->sku)
                                            <div class="text-sm text-neutral-500">SKU: {{ $product->sku }}</div>
                                        @endif
                                        @if($product->description)
                                            <div class="text-xs text-neutral-400 mt-1">{{ Str::limit($product->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-900">
                                {{ $product->category ?: '未分類' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-neutral-900">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium
                                    {{ $product->stock_status == 'in_stock' ? 'bg-green-50 text-green-700' : 
                                       ($product->stock_status == 'low_stock' ? 'bg-yellow-50 text-yellow-700' : 'bg-red-50 text-red-700') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium
                                    {{ $product->status == 'active' ? 'bg-green-50 text-green-700' : 
                                       ($product->status == 'inactive' ? 'bg-yellow-50 text-yellow-700' : 'bg-red-50 text-red-700') }}">
                                    {{ $product->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('products.show', $product->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-primary-100 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>檢視
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>編輯
                                    </a>
                                    <button onclick="deleteProduct({{ $product->id }})"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium rounded-md transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>刪除
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-neutral-500">
                                    <i class="fas fa-box-open text-4xl mb-4"></i>
                                    <p class="text-lg">尚無產品資料</p>
                                    <p class="text-sm">點擊上方「新增產品」按鈕來新增第一個產品</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 分頁 --}}
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-neutral-200">
                <div class="flex item-center justify-center flex-wrap mb-4">
                    <div class="flex-1 text-center">
                        <div class="text-sm text-neutral-600">
                            顯示第 {{ $products->firstItem() }} 到 {{ $products->lastItem() }} 項，共 {{ $products->total() }} 項
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center flex-wrap mb-3">
                    <nav class="flex-1 items-center space-x-1 flex-1 text-center">
                        {{-- 上一頁 --}}
                        @if($products->onFirstPage())
                            <span class="px-3 py-2 text-neutral-400 bg-neutral-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}"
                               class="px-3 py-2 text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 transition-colors duration-200">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- 頁碼 --}}
                        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if($page == $products->currentPage())
                                <span class="px-3 py-2 bg-primary-500 text-white rounded-lg font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                   class="px-3 py-2 text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 transition-colors duration-200">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- 下一頁 --}}
                        @if($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}"
                               class="px-3 py-2 text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 transition-colors duration-200">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="px-3 py-2 text-neutral-400 bg-neutral-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- 成功/錯誤訊息 --}}
@if(session('success'))
    <div id="success-message" class="fixed bottom-4 right-4 bg-green-50 border border-green-200 text-green-800 rounded-md p-4 shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div id="error-message" class="fixed bottom-4 right-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-4 shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
@endif

<script>
// 自動隱藏訊息
setTimeout(function() {
    const successMsg = document.getElementById('success-message');
    const errorMsg = document.getElementById('error-message');
    if (successMsg) successMsg.remove();
    if (errorMsg) errorMsg.remove();
}, 5000);

// 新增產品功能
function openAddProductModal() {
    window.location.href = '{{ route("products.create") }}';
}

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
                location.reload();
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
