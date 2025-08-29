@extends('layouts.user')

@section('title', $app->name . ' 整合 - TW_Zapier')

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
                        <a href="{{ route('user.apps.show', $app->id) }}" class="text-neutral-500 hover:text-neutral-700 transition-colors duration-200">
                            {{ $app->name }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-neutral-400 mx-2"></i>
                        <span class="text-neutral-900 font-medium">整合</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Header -->
<div class="bg-white border-b border-neutral-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <div class="flex items-center justify-center space-x-4 mb-6">
                @if($app->images && count($app->images) > 0)
                    <img src="{{ $app->images[0] }}"
                         alt="{{ $app->name }}"
                         class="w-16 h-16 rounded object-cover border border-neutral-200">
                @else
                    <div class="w-16 h-16 bg-accent-orange rounded flex items-center justify-center border border-neutral-200">
                        <i class="fas fa-cube text-white text-xl"></i>
                    </div>
                @endif
                <div class="text-4xl font-bold text-neutral-400">×</div>
                <div class="w-16 h-16 bg-neutral-100 rounded flex items-center justify-center border border-neutral-200">
                    <i class="fas fa-th-large text-neutral-600 text-xl"></i>
                </div>
            </div>

            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-4">
                {{ $app->name }} 整合
            </h1>
            <p class="text-xl text-neutral-600 mb-8 max-w-3xl mx-auto">
                將 {{ $app->name }} 與其他應用程式連接，建立強大的自動化工作流程
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <button class="inline-flex items-center px-6 py-3 bg-accent-orange hover:bg-accent-amber text-white font-semibold border border-accent-orange hover:border-accent-amber transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    建立新的整合
                </button>
                <button class="inline-flex items-center px-6 py-3 bg-white hover:bg-neutral-50 text-neutral-700 font-semibold border border-neutral-300 hover:border-neutral-400 transition-colors duration-200">
                    <i class="fas fa-book mr-2"></i>
                    查看文件
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Integration Features -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">整合功能</h2>
            <p class="text-lg text-gray-600">{{ $app->name }} 支援的觸發器和動作</p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Triggers -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-8 border border-green-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-play text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">觸發器</h3>
                        <p class="text-sm text-gray-600">當這些事件發生時啟動工作流程</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-green-200">
                        <i class="fas fa-plus-circle text-green-600"></i>
                        <div>
                            <div class="font-medium text-gray-900">新資料建立</div>
                            <div class="text-sm text-gray-600">當 {{ $app->name }} 中建立新記錄時觸發</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-green-200">
                        <i class="fas fa-edit text-green-600"></i>
                        <div>
                            <div class="font-medium text-gray-900">資料更新</div>
                            <div class="text-sm text-gray-600">當現有記錄被修改時觸發</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-green-200">
                        <i class="fas fa-trash text-green-600"></i>
                        <div>
                            <div class="font-medium text-gray-900">資料刪除</div>
                            <div class="text-sm text-gray-600">當記錄被刪除時觸發</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-green-200">
                        <i class="fas fa-clock text-green-600"></i>
                        <div>
                            <div class="font-medium text-gray-900">定時觸發</div>
                            <div class="text-sm text-gray-600">按照設定的時間間隔觸發</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-8 border border-blue-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cog text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">動作</h3>
                        <p class="text-sm text-gray-600">工作流程可以執行的操作</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-blue-200">
                        <i class="fas fa-plus text-blue-600"></i>
                        <div>
                            <div class="font-medium text-gray-900">建立記錄</div>
                            <div class="text-sm text-gray-600">在 {{ $app->name }} 中建立新的記錄</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-blue-200">
                        <i class="fas fa-sync text-blue-600"></i>
                        <div>
                            <div class="font-medium text-gray-900">更新記錄</div>
                            <div class="text-sm text-gray-600">修改現有記錄的資料</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-blue-200">
                        <i class="fas fa-search text-blue-600"></i>
                        <div>
                            <div class="font-medium text-gray-900">搜尋記錄</div>
                            <div class="text-sm text-gray-600">根據條件搜尋特定記錄</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-blue-200">
                        <i class="fas fa-paper-plane text-blue-600"></i>
                        <div>
                            <div class="font-medium text-gray-900">發送通知</div>
                            <div class="text-sm text-gray-600">發送電子郵件或其他形式的通知</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popular Integrations -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">熱門整合組合</h2>
            <p class="text-lg text-gray-600">{{ $app->name }} 與其他應用程式的常見整合方式</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularApps->take(6) as $popularApp)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6">
                        <!-- Integration Visual -->
                        <div class="flex items-center justify-center space-x-4 mb-6">
                            @if($app->images && count($app->images) > 0)
                                <img src="{{ $app->images[0] }}"
                                     alt="{{ $app->name }}"
                                     class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-cube text-white"></i>
                                </div>
                            @endif
                            
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                            </div>
                            
                            @if($popularApp->images && count(json_decode($popularApp->images, true)) > 0)
                                @php $images = json_decode($popularApp->images, true); @endphp
                                <img src="{{ $images[0] }}"
                                     alt="{{ $popularApp->name }}"
                                     class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-cube text-white"></i>
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">
                            {{ $app->name }} + {{ $popularApp->name }}
                        </h3>
                        <p class="text-sm text-gray-600 text-center mb-4">
                            自動同步 {{ $app->name }} 的資料到 {{ $popularApp->name }}，提升工作效率
                        </p>
                        
                        <div class="flex items-center justify-center space-x-2">
                            <button class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus mr-2"></i>建立整合
                            </button>
                            <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors duration-200">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Getting Started -->
<div class="bg-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">開始使用 {{ $app->name }} 整合</h2>
        <p class="text-lg text-gray-600 mb-8">只需幾個簡單步驟，即可建立您的第一個自動化工作流程</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-primary-600">1</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">連接帳號</h3>
                <p class="text-sm text-gray-600">連接您的 {{ $app->name }} 帳號到 TW_Zapier 平台</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-primary-600">2</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">設定觸發器</h3>
                <p class="text-sm text-gray-600">選擇何時啟動您的自動化工作流程</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-primary-600">3</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">配置動作</h3>
                <p class="text-sm text-gray-600">定義觸發後要執行的具體操作</p>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <button class="inline-flex items-center px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow-lg">
                <i class="fas fa-rocket mr-2"></i>
                立即開始整合
            </button>
            <a href="{{ route('user.apps.show', $app->id) }}" 
               class="inline-flex items-center px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                返回應用程式詳情
            </a>
        </div>
    </div>
</div>
@endsection
