@php
    // 判斷當前介面類型
    $isAdminInterface = request()->is('admin*') || request()->routeIs('admin.*');
    $isUserInterface = request()->is('user*') || request()->routeIs('user.*');
    
    // 獲取當前登入用戶資訊
    $account = session('admin_account');
    $currentUser = $account ? \App\Models\User::where('account', $account)->first() : null;
    $isLoggedIn = $currentUser !== null;
    $isAdmin = $currentUser && $currentUser->role === 'admin';
    $permissions = $currentUser && $isAdmin ? $currentUser->getPermissions() : [];
@endphp

<header 
class="w-full h-14 flex items-center justify-between sticky top-0 z-[1000] px-4 desktop:px-10 box-border bg-header-bg border-b border-header-border text-base antialiased"
data-testid="header"
>
<!-- Skip to content link -->
<a
    href="#main"
    class="w-fit absolute top-0 left-0 right-0 mx-auto py-0.5 px-4 pb-2 text-sm text-white bg-header-bg rounded-b opacity-0 pointer-events-none z-10 focus:opacity-100 focus:pointer-events-auto outline-none"
    data-testid="skip-link"
>
    Skip to content
</a>

<!-- Left section: Logo + Main Navigation -->
<div class="flex items-center gap-4">
    <!-- Logo -->
    <a 
    class="focus-visible:outline-2 focus-visible:outline-header-link-focus focus-visible:outline-offset-0.5"
    aria-label="TW Zapier" 
    href="{{ $isAdminInterface ? route('admin.index') : '/' }}"
    >
    <svg 
        class="block" 
        width="104" 
        height="28" 
        viewBox="0 0 244 66" 
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <!-- z -->
        <path
        d="M57.1877 45.2253L57.1534 45.1166L78.809 25.2914V15.7391H44.0663V25.2914H64.8181L64.8524 25.3829L43.4084 45.2253V54.7775H79.1579V45.2253H57.1877Z"
        fill="#86735E"
        />
        <!-- a -->
        <path
        d="M100.487 14.8297C96.4797 14.8297 93.2136 15.434 90.6892 16.6429C88.3376 17.6963 86.3568 19.4321 85.0036 21.6249C83.7091 23.8321 82.8962 26.2883 82.6184 28.832L93.1602 30.3135C93.5415 28.0674 94.3042 26.4754 95.4482 25.5373C96.7486 24.5562 98.3511 24.0605 99.9783 24.136C102.118 24.136 103.67 24.7079 104.634 25.8519C105.59 26.9959 106.076 28.5803 106.076 30.6681V31.7091H95.9401C90.7807 31.7091 87.0742 32.8531 84.8206 35.1411C82.5669 37.429 81.442 40.4492 81.4458 44.2014C81.4458 48.0452 82.5707 50.9052 84.8206 52.7813C87.0704 54.6574 89.8999 55.5897 93.3089 55.5783C97.5379 55.5783 100.791 54.1235 103.067 51.214C104.412 49.426 105.372 47.3793 105.887 45.2024H106.27L107.723 54.7546H117.275V30.5651C117.275 25.5659 115.958 21.6936 113.323 18.948C110.688 16.2024 106.409 14.8297 100.487 14.8297ZM103.828 44.6475C102.312 45.9116 100.327 46.5408 97.8562 46.5408C95.8199 46.5408 94.4052 46.1843 93.6121 45.4712C93.2256 45.1338 92.9182 44.7155 92.7116 44.246C92.505 43.7764 92.4043 43.2671 92.4166 42.7543C92.3941 42.2706 92.4702 41.7874 92.6403 41.3341C92.8104 40.8808 93.071 40.4668 93.4062 40.1174C93.7687 39.7774 94.1964 39.5145 94.6633 39.3444C95.1303 39.1743 95.6269 39.1006 96.1231 39.1278H106.093V39.7856C106.113 40.7154 105.919 41.6374 105.527 42.4804C105.134 43.3234 104.553 44.0649 103.828 44.6475Z"
        fill="#86735E"
        />
        <!-- p -->
        <path
        d="M146.201 14.6695C142.357 14.6695 139.268 15.8764 136.935 18.2902C135.207 20.0786 133.939 22.7479 133.131 26.2981H132.771L131.295 15.7563H121.657V66H132.942V45.3054H133.354C133.698 46.6852 134.181 48.0267 134.795 49.3093C135.75 51.3986 137.316 53.1496 139.286 54.3314C141.328 55.446 143.629 56.0005 145.955 55.9387C150.68 55.9387 154.277 54.0988 156.748 50.419C159.219 46.7392 160.455 41.6046 160.455 35.0153C160.455 28.6509 159.259 23.6689 156.869 20.0691C154.478 16.4694 150.922 14.6695 146.201 14.6695ZM147.345 42.9602C146.029 44.8668 143.97 45.8201 141.167 45.8201C140.012 45.8735 138.86 45.6507 137.808 45.1703C136.755 44.6898 135.832 43.9656 135.116 43.0574C133.655 41.2233 132.927 38.7122 132.931 35.5243V34.7807C132.931 31.5432 133.659 29.0646 135.116 27.3448C136.572 25.625 138.59 24.7747 141.167 24.7937C144.02 24.7937 146.092 25.6994 147.385 27.5107C148.678 29.322 149.324 31.8483 149.324 35.0896C149.332 38.4414 148.676 41.065 147.356 42.9602H147.345Z"
        fill="#86735E"
        />
        <!-- i 身-->
        <path d="M175.035 15.7391H163.75V54.7833H175.035V15.7391Z" fill="#86735E" />
        <!-- i 頭 -->
        <path
        d="M169.515 0.00366253C168.666 -0.0252113 167.82 0.116874 167.027 0.421484C166.234 0.726094 165.511 1.187 164.899 1.77682C164.297 2.3723 163.824 3.08658 163.512 3.87431C163.2 4.66204 163.055 5.50601 163.086 6.35275C163.056 7.20497 163.201 8.05433 163.514 8.84781C163.826 9.64129 164.299 10.3619 164.902 10.9646C165.505 11.5673 166.226 12.0392 167.02 12.3509C167.814 12.6626 168.663 12.8074 169.515 12.7762C170.362 12.8082 171.206 12.6635 171.994 12.3514C172.782 12.0392 173.496 11.5664 174.091 10.963C174.682 10.3534 175.142 9.63077 175.446 8.83849C175.75 8.04621 175.89 7.20067 175.859 6.35275C175.898 5.50985 175.761 4.66806 175.456 3.88115C175.151 3.09424 174.686 2.37951 174.09 1.78258C173.493 1.18565 172.779 0.719644 171.992 0.414327C171.206 0.109011 170.364 -0.0288946 169.521 0.00938803L169.515 0.00366253Z"
        fill="#86735E"
        />
        <!-- e -->
        <path
        d="M208.473 17.0147C205.839 15.4474 202.515 14.6657 198.504 14.6695C192.189 14.6695 187.247 16.4675 183.678 20.0634C180.108 23.6593 178.324 28.6166 178.324 34.9352C178.233 38.7553 179.067 42.5407 180.755 45.9689C182.3 49.0238 184.706 51.5592 187.676 53.2618C190.665 54.9892 194.221 55.8548 198.344 55.8586C201.909 55.8586 204.887 55.3095 207.278 54.2113C209.526 53.225 211.483 51.6791 212.964 49.7211C214.373 47.7991 215.42 45.6359 216.052 43.3377L206.329 40.615C205.919 42.1094 205.131 43.4728 204.041 44.5732C202.942 45.6714 201.102 46.2206 198.521 46.2206C195.451 46.2206 193.163 45.3416 191.657 43.5837C190.564 42.3139 189.878 40.5006 189.575 38.1498H216.201C216.31 37.0515 216.367 36.1306 216.367 35.387V32.9561C216.431 29.6903 215.757 26.4522 214.394 23.4839C213.118 20.7799 211.054 18.5248 208.473 17.0147ZM198.178 23.9758C202.754 23.9758 205.348 26.2275 205.962 30.731H189.775C190.032 29.2284 190.655 27.8121 191.588 26.607C193.072 24.8491 195.268 23.972 198.178 23.9758Z"
        fill="#86735E"
        />
        <!-- r -->
        <path
        d="M241.666 15.7391C238.478 15.7391 235.965 16.864 234.127 19.1139C232.808 20.7307 231.805 23.1197 231.119 26.2809H230.787L229.311 15.7391H219.673V54.7775H230.959V34.7578C230.959 32.2335 231.55 30.2982 232.732 28.9521C233.914 27.606 236.095 26.933 239.275 26.933H243.559V15.7391H241.666Z"
        fill="#86735E"
        />
        <!-- _ -->
        <path d="M39.0441 45.2253H0V54.789H39.0441V45.2253Z" fill="#A86F4B" />
    </svg>
    </a>

    <!-- Desktop Navigation -->
    <div class="hidden desktop:block">
    <nav aria-label="Main site navigation">
        <ul class="flex items-center gap-1 list-none">
        
        @if($isAdminInterface)
            {{-- Admin 介面導航 --}}
            <!-- 儀表板 -->
            <li>
                <a class="nav-link" href="{{ route('admin.index') }}" aria-label="儀表板">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" fill="currentColor"/>
                    </svg>
                    <span>儀表板</span>
                </a>
            </li>

            <!-- 管理員管理 -->
            @if($isAdmin && in_array('s01', $permissions))
            <li>
                <a class="nav-link" href="{{ route('admin.index') }}" aria-label="管理員管理">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" fill="currentColor"/>
                    </svg>
                    <span>管理員管理</span>
                </a>
            </li>
            @endif

            <!-- 權限管理 -->
            @if($isAdmin && in_array('s00', $permissions))
            <li>
                <a class="nav-link" href="{{ route('admin.permissions.index') }}" aria-label="權限管理">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" fill="currentColor"/>
                    </svg>
                    <span>權限管理</span>
                </a>
            </li>
            @endif

            <!-- 產品管理 -->
            @if($isAdmin && (in_array('s02', $permissions) || in_array('s03', $permissions)))
            <li>
                <a class="nav-link" href="{{ route('products.index') }}" aria-label="產品管理">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z" fill="currentColor"/>
                    </svg>
                    <span>產品管理</span>
                </a>
            </li>
            @endif

            <!-- 應用程式管理 -->
            <li>
                <a class="nav-link" href="{{ route('user.apps.index') }}" aria-label="應用程式管理">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z" fill="currentColor"/>
                    </svg>
                    <span>應用程式管理</span>
                </a>
            </li>

        @else
            {{-- User 介面導航 --}}
            <!-- 產品下拉選單 -->
            <li>
                <details data-testid="nav-dropdown" class="dropdown-container">
                    <summary class="dropdown-summary" data-testid="nav-dropdown-summary">
                        <span>產品</span>
                        <span class="dropdown-indicator">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" size="16" aria-hidden="false" role="img" data-name="arrowSmallDown">
                                <path d="M12 17.2999L19 11.4399V8.81995L12 14.6999L5 8.81995V11.4399L12 17.2999Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </summary>
                    <!-- 產品下拉選單內容 -->
                    <div class="dropdown-panel">
                        <div class="dropdown-main bg-header-dropdown-bg">
                            <div class="dropdown-content">
                                <div class="dropdown-header">
                                    <div class="dropdown-heading">Zapier 自動化平台</div>
                                    <p class="dropdown-description">無程式碼自動化，整合 7,000+ 應用程式</p>
                                </div>
                                <div class="dropdown-sections">
                                    <div>
                                        <div class="section-heading" id="products-submenu-heading-products">Products</div>
                                        <ul class="section-list" aria-labelledby="products-submenu-heading-products">
                                            <li class="section-item">
                                                <a class="section-link" href="/workflows" aria-label="Zaps">
                                                    <div class="section-icon bg-orange-50 text-primary-500">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8.99996 23.66L20.54 9.90997H15V0.159973L3.45996 13.91H8.99996V23.66Z" fill="currentColor"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>工作流程</span></div>
                                                        <div class="section-desc">製作自己的自動化工作流</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/tables" aria-label="Tables">
                                                    <div class="section-icon bg-orange-50 text-primary-500">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12 2.9978H21.0022V7.49897H12V2.9978Z" fill="currentColor"></path>
                                                            <path d="M12 7.49897L2.99756 7.4989V12.0001H11.9997L12 7.49897Z" fill="currentColor"></path>
                                                            <path d="M11.9997 12.0001L21.0022 12V16.5012H12L11.9997 12.0001Z" fill="currentColor"></path>
                                                            <path d="M2.99756 16.5011L12 16.5012L11.9997 21.0023H2.99756V16.5011Z" fill="currentColor"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>資料庫</span></div>
                                                        <div class="section-desc">為工作流程設計的資料庫</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/interfaces" aria-label="Interfaces">
                                                    <div class="section-icon bg-orange-50 text-primary-500">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.49989 7.50049V16.5001L16.4999 16.5001V21H3.00022L3 3H20.9999V16.5001L16.4999 16.5001L16.5 7.50049L7.49989 7.50049Z" fill="currentColor"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>介面</span></div>
                                                        <div class="section-desc">自訂使用介面</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="section-heading" id="products-submenu-heading-capabilities">Capabilities</div>
                                        <ul class="section-list" aria-labelledby="products-submenu-heading-capabilities">
                                            <li class="section-item">
                                                <a class="section-link" href="{{ route('user.apps.index') }}" aria-label="App integrations">
                                                    <div>
                                                        <div class="section-label"><span>App 整合</span></div>
                                                        <div class="section-desc">整合 7,000+ 應用程式</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/ai" aria-label="AI automation 🪄">
                                                    <div>
                                                        <div class="section-label"><span>AI agents 自動化 🪄</span></div>
                                                        <div class="section-desc">善用AI升級工作流</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/security-compliance" aria-label="Security">
                                                    <div>
                                                        <div class="section-label"><span>安全性</span></div>
                                                        <div class="section-desc">企業級安全</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-footer">
                                <ul class="footer-list">
                                    <li>
                                        <a class="footer-link" href="/templates">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.5898 13.59C13.9048 13.2754 14.1194 12.8745 14.2064 12.438C14.2934 12.0015 14.2491 11.5489 14.0788 11.1376C13.9086 10.7263 13.6202 10.3748 13.2502 10.1274C12.8801 9.88005 12.445 9.74802 11.9998 9.74802C11.5547 9.74802 11.1196 9.88005 10.7495 10.1274C10.3794 10.3748 10.0911 10.7263 9.92085 11.1376C9.75063 11.5489 9.70624 12.0015 9.79328 12.438C9.88033 12.8745 10.0949 13.2754 10.4098 13.59C10.8317 14.0113 11.4036 14.248 11.9998 14.248C12.5961 14.248 13.168 14.0113 13.5898 13.59ZM6.58984 6.59L3.77984 17L5.99984 16.35L8.19984 8.2L18.5898 5.41L15.7998 15.8L3.17984 19.18L2.58984 21.41L17.4398 17.41L21.4398 2.56L6.58984 6.59Z" fill="currentColor"></path>
                                            </svg>
                                            <span>探索模板</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="footer-link" href="/use-cases">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22 6H17.47L14.95 3H9.05L6.53 6H2V8H20V14H13V12H11V14H4V10H2V21H22V6ZM9.14 6L9.98 5H14.01L14.85 6H9.14ZM20 19H4V16H11V17H13V16H20V19Z" fill="currentColor"></path>
                                            </svg>
                                            <span>探索使用案例</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <aside class="dropdown-aside">
                            <div>
                                <div class="aside-heading" id="products-submenu-heading-whats-new">新功能</div>
                                <ul class="section-list" aria-labelledby="products-submenu-heading-whats-new">
                                    <li class="section-item">
                                        <a class="section-link" href="/canvas" aria-label="Canvas">
                                            <div class="section-icon text-neutral-700">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M21 3H3V7.5H16.5V21H21V3Z" fill="currentColor"></path>
                                                    <path d="M14.2498 11.9999C14.2498 13.2426 13.2424 14.25 11.9998 14.25C10.7572 14.25 9.74981 13.2426 9.74981 11.9999C9.74981 10.7573 10.7572 9.74993 11.9998 9.74993C13.2424 9.74993 14.2498 10.7573 14.2498 11.9999Z" fill="currentColor"></path>
                                                    <path d="M9.74981 16.5001C9.74981 17.7427 8.74245 18.7501 7.49981 18.7501C6.25717 18.7501 5.24981 17.7427 5.24981 16.5001C5.24981 15.2574 6.25717 14.2501 7.49981 14.2501C8.74245 14.2501 9.74981 15.2574 9.74981 16.5001Z" fill="currentColor"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="section-label">
                                                    <span>Canvas - 畫布</span>
                                                    <span class="beta-tag">Beta</span>
                                                </div>
                                                <div class="section-desc">使用 AI 規劃和繪製您的工作流程</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </aside>
                    </div>
                </details>
            </li>

            <!-- 實現下拉選單 -->
            <li>
                <details data-testid="nav-dropdown" class="dropdown-container">
                    <summary class="dropdown-summary" data-testid="nav-dropdown-summary">
                        <span>實現</span>
                        <span class="dropdown-indicator">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" size="16" aria-hidden="false" role="img" data-name="arrowSmallDown">
                                <path d="M12 17.2999L19 11.4399V8.81995L12 14.6999L5 8.81995V11.4399L12 17.2999Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </summary>
                    <!-- 實現下拉選單內容 -->
                    <div class="dropdown-panel">
                        <div class="dropdown-main">
                            <div class="dropdown-content">
                                <div class="dropdown-header">
                                    <div class="dropdown-heading">實現自動化</div>
                                    <p class="dropdown-description">探索各種方式來建立自動化工作流程</p>
                                </div>
                                <div class="dropdown-sections">
                                    <div>
                                        <div class="section-heading" id="implement-submenu-heading-by-team">依團隊分類</div>
                                        <ul class="section-list" aria-labelledby="implement-submenu-heading-by-team">
                                            <li class="section-item">
                                                <a class="section-link" href="/solutions/marketing" aria-label="Marketing">
                                                    <div>
                                                        <div class="section-label"><span>行銷</span></div>
                                                        <div class="section-desc">自動化行銷活動和潛在客戶管理</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/solutions/sales" aria-label="Sales">
                                                    <div>
                                                        <div class="section-label"><span>銷售</span></div>
                                                        <div class="section-desc">簡化銷售流程和客戶關係管理</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/solutions/it" aria-label="IT">
                                                    <div>
                                                        <div class="section-label"><span>IT</span></div>
                                                        <div class="section-desc">自動化 IT 工作流程和系統整合</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </details>
            </li>

            <!-- 資源下拉選單 -->
            <li>
                <details data-testid="nav-dropdown" class="dropdown-container">
                    <summary class="dropdown-summary" data-testid="nav-dropdown-summary">
                        <span>資源</span>
                        <span class="dropdown-indicator">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" size="16" aria-hidden="false" role="img" data-name="arrowSmallDown">
                                <path d="M12 17.2999L19 11.4399V8.81995L12 14.6999L5 8.81995V11.4399L12 17.2999Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </summary>
                    <!-- 資源下拉選單內容 -->
                    <div class="dropdown-panel">
                        <div class="dropdown-main">
                            <div class="dropdown-content">
                                <div class="dropdown-header">
                                    <div class="dropdown-heading">學習和支援</div>
                                    <p class="dropdown-description">取得協助、學習新技能，並與社群連結</p>
                                </div>
                                <div class="dropdown-sections">
                                    <div>
                                        <div class="section-heading" id="resources-submenu-heading-learn">學習使用</div>
                                        <ul class="section-list" aria-labelledby="resources-submenu-heading-learn">
                                            <li class="section-item">
                                                <a class="section-link" href="/learn" aria-label="Learn">
                                                    <div>
                                                        <div class="section-label"><span>學習中心</span></div>
                                                        <div class="section-desc">課程和教學指南</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/help" aria-label="Help docs">
                                                    <div>
                                                        <div class="section-label"><span>說明文件</span></div>
                                                        <div class="section-desc">詳細的產品文件</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </details>
            </li>

            <!-- 企業連結 -->
            <li>
                <a class="nav-link" href="/enterprise" aria-label="Enterprise" data-testid="nav-link">
                    <span>企業</span>
                </a>
            </li>

            <!-- 定價連結 -->
            <li>
                <a class="nav-link" href="/pricing" aria-label="Pricing" data-testid="nav-link">
                    <span>定價</span>
                </a>
            </li>
        @endif
        
        </ul>
    </nav>
    </div>
