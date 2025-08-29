@extends('layouts.admin')

@section('title', '管理者資料管理')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- 頁面標題和操作區 --}}
    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 mb-6">
        <div class="p-6 border-b border-neutral-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                {{-- 標題 --}}
                <div>
                    <h1 class="text-2xl font-bold text-neutral-800 mb-2">管理者資料管理</h1>
                    <p class="text-neutral-600">管理系統管理員帳號</p>
                </div>

                {{-- 操作按鈕和搜尋 --}}
                <div class="flex flex-col sm:flex-row gap-3">

                    {{-- 新增按鈕 (只有 admin 可以看到) --}}
                    @if(session('admin_account') === 'admin')
                        <button onclick="openAddAdminModal()"
                               class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>新增管理者
                        </button>
                    @endif

                    {{-- 搜尋表單 --}}
                    <form method="GET" action="{{ route('admin.index') }}" class="flex">
                        <div class="relative">
                            <input type="text"
                                   name="Search"
                                   value="{{ request('Search') }}"
                                   placeholder="搜尋帳號或名稱..."
                                   class="pl-10 pr-4 py-2 border border-neutral-300 rounded-l-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 w-64">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-400"></i>
                        </div>
                        <button type="submit"
                                class="px-4 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-r-lg transition-colors duration-200">
                            查詢
                        </button>
                    </form>

                </div>
            </div>
        </div>

        {{-- 成功/錯誤訊息 --}}
        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-green-700">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-red-700">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- 資料表格 --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700">管理者帳號</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700">管理名稱</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700">電子郵件</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700">
                            操作 <span class="text-xs text-neutral-500">(共 {{ $admins->total() }} 筆)</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-neutral-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-primary-600 text-sm"></i>
                                    </div>
                                    <span class="font-medium text-neutral-800">{{ $admin->account }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-neutral-700">{{ $admin->username }}</td>
                            <td class="px-6 py-4 text-neutral-600">{{ $admin->email ?? '未設定' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    {{-- 編輯按鈕：admin 可以編輯所有人，其他人只能編輯自己 --}}
                                    @if(session('admin_account') === 'admin' || session('admin_account') === $admin->account)
                                        <a href="{{ route('admin.edit', $admin->account) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                            <i class="fas fa-edit mr-1"></i>修改
                                        </a>
                                    @endif

                                    {{-- 刪除按鈕：只有 admin 可以刪除其他管理員，且不能刪除自己 --}}
                                    @if(session('admin_account') === 'admin' && $admin->account !== 'admin')
                                        <button onclick="deleteAdmin('{{ $admin->account }}')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                            <i class="fas fa-trash mr-1"></i>刪除
                                        </button>
                                    @elseif($admin->account === 'admin')
                                        <span class="inline-flex items-center px-3 py-1.5 bg-neutral-100 text-neutral-400 text-sm font-medium rounded-lg">
                                            <i class="fas fa-shield-alt mr-1"></i>系統帳號
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="text-neutral-500">
                                    <i class="fas fa-users text-4xl mb-4"></i>
                                    <p class="text-lg">沒有找到管理員資料</p>
                                    <p class="text-sm">請嘗試調整搜尋條件或新增管理員</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 分頁導航 --}}
        @if($admins->hasPages())
            <div class="px-6 py-4 border-t border-neutral-200">
                <div class="flex items-center justify-center flex-wrap">
                    <div class="flex-1 text-center">
                        <div class="text-sm text-neutral-600">
                            顯示第 {{ $admins->firstItem() }} 到 {{ $admins->lastItem() }} 項，共 {{ $admins->total() }} 項
                        </div>
                    </div>

                    <nav class="flex items-center space-x-1 flex-1 text-center">
                        {{-- 上一頁 --}}
                        @if($admins->onFirstPage())
                            <span class="px-3 py-2 text-neutral-400 bg-neutral-100 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $admins->previousPageUrl() }}"
                               class="px-3 py-2 text-neutral-600 bg-white border border-neutral-300 rounded-lg hover:bg-neutral-50 transition-colors duration-200">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- 頁碼 --}}
                        @foreach($admins->getUrlRange(1, $admins->lastPage()) as $page => $url)
                            @if($page == $admins->currentPage())
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
                        @if($admins->hasMorePages())
                            <a href="{{ $admins->nextPageUrl() }}"
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

{{-- 刪除確認 Modal --}}
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md mx-4">
        <div class="text-center">
            <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
            <h3 class="text-lg font-semibold text-neutral-800 mb-2">確認刪除</h3>
            <p class="text-neutral-600 mb-6">您確定要刪除這個管理員嗎？此操作無法復原。</p>

            <div class="flex gap-3 justify-center">
                <button onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-neutral-200 hover:bg-neutral-300 text-neutral-700 rounded-lg transition-colors duration-200">
                    取消
                </button>
                <button id="confirmDelete"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-200">
                    確認刪除
                </button>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
