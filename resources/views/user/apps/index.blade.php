@extends('layouts.user')

@section('title', '應用程式 - TW_Zapier')

@section('content')
    <!-- Hero Section -->
    <div class="hero border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <div
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-100 opacity-110 text-white mb-6 shadow-sm">
                    <svg class="block" width="104" height="28" viewBox="0 0 244 66" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <!-- z -->
                        <path
                            d="M57.1877 45.2253L57.1534 45.1166L78.809 25.2914V15.7391H44.0663V25.2914H64.8181L64.8524 25.3829L43.4084 45.2253V54.7775H79.1579V45.2253H57.1877Z"
                            fill="#86735E" />
                        <!-- a -->
                        <path
                            d="M100.487 14.8297C96.4797 14.8297 93.2136 15.434 90.6892 16.6429C88.3376 17.6963 86.3568 19.4321 85.0036 21.6249C83.7091 23.8321 82.8962 26.2883 82.6184 28.832L93.1602 30.3135C93.5415 28.0674 94.3042 26.4754 95.4482 25.5373C96.7486 24.5562 98.3511 24.0605 99.9783 24.136C102.118 24.136 103.67 24.7079 104.634 25.8519C105.59 26.9959 106.076 28.5803 106.076 30.6681V31.7091H95.9401C90.7807 31.7091 87.0742 32.8531 84.8206 35.1411C82.5669 37.429 81.442 40.4492 81.4458 44.2014C81.4458 48.0452 82.5707 50.9052 84.8206 52.7813C87.0704 54.6574 89.8999 55.5897 93.3089 55.5783C97.5379 55.5783 100.791 54.1235 103.067 51.214C104.412 49.426 105.372 47.3793 105.887 45.2024H106.27L107.723 54.7546H117.275V30.5651C117.275 25.5659 115.958 21.6936 113.323 18.948C110.688 16.2024 106.409 14.8297 100.487 14.8297ZM103.828 44.6475C102.312 45.9116 100.327 46.5408 97.8562 46.5408C95.8199 46.5408 94.4052 46.1843 93.6121 45.4712C93.2256 45.1338 92.9182 44.7155 92.7116 44.246C92.505 43.7764 92.4043 43.2671 92.4166 42.7543C92.3941 42.2706 92.4702 41.7874 92.6403 41.3341C92.8104 40.8808 93.071 40.4668 93.4062 40.1174C93.7687 39.7774 94.1964 39.5145 94.6633 39.3444C95.1303 39.1743 95.6269 39.1006 96.1231 39.1278H106.093V39.7856C106.113 40.7154 105.919 41.6374 105.527 42.4804C105.134 43.3234 104.553 44.0649 103.828 44.6475Z"
                            fill="#86735E" />
                        <!-- p -->
                        <path
                            d="M146.201 14.6695C142.357 14.6695 139.268 15.8764 136.935 18.2902C135.207 20.0786 133.939 22.7479 133.131 26.2981H132.771L131.295 15.7563H121.657V66H132.942V45.3054H133.354C133.698 46.6852 134.181 48.0267 134.795 49.3093C135.75 51.3986 137.316 53.1496 139.286 54.3314C141.328 55.446 143.629 56.0005 145.955 55.9387C150.68 55.9387 154.277 54.0988 156.748 50.419C159.219 46.7392 160.455 41.6046 160.455 35.0153C160.455 28.6509 159.259 23.6689 156.869 20.0691C154.478 16.4694 150.922 14.6695 146.201 14.6695ZM147.345 42.9602C146.029 44.8668 143.97 45.8201 141.167 45.8201C140.012 45.8735 138.86 45.6507 137.808 45.1703C136.755 44.6898 135.832 43.9656 135.116 43.0574C133.655 41.2233 132.927 38.7122 132.931 35.5243V34.7807C132.931 31.5432 133.659 29.0646 135.116 27.3448C136.572 25.625 138.59 24.7747 141.167 24.7937C144.02 24.7937 146.092 25.6994 147.385 27.5107C148.678 29.322 149.324 31.8483 149.324 35.0896C149.332 38.4414 148.676 41.065 147.356 42.9602H147.345Z"
                            fill="#86735E" />
                        <!-- i 身-->
                        <path d="M175.035 15.7391H163.75V54.7833H175.035V15.7391Z" fill="#86735E" />
                        <!-- i 頭 -->
                        <path
                            d="M169.515 0.00366253C168.666 -0.0252113 167.82 0.116874 167.027 0.421484C166.234 0.726094 165.511 1.187 164.899 1.77682C164.297 2.3723 163.824 3.08658 163.512 3.87431C163.2 4.66204 163.055 5.50601 163.086 6.35275C163.056 7.20497 163.201 8.05433 163.514 8.84781C163.826 9.64129 164.299 10.3619 164.902 10.9646C165.505 11.5673 166.226 12.0392 167.02 12.3509C167.814 12.6626 168.663 12.8074 169.515 12.7762C170.362 12.8082 171.206 12.6635 171.994 12.3514C172.782 12.0392 173.496 11.5664 174.091 10.963C174.682 10.3534 175.142 9.63077 175.446 8.83849C175.75 8.04621 175.89 7.20067 175.859 6.35275C175.898 5.50985 175.761 4.66806 175.456 3.88115C175.151 3.09424 174.686 2.37951 174.09 1.78258C173.493 1.18565 172.779 0.719644 171.992 0.414327C171.206 0.109011 170.364 -0.0288946 169.521 0.00938803L169.515 0.00366253Z"
                            fill="#86735E" />
                        <!-- e -->
                        <path
                            d="M208.473 17.0147C205.839 15.4474 202.515 14.6657 198.504 14.6695C192.189 14.6695 187.247 16.4675 183.678 20.0634C180.108 23.6593 178.324 28.6166 178.324 34.9352C178.233 38.7553 179.067 42.5407 180.755 45.9689C182.3 49.0238 184.706 51.5592 187.676 53.2618C190.665 54.9892 194.221 55.8548 198.344 55.8586C201.909 55.8586 204.887 55.3095 207.278 54.2113C209.526 53.225 211.483 51.6791 212.964 49.7211C214.373 47.7991 215.42 45.6359 216.052 43.3377L206.329 40.615C205.919 42.1094 205.131 43.4728 204.041 44.5732C202.942 45.6714 201.102 46.2206 198.521 46.2206C195.451 46.2206 193.163 45.3416 191.657 43.5837C190.564 42.3139 189.878 40.5006 189.575 38.1498H216.201C216.31 37.0515 216.367 36.1306 216.367 35.387V32.9561C216.431 29.6903 215.757 26.4522 214.394 23.4839C213.118 20.7799 211.054 18.5248 208.473 17.0147ZM198.178 23.9758C202.754 23.9758 205.348 26.2275 205.962 30.731H189.775C190.032 29.2284 190.655 27.8121 191.588 26.607C193.072 24.8491 195.268 23.972 198.178 23.9758Z"
                            fill="#86735E" />
                        <!-- r -->
                        <path
                            d="M241.666 15.7391C238.478 15.7391 235.965 16.864 234.127 19.1139C232.808 20.7307 231.805 23.1197 231.119 26.2809H230.787L229.311 15.7391H219.673V54.7775H230.959V34.7578C230.959 32.2335 231.55 30.2982 232.732 28.9521C233.914 27.606 236.095 26.933 239.275 26.933H243.559V15.7391H241.666Z"
                            fill="#86735E" />
                        <!-- _ -->
                        <path d="M39.0441 45.2253H0V54.789H39.0441V45.2253Z" fill="#A86F4B" />
                    </svg>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Connect your apps
                    <p class="text-accent-orange">Automate your work</p>
                </h1>
                <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                    從 <span class="font-semibold text-accent-orange">{{ $apps->total() }}</span>
                    個應用程式中選擇，建立強大的自動化工作流程，讓工作更有效率
                </p>

                <!-- Search Bar -->
                {{-- <div class="max-w-2xl mx-auto rounded-xs">
                    <form method="GET" action="{{ route('user.apps.index') }}" class="relative">
                        <div class="search-container relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ $search }}" placeholder="搜尋應用程式..."
                                class="w-full pl-12 pr-16 py-4 text-gray-900 bg-white border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-accent-orange focus:border-accent-orange text-lg shadow-sm transition-all duration-300">
                            <button type="submit"
                                class="absolute right-2 top-2 bg-accent-orange hover:bg-accent-ball text-white px-6 py-2 rounded-sm transition-all duration-200 hover:shadow-sm transform hover:scale-105 z-10">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div> --}}

                <!-- 新版 Search Bar - CodePen 動畫風格（符合專案配色） -->
                <div class="max-w-2xl mx-auto">
                    <form method="GET" action="{{ route('user.apps.index') }}" class="relative" role="search" aria-label="搜尋應用程式">
                        <div class="codepen-search-bar relative">
                            <!-- SVG 動畫邊框 -->
                            <svg width="100%" height="100%" viewBox="0 0 400 60" class="search-border" preserveAspectRatio="none">
                                <polyline points="399,1 399,59 1,59 1,1 399,1" class="bg-line" />
                                <polyline points="399,1 399,59 1,59 1,1 399,1" class="hl-line" />
                                {{-- <polyline points="399.5,0.5 399.5,59.5 0.5,59.5 0.5,0.5 399.5,0.5" class="bg-line" vector-effect="non-scaling-stroke" />
                                <polyline points="399.5,0.5 399.5,59.5 0.5,59.5 0.5,0.5 399.5,0.5" class="hl-line" vector-effect="non-scaling-stroke" /> --}}
                            </svg>

                            <!-- 左側搜尋圖示 -->
                            <div class="search-icon">
                                <i class="fas fa-search text-neutral-400"></i>
                            </div>

                            <!-- 輸入框 -->
                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="搜尋應用程式..."
                                class="search-input"
                                aria-label="搜尋輸入框"
                            />

                            <!-- 送出按鈕 -->
                            <button type="submit" class="search-button" aria-label="送出搜尋">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Main Content with Sidebar -->
    <div class="bg-header-bg min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Accordion Sidebar -->
                <div class="lg:col-span-1 mb-8 lg:mb-0">
                    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden shadow-sm">
                        <!-- Sidebar Header -->
                        <div class="px-6 py-5 bg-gradient-to-r from-accent-orange to-accent-ball">
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
                                        <i
                                            class="fas fa-th-large {{ (!$category || $category === 'all') ? 'text-white' : 'text-neutral-400' }}"></i>
                                        <span class="font-medium">全部應用程式</span>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ (!$category || $category === 'all') ? 'bg-white bg-opacity-20 text-neutral-700' : 'bg-neutral-100 text-neutral-600' }}">
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
                                            <i
                                                class="{{ $categoryIcons[$cat] ?? 'fas fa-cube' }} {{ $category === $cat ? 'text-white' : 'text-neutral-400' }}"></i>
                                            <span class="font-medium hover:text-primary-100 transition-colors">{{ $cat }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category === $cat ? 'bg-white bg-opacity-20 text-neutral-700' : 'bg-neutral-100 text-neutral-600' }}">
                                                {{ $categoryStats[$cat] ?? 0 }}
                                            </span>
                                            <i
                                                class="fas fa-chevron-down accordion-icon transition-transform duration-200 {{ $category === $cat ? 'text-white' : 'text-neutral-400' }}"></i>
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
                                                                <img src="{{ $app->images[0] }}" alt="{{ $app->name }}"
                                                                    class="w-4 h-4 rounded">
                                                            @else
                                                                <div class="w-4 h-4 bg-neutral-200 rounded"></div>
                                                            @endif
                                                            <span class="truncate">{{ $app->name }}</span>
                                                        </a>
                                                    @endforeach
                                                    @if($categoryStats[$cat] > 3)
                                                        <p class="text-xs text-neutral-400 mt-1 px-2">還有
                                                            {{ $categoryStats[$cat] - 3 }} 個應用程式...</p>
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
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($apps as $app)
                                <div
                                    class="group bg-white border border-gray-200 rounded-xs shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden relative">
                                    <!-- Stretched Link -->
                                    <a href="{{ route('user.apps.show', $app->id) }}" class="stretched-link"
                                        aria-label="查看 {{ $app->name }} 詳情"></a>

                                    <!-- App Icon -->
                                    <div class="p-6 pb-4">
                                        <div class="flex items-start space-x-4">
                                            @if($app->images && count(json_decode($app->images, true)) > 0)
                                                @php $images = json_decode($app->images, true); @endphp
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $images[0] }}" alt="{{ $app->name }}"
                                                        class="w-14 h-14 rounded-xl object-cover shadow-sm">
                                                </div>
                                            @else
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-14 h-14 bg-gradient-to-br from-accent-orange to-accent-ball rounded-xl flex items-center justify-center shadow-sm">
                                                        <i class="fas fa-cube text-white text-xl"></i>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="flex-1 min-w-0">
                                                <h3
                                                    class="text-lg font-semibold text-gray-900 truncate group-hover:text-accent-orange transition-colors duration-200">
                                                    {{ $app->name }}</h3>
                                                <p class="text-sm text-gray-500 mt-1">{{ $app->category }}</p>

                                                <!-- Rating and Price -->
                                                <div class="flex items-center space-x-3 mt-2">
                                                    @if($app->price == 0)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            免費
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            ${{ number_format($app->price, 0) }}
                                                        </span>
                                                    @endif

                                                    @if($app->rating ?? false)
                                                        <div class="flex items-center">
                                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                            <span
                                                                class="text-xs text-gray-600 ml-1">{{ number_format($app->rating, 1) }}</span>
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


                                                <!-- 加入收藏按鈕 -->
                                                <button
                                                    onclick="toggleWishlist({{ $app->id }}, this)"
                                                    class="wishlist-btn inline-flex items-center px-3 py-2 bg-white hover:bg-red-50 text-gray-600 hover:text-accent-red text-sm font-medium border border-gray-300 hover:border-red-300 rounded-xs transition-all duration-200 relative z-10 {{ in_array($app->id, $userWishlist) ? 'wishlisted' : '' }}"
                                                    data-product-id="{{ $app->id }}"
                                                    data-wishlisted="{{ in_array($app->id, $userWishlist) ? 'true' : 'false' }}"
                                                    title="{{ in_array($app->id, $userWishlist) ? '移除收藏' : '加入收藏' }}"> 
                                                    <i class="ml-1 fas fa-heart {{ in_array($app->id, $userWishlist) ? 'text-accent-red' : '' }}"></i>
                                                    <span class="btn-text ml-1">{{ in_array($app->id, $userWishlist) ? '已收藏' : '' }}</span>
                                                </button>
                                            </div>

                                            <a href="{{ route('user.apps.integrations', $app->id) }}" target="_blank"
                                                class="inline-flex items-center px-4 py-2 bg-accent-orange hover:bg-accent-ball text-white text-sm font-medium rounded-xs transition-all duration-200 hover:shadow-sm transform hover:scale-105 relative z-10">
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
                            <div
                                class="w-24 h-24 bg-neutral-100 border border-neutral-200 rounded-full flex items-center justify-center mx-auto mb-6">
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
                            <div
                                class="group p-8 bg-white border border-gray-200 rounded-xl hover:border-accent-orange hover:shadow-lg transition-all duration-300 transform hover:scale-105 relative">
                                <a href="{{ route('user.apps.index', ['category' => $cat]) }}" class="stretched-link"
                                    aria-label="查看 {{ $cat }} 分類"></a>
                                <div class="text-center">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-accent-orange to-accent-ball rounded-xl flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg transition-all duration-300">
                                        <i class="fas fa-th-large text-white text-xl"></i>
                                    </div>
                                    <h3
                                        class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-accent-orange transition-colors duration-200">
                                        {{ $cat }}</h3>
                                    <p class="text-sm text-gray-600">{{ $categoryStats[$cat] ?? 0 }} 個應用程式</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
