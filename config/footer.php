<?php
/**

    _    _  __    _    ____  _   _ ___ 
   / \  | |/ /   / \  / ___|| | | |_ _|
  / _ \ | ' /   / _ \ \___ \| |_| || | 
 / ___ \| . \  / ___ \ ___) |  _  || | 
/_/   \_\_|\_\/_/   \_\____/|_| |_|___|

 * [Romanticism]
 * footer.php 页脚文件
 * @version 2.2 - 250710
**/
?>

<div class="mdui-shadow-0 mdui-text-center mdui-card toup">
<br>

      <br>
      <span class="title">
        &copy;<?php echo date("Y"); ?> <?php $this->options->title(); ?>
        <br>
        <?php if($this->options->AKAROMfootericp):?>
            <?php echo'<br>';
                  echo $this->options->AKAROMfootericp; ?>
        </span><br>
          <?php else: ?>
            </span>
        <?php endif;?>
         <br>
         <!-- 已经弄得很不显眼了，请不要删除以下信息 -->
      <small style="opacity: .2;">Theme <b><a class="chameleon underline"href="https://imakashi.com/blog/archives/themeRomanticism.html">Romanticism2.2</a></b> by <a class="chameleon underline" href="https://imakashi.com/"><b>Akashi</b></a>
      <br>
      Powered by <a class="chameleon underline" href="https://typecho.org"><b>Typecho</b></a></small>
      <br><br>
    </div>

    <script>
        document.getElementById("switch-theme").addEventListener("click", () => {
            const isDark = document.body.classList.toggle("mdui-theme-layout-dark");
            if(isDark){
                localStorage.romanticismTheme = true;
            }else{
                delete localStorage.romanticismTheme;
            }
        });
    </script>

    <script src="<?php $this->options->themeUrl('config/mdui/js/mdui.min.js'); ?>" defer></script>
    <script src="<?php $this->options->themeUrl('config/js/jquery.min.js'); ?>" defer></script>
    
    <script src="<?php $this->options->themeUrl('config/js/lazyload.js?v=2.2'); ?>" defer></script>
    <script src="<?php $this->options->themeUrl('config/js/tagIcon.js?v=2.2'); ?>" defer></script>
    <script src="<?php $this->options->themeUrl('config/js/customStyle.js?v=2.2'); ?>" defer></script>
    <script src="<?php $this->options->themeUrl('config/js/returntop.js?v=2.2'); ?>" defer></script>
    <script src="<?php $this->options->themeUrl('config/js/prism.highlight.js'); ?>" defer></script>

    <script src="<?php $this->options->themeUrl('config/js/jquery.fancybox.min.js'); ?>" defer></script>
    <?php if (!empty($this->options->AKAROMfucset) && in_array('AKAROMindexloading', $this->options->AKAROMfucset)): ?>
    <script type="text/javascript" src="<?php $this->options->themeUrl('config/js/loading.js?v=2.2'); ?>" defer></script>
    <?php endif; ?>
    
    <script src="<?php $this->options->themeUrl('config/js/OwO.js'); ?>" defer></script>
    
    <script>
    // 等待所有脚本加载完成
    window.addEventListener('DOMContentLoaded', function() {
        // 初始化Fancybox
        if (typeof $ !== 'undefined' && $.fancybox) {
            $( ".fancybox").fancybox();
        }
        
        // 初始化OwO
        if (typeof $ !== 'undefined') {
            window.OwO_show = function() {
                if ($(".OwO-items").css("max-height") == '0px') {
                    $(".OwO").addClass("OwO-open");
                } else {
                    $(".OwO").removeClass("OwO-open");
                }
            };
        }
    });
    </script>

    <script src="<?php $this->options->themeUrl('config/js/md5.min.js'); ?>" defer></script>
    <script src="<?php $this->options->themeUrl('config/js/preheadicon.js?v=2.2'); ?>" defer></script>

    <!-- 自定义JS -->
    <?php if(!empty($this->options->AKAROMcustomJs)): ?>
        <script type="text/javascript" defer>
            <?php $this->options->AKAROMcustomJs(); ?>
        </script>
    <?php endif; ?>

    <?php $this->footer(); ?>
    
    <!-- 性能监控代码 -->
    <script>
    // 性能监控
    (function() {
        // 核心Web指标监控
        const metrics = {
            lcp: 0,
            fid: 0,
            cls: 0
        };
        
        // 监控LCP（最大内容绘制）
        try {
            new PerformanceObserver((entries) => {
                const lcpEntry = entries.getEntries()[0];
                if (lcpEntry) {
                    metrics.lcp = lcpEntry.startTime;
                    console.log('LCP:', metrics.lcp, 'ms');
                }
            }).observe({ type: 'largest-contentful-paint', buffered: true });
        } catch (e) {
            console.log('浏览器不支持LCP监控:', e.message);
        }
        
        // 监控FID（首次输入延迟）
        try {
            new PerformanceObserver((entries) => {
                const fidEntry = entries.getEntries()[0];
                if (fidEntry) {
                    metrics.fid = fidEntry.processingStart - fidEntry.startTime;
                    console.log('FID:', metrics.fid, 'ms');
                }
            }).observe({ type: 'first-input', buffered: true });
        } catch (e) {
            console.log('浏览器不支持FID监控:', e.message);
        }
        
        // 监控CLS（累积布局偏移）
        try {
            let cumulativeLayoutShift = 0;
            
            new PerformanceObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.hadRecentInput) {
                        cumulativeLayoutShift += entry.value;
                        metrics.cls = cumulativeLayoutShift;
                        console.log('CLS:', metrics.cls);
                    }
                });
            }).observe({ type: 'layout-shift', buffered: true });
        } catch (e) {
            console.log('浏览器不支持CLS监控:', e.message);
        }
        
        // 页面加载完成后报告性能指标
        window.addEventListener('load', function() {
            setTimeout(() => {
                console.log('=== 性能指标报告 ===');
                console.log('LCP (最大内容绘制):', metrics.lcp.toFixed(2), 'ms');
                console.log('FID (首次输入延迟):', metrics.fid.toFixed(2), 'ms');
                console.log('CLS (累积布局偏移):', metrics.cls.toFixed(4));
                console.log('================================');
                
                // 检查是否达到性能目标
                const targets = {
                    lcp: 2500, // 2.5秒
                    fid: 100,  // 100毫秒
                    cls: 0.1   // 0.1
                };
                
                console.log('=== 性能目标检查 ===');
                console.log('LCP <', targets.lcp, 'ms:', metrics.lcp < targets.lcp ? '✓' : '✗');
                console.log('FID <', targets.fid, 'ms:', metrics.fid < targets.fid ? '✓' : '✗');
                console.log('CLS <', targets.cls, ':', metrics.cls < targets.cls ? '✓' : '✗');
                console.log('================================');
            }, 1000);
        });
        
        // 网络请求性能监控
        if ('navigation' in performance) {
            const navTiming = performance.getEntriesByType('navigation')[0];
            if (navTiming) {
                console.log('=== 网络性能指标 ===');
                console.log('页面加载时间:', (navTiming.loadEventEnd - navTiming.navigationStart).toFixed(2), 'ms');
                console.log('DNS解析时间:', (navTiming.domainLookupEnd - navTiming.domainLookupStart).toFixed(2), 'ms');
                console.log('TCP连接时间:', (navTiming.connectEnd - navTiming.connectStart).toFixed(2), 'ms');
                console.log('首字节时间(TTFB):', (navTiming.responseStart - navTiming.navigationStart).toFixed(2), 'ms');
                console.log('内容下载时间:', (navTiming.responseEnd - navTiming.responseStart).toFixed(2), 'ms');
                console.log('================================');
            }
        }
    })();
    </script>
</div>
</body>
</html>
