// 图片懒加载功能
(function() {
    // 兼容性检查：检查浏览器是否支持必要的特性
    function checkSupport() {
        return {
            intersectionObserver: 'IntersectionObserver' in window,
            classList: 'classList' in document.documentElement,
            dataset: 'dataset' in document.documentElement,
            querySelectorAll: 'querySelectorAll' in document
        };
    }

    // 图片懒加载类
    function ImageLazyLoader() {
        this.observer = null;
        this.support = checkSupport();
        this.init();
    }

    ImageLazyLoader.prototype.init = function() {
        // 检查浏览器是否支持 Intersection Observer
        if (this.support.intersectionObserver) {
            this.setupObserver();
            this.observeImages();
        } else {
            // 降级方案：直接加载所有图片
            this.loadAllImages();
        }
    };

    ImageLazyLoader.prototype.setupObserver = function() {
        try {
            this.observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var element = entry.target;
                        this.loadImage(element);
                        this.observer.unobserve(element);
                    }
                }.bind(this));
            }.bind(this), {
                // 提前500px开始加载
                rootMargin: '500px 0px',
                threshold: 0.01
            });
        } catch (e) {
            // 如果创建Observer失败，使用降级方案
            console.log('创建IntersectionObserver失败，使用降级方案:', e.message);
            this.loadAllImages();
        }
    };

    ImageLazyLoader.prototype.observeImages = function() {
        if (!this.support.querySelectorAll) {
            // 降级方案：直接加载所有图片
            this.loadAllImages();
            return;
        }

        // 观察带 lazyload 类的图片
        var lazyImages = document.querySelectorAll('.lazyload');
        for (var i = 0; i < lazyImages.length; i++) {
            var img = lazyImages[i];
            if (this.observer) {
                this.observer.observe(img);
            } else {
                this.loadImage(img);
            }
        }

        // 观察带 AKAROMlazyload 类的背景图片
        var lazyBgImages = document.querySelectorAll('.AKAROMlazyload');
        for (var i = 0; i < lazyBgImages.length; i++) {
            var element = lazyBgImages[i];
            if (this.observer) {
                this.observer.observe(element);
            } else {
                this.loadImage(element);
            }
        }
    };

    ImageLazyLoader.prototype.loadImage = function(element) {
        if (!element) return;

        if (element.tagName === 'IMG' && element.dataset && element.dataset.src) {
            // 加载 <img> 标签
            var src = element.dataset.src;
            
            element.onload = function() {
                if (this.support.classList) {
                    element.classList.add('loaded');
                } else {
                    element.className += ' loaded';
                }
                // 移除占位符样式
                element.style.opacity = '1';
            }.bind(this);
            
            element.onerror = function() {
                // 加载失败时显示错误占位符
                element.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="300" viewBox="0 0 400 300%22%3E%3Crect width="400" height="300" fill="%23f0f0f0"/%3E%3Ctext x="200" y="150" font-size="14" text-anchor="middle" fill="%23ff4444"%3E图片加载失败%3C/text%3E%3C/svg%3E';
                if (this.support.classList) {
                    element.classList.add('error');
                } else {
                    element.className += ' error';
                }
            }.bind(this);
            
            // 开始加载
            element.src = src;
            // 移除 data-src 属性
            if (element.dataset) {
                delete element.dataset.src;
            } else {
                element.removeAttribute('data-src');
            }
        } else if (element.classList && element.classList.contains('AKAROMlazyload') && element.dataset && element.dataset.bg) {
            // 加载背景图片
            var bgUrl = element.dataset.bg;
            var img = new Image();
            
            img.onload = function() {
                element.style.backgroundImage = 'url(' + bgUrl + ')';
                if (this.support.classList) {
                    element.classList.add('loaded');
                } else {
                    element.className += ' loaded';
                }
            }.bind(this);
            
            img.onerror = function() {
                // 加载失败时使用默认背景色
                element.style.backgroundColor = '#f0f0f0';
                if (this.support.classList) {
                    element.classList.add('error');
                } else {
                    element.className += ' error';
                }
            }.bind(this);
            
            // 开始加载
            img.src = bgUrl;
            // 移除 data-bg 属性
            if (element.dataset) {
                delete element.dataset.bg;
            } else {
                element.removeAttribute('data-bg');
            }
        }
    };

    ImageLazyLoader.prototype.loadAllImages = function() {
        if (!this.support.querySelectorAll) return;

        // 降级方案：直接加载所有图片
        var lazyImages = document.querySelectorAll('.lazyload');
        for (var i = 0; i < lazyImages.length; i++) {
            var img = lazyImages[i];
            if (img.dataset && img.dataset.src) {
                img.src = img.dataset.src;
                if (img.dataset) {
                    delete img.dataset.src;
                } else {
                    img.removeAttribute('data-src');
                }
                if (this.support.classList) {
                    img.classList.add('loaded');
                } else {
                    img.className += ' loaded';
                }
            }
        }

        var lazyBgImages = document.querySelectorAll('.AKAROMlazyload');
        for (var i = 0; i < lazyBgImages.length; i++) {
            var element = lazyBgImages[i];
            if (element.dataset && element.dataset.bg) {
                element.style.backgroundImage = 'url(' + element.dataset.bg + ')';
                if (element.dataset) {
                    delete element.dataset.bg;
                } else {
                    element.removeAttribute('data-bg');
                }
                if (this.support.classList) {
                    element.classList.add('loaded');
                } else {
                    element.className += ' loaded';
                }
            }
        }
    };

    // 重新观察新添加的图片
    ImageLazyLoader.prototype.observeNewImages = function() {
        if (this.observer) {
            this.observeImages();
        } else {
            this.loadAllImages();
        }
    };

    // 初始化懒加载
    function initLazyLoader() {
        window.imageLazyLoader = new ImageLazyLoader();
    }

    // 页面加载完成后初始化
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLazyLoader);
    } else {
        initLazyLoader();
    }

    // 添加CSS样式
    function addStyles() {
        var styles = '
/* 懒加载图片样式 */
.lazyload {
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    background-color: #f0f0f0;
}

.lazyload.loaded {
    opacity: 1;
}

.lazyload.error {
    opacity: 1;
}

/* 背景图片懒加载样式 */
.AKAROMlazyload {
    background-color: #f0f0f0;
    background-size: cover;
    background-position: center;
    transition: background-image 0.3s ease-in-out;
}

.AKAROMlazyload.loaded {
    background-color: transparent;
}

/* 图片容器样式 */
.akarom-imgbox {
    position: relative;
    overflow: hidden;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.akarom-imgbox .center {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f0f0f0;
    transition: opacity 0.3s ease-in-out;
}

.akarom-imgbox img.loaded + .center {
    opacity: 0;
    pointer-events: none;
}
';

        var styleSheet = document.createElement('style');
        if (styleSheet.styleSheet) {
            // IE8及以下
            styleSheet.styleSheet.cssText = styles;
        } else {
            // 现代浏览器
            styleSheet.textContent = styles;
        }
        document.head.appendChild(styleSheet);
    }

    // 添加样式
    addStyles();

    // 暴露API
    window.ImageLazyLoader = ImageLazyLoader;
})();