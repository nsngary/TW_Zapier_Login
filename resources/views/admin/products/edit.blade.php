@extends('layouts.admin')

@section('title', '編輯產品')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- 頁面標題 --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-neutral-800">編輯產品</h1>
            <p class="text-neutral-600 mt-2">修改產品資料</p>
        </div>
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center px-4 py-2 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>返回列表
        </a>
    </div>

    {{-- 編輯產品表單 --}}
    <div class="bg-white rounded-xl shadow-sm border border-neutral-200 overflow-hidden">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- 基本資訊 --}}
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-neutral-800 mb-4">基本資訊</h3>
                </div>

                {{-- 產品名稱 --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">
                        產品名稱 <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name"
                           name="name" 
                           value="{{ old('name', $product->name) }}"
                           required
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('name') border-red-300 @enderror"
                           placeholder="請輸入產品名稱">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SKU --}}
                <div>
                    <label for="sku" class="block text-sm font-medium text-neutral-700 mb-2">
                        產品編號 (SKU)
                    </label>
                    <input type="text" 
                           id="sku"
                           name="sku" 
                           value="{{ old('sku', $product->sku) }}"
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('sku') border-red-300 @enderror"
                           placeholder="請輸入產品編號">
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 產品分類 --}}
                <div>
                    <label for="category" class="block text-sm font-medium text-neutral-700 mb-2">
                        產品分類
                    </label>
                    <input type="text" 
                           id="category"
                           name="category" 
                           value="{{ old('category', $product->category) }}"
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('category') border-red-300 @enderror"
                           placeholder="請輸入產品分類">
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 產品狀態 --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-neutral-700 mb-2">
                        產品狀態 <span class="text-red-500">*</span>
                    </label>
                    <select id="status" 
                            name="status" 
                            required
                            class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('status') border-red-300 @enderror">
                        <option value="">請選擇狀態</option>
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>啟用</option>
                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>停用</option>
                        <option value="discontinued" {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>停產</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 產品描述 --}}
                <div class="lg:col-span-2">
                    <label for="description" class="block text-sm font-medium text-neutral-700 mb-2">
                        產品描述
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="3"
                              class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('description') border-red-300 @enderror"
                              placeholder="請輸入產品簡短描述">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 產品詳細內容 --}}
                <div class="lg:col-span-2">
                    <label for="detail" class="block text-sm font-medium text-neutral-700 mb-2">
                        產品詳細內容
                    </label>
                    <textarea id="detail"
                              name="detail"
                              rows="6"
                              class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('detail') border-red-300 @enderror"
                              placeholder="請輸入產品詳細內容、規格、使用方法等">{{ old('detail', $product->detail) }}</textarea>
                    @error('detail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 價格與庫存 --}}
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-neutral-800 mb-4 mt-6">價格與庫存</h3>
                </div>

                {{-- 產品價格 --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-neutral-700 mb-2">
                        產品價格 <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-neutral-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" 
                               id="price"
                               name="price" 
                               value="{{ old('price', $product->price) }}"
                               step="0.01"
                               min="0"
                               required
                               class="w-full pl-8 pr-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('price') border-red-300 @enderror"
                               placeholder="0.00">
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 庫存數量 --}}
                <div>
                    <label for="stock" class="block text-sm font-medium text-neutral-700 mb-2">
                        庫存數量 <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="stock"
                           name="stock" 
                           value="{{ old('stock', $product->stock) }}"
                           min="0"
                           required
                           class="w-full px-4 py-3 border border-neutral-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('stock') border-red-300 @enderror"
                           placeholder="0">
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 產品圖片 --}}
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-neutral-800 mb-4 mt-6">產品圖片</h3>

                    {{-- 現有圖片 --}}
                    @if($product->images && count($product->images) > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-neutral-700 mb-3">現有圖片</label>
                            <div id="existing-images" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                @foreach($product->images as $index => $image)
                                    <div class="relative group image-item" data-image-path="{{ $image }}">
                                        <img src="{{ $image }}"
                                             alt="產品圖片"
                                             class="w-full h-24 object-cover rounded-lg border-2 {{ $index === 0 ? 'border-primary-500' : 'border-neutral-200' }} cursor-pointer hover:border-primary-400 transition-colors">

                                        {{-- 刪除按鈕 --}}
                                        <button type="button"
                                                onclick="removeExistingImage(this, '{{ $image }}')"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>

                                        {{-- 主圖標示 --}}
                                        @if($index === 0)
                                            <div class="absolute bottom-1 left-1 bg-primary-500 text-white text-xs px-2 py-1 rounded">
                                                主圖
                                            </div>
                                        @endif

                                        {{-- 設為主圖按鈕 --}}
                                        @if($index !== 0)
                                            <button type="button"
                                                    onclick="setAsMainImage(this)"
                                                    class="absolute bottom-1 left-1 bg-neutral-800 hover:bg-neutral-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                設為主圖
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- 隱藏的輸入欄位來儲存要刪除的圖片 --}}
                            <input type="hidden" name="deleted_images" id="deleted-images" value="">
                            <input type="hidden" name="main_image_index" id="main-image-index" value="0">
                        </div>
                    @endif

                    {{-- 上傳新圖片 --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">
                            上傳新圖片
                        </label>
                        <div id="upload-area" class="border-2 border-dashed border-neutral-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200 cursor-pointer">
                            <div id="upload-prompt">
                                <i class="fas fa-cloud-upload-alt text-3xl text-neutral-400 mb-2"></i>
                                <p class="text-neutral-600 mb-2">點擊上傳或拖拽圖片到此處</p>
                                <p class="text-xs text-neutral-500">支援 PNG, JPG, GIF，最大 2MB</p>
                            </div>
                            <input type="file" id="new-images" name="new_images[]" multiple accept="image/*" class="hidden">
                        </div>

                        {{-- 新圖片預覽 --}}
                        <div id="new-images-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4 hidden"></div>
                    </div>

                    @error('new_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 提交按鈕 --}}
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-neutral-200">
                <a href="{{ route('products.index') }}"
                   class="px-6 py-2.5 bg-neutral-100 hover:bg-neutral-200 text-neutral-700 rounded-lg transition-colors duration-200">
                    取消
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>更新產品
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 錯誤訊息 --}}
@if(session('error'))
    <div id="error-message" class="fixed bottom-4 right-4 bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
@endif

<script>
// 自動隱藏錯誤訊息
setTimeout(function() {
    const errorMsg = document.getElementById('error-message');
    if (errorMsg) errorMsg.remove();
}, 5000);

// 圖片上傳功能
let deletedImages = [];
let newImageFiles = [];

// 上傳區域點擊事件
document.getElementById('upload-area').addEventListener('click', function() {
    document.getElementById('new-images').click();
});

// 拖拽上傳功能
const uploadArea = document.getElementById('upload-area');

uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    uploadArea.classList.add('border-primary-500', 'bg-primary-50');
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('border-primary-500', 'bg-primary-50');
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('border-primary-500', 'bg-primary-50');

    const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
    if (files.length > 0) {
        handleNewImages(files);
    }
});