</div>

<!-- Right section: Secondary Navigation + Auth -->
<div class="flex items-center gap-1">
    @if($isAdminInterface)
        {{-- Admin 介面右側區域 --}}
        <!-- 切換到用戶介面 -->
        <div class="hidden desktop:block">
            <a class="nav-link" href="/" aria-label="切換到用戶介面">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/>
                </svg>
                <span>用戶介面</span>
            </a>
        </div>

        <!-- 管理員帳戶下拉選單 -->
        @if($isLoggedIn)
        <div class="flex items-center gap-2">
            <details class="dropdown-container">
                <summary class="dropdown-summary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                    </svg>
                    <span>{{ $currentUser->username ?? '管理員' }}</span>
                    <span class="dropdown-indicator">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 17.2999L19 11.4399V8.81995L12 14.6999L5 8.81995V11.4399L12 17.2999Z" fill="currentColor"></path>
                        </svg>
                    </span>
                </summary>
                <div class="dropdown-panel">
                    <div class="dropdown-main">
                        <div class="dropdown-content">
                            <div class="dropdown-sections">
                                <div>
                                    <ul class="section-list">
                                        <li class="section-item">
                                            <a class="section-link" href="{{ route('admin.edit', $currentUser->account) }}">
                                                <div class="section-icon bg-blue-50 text-blue-600">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="section-label"><span>個人設定</span></div>
                                                    <div class="section-desc">編輯個人資料和設定</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="section-item">
                                            <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                                                @csrf
                                                <button type="submit" class="section-link w-full text-left">
                                                    <div class="section-icon bg-red-50 text-red-600">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" fill="currentColor"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>登出</span></div>
                                                        <div class="section-desc">登出管理系統</div>
                                                    </div>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </details>
        </div>
        @endif

    @else
        {{-- User 介面右側區域 --}}
        <!-- Secondary Navigation (Desktop only) -->
        <div class="hidden desktop:block">
        <nav aria-label="Secondary site navigation">
            <ul class="flex items-center gap-1 list-none">
            <li>
                <a class="nav-link" href="http://localhost:3000/editor" aria-label="工作區">
                <span class="flex">
                    <svg width="18" height="18" viewBox="0 0 256 256" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M224.32,114.24a56,56,0,0,0-60.07-76.57A56,56,0,0,0,67.93,51.44a56,56,0,0,0-36.25,90.32A56,56,0,0,0,69,217A56.39,56.39,0,0,0,83.59,219a55.75,55.75,0,0,0,8.17-.61,56,56,0,0,0,96.31-13.78,56,56,0,0,0,36.25-90.32Zm-80.32,23-16,9.24-16-9.24V118.76l16-9.24,16,9.24Zm38.85-82.81a40,40,0,0,1,28.56,48c-.95-.63-1.91-1.24-2.91-1.81L164,74.88a8,8,0,0,0-8,0l-44,25.41V81.81l40.5-23.38A39.76,39.76,0,0,1,182.85,54.43Zm-142,32.5A39.75,39.75,0,0,1,64.12,68.57C64.05,69.71,64,70.85,64,72v51.38a8,8,0,0,0,4,6.93l44,25.4L96,165,55.5,141.57A40,40,0,0,1,40.86,86.93ZM136,224a39.79,39.79,0,0,1-27.52-10.95c1-.51,2-1.05,3-1.63L156,185.73a8,8,0,0,0,4-6.92V128l16,9.24V184A40,40,0,0,1,136,224Z" fill="currentColor"></path>
                    </svg>
                </span>
                <span>工作區</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('user.apps.index') }}" aria-label="探索">
                <span class="flex">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 11H11V3H3V11ZM5 5H9V9H5V5Z" fill="currentColor"></path>
                        <path d="M3 21H11V13H3V21ZM5 15H9V19H5V15Z" fill="currentColor"></path>
                        <path d="M13 21H21V13H13V21ZM15 15H19V19H15V15Z" fill="currentColor"></path>
                        <path d="M18 6V3H16V6H13V8H16V11H18V8H21V6H18Z" fill="currentColor"></path>
                    </svg>
                </span>
                <span>探索</span>
                </a>
            </li>
            <li>
                <a class="nav-link" href="/contact-sales" aria-label="聯絡銷售" data-testid="nav-link">
                    <span>聯絡銷售</span>
                </a>
            </li>
            </ul>
        </nav>
        </div>

        <!-- Auth Links -->
        @if($isLoggedIn)
            {{-- 已登入用戶：顯示帳戶設定下拉選單 --}}
            <div class="flex items-center gap-2">
                <details class="dropdown-container">
                    <summary class="dropdown-summary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                        </svg>
                        <span>{{ $currentUser->username ?? '用戶' }}</span>
                        <span class="dropdown-indicator">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 17.2999L19 11.4399V8.81995L12 14.6999L5 8.81995V11.4399L12 17.2999Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </summary>
                    <div class="dropdown-panel">
                        <div class="dropdown-main">
                            <div class="dropdown-content">
                                <div class="dropdown-sections">
                                    <div>
                                        <ul class="section-list">
                                            <li class="section-item">
                                                <a class="section-link" href="/dashboard/cart">
                                                    <div class="section-icon bg-blue-50 text-blue-600">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20C20.55 4 21 4.45 21 5S20.55 6 20 6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4C3.45 6 3 5.55 3 5S3.45 4 4 4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z" fill="currentColor"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>購物車</span></div>
                                                        <div class="section-desc">查看購物車內容</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/dashboard/wishlist">
                                                    <div class="section-icon bg-pink-50 text-pink-600">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" fill="currentColor"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>心願清單</span></div>
                                                        <div class="section-desc">管理收藏的應用程式</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/dashboard/profile">
                                                    <div class="section-icon bg-blue-50 text-blue-600">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" fill="currentColor"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>個人資料</span></div>
                                                        <div class="section-desc">編輯個人資料</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/dashboard/settings">
                                                    <div class="section-icon bg-green-50 text-green-600">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.82,11.69,4.82,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z" fill="currentColor"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>帳戶設定</span></div>
                                                        <div class="section-desc">管理帳戶設定</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/dashboard/billing">
                                                    <div class="section-icon bg-yellow-50 text-yellow-600">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" fill="currentColor"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>付款設定</span></div>
                                                        <div class="section-desc">管理付款方式和帳單</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <a class="section-link" href="/dashboard/workflows">
                                                    <div class="section-icon bg-orange-50 text-orange-600">
                                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8.99996 23.66L20.54 9.90997H15V0.159973L3.45996 13.91H8.99996V23.66Z" fill="currentColor"/>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <div class="section-label"><span>我的工作流程</span></div>
                                                        <div class="section-desc">查看和管理工作流程</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="section-item">
                                                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                                                    @csrf
                                                    <button type="submit" class="section-link w-full text-left">
                                                        <div class="section-icon bg-red-50 text-red-600">
                                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" fill="currentColor"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="section-label"><span>登出</span></div>
                                                            <div class="section-desc">登出系統</div>
                                                        </div>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </details>
            </div>
        @else
            {{-- 未登入用戶：顯示登入和註冊按鈕 --}}
            <div class="flex items-center gap-2" data-testid="auth-links">
            <span class="hidden desktop:inline">
                <a class="nav-link" href="/login" aria-label="登入">
                <span>登入</span>
                </a>
            </span>
            <span class="auth-button">
                <a href="/sign-up" class="btn-primary">免費註冊</a>
            </span>
            </div>
        @endif
    @endif

    <!-- Mobile Navigation Toggle -->
    <div class="desktop:hidden">
    <details class="mobile-nav-root">
        <summary class="mobile-nav-summary" aria-label="Menu" data-testid="mobile-nav-summary">
        <span class="mobile-nav-open">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" size="24" aria-hidden="false" role="img" data-name="navMenu">
            <path d="M20 6H4V8H20V6Z" fill="currentColor"></path>
            <path d="M20 11H4V13H20V11Z" fill="currentColor"></path>
            <path d="M20 16H4V18H20V16Z" fill="currentColor"></path>
            </svg>
        </span>
        <span class="mobile-nav-close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" size="24" aria-hidden="false" role="img" data-name="formX">
            <path d="M18.3 5.71a.996.996 0 00-1.41 0L12 10.59 7.11 5.7A.996.996 0 105.7 7.11L10.59 12 5.7 16.89a.996.996 0 101.41 1.41L12 13.41l4.89 4.89a.996.996 0 101.41-1.41L13.41 12l4.89-4.89c.38-.38.38-1.02 0-1.4z" fill="currentColor"></path>
            </svg>
        </span>
        </summary>

        <!-- Mobile Navigation Panel -->
        <div class="mobile-nav-panel">
        <div class="mobile-nav-content">
            <nav>
            <ul class="mobile-nav-list">
                @if($isAdminInterface)
                    {{-- Admin 手機版導航 --}}
                    <li><a href="{{ route('admin.index') }}" class="mobile-nav-link">儀表板</a></li>
                    @if($isAdmin && in_array('s01', $permissions))
                    <li><a href="{{ route('admin.index') }}" class="mobile-nav-link">管理員管理</a></li>
                    @endif
                    @if($isAdmin && in_array('s00', $permissions))
                    <li><a href="{{ route('admin.permissions.index') }}" class="mobile-nav-link">權限管理</a></li>
                    @endif
                    @if($isAdmin && (in_array('s02', $permissions) || in_array('s03', $permissions)))
                    <li><a href="{{ route('products.index') }}" class="mobile-nav-link">產品管理</a></li>
                    @endif
                    <li><a href="{{ route('user.apps.index') }}" class="mobile-nav-link">應用程式管理</a></li>
                    <li><a href="/" class="mobile-nav-link">切換到用戶介面</a></li>
                @else
                    {{-- User 手機版導航 --}}
                    <li><a href="#" class="mobile-nav-link">產品</a></li>
                    <li><a href="#" class="mobile-nav-link">實現</a></li>
                    <li><a href="#" class="mobile-nav-link">資源</a></li>
                    <li><a href="#" class="mobile-nav-link">企業</a></li>
                    <li><a href="/pricing" class="mobile-nav-link">定價</a></li>
                    <li><a href="http://localhost:3000/editor" class="mobile-nav-link">工作區</a></li>
                    <li><a href="{{ route('user.apps.index') }}" class="mobile-nav-link">探索</a></li>
                @endif
            </ul>
            </nav>
        </div>

        <!-- 手機版頁腳 -->
        <div class="mobile-nav-footer">
            @if($isLoggedIn)
                <div class="mobile-auth-links">
                <span class="mobile-auth-link">{{ $currentUser->username ?? '用戶' }}</span>
                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="mobile-auth-button">登出</button>
                </form>
                </div>
            @else
                <div class="mobile-auth-links">
                <a href="/login" class="mobile-auth-link">登入</a>
                <a href="/sign-up" class="mobile-auth-button">免費註冊</a>
                </div>
            @endif
        </div>
        </div>
    </details>
    </div>
