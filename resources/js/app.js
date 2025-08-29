import './bootstrap';

// Header Navigation 下拉選單功能
document.addEventListener('DOMContentLoaded', function() {
    // 處理桌面版下拉選單
    const dropdownContainers = document.querySelectorAll('.dropdown-container');

    dropdownContainers.forEach(container => {
        const summary = container.querySelector('.dropdown-summary');

        if (summary) {
            // 點擊其他地方關閉下拉選單
            document.addEventListener('click', function(event) {
                if (!container.contains(event.target) && container.hasAttribute('open')) {
                    container.removeAttribute('open');
                }
            });

            // 防止點擊下拉面板時關閉選單
            const panel = container.querySelector('.dropdown-panel');
            if (panel) {
                panel.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
        }
    });

    // 處理手機版導航選單
    const mobileNavRoot = document.querySelector('.mobile-nav-root');
    if (mobileNavRoot) {
        const mobileNavSummary = mobileNavRoot.querySelector('.mobile-nav-summary');

        if (mobileNavSummary) {
            // 點擊其他地方關閉手機版選單
            document.addEventListener('click', function(event) {
                if (!mobileNavRoot.contains(event.target) && mobileNavRoot.hasAttribute('open')) {
                    mobileNavRoot.removeAttribute('open');
                }
            });

            // 防止點擊選單內容時關閉選單
            const mobilePanel = mobileNavRoot.querySelector('.mobile-nav-panel');
            if (mobilePanel) {
                mobilePanel.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
        }
    }

    // 處理手機版下拉選單
    const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');
    mobileDropdowns.forEach(dropdown => {
        const summary = dropdown.querySelector('.mobile-dropdown-summary');

        if (summary) {
            // 防止點擊下拉內容時關閉選單
            const content = dropdown.querySelector('.mobile-dropdown-content');
            if (content) {
                content.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
        }
    });

    // ESC 鍵關閉所有開啟的選單
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            // 關閉桌面版下拉選單
            dropdownContainers.forEach(container => {
                if (container.hasAttribute('open')) {
                    container.removeAttribute('open');
                }
            });

            // 關閉手機版導航選單
            if (mobileNavRoot && mobileNavRoot.hasAttribute('open')) {
                mobileNavRoot.removeAttribute('open');
            }

            // 關閉手機版下拉選單
            mobileDropdowns.forEach(dropdown => {
                if (dropdown.hasAttribute('open')) {
                    dropdown.removeAttribute('open');
                }
            });
        }
    });
});
