@extends('layouts.admin')

@section('title', '權限管理 - TW_Zapier')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- 頁面標題 --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800 mb-2">權限管理</h1>
            <p class="text-neutral-600">管理系統管理員的權限分配</p>
        </div>
    </div>
    
    {{-- 權限說明 --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
        <h3 class="text-lg font-semibold text-blue-800 mb-4">
            <i class="fas fa-info-circle mr-2"></i>權限等級說明
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($permissionLevels as $sid => $name)
                <div class="bg-white rounded-lg p-4 border border-blue-200">
                    <div class="flex items-center mb-2">
                        <span class="inline-block w-3 h-3 rounded-full bg-primary-500 mr-2"></span>
                        <span class="font-medium text-neutral-800">{{ $sid }}</span>
                    </div>
                    <p class="text-sm text-neutral-600">{{ $name }}</p>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- 搜尋區 --}}
    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6 mb-8">
        <form method="GET" action="{{ route('admin.permissions.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-neutral-700 mb-2">搜尋管理員</label>
                <input type="text" 
                       id="search"
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="輸入帳號或名稱..."
                       class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
            <div class="md:w-32 flex items-end">
                <button type="submit" 
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>查詢
                </button>
            </div>
        </form>
    </div>
    
    {{-- 管理員權限列表 --}}
    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200">
                <thead class="bg-neutral-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                            管理員資訊
                        </th>
                        @foreach($permissionLevels as $sid => $name)
                            <th class="px-6 py-3 text-center text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                {{ $sid }}<br>
                                <span class="text-xs font-normal normal-case">{{ $name }}</span>
                            </th>
                        @endforeach
                        <th class="px-6 py-3 text-center text-xs font-medium text-neutral-500 uppercase tracking-wider">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-200">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-neutral-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                            <i class="fas fa-user text-primary-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900">{{ $admin->username }}</div>
                                        <div class="text-sm text-neutral-500">{{ $admin->account }}</div>
                                    </div>
                                </div>
                            </td>
                            @foreach($permissionLevels as $sid => $name)
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        // 使用更直接的方法檢查權限
                                        $hasPermission = \App\Models\AdminPermission::where('account', $admin->account)
                                                                                   ->where('sid', $sid)
                                                                                   ->exists();
                                    @endphp
                                    <div class="flex justify-center">
                                        <button type="button"
                                                class="permission-toggle {{ $hasPermission ? 'bg-green-100 text-green-800 border-green-300' : 'bg-neutral-100 text-neutral-500 border-neutral-300' }} border rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-200 hover:scale-110"
                                                data-account="{{ $admin->account }}"
                                                data-sid="{{ $sid }}"
                                                data-has-permission="{{ $hasPermission ? 'true' : 'false' }}">
                                            <i class="fas {{ $hasPermission ? 'fa-check' : 'fa-times' }} text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('admin.permissions.edit', $admin->account) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-primary-700 bg-primary-100 hover:bg-primary-200 transition-colors duration-200">
                                    <i class="fas fa-edit mr-1"></i>編輯
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($permissionLevels) + 2 }}" class="px-6 py-12 text-center text-neutral-500">
                                <i class="fas fa-users text-4xl mb-4 text-neutral-300"></i>
                                <p>沒有找到管理員資料</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- 分頁 --}}
    @if($admins->hasPages())
        <div class="mt-8">
            {{ $admins->links() }}
        </div>
    @endif
    
</div>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 權限切換功能
    document.querySelectorAll('.permission-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const account = this.dataset.account;
            const sid = this.dataset.sid;
            const hasPermission = this.dataset.hasPermission === 'true';
            const action = hasPermission ? 'revoke' : 'assign';
            
            // 發送 AJAX 請求
            fetch(`/admin/permissions/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    account: account,
                    sid: sid
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 更新按鈕狀態
                    const newHasPermission = !hasPermission;
                    this.dataset.hasPermission = newHasPermission.toString();
                    
                    if (newHasPermission) {
                        this.className = 'permission-toggle bg-green-100 text-green-800 border-green-300 border rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-200 hover:scale-110';
                        this.innerHTML = '<i class="fas fa-check text-xs"></i>';
                    } else {
                        this.className = 'permission-toggle bg-neutral-100 text-neutral-500 border-neutral-300 border rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-200 hover:scale-110';
                        this.innerHTML = '<i class="fas fa-times text-xs"></i>';
                    }
                    
                    // 顯示成功訊息
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('操作失敗，請稍後再試', 'error');
            });
        });
    });
    
    // 顯示訊息函數
    function showMessage(message, type) {
        const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `fixed top-4 right-4 ${alertClass} border px-4 py-3 rounded-lg shadow-lg z-50`;
        alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${iconClass} mr-2"></i>
                <span>${message}</span>
                <button type="button" class="ml-4 text-lg font-semibold" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        `;
        
        document.body.appendChild(alertDiv);
        
        // 3秒後自動移除
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 3000);
    }
});
</script>
@endsection