</div>
</header>

<style>
/* 基礎樣式 */
.nav-link {
  @apply flex items-center gap-1.5 py-2.5 px-2 text-sm text-header-text-secondary rounded no-underline outline-none;
  @apply hover:bg-header-button-hover focus-visible:bg-header-button-hover;
  @apply focus-visible:outline-2 focus-visible:outline-header-link-focus focus-visible:outline-offset-0.5;
}

/* 按鈕樣式 */
.btn-primary {
  @apply h-9 px-3 inline-flex items-center justify-center bg-primary-500 text-white font-semibold text-sm no-underline rounded-[18px] box-border transition-colors duration-250;
  @apply hover:bg-accent-amber;
}

.auth-button > a[data-size="large"] {
  @apply h-11 rounded-[22px];
}

/* ==== 下拉選單基礎樣式 ==== */
.dropdown-summary {
  @apply flex relative items-center py-2.5 px-2 pl-2.5 text-sm text-header-text-secondary rounded list-none cursor-pointer outline-none;
  @apply hover:bg-header-button-hover focus-visible:bg-header-button-hover;
  line-height:16px;
}
.dropdown-summary::-webkit-details-marker {
  @apply hidden;
}
.dropdown-summary::-webkit-details-maker {
    @apply hidden;
}
/* 底部指示線動畫 */
.dropdown-summary::after {
    content:"";
    @apply h-1 bg-header-dropdown-indicator w-0 absolute left-0 trasistion-all ease-in-out;
    bottom: -9.5px;
    trasition-duration: 0.25s;
}
.dropdown-container[open] .dropdown-summary::after {
    @apply w-full;
}