@endsection

    @push('styles')
        <style>
            .hero {
                background-image:
                    linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(134, 115, 94, 0.1) 100%),
                    url('https://res.cloudinary.com/zapier-media/image/upload/f_auto/q_auto/v1745435119/product-gallery-background_ed59bc.jpg');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
            }

            /* 確保文字在背景圖片上清晰可見 */
            .hero .text-center {
                position: relative;
                z-index: 2;
            }

            /* Stretched Link Styles - Bootstrap-like */
            .stretched-link::after {
                position: absolute !important;
                top: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                z-index: 1 !important;
                content: "" !important;
                pointer-events: auto !important;
            }

            /* Ensure parent container has relative positioning */
            .relative {
                position: relative !important;
            }

            /* Hover effects for stretched link cards */
            .relative:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                cursor: pointer;
            }

            .relative {
                transition: all 0.3s ease;
            }

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
                /* background-color: #f97316 !important; */
                /* color: white !important; */
            }

            .accordion-item:hover .accordion-header.bg-accent-orange i,
            .accordion-item:hover .accordion-header.bg-accent-orange .inline-flex,
            .accordion-header.bg-accent-orange i,
            .accordion-header.bg-accent-orange .inline-flex {
                background-color: rgba(249, 115, 22, 0) !important;
                color: rgb(255, 255, 255) !important;
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
                /* color: white !important; */
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
            .accordion-content>div {
                transform: translateY(-10px);
                transition: transform 0.3s ease-out;
            }

            .accordion-content.show>div {
                transform: translateY(0);
            }

            /* 改善手風琴項目的視覺層次 */
            .accordion-item {
                position: relative;
                overflow: hidden;
            }

            .accordion-item::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 4px;
                background: transparent;
                transition: background-color 0.3s ease;
            }

            .accordion-item:has(.accordion-header.bg-accent-orange)::before {
                background: linear-gradient(to bottom, #C07F56, #bd743a);
            }

            /* 改善分類應用程式列表的樣式 */
            .accordion-content .space-y-2 a:hover {
                transform: translateX(4px);
                transition: transform 0.2s ease;
            }

            /* CodePen 風格搜尋欄樣式 */
            .codepen-search-bar {
                width: 100%;
                height: 60px;
                position: relative;
                font-family: inherit;
            }
            .codepen-search-bar .search-border {
                position: absolute;
                inset: 0;
                fill: none;
                stroke-width: 1;
                pointer-events: none;
            }
            .codepen-search-bar { --sb-inset: 10px; }
            .codepen-search-bar .bg-line {
                fill: rgba(255, 255, 255, 0);
                stroke: rgba(236, 233, 223, 0.5);
                transition: all .8s ease-in-out;
            }

            .codepen-search-bar .hl-line {
                stroke: #ffffff; /* accent-amber 對應值 */
                stroke-dasharray: 40 480;
                stroke-dashoffset: 40;
                transition: all .8s ease-in-out;
            }
            .codepen-search-bar:hover .bg-line {
                fill: rgba(255, 253, 249, 0.1);
            }
            
            .codepen-search-bar .hl-line { 
                opacity: 0; 
            }
            .codepen-search-bar:hover .bg-line,
            .codepen-search-bar:focus-within .bg-line { 
                opacity: 1; 
            }
            
            .codepen-search-bar:hover .hl-line,
            .codepen-search-bar:focus-within .hl-line {
                stroke-dashoffset: -480;
                opacity: 1;
            }
            .search-input {
                position: absolute;
                top: var(--sb-inset);
                left: var(--sb-inset);
                right: var(--sb-inset);
                bottom: var(--sb-inset);
                width: auto;
                height: auto;
                padding-left: calc(2.75rem);
                padding-right: calc(3.75rem);
                border: none;
                background: transparent;
                color: #201515;
                font-size: 1.125rem;
                border-radius: 0.25rem;
                outline: none;
            }
            .search-icon {
                position: absolute;
                top: var(--sb-inset);
                bottom: var(--sb-inset);
                left: calc(var(--sb-inset) + 10px);
                display: flex;
                align-items: center;
                pointer-events: none;
                z-index: 10;
            }
            
            .search-input::placeholder {
                color: #6C604D; /* accent gray */
            }
            .search-button {
                position: absolute;
                right: var(--sb-inset);
                top: var(--sb-inset);
                bottom: var(--sb-inset);
                height: auto;
                padding: 0 1rem;
                background: #C07F56;
                color: #fff;
                border: none;
                border-radius: 0.125rem;
                cursor: pointer;
                transition: all .2s ease;
                z-index: 10;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .search-button:hover {
                background: #bd743a; /* accent-ball */
                transform: scale(1.05);
                box-shadow: 0 4px 12px rgba(192, 127, 86, 0.3);
            }

                transition: transform 0.2s ease;
            }

            /* 添加載入動畫 */
            .accordion-content.show {
                animation: accordionSlideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* 改善搜尋框樣式 */
            .search-container {
                position: relative;
            }

            .search-container::before {
                content: '';
                position: absolute;
                inset: -2px;
                background: linear-gradient(45deg, #C07F56, #bd743a);
                border-radius: 8px;
                opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
                z-index: -1;
            }

            .search-container:focus-within::before {
                opacity: 1;
            }

            .search-container input:focus {
                border-color: transparent;
                box-shadow: 0 0 0 2px rgba(192, 127, 86, 0.2);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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
                    header.addEventListener('click', function (e) {
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

                // 根據 URL 參數自動展開對應分類
                function autoExpandCategory() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const categoryParam = urlParams.get('category');

                    if (categoryParam && categoryParam !== 'all') {
                        // 找到對應的手風琴項目
                        const accordionHeaders = document.querySelectorAll('.accordion-header');

                        accordionHeaders.forEach((header, index) => {
                            const categoryText = header.querySelector('span').textContent.trim();

                            if (categoryText === categoryParam) {
                                // 展開對應的分類
                                const targetId = header.getAttribute('data-target');
                                const content = document.getElementById(targetId);
                                const icon = header.querySelector('.accordion-icon');

                                if (content && icon) {
                                    // 顯示內容
                                    content.classList.add('show');
                                    content.style.display = 'block';

                                    // 旋轉圖標
                                    icon.classList.add('rotated');

                                    // 添加活動狀態
                                    header.classList.remove('text-neutral-700', 'hover:bg-gray-50');
                                    header.classList.add('bg-accent-orange', 'text-white');

                                    // 更新圖標顏色
                                    const icons = header.querySelectorAll('i:not(.accordion-icon)');
                                    icons.forEach(i => {
                                        i.classList.remove('text-neutral-400');
                                        i.classList.add('text-white');
                                    });

                                    // 更新徽章樣式
                                    const badge = header.querySelector('.inline-flex');
                                    if (badge) {
                                        badge.classList.remove('bg-neutral-100', 'text-neutral-600');
                                        badge.classList.add('bg-white', 'bg-opacity-20', 'text-white');
                                    }

                                    console.log(`自動展開分類: ${categoryParam}`);
                                }
                            }
                        });
                    }
                }

                // 執行自動展開
                autoExpandCategory();

                console.log('手風琴初始化完成 - 根據 URL 參數自動展開分類');

                // Stretched-link 功能
                function initStretchedLinks() {
                    const stretchedLinks = document.querySelectorAll('.stretched-link');

                    stretchedLinks.forEach(link => {
                        const parentCard = link.closest('.relative');
                        if (parentCard) {
                            // 移除現有的點擊事件監聽器（如果有的話）
                            parentCard.removeEventListener('click', parentCard._stretchedLinkHandler);

                            // 創建新的點擊事件處理器
                            const clickHandler = (event) => {
                                // 檢查點擊的目標是否是整合按鈕或其子元素
                                const integrationButton = event.target.closest('.z-10');
                                if (integrationButton) {
                                    // 如果點擊的是整合按鈕，讓它正常處理
                                    return;
                                }

                                // 否則導航到 stretched-link 的 URL
                                event.preventDefault();
                                window.location.href = link.href;
                            };

                            // 添加點擊事件監聽器
                            parentCard.addEventListener('click', clickHandler);
                            parentCard._stretchedLinkHandler = clickHandler;

                            // 添加 cursor pointer 樣式
                            parentCard.style.cursor = 'pointer';
                        }
                    });

                    console.log(`已為 ${stretchedLinks.length} 個 stretched-link 添加點擊功能`);
                }

                // 初始化 stretched-link
                initStretchedLinks();
            });

            // 心願清單功能
            function toggleWishlist(productId, button) {
                // 防止事件冒泡到父元素
                event.stopPropagation();

                const btnText = button.querySelector('.btn-text');
                const btnIcon = button.querySelector('i');
                const isWishlisted = button.dataset.wishlisted === 'true';
                const originalText = btnText.textContent;

                // 設置載入狀態
                button.disabled = true;
                btnText.textContent = '處理中...';
                btnIcon.className = 'fas fa-spinner fa-spin';

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
                            btnText.textContent = '';
                            btnIcon.className = 'fas fa-heart';
                            btnIcon.classList.remove('text-accent-red');
                            button.classList.remove('wishlisted');
                            button.dataset.wishlisted = 'false';
                            button.title = '加入收藏';
                        } else {
                            // 加入收藏成功
                            btnText.textContent = '已收藏';
                            btnIcon.className = 'fas fa-heart text-accent-red';
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
                    btnIcon.className = 'fas fa-heart text-accent-red';
                } else {
                    btnIcon.className = 'fas fa-heart';
                    btnIcon.classList.remove('text-accent-red');
                }
            }

            function showMessage(message, type) {
                // 創建訊息元素
                const messageDiv = document.createElement('div');
                messageDiv.className = `fixed top-15 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

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