# 動態 Header 組件使用說明

## 概述

`dynamic-header.blade.php` 是一個智能的 header 組件，能根據當前介面類型（user/admin）和用戶登入狀態動態顯示不同的導航內容。

## 功能特色

### 1. 自動介面檢測
- **Admin 介面**：當 URL 包含 `admin*` 或路由名稱為 `admin.*` 時自動啟用
- **User 介面**：其他情況下使用用戶介面模式

### 2. 用戶狀態感知
- 自動檢測用戶登入狀態
- 根據用戶角色（admin/user）顯示對應功能
- 支援權限系統整合

### 3. 響應式設計
- 桌面版：完整導航選單和下拉面板
- 手機版：折疊式導航選單

## 使用方法

### 在 Blade 模板中引入

```blade
@include('layouts.dynamic-header')
```

### 替換現有 header

在您的主要佈局檔案中（如 `admin.blade.php` 或 `user.blade.php`），將原有的 header 引入替換為：

```blade
{{-- 舊的引入方式 --}}
@include('layouts.header')

{{-- 新的動態引入方式 --}}
@include('layouts.dynamic-header')
```

## 介面配置

### Admin 介面導航
- **儀表板**：管理系統首頁
- **用戶管理**：管理員管理和權限管理（需要 s01 或 s00 權限）
- **產品管理**：產品相關管理功能（需要 s02 權限）
- **系統設定**：系統配置選項
- **應用程式管理**：應用程式管理功能

### User 介面導航
- **產品**：產品相關頁面
- **實現**：實現方案頁面
- **資源**：資源和文檔頁面
- **企業**：企業解決方案
- **定價**：定價資訊

### 右側區域配置

#### Admin 介面
- **切換到用戶介面**：快速切換到用戶模式
- **管理員帳戶選單**：個人設定和登出功能

#### User 介面
- **工作區**：連結到工作區應用
- **探索**：應用程式探索頁面
- **帳戶選單**（已登入）：個人資料、帳戶設定、我的工作流程、登出
- **登入/註冊按鈕**（未登入）：登入和免費註冊

## 權限系統整合

組件會自動檢查用戶權限並顯示對應的導航項目：

- **s00**：權限管理權限
- **s01**：帳號管理權限
- **s02**：產品管理權限
- **s03**：產品維護權限

## 自訂配置

### 修改導航項目

在 `dynamic-header.blade.php` 中找到對應的區塊進行修改：

```blade
@if($isAdminInterface)
    {{-- Admin 介面導航 --}}
    <!-- 在這裡添加或修改 Admin 導航項目 -->
@else
    {{-- User 介面導航 --}}
    <!-- 在這裡添加或修改 User 導航項目 -->
@endif
```

### 添加新的權限檢查

```blade
@if($isAdmin && in_array('新權限代碼', $permissions))
    <!-- 需要特定權限的導航項目 -->
@endif
```

### 修改樣式

組件使用現有的 CSS 類別，如需自訂樣式，請修改 `resources/css/app.css` 中的對應樣式。

## 技術細節

### 變數說明

- `$isAdminInterface`：是否為 Admin 介面
- `$isUserInterface`：是否為 User 介面
- `$currentUser`：當前登入用戶物件
- `$isLoggedIn`：是否已登入
- `$isAdmin`：是否為管理員
- `$permissions`：用戶權限陣列

### 路由檢測邏輯

```php
$isAdminInterface = request()->is('admin*') || request()->routeIs('admin.*');
$isUserInterface = request()->is('user*') || request()->routeIs('user.*');
```

### 用戶資訊獲取

```php
$account = session('admin_account');
$currentUser = $account ? \App\Models\User::where('account', $account)->first() : null;
```

## 注意事項

1. **Session 依賴**：組件依賴 `admin_account` session 來識別用戶
2. **權限模型**：需要 User 模型有 `getPermissions()` 方法
3. **路由命名**：確保路由命名符合 `admin.*` 和 `user.*` 的規範
4. **CSS 依賴**：需要完整的 header 相關 CSS 樣式

## 故障排除

### 導航不顯示
- 檢查路由命名是否正確
- 確認 CSS 檔案已正確編譯和載入

### 權限檢查失效
- 確認 User 模型有 `getPermissions()` 方法
- 檢查 session 中是否有 `admin_account`

### 樣式問題
- 確認已執行 `npm run build`
- 檢查 Vite 資源是否正確載入

## 更新記錄

- **v1.0**：初始版本，支援基本的 admin/user 介面切換
- 支援權限系統整合
- 響應式設計支援
- 完整的下拉選單功能