/* ==== 箭頭旋轉動畫 ==== */
.dropdown-indicator {
  @apply flex ml-1 transition-transform duration-250 ease-in-out;
}

.dropdown-container[open] .dropdown-indicator {
  @apply rotate-180;
}

/* 下拉選單面板樣式 */
.dropdown-panel {
  @apply w-full grid grid-cols-[auto_1fr] absolute top-14 left-0 bg-header-dropdown-bg border-b border-header-border content-around justify-center;
}

.dropdown-container[open] .dropdown-panel::after {
  content: "";
  @apply fixed left-0 right-0 h-screen bg-header-dropdown-overlay -z-10 pointer-events-none;
}

.dropdown-main {
  @apply w-full min-w-[50vw];
}

.dropdown-main:only-child {
  @apply col-span-2;
}

.dropdown-content {
  @apply py-8 px-10 box-border;
}

@media (min-width: 1280px) {
  .dropdown-content {
    @apply py-8 pr-16 pl-40;
  }
}

.dropdown-aside {
  @apply min-w-64 py-8 px-6 flex flex-col gap-12 bg-neutral-50;
}

@media (min-width: 1280px) {
  .dropdown-aside {
    @apply px-10;
  }
}

.dropdown-header {
  @apply max-w-[512px] mb-10;
}

