{{-- 應用程式詳細資訊模板 --}}
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">
            <!-- 主要內容 -->
            <div class="lg:col-span-2 space-y-8">
                
                {{-- 應用程式描述 --}}
                <div class="border-b border-gray-200 pb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">關於 {{ $app->name }}</h2>
                    @if($app->detail)
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! $app->detail !!}
                        </div>
                    @else
                        <p class="text-gray-600 text-lg">{{ $app->description ?: '這是一個強大的應用程式，可以幫助您提升工作效率。' }}</p>
                    @endif
                </div>

                {{-- 主要功能 --}}
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">主要功能</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">自動化工作流程</h4>
                                <p class="text-sm text-gray-600 mt-1">建立自動化流程，節省重複性工作時間</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">即時同步</h4>
                                <p class="text-sm text-gray-600 mt-1">資料即時同步，確保資訊一致性</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">多平台整合</h4>
                                <p class="text-sm text-gray-600 mt-1">與多種應用程式無縫整合</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">安全可靠</h4>
                                <p class="text-sm text-gray-600 mt-1">企業級安全保護，資料傳輸加密</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 常見整合範例 --}}
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">常見整合範例</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-sync-alt text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">自動同步資料</h4>
                                <p class="text-sm text-gray-600">當 {{ $app->name }} 中有新資料時，自動同步到其他應用程式，確保資訊一致性。</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bell text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">即時通知</h4>
                                <p class="text-sm text-gray-600">重要事件發生時，立即發送通知到 Slack、Email 或其他通訊平台。</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-bar text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">資料分析</h4>
                                <p class="text-sm text-gray-600">自動收集和分析資料，產生報告並發送到指定位置。</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 技術規格 --}}
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">技術規格</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">支援的觸發器</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-dot-circle text-blue-500 text-xs"></i>
                                    <span>新增記錄時</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-dot-circle text-blue-500 text-xs"></i>
                                    <span>更新記錄時</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-dot-circle text-blue-500 text-xs"></i>
                                    <span>刪除記錄時</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-dot-circle text-blue-500 text-xs"></i>
                                    <span>定時觸發</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3">支援的動作</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-dot-circle text-green-500 text-xs"></i>
                                    <span>建立新記錄</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-dot-circle text-green-500 text-xs"></i>
                                    <span>更新現有記錄</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-dot-circle text-green-500 text-xs"></i>
                                    <span>搜尋記錄</span>
                                </li>
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-dot-circle text-green-500 text-xs"></i>
                                    <span>發送通知</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 側邊欄 -->
            <div class="lg:col-span-1 mt-8 lg:mt-0">
                <div class="space-y-6">
                    {{-- 快速資訊 --}}
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">快速資訊</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">分類</span>
                                <span class="text-sm font-medium text-gray-900">{{ $app->category }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">價格</span>
                                <span class="text-sm font-medium text-gray-900">
                                    @if($app->price == 0)
                                        免費
                                    @else
                                        ${{ number_format($app->price, 0) }}
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">狀態</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    已驗證
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- 開始整合按鈕 --}}
                    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg p-6 text-white">
                        <h4 class="font-semibold mb-2">準備開始？</h4>
                        <p class="text-sm text-primary-100 mb-4">立即建立您的第一個自動化工作流程</p>
                        <a href="{{ route('user.apps.integrations', $app->id) }}" 
                           class="inline-flex items-center justify-center w-full px-4 py-2 bg-white text-primary-600 font-medium rounded-md hover:bg-primary-50 transition-colors duration-200">
                            <i class="fas fa-rocket mr-2"></i>
                            開始整合
                        </a>
                    </div>

                    {{-- 需要協助 --}}
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-3">需要協助？</h4>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center text-sm text-gray-600 hover:text-primary-600 transition-colors">
                                <i class="fas fa-book mr-2"></i>
                                查看說明文件
                            </a>
                            <a href="#" class="flex items-center text-sm text-gray-600 hover:text-primary-600 transition-colors">
                                <i class="fas fa-video mr-2"></i>
                                觀看教學影片
                            </a>
                            <a href="#" class="flex items-center text-sm text-gray-600 hover:text-primary-600 transition-colors">
                                <i class="fas fa-comments mr-2"></i>
                                聯絡客服
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
