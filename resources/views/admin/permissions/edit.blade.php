@extends('layouts.admin')

@section('title', '編輯權限 - TW_Zapier')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- 頁面標題 --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800 mb-2">編輯權限</h1>
            <p class="text-neutral-600">管理員：{{ $admin->username }} ({{ $admin->account }})</p>
        </div>
        <a href="{{ route('admin.permissions.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>返回列表
        </a>
    </div>
    
    {{-- 權限編輯表單 --}}
    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-8">
        <form method="POST" action="{{ route('admin.permissions.update', $admin->account) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-neutral-800 mb-6">權限分配</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($permissionLevels as $sid => $name)
                        <div class="border border-neutral-200 rounded-lg p-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" 
                                           id="permission_{{ $sid }}"
                                           name="permissions[]" 
                                           value="{{ $sid }}"
                                           {{ in_array($sid, $adminPermissions) ? 'checked' : '' }}
                                           class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                                </div>
                                <div class="ml-3">
                                    <label for="permission_{{ $sid }}" class="text-sm font-medium text-neutral-900 cursor-pointer">
                                        {{ $sid }} - {{ $name }}
                                    </label>
                                    <p class="text-sm text-neutral-500 mt-1">
                                        @switch($sid)
                                            @case('s00')
                                                可以管理所有使用者的權限分配，控制其他使用者可存取哪些功能
                                                @break
                                            @case('s01')
                                                可以刪除或編輯其他使用者的帳號資料
                                                @break
                                            @case('s02')
                                                可以新增、修改、上下架商品等完整產品管理功能
                                                @break
                                            @case('s03')
                                                僅能修改已上架產品的內容（如更新產品圖片與文字描述）
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            {{-- 操作按鈕 --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.permissions.index') }}" 
                   class="px-6 py-2 border border-neutral-300 rounded-lg text-neutral-700 bg-white hover:bg-neutral-50 transition-colors duration-200">
                    取消
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>儲存權限
                </button>
            </div>
        </form>
    </div>
    
    {{-- 權限說明 --}}
    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <h4 class="text-lg font-semibold text-yellow-800 mb-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>權限說明
        </h4>
        <div class="text-sm text-yellow-700 space-y-2">
            <p><strong>注意事項：</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li>同一使用者可擁有多個權限</li>
                <li>權限等級由高到低：s00 > s01 > s02 > s03</li>
                <li>擁有 s00 權限的管理員可以管理所有其他管理員的權限</li>
                <li>權限變更會立即生效，使用者需要重新登入才能看到完整效果</li>
            </ul>
        </div>
    </div>
    
</div>
@endsection