.dropdown-heading {
  @apply text-[30px] font-semibold leading-none tracking-wide text-header-text-primary font-sans;

}

.dropdown-description {
  @apply text-sm leading-4 text-header-text-secondary mt-2;
}

.dropdown-sections {
  @apply flex gap-[72px];
  justify-content: auto;
}

.dropdown-footer {
  @apply py-5 px-10 border-t border-header-border;
}

@media (min-width: 1280px) {
  .dropdown-footer {
    @apply pl-40;
  }
}

.footer-list {
  @apply list-none flex gap-8;
}

.footer-link {
  @apply flex gap-1.5 text-[13px] font-medium leading-none no-underline text-header-text-primary;
  @apply hover:text-accent-amber focus-visible:outline-2 focus-visible:outline-header-link-focus focus-visible:outline-offset-1;
}

/* 區段樣式 */
.section-heading,
.aside-heading {
  @apply text-sm font-semibold leading-none tracking-wide uppercase text-header-text-disabled mb-4 font-sans;

}

.aside-heading {
  @apply text-[30px] tracking-wide text-header-text-primary mb-6 font-sans;
  text-transform: none;
}

.section-list {
  @apply flex flex-col gap-3 list-none;
}

.section-link {
  @apply w-fit max-w-96 flex items-start gap-2 no-underline text-header-text-primary;
  @apply focus-visible:outline-2 focus-visible:outline-header-link-focus focus-visible:outline-offset-1;
}