let deleteAccount = '';

function deleteAdmin(account) {
    deleteAccount = account;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (deleteAccount) {
        fetch(`/admin/${deleteAccount}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || '刪除失敗！');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('發生錯誤，請稍後再試');
        });
    }
    closeDeleteModal();
});

// 自動隱藏訊息
setTimeout(() => {
    const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease-out';
        alert.style.opacity = '0';
        setTimeout(() => {
            alert.remove();
        }, 500);
    });
}, 5000);

// 新增管理者懸浮窗功能
function openAddAdminModal() {
    document.getElementById('addAdminModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddAdminModal() {
    document.getElementById('addAdminModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // 重置表單
    document.getElementById('addAdminForm').reset();
    // 清除錯誤訊息
    document.querySelectorAll('.error-message').forEach(el => el.remove());
}

// 提交新增管理者表單
async function submitAddAdminForm(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    // 顯示載入狀態
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>建立中...';
    submitBtn.disabled = true;

    try {
        const response = await fetch('{{ route("admin.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            // 成功後重新載入頁面
            showMessage('管理員新增成功！', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            // 顯示錯誤
            if (data.errors) {
                displayFormErrors(data.errors);
            } else {
                showMessage(data.message || '新增失敗', 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showMessage('新增失敗，請稍後再試', 'error');
    } finally {
        // 恢復按鈕狀態
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

// 顯示表單錯誤
function displayFormErrors(errors) {
    // 清除舊的錯誤訊息
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    for (const [field, messages] of Object.entries(errors)) {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-red-500 text-sm mt-1';
            errorDiv.textContent = messages[0];
            input.parentNode.appendChild(errorDiv);
        }
    }
}

// 顯示訊息
function showMessage(message, type) {
    const alertClass = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800';
    const messageDiv = document.createElement('div');
    messageDiv.className = `fixed bottom-4 right-4 ${alertClass} border rounded-lg p-4 shadow-lg z-50`;
    messageDiv.textContent = message;

    document.body.appendChild(messageDiv);

    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}
</script>

{{-- 新增管理者懸浮窗 --}}
<div id="addAdminModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        {{-- 標題列 --}}
        <div class="flex items-center justify-between p-6 border-b border-neutral-200">
            <h2 class="text-2xl font-bold text-neutral-800">
                <i class="fas fa-user-plus mr-2 text-primary-600"></i>新增管理者
            </h2>
            <button onclick="closeAddAdminModal()" class="text-neutral-400 hover:text-neutral-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- 表單內容 --}}
        <form id="addAdminForm" onsubmit="submitAddAdminForm(event)" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- 管理員帳號 --}}
                <div>
                    <label for="account" class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-user mr-2"></i>管理員帳號 <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="account"
                           name="account"
                           required
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                           placeholder="請輸入管理員帳號">
                </div>

                {{-- 管理員名稱 --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-id-card mr-2"></i>管理員名稱 <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="username"
                           name="username"
                           required
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                           placeholder="請輸入管理員名稱">
                </div>

                {{-- 密碼 --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>密碼 <span class="text-red-500">*</span>
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           minlength="3"
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                           placeholder="請輸入密碼（最少3個字元）">
                </div>

                {{-- 電子郵件 --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-2">
                        <i class="fas fa-envelope mr-2"></i>電子郵件
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                           placeholder="選填，留空將自動生成">
                </div>
            </div>

            {{-- 權限設定 --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-neutral-700 mb-4">
                    <i class="fas fa-key mr-2"></i>權限設定
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer">
                        <input type="checkbox" name="permissions[]" value="s00" class="mr-3">
                        <div>
                            <div class="font-medium text-sm">權限管理</div>
                            <div class="text-xs text-neutral-500">s00</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer">
                        <input type="checkbox" name="permissions[]" value="s01" class="mr-3">
                        <div>
                            <div class="font-medium text-sm">帳號管理</div>
                            <div class="text-xs text-neutral-500">s01</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer">
                        <input type="checkbox" name="permissions[]" value="s02" class="mr-3">
                        <div>
                            <div class="font-medium text-sm">產品管理</div>
                            <div class="text-xs text-neutral-500">s02</div>
                        </div>
                    </label>
                    <label class="flex items-center p-3 border border-neutral-200 rounded-lg hover:bg-neutral-50 cursor-pointer">
                        <input type="checkbox" name="permissions[]" value="s03" class="mr-3">
                        <div>
                            <div class="font-medium text-sm">產品維護</div>
                            <div class="text-xs text-neutral-500">s03</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- 按鈕區 --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-neutral-200">
                <button type="button"
                        onclick="closeAddAdminModal()"
                        class="px-6 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition-colors duration-200">
                    取消
                </button>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>建立管理者
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
