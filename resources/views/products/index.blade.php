@extends('layouts.main')

@section('title', '產品列表 - TW_Zapier')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- 頁面標題 --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-neutral-800 mb-2">產品列表</h1>
        <p class="text-neutral-600">探索我們精選的優質產品</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- 側邊分類選單 --}}
        <div class="lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-neutral-800 mb-4">
                    <i class="fas fa-list mr-2 text-primary-500"></i>產品分類
                </h3>

                {{-- 所有產品 --}}
                <div class="mb-4">
                    <a href="{{ route('products.index') }}"
                       class="flex items-center px-3 py-2 rounded-lg transition-colors duration-200 {{ !request('classid') && !request('level') ? 'bg-primary-100 text-primary-700 font-medium' : 'text-neutral-600 hover:bg-neutral-50' }}">
                        <i class="fas fa-th-large mr-2 text-sm"></i>
                        所有產品
                    </a>
                </div>

                {{-- 分類樹狀結構 --}}
                <div class="space-y-1">
                    @foreach($categories->whereIn('uplink', [null, 0]) as $parentCategory)
                        <div class="mb-3">
                            {{-- 父分類 --}}
                            <a href="{{ route('products.index', ['level' => 1, 'classid' => $parentCategory->classid]) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg transition-colors duration-200 {{ request('level') == 1 && request('classid') == $parentCategory->classid ? 'bg-primary-100 text-primary-700 font-medium' : 'text-neutral-700 hover:bg-neutral-50 font-medium' }}">
                                <span>
                                    <i class="fas fa-folder mr-2 text-sm"></i>
                                    {{ $parentCategory->cname }}
                                </span>
                                @if($parentCategory->children->count() > 0)
                                    <i class="fas fa-chevron-down text-xs"></i>
                                @endif
                            </a>

                            {{-- 子分類 --}}
                            @if($parentCategory->children->count() > 0)
                                <div class="ml-4 mt-1 space-y-1">
                                    @foreach($parentCategory->children->sortBy('sort') as $childCategory)
                                        <a href="{{ route('products.index', ['classid' => $childCategory->classid]) }}"
                                           class="flex items-center px-3 py-2 rounded-lg transition-colors duration-200 {{ request('classid') == $childCategory->classid && !request('level') ? 'bg-primary-50 text-primary-600' : 'text-neutral-600 hover:bg-neutral-50' }}">
                                            <i class="fas fa-tag mr-2 text-xs"></i>
                                            {{ $childCategory->cname }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 主要內容區 --}}
        <div class="flex-1">

            {{-- 搜尋和篩選區 --}}
            <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6 mb-8">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4">

                    {{-- 關鍵字搜尋 --}}
                    <div class="flex-1">
                        <label for="search_name" class="block text-sm font-medium text-neutral-700 mb-2">搜尋產品</label>
                        <input type="text"
                               id="search_name"
                               name="search_name"
                               value="{{ request('search_name') }}"
                               placeholder="輸入產品名稱..."
                               class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>

                    {{-- 快速分類篩選 --}}
                    <div class="md:w-48">
                        <label for="classid" class="block text-sm font-medium text-neutral-700 mb-2">快速篩選</label>
                        <select name="classid"
                                id="classid"
                                class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">所有分類</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->classid }}" {{ request('classid') == $category->classid ? 'selected' : '' }}>
                                    {{ $category->parent ? '　└ ' : '' }}{{ $category->cname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 搜尋按鈕 --}}
                    <div class="md:w-32 flex items-end">
                        <button type="submit"
                                class="w-full bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>搜尋
                        </button>
                    </div>

                </form>
            </div>

            {{-- 產品列表 --}}
            @include('partials.product-list', ['products' => $products])

        </div>

    </div>

</div>
@endsection
