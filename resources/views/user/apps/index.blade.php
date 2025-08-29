@extends('layouts.user')

@section('title', '應用程式 - TW_Zapier')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-white to-gray-50 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-accent-orange text-white mb-6 shadow-sm">
                <i class="fas fa-bolt mr-2"></i>
                自動化流程平台
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                連接您最愛的
                <span class="text-accent-orange">應用程式</span>
            </h1>
            <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                從 <span class="font-semibold text-accent-orange">{{ $apps->total() }}</span> 個應用程式中選擇，建立強大的自動化工作流程，讓工作更有效率
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <form method="GET" action="{{ route('user.apps.index') }}" class="relative">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                               name="search"
                               value="{{ $search }}"
                               placeholder="搜尋應用程式..."
                               class="w-full pl-12 pr-16 py-4 text-gray-900 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-orange focus:border-accent-orange text-lg shadow-sm">
                        <button type="submit"
                                class="absolute right-2 top-2 bg-accent-orange hover:bg-accent-brown text-white px-6 py-2 rounded-lg transition-all duration-200 hover:shadow-sm transform hover:scale-105">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Main Content with Sidebar -->
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Accordion Sidebar -->
            <div class="lg:col-span-1 mb-8 lg:mb-0">
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <!-- Sidebar Header -->
                    <div class="px-6 py-5 bg-gradient-to-r from-accent-orange to-accent-brown">
                        <h3 class="text-lg font-semibold text-white">應用程式分類</h3>
                        <p class="text-sm text-orange-100 mt-1">選擇分類來篩選應用程式</p>
                    </div>

                <!-- Accordion Menu -->
                <div class="divide-y divide-neutral-200">
                    <!-- All Apps Item -->
                    <div class="accordion-item">
                        <a href="{{ route('user.apps.index', array_merge(request()->query(), ['category' => 'all'])) }}"
                           class="all-apps-link flex items-center justify-between px-6 py-4 transition-colors duration-200 {{ (!$category || $category === 'all') ? 'bg-accent-orange text-white' : 'text-neutral-700 hover:bg-gray-50' }}">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-th-large {{ (!$category || $category === 'all') ? 'text-white' : 'text-neutral-400' }}"></i>
                                <span class="font-medium">全部應用程式</span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ (!$category || $category === 'all') ? 'bg-white bg-opacity-20 text-white' : 'bg-neutral-100 text-neutral-600' }}">
                                {{ $apps->total() }}
                            </span>
                        </a>
                    </div>

                    <!-- Category Accordion Items -->
                    @php
                        $categoryIcons = [
                            'IT 營運工具' => 'fas fa-server',
                            '人工智慧' => 'fas fa-robot',
                            '內容與檔案管理' => 'fas fa-folder',
                            '客戶支援' => 'fas fa-headset',
                            '生產力工具' => 'fas fa-tasks',
                            '行銷推廣' => 'fas fa-bullhorn',
                            '通訊協作' => 'fas fa-comments',
                            '銷售與客戶關係管理' => 'fas fa-chart-line'
                        ];
                    @endphp

                    @foreach($categories as $cat)
                        <div class="accordion-item">
                            <button type="button"
                                    class="accordion-header w-full flex items-center justify-between px-6 py-4 text-left transition-colors duration-200 {{ $category === $cat ? 'bg-accent-orange text-white' : 'text-neutral-700 hover:bg-gray-50' }}"
                                    data-target="category-{{ $loop->index }}">
                                <div class="flex items-center space-x-3">
                                    <i class="{{ $categoryIcons[$cat] ?? 'fas fa-cube' }} {{ $category === $cat ? 'text-white' : 'text-neutral-400' }}"></i>
                                    <span class="font-medium hover:text-accent-orange transition-colors">{{ $cat }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category === $cat ? 'bg-white bg-opacity-20 text-white' : 'bg-neutral-100 text-neutral-600' }}">
                                        {{ $categoryStats[$cat] ?? 0 }}
                                    </span>
                                    <i class="fas fa-chevron-down accordion-icon transition-transform duration-200 {{ $category === $cat ? 'text-white' : 'text-neutral-400' }}"></i>
                                </div>
                            </button>

                            <div id="category-{{ $loop->index }}" class="accordion-content">
                                <div class="px-6 py-3 bg-gray-50">
                                    <div class="space-y-2">
                                        <a href="{{ route('user.apps.index', array_merge(request()->query(), ['category' => $cat])) }}"
                                           class="flex items-center justify-between px-3 py-2 rounded-md text-sm hover:bg-white transition-colors duration-200 {{ $category === $cat ? 'bg-white text-accent-orange font-medium' : 'text-neutral-600 hover:text-neutral-900' }}">
                                            <span>查看所有 {{ $cat }}</span>
                                            <i class="fas fa-arrow-right text-xs"></i>
                                        </a>

                                        <div class="pt-2 border-t border-neutral-200">
                                            <p class="text-xs text-neutral-500 mb-2">此分類中的應用程式：</p>
                                            @php
                                                // 獲取該分類的應用程式
                                                $categoryApps = \App\Models\Product::where('category', $cat)->limit(3)->get();
                                            @endphp
                                            @foreach($categoryApps as $app)
                                                <a href="{{ route('user.apps.show', $app->id) }}"
                                                   class="flex items-center space-x-2 px-2 py-1 rounded text-xs text-neutral-600 hover:bg-white hover:text-neutral-900 transition-colors duration-200">
                                                    @if($app->images && count($app->images) > 0)
                                                        <img src="{{ $app->images[0] }}" alt="{{ $app->name }}" class="w-4 h-4 rounded">
                                                    @else
                                                        <div class="w-4 h-4 bg-neutral-200 rounded"></div>
                                                    @endif
                                                    <span class="truncate">{{ $app->name }}</span>
                                                </a>
                                            @endforeach
                                            @if($categoryStats[$cat] > 3)
                                                <p class="text-xs text-neutral-400 mt-1 px-2">還有 {{ $categoryStats[$cat] - 3 }} 個應用程式...</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Results Summary -->
                <div class="px-6 py-4 bg-gray-50 border-t border-neutral-200">
                    <div class="text-sm text-neutral-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        顯示 {{ $apps->firstItem() ?? 0 }} - {{ $apps->lastItem() ?? 0 }} 項，共 {{ $apps->total() }} 項結果
                    </div>
                </div>
            </div>
        </div>

        <!-- Apps Grid -->
        <div class="lg:col-span-3">
            @if($apps->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($apps as $app)
                <div class="group bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                    <!-- App Icon -->
                    <div class="p-6 pb-4">
                        <div class="flex items-start space-x-4">
                            @if($app->images && count(json_decode($app->images, true)) > 0)
                                @php $images = json_decode($app->images, true); @endphp
                                <div class="flex-shrink-0">
                                    <img src="{{ $images[0] }}"
                                         alt="{{ $app->name }}"
                                         class="w-14 h-14 rounded-xl object-cover shadow-sm">
                                </div>
                            @else
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-gradient-to-br from-accent-orange to-accent-brown rounded-xl flex items-center justify-center shadow-sm">
                                        <i class="fas fa-cube text-white text-xl"></i>
                                    </div>
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 truncate group-hover:text-accent-orange transition-colors duration-200">{{ $app->name }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $app->category }}</p>

                                <!-- Rating and Price -->
                                <div class="flex items-center space-x-3 mt-2">
                                    @if($app->price == 0)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            免費
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            ${{ number_format($app->price, 0) }}
                                        </span>
                                    @endif

                                    @if($app->rating ?? false)
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                            <span class="text-xs text-gray-600 ml-1">{{ number_format($app->rating, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- App Description -->
                    <div class="px-6 pb-6">
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-2">{{ $app->description }}</p>
                    </div>

                    <!-- App Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('user.apps.show', $app->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 hover:border-gray-400 rounded-lg transition-all duration-200 hover:shadow-sm">
                                    <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                                    查看詳情
                                </a>
                            </div>

                            <a href="{{ route('user.apps.integrations', $app->id) }}"
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-accent-orange hover:bg-accent-brown text-white text-sm font-medium rounded-lg transition-all duration-200 hover:shadow-sm transform hover:scale-105">
                                <i class="fas fa-plug mr-2"></i>
                                整合
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
                </div>

                <!-- Pagination -->
                @if($apps->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $apps->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-neutral-100 border border-neutral-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-neutral-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-neutral-900 mb-2">找不到相關應用程式</h3>
                    <p class="text-neutral-600 mb-6">請嘗試調整搜尋條件或瀏覽其他分類</p>
                    <a href="{{ route('user.apps.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-accent-orange hover:bg-accent-amber text-white border border-accent-orange hover:border-accent-amber transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        查看所有應用程式
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Popular Categories Section -->
@if(!$search && (!$category || $category === 'all'))
<div class="bg-gradient-to-br from-gray-50 to-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">熱門分類</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">探索不同類型的應用程式，找到最適合您的自動化解決方案</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($categories->take(8) as $cat)
                <a href="{{ route('user.apps.index', ['category' => $cat]) }}"
                   class="group p-8 bg-white border border-gray-200 rounded-xl hover:border-accent-orange hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-accent-orange to-accent-brown rounded-xl flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-th-large text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-accent-orange transition-colors duration-200">{{ $cat }}</h3>
                        <p class="text-sm text-gray-600">{{ $categoryStats[$cat] ?? 0 }} 個應用程式</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    /* Accordion Styles */
    .accordion-content {
        display: none !important;
    }

    .accordion-content.show {
        display: block !important;
        max-height: 600px;
        opacity: 1;
        animation: accordionSlideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes accordionSlideDown {
        from {
            max-height: 0;
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            max-height: 600px;
            opacity: 1;
            transform: translateY(0);
        }
    }

    .accordion-icon {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: center;
    }

    .accordion-icon.rotated {
        transform: rotate(180deg);
    }

    /* Hover effects */
    .accordion-item:hover .accordion-header:not(.bg-accent-orange) {
        background-color: rgba(0, 0, 0, 0.03);
    }

    /* Ensure active accordion items have orange background */
    .accordion-header.bg-accent-orange {
        background-color: #C07F56 !important;
        color: white !important;
    }

    /* Active accordion item hover - maintain orange background and white text */
    .accordion-item:hover .accordion-header.bg-accent-orange,
    .accordion-header.bg-accent-orange:hover {
        background-color: #C07F56 !important;
        color: white !important;
    }

    .accordion-item:hover .accordion-header.bg-accent-orange i,
    .accordion-item:hover .accordion-header.bg-accent-orange .inline-flex,
    .accordion-header.bg-accent-orange:hover i,
    .accordion-header.bg-accent-orange:hover .inline-flex {
        background-color: #f97316 !important;
        color: white !important;
    }

    /* Active all-apps link hover - maintain orange background and white text */
    .all-apps-link.bg-accent-orange {
        background-color: #C07F56 !important;
        color: white !important;
    }

    .all-apps-link.bg-accent-orange:hover {
        background-color: #C07F56 !important;
        color: white !important;
    }

    .all-apps-link.bg-accent-orange:hover i,
    .all-apps-link.bg-accent-orange:hover .inline-flex {
        color: white !important;
    }

    /* Active category styling */
    .accordion-header.active {
        background-color: #f97316 !important;
        color: white !important;
    }

    .accordion-header.active .accordion-icon,
    .accordion-header.active i:not(.accordion-icon) {
        color: white !important;
    }

    /* Smooth background transitions */
    .accordion-header {
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    /* Content animation improvements */
    .accordion-content > div {
        transform: translateY(-10px);
        transition: transform 0.3s ease-out;
    }

    .accordion-content.show > div {
        transform: translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 手風琴功能
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        // 初始化所有手風琴為關閉狀態
        document.querySelectorAll('.accordion-content').forEach(content => {
            content.classList.remove('show');
            content.style.display = 'none'; // 強制隱藏
        });

        // 初始化所有圖標為未旋轉狀態
        document.querySelectorAll('.accordion-icon').forEach(icon => {
            icon.classList.remove('rotated');
        });

        accordionHeaders.forEach(header => {
            header.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('data-target');
                const content = document.getElementById(targetId);
                const icon = this.querySelector('.accordion-icon');

                if (!content) return;

                // 檢查當前狀態
                const isOpen = content.classList.contains('show');

                // 如果點擊的是已展開的項目，直接收合它
                if (isOpen) {
                    // 關閉當前項目
                    content.classList.remove('show');
                    content.style.display = 'none';
                    if (icon) {
                        icon.classList.remove('rotated');
                    }
                    // 移除活動狀態
                    this.classList.remove('bg-accent-orange', 'text-white');
                    this.classList.add('text-neutral-700', 'hover:bg-gray-50');

                    // 更新圖標顏色
                    const icons = this.querySelectorAll('i:not(.accordion-icon)');
                    icons.forEach(i => {
                        i.classList.remove('text-white');
                        i.classList.add('text-neutral-400');
                    });

                    // 更新數量標籤
                    const badge = this.querySelector('.inline-flex');
                    if (badge) {
                        badge.classList.remove('bg-white', 'bg-opacity-20', 'text-white');
                        badge.classList.add('bg-neutral-100', 'text-neutral-600');
                    }
                    return; // 結束函數，不執行後續邏輯
                }

                // 如果點擊的是未展開的項目，先關閉所有其他項目
                document.querySelectorAll('.accordion-content').forEach(item => {
                    if (item.classList.contains('show')) {
                        item.classList.remove('show');
                        item.style.display = 'none';
                        const otherHeader = item.previousElementSibling;
                        const otherIcon = otherHeader.querySelector('.accordion-icon');
                        if (otherIcon) {
                            otherIcon.classList.remove('rotated');
                        }
                        // 移除活動狀態
                        otherHeader.classList.remove('bg-accent-orange', 'text-white');
                        otherHeader.classList.add('text-neutral-700', 'hover:bg-gray-50');

                        // 更新其他按鈕中的圖標顏色
                        const otherIcons = otherHeader.querySelectorAll('i:not(.accordion-icon)');
                        otherIcons.forEach(i => {
                            i.classList.remove('text-white');
                            i.classList.add('text-neutral-400');
                        });

                        // 更新數量標籤
                        const otherBadge = otherHeader.querySelector('.inline-flex');
                        if (otherBadge) {
                            otherBadge.classList.remove('bg-white', 'bg-opacity-20', 'text-white');
                            otherBadge.classList.add('bg-neutral-100', 'text-neutral-600');
                        }
                    }
                });

                // 同時移除「全部應用程式」的活動狀態
                const allAppsLink = document.querySelector('.all-apps-link');
                if (allAppsLink) {
                    allAppsLink.classList.remove('bg-accent-orange', 'text-white');
                    allAppsLink.classList.add('text-neutral-700', 'hover:bg-gray-50');

                    // 更新「全部應用程式」中的圖標顏色
                    const allAppsIcons = allAppsLink.querySelectorAll('i');
                    allAppsIcons.forEach(i => {
                        i.classList.remove('text-white');
                        i.classList.add('text-neutral-400');
                    });

                    // 更新「全部應用程式」的數量標籤
                    const allAppsBadge = allAppsLink.querySelector('.inline-flex');
                    if (allAppsBadge) {
                        allAppsBadge.classList.remove('bg-white', 'bg-opacity-20', 'text-white');
                        allAppsBadge.classList.add('bg-neutral-100', 'text-neutral-600');
                    }
                }

                // 展開當前項目
                content.style.display = 'block';
                content.classList.add('show');
                if (icon) {
                    icon.classList.add('rotated');
                }
                // 添加活動狀態
                this.classList.remove('text-neutral-700', 'hover:bg-gray-50');
                this.classList.add('bg-accent-orange', 'text-white');

                // 更新圖標顏色
                const icons = this.querySelectorAll('i:not(.accordion-icon)');
                icons.forEach(i => {
                    i.classList.remove('text-neutral-400');
                    i.classList.add('text-white');
                });

                // 更新數量標籤
                const badge = this.querySelector('.inline-flex');
                if (badge) {
                    badge.classList.remove('bg-neutral-100', 'text-neutral-600');
                    badge.classList.add('bg-white', 'bg-opacity-20', 'text-white');
                }
            });
        });

        // 不再自動展開任何分類，所有手風琴預設關閉
        console.log('手風琴初始化完成 - 所有項目預設關閉');
    });
</script>
@endpush

@push('scripts')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
