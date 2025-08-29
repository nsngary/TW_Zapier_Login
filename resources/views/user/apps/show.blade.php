@extends('layouts.user')

@section('title', $app->name . ' - TW_Zapier')

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
                        <span class="text-neutral-900 font-medium">{{ $app->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- App Header -->
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
            <!-- App Icon and Basic Info -->
            <div class="lg:col-span-5">
                <div class="flex items-start space-x-6">
                    @if($app->images && count($app->images) > 0)
                        <img src="{{ $app->images[0] }}"
                             alt="{{ $app->name }}"
                             class="w-20 h-20 rounded object-cover border border-neutral-200">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-br from-accent-orange to-accent-amber rounded flex items-center justify-center border border-neutral-200">
                            <i class="fas fa-cube text-white text-2xl"></i>
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <h1 class="text-3xl font-bold text-neutral-900 mb-2">{{ $app->name }}</h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="inline-flex items-center px-3 py-1 border border-primary-200 text-sm font-medium bg-primary-100 text-primary-800">
                                {{ $app->category }}
                            </span>
                            @if($app->price == 0)
                                <span class="inline-flex items-center px-3 py-1 border border-green-200 text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>免費
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 border border-blue-200 text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-dollar-sign mr-1"></i>${{ number_format($app->price, 0) }}
                                </span>
                            @endif
                        </div>
                        <p class="text-lg text-neutral-600 leading-relaxed">{{ $app->description }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-8 lg:mt-0 lg:col-span-7">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('user.apps.integrations', $app->id) }}"
                       target="_blank"
                       class="inline-flex items-center justify-center px-6 py-3 bg-accent-orange hover:bg-accent-amber text-white font-medium border border-accent-orange hover:border-accent-amber transition-colors duration-200">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        查看整合詳情
                    </a>
                    <button class="inline-flex items-center justify-center px-6 py-3 bg-white hover:bg-neutral-50 text-neutral-700 font-medium border border-neutral-300 hover:border-neutral-400 transition-colors duration-200">
                        <i class="fas fa-heart mr-2"></i>
                        加入收藏
                    </button>
                </div>
                
                <!-- Quick Stats -->
                <div class="mt-8 grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-neutral-50 border border-neutral-200">
                        <div class="text-2xl font-bold text-neutral-900">{{ $app->stock }}</div>
                        <div class="text-sm text-neutral-600">可用連接數</div>
                    </div>
                    <div class="text-center p-4 bg-neutral-50 border border-neutral-200">
                        <div class="text-2xl font-bold text-neutral-900">{{ $app->sku }}</div>
                        <div class="text-sm text-neutral-600">應用程式編號</div>
                    </div>
                    <div class="text-center p-4 bg-neutral-50 border border-neutral-200">
                        <div class="text-2xl font-bold text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="text-sm text-neutral-600">已驗證</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 使用應用程式詳細資訊模板 --}}
@include('components.app-details', ['app' => $app])

@endsection