.section-icon {
  @apply flex text-header-text-primary p-2.5 rounded-lg bg-neutral-50;
}

.section-icon[class*="bg-orange"] {
  @apply bg-orange-50;
}

.section-icon[class*="bg-purple"] {
  @apply bg-purple-50;
}

.section-item:not(:last-child) .section-icon {
  @apply mb-2;
}

.section-label {
  @apply flex gap-1.5 text-sm font-medium leading-5;
}

.section-link:hover .section-label {
  @apply text-accent-amber;
}

.section-desc {
  @apply text-[13px] leading-5 text-header-text-muted mt-1;
}

.section-link:hover .section-desc {
  @apply underline;
}

.section-item:not(:last-child) .section-desc {
  @apply mb-2;
}

.beta-tag {
  @apply h-auto px-1 inline-flex items-center justify-center text-[13px] font-medium leading-5 text-center text-header-text-disabled border border-neutral-400 rounded-sm;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 桌面版下拉選單控制
    const handleDropdownToggle = (event) => {
        const target = event.target;

        if (target.tagName === 'DETAILS' && target.hasAttribute('data-testid') && target.getAttribute('data-testid') === 'nav-dropdown') {
            if (target.open) {
                // 當前下拉選單剛剛被開啟，關閉其他桌面版下拉選單
                const allDropdowns = document.querySelectorAll('details[data-testid="nav-dropdown"]');
                allDropdowns.forEach(dropdown => {
                    if (dropdown !== target && dropdown.open) {
                        dropdown.open = false;
                    }
                });
            }
        }
    };

    // 點擊外部關閉功能
    const handleClickOutside = (event) => {
        const target = event.target;
        const header = document.querySelector('header[data-testid="header"]');

        if (header && !header.contains(target)) {
            // 關閉所有下拉選單
            const dropdowns = document.querySelectorAll('details[data-testid="nav-dropdown"][open]');
            dropdowns.forEach(dropdown => {
                dropdown.open = false;
            });
        }
    };

    // 鍵盤導航支援
    const handleKeyDown = (event) => {
        if (event.key === 'Escape') {
            // 關閉所有下拉選單
            const dropdowns = document.querySelectorAll('details[data-testid="nav-dropdown"][open]');
            dropdowns.forEach(dropdown => {
                dropdown.open = false;
            });
        }
    };

    // 添加事件監聽器
    document.addEventListener('click', handleClickOutside);
    document.addEventListener('keydown', handleKeyDown);

    // 為桌面版下拉選單添加事件監聽器
    const dropdowns = document.querySelectorAll('details[data-testid="nav-dropdown"]');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('toggle', handleDropdownToggle);
    });

    console.log('Header navigation initialized with', dropdowns.length, 'dropdowns');
});
</script>
