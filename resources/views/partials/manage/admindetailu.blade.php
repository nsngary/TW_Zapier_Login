@extends('layouts.admin')

@section('title', '編輯管理員')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- 頁面標題 --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">編輯管理員</h1>
            <p class="text-neutral-600 mt-2">管理員：{{ $admin->username }} ({{ $admin->account }})</p>
        </div>
        <a href="{{ route('admin.index') }}"
           class="inline-flex items-center px-4 py-2 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>返回列表
        </a>
    </div>

    {{-- 編輯表單 --}}
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200">
        <form action="{{ route('admin.update', $admin->account) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- 帳號 (不可編輯) --}}
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-user mr-2"></i>管理員帳號
                    </label>
                    <input type="text" 
                           value="{{ $admin->account }}" 
                           disabled
                           class="w-full px-4 py-3 bg-neutral-50 border border-neutral-200 rounded-lg text-neutral-500">
                    <p class="text-xs text-neutral-500 mt-1">帳號無法修改</p>
                </div>

                {{-- 管理員名稱 --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-id-card mr-2"></i>管理員名稱 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="username"
                           name="username" 
                           value="{{ old('username', $admin->username) }}" 
                           required
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 密碼 --}}
                <div class="md:col-span-2">
                    <label for="password" class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>新密碼
                    </label>
                    <input type="password" 
                           id="password"
                           name="password" 
                           placeholder="留空表示不修改密碼"
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                    <p class="text-xs text-neutral-500 mt-1">留空表示不修改密碼，最少 3 個字元</p>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 提交按鈕 --}}
            <div class="flex items-center justify-between pt-6 border-t border-neutral-200 mt-8">
                <div class="text-sm text-neutral-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    修改後將立即生效
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.index') }}"
                       class="px-6 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition-colors duration-200">
                        取消
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>儲存修改
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- 管理員資訊卡片 --}}
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-neutral-200 p-6">
        <h3 class="text-lg font-semibold text-neutral-800 mb-4">
            <i class="fas fa-info-circle mr-2"></i>管理員資訊
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="text-neutral-500">建立時間：</span>
                <span class="text-neutral-800">{{ $admin->created_at ? $admin->created_at->format('Y-m-d H:i') : '未知' }}</span>
            </div>
            <div>
                <span class="text-neutral-500">最後更新：</span>
                <span class="text-neutral-800">{{ $admin->updated_at ? $admin->updated_at->format('Y-m-d H:i') : '未知' }}</span>
            </div>
            <div>
                <span class="text-neutral-500">帳號狀態：</span>
                <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                    <i class="fas fa-check-circle mr-1"></i>正常
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