// 檔案選擇事件
document.getElementById('new-images').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    if (files.length > 0) {
        handleNewImages(files);
    }
});

// 處理新圖片
function handleNewImages(files) {
    const previewContainer = document.getElementById('new-images-preview');

    files.forEach((file, index) => {
        // 檢查檔案大小 (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert(`檔案 ${file.name} 超過 2MB 限制`);
            return;
        }

        // 檢查檔案類型
        if (!file.type.startsWith('image/')) {
            alert(`檔案 ${file.name} 不是有效的圖片格式`);
            return;
        }

        newImageFiles.push(file);

        const reader = new FileReader();
        reader.onload = function(e) {
            const imageDiv = document.createElement('div');
            imageDiv.className = 'relative group';
            imageDiv.innerHTML = `
                <img src="${e.target.result}"
                     alt="新圖片預覽"
                     class="w-full h-24 object-cover rounded-lg border border-neutral-200">
                <button type="button"
                        onclick="removeNewImage(this, ${newImageFiles.length - 1})"
                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <i class="fas fa-times text-xs"></i>
                </button>
                <div class="absolute bottom-1 left-1 bg-green-500 text-white text-xs px-2 py-1 rounded">
                    新增
                </div>
            `;

            previewContainer.appendChild(imageDiv);
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    updateFileInput();
}

// 移除新圖片
function removeNewImage(button, fileIndex) {
    // 從陣列中移除檔案
    newImageFiles.splice(fileIndex, 1);

    // 移除預覽元素
    button.parentElement.remove();

    // 如果沒有新圖片了，隱藏預覽容器
    const previewContainer = document.getElementById('new-images-preview');
    if (newImageFiles.length === 0) {
        previewContainer.classList.add('hidden');
    }

    // 重新編號剩餘的圖片
    const remainingImages = previewContainer.querySelectorAll('.relative');
    remainingImages.forEach((img, index) => {
        const removeBtn = img.querySelector('button');
        removeBtn.setAttribute('onclick', `removeNewImage(this, ${index})`);
    });

    updateFileInput();
}

// 更新檔案輸入
function updateFileInput() {
    const fileInput = document.getElementById('new-images');
    const dataTransfer = new DataTransfer();

    newImageFiles.forEach(file => {
        dataTransfer.items.add(file);
    });

    fileInput.files = dataTransfer.files;
}

// 移除現有圖片
function removeExistingImage(button, imagePath) {
    if (confirm('確定要刪除這張圖片嗎？')) {
        // 添加到刪除列表
        deletedImages.push(imagePath);
        document.getElementById('deleted-images').value = JSON.stringify(deletedImages);

        // 移除視覺元素
        const imageItem = button.closest('.image-item');
        const wasMainImage = imageItem.querySelector('.absolute.bottom-1.left-1.bg-primary-500');

        imageItem.remove();

        // 如果刪除的是主圖，將第一張設為主圖
        if (wasMainImage) {
            const remainingImages = document.querySelectorAll('#existing-images .image-item');
            if (remainingImages.length > 0) {
                setAsMainImageElement(remainingImages[0]);
            }
        }

        // 重新編號主圖索引
        updateMainImageIndex();
    }
}

// 設為主圖
function setAsMainImage(button) {
    const imageItem = button.closest('.image-item');
    setAsMainImageElement(imageItem);
}

function setAsMainImageElement(imageItem) {
    // 移除所有主圖標示
    document.querySelectorAll('#existing-images .image-item').forEach((item, index) => {
        const img = item.querySelector('img');
        const mainLabel = item.querySelector('.bg-primary-500');
        const setMainBtn = item.querySelector('.bg-neutral-800');

        // 重置邊框
        img.classList.remove('border-primary-500');
        img.classList.add('border-neutral-200');

        // 移除主圖標籤
        if (mainLabel) {
            mainLabel.remove();
        }

        // 顯示設為主圖按鈕
        if (setMainBtn) {
            setMainBtn.style.display = 'block';
        } else {
            // 如果沒有按鈕，創建一個
            const newBtn = document.createElement('button');
            newBtn.type = 'button';
            newBtn.onclick = function() { setAsMainImage(this); };
            newBtn.className = 'absolute bottom-1 left-1 bg-neutral-800 hover:bg-neutral-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200';
            newBtn.textContent = '設為主圖';
            item.appendChild(newBtn);
        }
    });

    // 設定新的主圖
    const img = imageItem.querySelector('img');
    const setMainBtn = imageItem.querySelector('.bg-neutral-800');

    // 設定主圖邊框
    img.classList.remove('border-neutral-200');
    img.classList.add('border-primary-500');

    // 隱藏設為主圖按鈕
    if (setMainBtn) {
        setMainBtn.style.display = 'none';
    }

    // 添加主圖標籤
    const mainLabel = document.createElement('div');
    mainLabel.className = 'absolute bottom-1 left-1 bg-primary-500 text-white text-xs px-2 py-1 rounded';
    mainLabel.textContent = '主圖';
    imageItem.appendChild(mainLabel);

    updateMainImageIndex();
}

// 更新主圖索引
function updateMainImageIndex() {
    const imageItems = document.querySelectorAll('#existing-images .image-item');
    let mainImageIndex = 0;

    imageItems.forEach((item, index) => {
        const mainLabel = item.querySelector('.bg-primary-500');
        if (mainLabel) {
            mainImageIndex = index;
        }
    });

    document.getElementById('main-image-index').value = mainImageIndex;
}
</script>
@endsection
