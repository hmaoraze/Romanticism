<?php
/**

    _    _  __    _    ____  _   _ ___ 
   / \  | |/ /   / \  / ___|| | | |_ _|
  / _ \ | ' /   / _ \ \___ \| |_| || | 
 / ___ \| . \  / ___ \ ___) |  _  || | 
/_/   \_\_|\_\/_/   \_\____/|_| |_|___|

 * [Romanticism]
 * functions.php 主题基本配置文件
 * @version 2.2
 * @link https://imakashi.eu.org/
**/

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {  //后台设置界面
?>
    
    <style type="text/css">
        hr{
            width:100%;
            border:none;
            border-top:2px dashed #DCDCDC;
        }
        img{
            height:75px;
            margin-bottom: -5px;
            margin-right: -10px;
        }
    </style>
    <h1><img src="<?php echo Helper::options()->themeUrl.'/config/style/img/icon.png'; ?>">主题设置</h1>
    <p><button id="checkUpdateBtn" class="btn">检查更新</button> · 当前版本: 2.2 · <a href="https://github.com/akashiwest/Romanticism" target="_blank">Github 文档</a></p>
    <div id="updateStatus"></div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const checkUpdateBtn = document.getElementById('checkUpdateBtn');
    const updateStatus = document.getElementById('updateStatus');
    
    function escapeHTML(str) {
        const div = document.createElement('div');
        div.textContent = str ?? '';
        return div.innerHTML;
    }
    
    function sanitizeURL(url) {
        try {
            const parsed = new URL(url);
            if (parsed.protocol === 'http:' || parsed.protocol === 'https:') {
                return url;
            }
        } catch (e) {}
        return '#';
    }
    
    checkUpdateBtn.addEventListener('click', function() {
        updateStatus.innerHTML = "<p><b>检查更新中...</b></p>";
        checkUpdateBtn.disabled = true;
        
        fetch('<?php echo Helper::options()->themeUrl . "/update.php"; ?>')
            .then(response => {
                if (!response.ok) throw new Error('网络响应错误');
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    updateStatus.innerHTML = `
                        <p style="color:Crimson;"><b>${escapeHTML(data.error)}</b></p>
                    `;
                    return;
                }
                
                if (data.current_version !== data.latest_version) {
                    updateStatus.innerHTML = `
                        <p><b>最新版本:</b> ${escapeHTML(data.latest_version)}</p>
                        <p><b>更新内容:</b> ${escapeHTML(data.feature)}</p>
                        <p><a href="${sanitizeURL(data.update_url)}" target="_blank" rel="noopener noreferrer"><b>点击下载更新</b></a></p>
                    `;
                } else {
                    updateStatus.innerHTML = `
                        <p style="color:ForestGreen;"><b>当前已是最新版本</b></p>
                    `;
                }
            })
            .catch(error => {
                updateStatus.innerHTML = `
                    <p style="color:Crimson;"><b>检查更新失败: ${escapeHTML(error.message)}</b></p>
                `;
            })
            .finally(() => {
                checkUpdateBtn.disabled = false;
            });
        });
    });
    </script>
    <style>
        button.primary{
            position: fixed;
            bottom: 50px;
            left: 50px;
        }
        @media(max-width:500px){
            button.primary{
                position: fixed;
                bottom: 50px;
                left: 0px; 
            }
            }
    </style>
    <hr>
    <p>请前往Typecho自带的设置界面来设置博客名称与描述。</p>


    <?php
    $AKAROMlogoUrl = new Typecho_Widget_Helper_Form_Element_Text('AKAROMlogoUrl', NULL, NULL, _t('设置您的头像'), _t('在这里填入一个图片 url 地址，将会显示在侧边栏上部。'));
    $form->addInput($AKAROMlogoUrl);

    $AKAROMindeximg = new Typecho_Widget_Helper_Form_Element_Text('AKAROMindeximg', NULL, NULL, _t('设置首页主题图'), _t('在这里填入一个图片 url 地址。'));
    $form->addInput($AKAROMindeximg);

    $AKAROMsidebarimg = new Typecho_Widget_Helper_Form_Element_Text('AKAROMsidebarimg', NULL, NULL, _t('设置侧边栏顶图'), _t('在这里填入一个图片 url 地址，将会显示在侧边栏上部。'));
    $form->addInput($AKAROMsidebarimg);

    $AKAROMsign = new Typecho_Widget_Helper_Form_Element_Text('AKAROMsign', NULL, NULL, _t('设置网站图标'), _t('在这里填入一个图片 url 地址，将会显示在浏览器标签栏。'));
    $form->addInput($AKAROMsign);

    $AKAROMindexslogen = new Typecho_Widget_Helper_Form_Element_Text('AKAROMindexslogen', NULL, NULL, _t('设置短描述'), _t('在这里填入一段文字，会显示在首页顶部和友情链接。为了搜索引擎收录优化，您可以在 Typecho 自带的设置界面设置一个50-100字的对博客的详细描述，他们不会显示在主题中。'));
    $form->addInput($AKAROMindexslogen);

    $AKAROMinfobox = new Typecho_Widget_Helper_Form_Element_Text('AKAROMinfobox', NULL, NULL, _t('设置公告'), _t('输入一些公告或通知，将会显示在首页。'));
    $form->addInput($AKAROMinfobox);
    $AKAROMsticky = new Typecho_Widget_Helper_Form_Element_Text('AKAROMsticky', NULL, NULL, _t('置顶文章'), _t('填入文章的 cid，多个数值以半角逗号分隔。例如：21,15,3'));
    $form->addInput($AKAROMsticky);
    
    $AKAROMLinksterms = new Typecho_Widget_Helper_Form_Element_Textarea('AKAROMLinksterms', NULL, NULL, _t('设置交换友情链接的要求'), _t('此段文字将会显示在“友情链接页”；<br>您可以填入例如 <b>1.不接受违法站点；2.先友后链</b> 等信息。<br><b>注意：</b>请先创建一个空页面，在自定义模板中选择“友情链接页”。'));
    $form->addInput($AKAROMLinksterms);

    $AKAROMLinkstermsUrl = new Typecho_Widget_Helper_Form_Element_Text('AKAROMLinkstermsUrl', NULL, NULL, _t('设置交换友链的本站链接'), _t('供申请友链的朋友填写，可以是个人主页而不是此博客页面。'));
    $form->addInput($AKAROMLinkstermsUrl);

    $AKAROMrewardimg = new Typecho_Widget_Helper_Form_Element_Text('AKAROMrewardimg', NULL, NULL, _t('设置赞赏图片'), _t('可填入收款码等图片的 url 地址，会出现在文章界面末尾。不填则不显示。'));
    $form->addInput($AKAROMrewardimg);

    $AKAROMfootericp = new Typecho_Widget_Helper_Form_Element_Text('AKAROMfootericp', NULL, NULL, _t('设置页脚备案信息'), _t('此处填入的信息将会显示在页脚备案信息区，请依据博客情况填写。不填则不显示备案信息。可以使用 html 标签'));
    $form->addInput($AKAROMfootericp);

    // 首页加载动画
    $AKAROMfucset = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMfucset', 
        array('AKAROMindexloading' => _t('开启此选项将会在站点加载时显示加载动画。')),
        array(), // 默认不勾选，传空数组
        _t('首页加载动画')
    );
    $form->addInput($AKAROMfucset->multiMode());

    // 评论区验证码
    $AKAROMfucsetcaptcha = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMfucsetcaptcha', 
        array('AKAROMsetcaptcha' => _t('不启用')),
        array(), // 默认不勾选
        _t('评论区简单验证码')
    );
    $form->addInput($AKAROMfucsetcaptcha->multiMode());

    $AKAROMcustomCss = new Typecho_Widget_Helper_Form_Element_Textarea('AKAROMcustomCss', NULL, NULL, _t('自定义 CSS 代码'), _t('输入自定义的 CSS 代码，优先级为高'));
    $form->addInput($AKAROMcustomCss);

    $AKAROMcustomJs = new Typecho_Widget_Helper_Form_Element_Textarea('AKAROMcustomJs', NULL, NULL, _t('自定义 JS 代码（页脚）'), _t('可以在此处添加访客统计等 JavaScript 代码'));
    $form->addInput($AKAROMcustomJs);

    // SEO设置区域
    echo '<hr>';
    echo '<h2>SEO优化设置</h2>';
    
    $AKAROMseoKeywords = new Typecho_Widget_Helper_Form_Element_Text('AKAROMseoKeywords', NULL, NULL, _t('网站默认关键词'), _t('多个关键词用逗号分隔，建议不超过5个关键词'));
    $form->addInput($AKAROMseoKeywords);

    $AKAROMseoDescription = new Typecho_Widget_Helper_Form_Element_Textarea('AKAROMseoDescription', NULL, NULL, _t('网站默认描述'), _t('网站的默认描述，建议长度100-160字符'));
    $form->addInput($AKAROMseoDescription);

    $AKAROMseoTitleFormat = new Typecho_Widget_Helper_Form_Element_Select('AKAROMseoTitleFormat', array(
        'title-site' => _t('标题 - 网站名称'),
        'site-title' => _t('网站名称 - 标题'),
        'title' => _t('仅标题')
    ), 'title-site', _t('SEO标题格式'), _t('设置页面标题的显示格式'));
    $form->addInput($AKAROMseoTitleFormat);

    $AKAROMseoSeparator = new Typecho_Widget_Helper_Form_Element_Text('AKAROMseoSeparator', NULL, '-', _t('标题分隔符'), _t('设置标题中使用的分隔符，如 - 、| 等'));
    $form->addInput($AKAROMseoSeparator);

    $AKAROMseoBreadcrumb = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMseoBreadcrumb', 
        array('enable' => _t('启用面包屑导航')),
        array('enable'),
        _t('面包屑导航设置')
    );
    $form->addInput($AKAROMseoBreadcrumb->multiMode());

    $AKAROMseoRobots = new Typecho_Widget_Helper_Form_Element_Textarea('AKAROMseoRobots', NULL, "User-Agent: *\nAllow: /", _t('robots.txt设置'), _t('设置网站的robots.txt内容'));
    $form->addInput($AKAROMseoRobots);

    $AKAROMseoSitemap = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMseoSitemap', 
        array('enable' => _t('启用自动生成sitemap.xml')),
        array('enable'),
        _t('Sitemap设置')
    );
    $form->addInput($AKAROMseoSitemap->multiMode());
    
    // 又拍云图片处理设置
    echo '<hr>';
    echo '<h2>又拍云图片处理设置</h2>';
    
    $AKAROMupyunEnabled = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMupyunEnabled', 
        array('enable' => _t('启用又拍云图片处理')),
        array(),
        _t('功能开关')
    );
    $form->addInput($AKAROMupyunEnabled->multiMode());
    
    $AKAROMupyunSeparator = new Typecho_Widget_Helper_Form_Element_Select('AKAROMupyunSeparator', array(
        '!' => _t('!（感叹号，默认）'),
        '-' => _t('-（中划线）'),
        '_' => _t('_（下划线）')
    ), '!', _t('间隔标识符'), _t('用于分隔图片URL和处理参数的标识符'));
    $form->addInput($AKAROMupyunSeparator);
    
    $AKAROMupyunWebp = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMupyunWebp', 
        array('enable' => _t('优先使用WebP格式')),
        array('enable'),
        _t('WebP格式设置')
    );
    $form->addInput($AKAROMupyunWebp->multiMode());
    
    $AKAROMupyunWebpLossless = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMupyunWebpLossless', 
        array('enable' => _t('使用无损WebP压缩')),
        array(),
        _t('WebP压缩模式'),
        _t('仅对PNG等无损格式生效')
    );
    $form->addInput($AKAROMupyunWebpLossless->multiMode());
    
    $AKAROMupyunQuality = new Typecho_Widget_Helper_Form_Element_Text('AKAROMupyunQuality', NULL, '75', _t('图片质量'), _t('设置图片压缩质量，范围1-99，建议75'));
    $form->addInput($AKAROMupyunQuality);
    
    $AKAROMupyunCompress = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMupyunCompress', 
        array('enable' => _t('启用图片压缩优化')),
        array('enable'),
        _t('压缩设置'),
        _t('对JPG/PNG进行压缩以减少体积')
    );
    $form->addInput($AKAROMupyunCompress->multiMode());
    
    $AKAROMupyunProgressive = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMupyunProgressive', 
        array('enable' => _t('启用JPG渐进式加载')),
        array('enable'),
        _t('渐进式加载'),
        _t('使图片从模糊到清晰加载')
    );
    $form->addInput($AKAROMupyunProgressive->multiMode());
    
    $AKAROMupyunThumbnail = new Typecho_Widget_Helper_Form_Element_Text('AKAROMupyunThumbnail', NULL, 'fw/800', _t('默认缩略图设置'), _t('设置默认的图片处理参数，如fw/800表示限定宽度为800px'));
    $form->addInput($AKAROMupyunThumbnail);
}

function themeFields($layout) { //文章自定义字段功能
    // 添加页面图标字段
    if (preg_match("/write-page.php/", $_SERVER['REQUEST_URI'])) {
        $AKAROMarticleicon = new Typecho_Widget_Helper_Form_Element_Text(
            'AKAROMarticleicon',
            NULL,
            NULL,
            _t('页面图标'),
            _t('输入 <a href="https://www.mdui.org/docs/material_icon" target="_blank">Material Icons 图标名</a>,将显示在侧拉菜单。如留空将使用默认图标。')
        );
        $layout->addItem($AKAROMarticleicon);
    }

    $AKAROMarticleimg = new Typecho_Widget_Helper_Form_Element_Text('AKAROMarticleimg', NULL, NULL, _t('设置文章封面图'), _t('在这里填入一个图片 URL 地址。如未设置封面图将会自动显示随机图片。'));
    $layout->addItem($AKAROMarticleimg);

    $AKAROMarticleCopyright = new Typecho_Widget_Helper_Form_Element_Select('AKAROMarticleCopyright', array(
        'SA' => 'CC BY-NC-SA 版权协议',
        'ND' => 'CC BY-NC-ND 版权协议',
        'BAN' => '禁止转载',
        'hide' => '不显示'
    ), 'SA', _t('版权声明'), _t('将会在文章底部显示版权声明。选择你需要的版权种类'));
    $layout->addItem($AKAROMarticleCopyright);

    $AKAROMarticleSMS = new Typecho_Widget_Helper_Form_Element_Select('AKAROMarticleSMS', array(
        'default' => '长文章（默认）',
        'sms' => '短讯'
    ), 'default', _t('文章类型'), _t('当设置为 "短讯" 后则在首页拥有一个不一样的外观，适合一小段文字与单图片'));
    $layout->addItem($AKAROMarticleSMS);

    $AKAROMfucsetreward = new Typecho_Widget_Helper_Form_Element_Radio(
        'AKAROMfucsetreward',
        array(
            '0' => _t('显示赞赏按钮'),
            '1' => _t('隐藏')
        ),
        '0',
        _t('显示赞赏按钮')
    );
    $layout->addItem($AKAROMfucsetreward);

    $AKAROMarticlecolor = new Typecho_Widget_Helper_Form_Element_Text('AKAROMarticlecolor', NULL, NULL, _t('<b>已废弃选项</b><br><small>设置文章封面底色</small>'), _t('如未设置封面图将会自动显示随机图片。'));
    $layout->addItem($AKAROMarticlecolor);

    // 页面级SEO设置
    echo '<hr>';
    echo '<h3>SEO设置</h3>';
    
    $AKAROMseoTitle = new Typecho_Widget_Helper_Form_Element_Text('AKAROMseoTitle', NULL, NULL, _t('页面独立标题'), _t('留空则使用默认标题'));
    $layout->addItem($AKAROMseoTitle);

    $AKAROMseoPageKeywords = new Typecho_Widget_Helper_Form_Element_Text('AKAROMseoPageKeywords', NULL, NULL, _t('页面独立关键词'), _t('多个关键词用逗号分隔'));
    $layout->addItem($AKAROMseoPageKeywords);

    $AKAROMseoPageDescription = new Typecho_Widget_Helper_Form_Element_Textarea('AKAROMseoPageDescription', NULL, NULL, _t('页面独立描述'), _t('页面的描述，建议长度100-160字符'));
    $layout->addItem($AKAROMseoPageDescription);

    $AKAROMseoCanonical = new Typecho_Widget_Helper_Form_Element_Text('AKAROMseoCanonical', NULL, NULL, _t('Canonical URL'), _t('设置页面的规范URL，避免重复内容'));
    $layout->addItem($AKAROMseoCanonical);

    $AKAROMseoNofollow = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'AKAROMseoNofollow', 
        array('enable' => _t('添加nofollow标签')),
        array(),
        _t('Nofollow设置'),
        _t('对页面添加nofollow标签，阻止搜索引擎跟踪链接')
    );
    $layout->addItem($AKAROMseoNofollow->multiMode());
}


function themeInit($archive) {
    // 初始化SEO功能
    AKAROM_seo_init();
}


function Fancybox($content){ //Fancybox图片灯箱功能
    //以下参考自 Skywt 开发的 Daydream 主题（https://github.com/Skywt2003/Daydream），感谢大佬。
    $content = preg_replace_callback("/<img src=\"([^\"]*)\" alt=\"([^\"]*)\" title=\"([^\"]*)\">/i", function($matches) {
        $src = $matches[1];
        $alt = $matches[2];
        $title = $matches[3];
        
        // 应用又拍云图片处理
        $processedSrc = AKAROM_upyun_image_url($src);
        $processedHref = AKAROM_upyun_image_url($src, array('fw' => '1200')); // 灯箱使用较大尺寸
        
        return "<div data-fancybox=\"gallery\" href=\"$processedHref\" data-caption=\"$title\" class=\"akarom-imgbox btnyuan blur\"><div class=\"center mdui-valign\"><i class=\"mdui-list-item-icon mdui-icon material-icons\">photo</i>&nbsp;加载中</div><img class=\"btnyuan lazyload\" data-src=\"$processedSrc\" src=\"data:image/svg+xml,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" width=\"400\" height=\"300\" viewBox=\"0 0 400 300%22%3E%3Crect width=\"400\" height=\"300\" fill=\"%23f0f0f0\"/%3E%3Ctext x=\"200\" y=\"150\" font-size=\"14\" text-anchor=\"middle\" fill=\"%23999\"%3E加载中...%3C/text%3E%3C/svg%3E\" alt=\"$alt\" title=\"$title\" decoding=\"async\" onload=\"this.classList.add('loaded')\" onerror=\"this.style.height='50px'; this.previousElementSibling.innerHTML='图片加载失败';\"></div>";
    }, $content);
    return $content;
}

// 又拍云图片处理URL生成函数
function AKAROM_upyun_image_url($url, $params = array()) {
    $options = Helper::options();
    
    // 检查是否启用又拍云图片处理
    if (!$options->AKAROMupyunEnabled || !in_array('enable', $options->AKAROMupyunEnabled)) {
        return $url;
    }
    
    // 获取间隔标识符
    $separator = $options->AKAROMupyunSeparator ? $options->AKAROMupyunSeparator : '!';
    
    // 构建处理参数
    $processParams = array();
    
    // 添加默认缩略图设置
    if ($options->AKAROMupyunThumbnail) {
        $processParams[] = $options->AKAROMupyunThumbnail;
    }
    
    // 添加质量设置
    if ($options->AKAROMupyunQuality) {
        $processParams[] = 'quality/' . $options->AKAROMupyunQuality;
    }
    
    // 添加压缩设置
    if ($options->AKAROMupyunCompress && in_array('enable', $options->AKAROMupyunCompress)) {
        $processParams[] = 'compress/true';
    }
    
    // 添加渐进式加载设置
    if ($options->AKAROMupyunProgressive && in_array('enable', $options->AKAROMupyunProgressive)) {
        $processParams[] = 'progressive/true';
    }
    
    // 添加自定义参数
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $processParams[] = $key . '/' . $value;
        }
    }
    
    // 添加WebP格式设置
    if ($options->AKAROMupyunWebp && in_array('enable', $options->AKAROMupyunWebp)) {
        if ($options->AKAROMupyunWebpLossless && in_array('enable', $options->AKAROMupyunWebpLossless)) {
            $processParams[] = 'format/webp';
            $processParams[] = 'lossless/true';
        } else {
            $processParams[] = 'format/webp';
        }
    }
    
    // 构建完整的处理参数
    $processString = '';
    if (!empty($processParams)) {
        $processString = $separator . implode('/', $processParams);
    }
    
    // 生成最终URL
    return $url . $processString;
}

// 页面加载速度优化函数
function AKAROM_speed_optimization() {
    $options = Helper::options();
    
    // 输出预加载和预连接优化
    echo '<!-- 页面加载速度优化 -->
';
    
    // 预连接关键域名
    echo '<link rel="preconnect" href="https://fonts.loli.net">
';
    echo '<link rel="preconnect" href="https://p.upyun.com">
';
    
    // 预加载关键CSS文件
    echo '<link rel="preload" href="' . $options->themeUrl('config/mdui/css/mdui.min.css') . '" as="style" onload="this.onload=null;this.rel=stylesheet">
';
    echo '<link rel="preload" href="' . $options->themeUrl('config/style/romanticism.aka.css?v=2.2') . '" as="style" onload="this.onload=null;this.rel=stylesheet">
';
    
    // 预加载关键字体
    echo '<link rel="preload" href="https://fonts.loli.net/css2?family=Noto+Serif+SC:wght@400;900&amp;display=swap" as="style" onload="this.onload=null;this.rel=stylesheet">
';
    echo '<link rel="preload" href="' . $options->themeUrl('config/mdui/icons/material-icons/MaterialIcons-Regular.woff2') . '" as="font" type="font/woff2" crossorigin>
';
    
    // 预加载关键JavaScript文件
    echo '<link rel="preload" href="' . $options->themeUrl('config/mdui/js/mdui.min.js') . '" as="script">
';
    echo '<link rel="preload" href="' . $options->themeUrl('config/js/jquery.min.js') . '" as="script">
';
    echo '<link rel="preload" href="' . $options->themeUrl('config/js/lazyload.js?v=2.2') . '" as="script">
';
    
    // 预加载关键视觉资源
    if ($options->AKAROMlogoUrl) {
        $logoUrl = AKAROM_upyun_image_url($options->AKAROMlogoUrl);
        echo '<link rel="preload" href="' . htmlspecialchars($logoUrl) . '" as="image">
';
    }
    if ($options->AKAROMsidebarimg) {
        $sidebarImgUrl = AKAROM_upyun_image_url($options->AKAROMsidebarimg);
        echo '<link rel="preload" href="' . htmlspecialchars($sidebarImgUrl) . '" as="image">
';
    }
    if ($options->AKAROMindeximg) {
        $indexImgUrl = AKAROM_upyun_image_url($options->AKAROMindeximg);
        echo '<link rel="preload" href="' . htmlspecialchars($indexImgUrl) . '" as="image">
';
    }
    
    // 预加载关键资源的fallback
    echo '<noscript>
';
    echo '<link rel="stylesheet" href="' . $options->themeUrl('config/mdui/css/mdui.min.css') . '">
';
    echo '<link rel="stylesheet" href="' . $options->themeUrl('config/style/romanticism.aka.css?v=2.2') . '">
';
    echo '<link rel="stylesheet" href="https://fonts.loli.net/css2?family=Noto+Serif+SC:wght@400;900&amp;display=swap">
';
    echo '</noscript>
';
}

// 资源压缩检测函数
function AKAROM_check_compression() {
    // 检查服务器是否启用了gzip压缩
    $headers = headers_list();
    $compressionEnabled = false;
    
    foreach ($headers as $header) {
        if (stripos($header, 'content-encoding') !== false && (stripos($header, 'gzip') !== false || stripos($header, 'deflate') !== false)) {
            $compressionEnabled = true;
            break;
        }
    }
    
    return $compressionEnabled;
}

function AKAROM_simple_captcha_math() { // 评论区简单验证码
    $user = Typecho_Widget::widget('Widget_User');
    if ($user->hasLogin()) {
        // 已登录用户 -> 不显示验证码
        return;
    }

    $options = Helper::options();
    if (!empty($options->AKAROMfucsetcaptcha) && in_array('AKAROMsetcaptcha', $options->AKAROMfucsetcaptcha)){
        echo "
        <div class=\"mdui-textfield\" style=\"display:none;\">
            <i class=\"mdui-icon material-icons\">beach_access</i>
            <input class=\"mdui-textfield-input\" type=\"text\" name=\"sum\" id=\"sum\" value=\"2\">
        </div>
        ";
        echo "<input type=\"hidden\" name=\"num1\" value=\"1\">\n";
        echo "<input type=\"hidden\" name=\"num2\" value=\"1\"><br>";
    } else {
        $num1 = rand(1, 15);
        $num2 = rand(1, 15);
        echo "
        <div class=\"mdui-textfield\">
            <i class=\"mdui-icon material-icons\">beach_access</i>
            <input class=\"mdui-textfield-input\" type=\"text\" name=\"sum\" id=\"sum\" placeholder=\"$num1 + $num2 = ?\" required/>
            <div class=\"mdui-textfield-error\">验证码不能为空</div>
        </div>
        ";
        echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
        echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">";
    }
}

function AKAROM_simple_captcha($comment, $post, $result) { // 验证码判断
    $user = Typecho_Widget::widget('Widget_User');
    if ($user->hasLogin()) {
        // 已登录用户 -> 跳过验证
        return $comment;
    }

    if (!empty($_REQUEST['text'])) {
        if (empty($_POST['num1']) || empty($_POST['num2'])) {
            throw new Typecho_Widget_Exception(_t('验证码异常，请重试', '评论失败'));
        } else {
            $sum = $_POST['sum'];
            switch ($sum) {
                case $_POST['num1'] + $_POST['num2']: break;
                case null:
                    throw new Typecho_Widget_Exception(_t('请输入验证码，请重试', '评论失败'));
                    break;
                default:
                    throw new Typecho_Widget_Exception(_t('验证码错误，请重试', '评论失败'));
            }
        }
    }
    return $comment;
}




//github卡片
function getGitHubRepoInfo($url) {
    $parts = parse_url($url);
    if (!isset($parts['path'])) return false;

    $pathParts = array_values(array_filter(explode('/', $parts['path'])));
    if (count($pathParts) < 2) return false;

    $owner = $pathParts[0];
    $repo = preg_replace('/\.git$/', '', $pathParts[1]); // 去除.git后缀

    $cacheKey = md5("{$owner}/{$repo}");
    $cacheDir = __DIR__ . '/cache/githubapi';
    
    // 确保缓存目录路径安全
    $cacheDir = realpath($cacheDir) ?: $cacheDir;
    if (strpos($cacheDir, __DIR__) !== 0) {
        error_log("缓存目录路径不安全: $cacheDir");
        return false;
    }
    
    if (!file_exists($cacheDir) && !mkdir($cacheDir, 0700, true)) {
        error_log("无法创建缓存目录: $cacheDir");
    }

    $cacheFile = $cacheDir . '/' . $cacheKey . '.json';
    $cacheTime = 3600;

    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
        $json = file_get_contents($cacheFile);
        return $json ? json_decode($json, true) : false;
    }

    $apiUrl = "https://api.github.com/repos/{$owner}/{$repo}";
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: Typecho-Romanticism/2.2\r\n",
            'timeout' => 5
        ]
    ];
    
    $json = @file_get_contents($apiUrl, false, stream_context_create($opts));
    if ($json === false) return false;

    //状态码
    $statusCode = 0;
    foreach ($http_response_header as $header) {
        if (preg_match('#HTTP/\d+(?:\.\d+)?\s+(\d+)#i', $header, $m)) {
            $statusCode = (int)$m[1];
            break;
        }
    }
    if ($statusCode !== 200) return false;

    if (!file_put_contents($cacheFile, $json)) {
        error_log("缓存写入失败: $cacheFile");
    }

    return json_decode($json, true);
}

function parseCustomGitHubTag($content) {
    return preg_replace_callback(
        '/\[github\s+link="([\w\-\.]+\/[\w\-\.]+)"\]/i', // 允许点号
        function($matches) {
            $repoPath = $matches[1];
            $url = "https://github.com/" . $repoPath;
            $data = getGitHubRepoInfo($url);

            if (!$data) return '<div class="mdui-typo blur LDtrans yuan akarom-panel-menu">无法获取 GitHub 数据，请检查</div>';

            // 在 parseCustomGitHubTag 的回调函数中修改这部分
            $safeData = [
                'name' => htmlspecialchars($data['name']),
                'desc' => htmlspecialchars($data['description'] ?? ''),
                'stars' => intval($data['stargazers_count']),
                'url' => htmlspecialchars($url),
                'repoPath' => htmlspecialchars($repoPath),
                // 新增更新时间 ▼
                'lastUpdated' => isset($data['pushed_at']) 
                    ? htmlspecialchars(date('y-m-d', strtotime($data['pushed_at'])))
                    : '未知时间'
            ];
            $themeUrl = Helper::options()->themeUrl.'/config/style/img/icon/github-mark.svg';
            return <<<HTML
            <div class="mdui-typo blur LDtrans yuan akarom-panel-menu">
                <div class="akarom-corner-symbol-rb">
                    <img class="akarom-inverticon" src="{$themeUrl}">
                </div>
                <h3>{$safeData['repoPath']}</h3>
                <p>{$safeData['desc']}</p>
                <div class="meta">
                    <span class="github-updated" title="最后更新时间">
                    更新于 {$safeData['lastUpdated']}
                    </span>
                     · 
                    <span class="github-stars">⭐ {$safeData['stars']}</span>
                    <a class="mdui-float-right"
                       href="{$safeData['url']}" 
                       target="_blank" 
                       rel="noopener noreferrer"><b>查看该项目</b></a>
                </div>
            </div>
            HTML;
        },
        $content
    );
}


/**
 * 获取全站文章总字数
 * 
 * @return int 文章总字数
 */
function getTotalWordCount() {
    $cacheFile = __DIR__ . '/cache/total_words_cache.txt';
    $cacheTime = 3600; // 缓存时间1小时
    
    // 确保缓存目录存在
    $cacheDir = dirname($cacheFile);
    if (!file_exists($cacheDir) && !mkdir($cacheDir, 0700, true)) {
        error_log("无法创建缓存目录: $cacheDir");
    }
    
    // 检查缓存是否存在且未过期
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
        $cachedValue = file_get_contents($cacheFile);
        if (is_numeric($cachedValue)) {
            return (int)$cachedValue;
        }
    }
    
    // 缓存不存在或已过期，重新计算
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $totalWords = 0;
    
    // 查询所有已发布的文章
    $rows = $db->fetchAll($db->select('text')
                ->from($prefix . 'contents')
                ->where('type = ?', 'post')
                ->where('status = ?', 'publish'));
    
    foreach ($rows as $row) {
        // 去除HTML标签和空白字符
        $text = strip_tags($row['text']);
        $text = preg_replace('/\s+/', '', $text);
        $totalWords += mb_strlen($text, 'UTF-8');
    }
    
    // 缓存结果
    file_put_contents($cacheFile, $totalWords);
    
    return $totalWords;
}


/**
 * 文章目录生成
 */
function generateTOC($content) {
    // 通过正则表达式匹配文章中的H1和H2标签
    $pattern = '/<h([1-2])(.*?)>(.*?)<\/h[1-2]>/i';
    
    if (preg_match_all($pattern, $content, $matches)) {
        $toc = '<div class="mdui-typo blur LDtrans yuan akarom-panel-menu">
                <b>文章目录</b>';
        
        $currentLevel = 0;
        $count = count($matches[0]);
        
        for ($i = 0; $i < $count; $i++) {
            $level = (int)$matches[1][$i];
            $title = strip_tags($matches[3][$i]);
            $id = 'toc-' . $i;
            
            // 添加ID到原标题，用于点击跳转
            $content = str_replace($matches[0][$i], '<h' . $level . $matches[2][$i] . ' id="' . $id . '">' . $matches[3][$i] . '</h' . $level . '>', $content);
            
            // 处理目录层级
            if ($level > $currentLevel) {
                $toc .= '<ul class="toc-sublist">';
            } else if ($level < $currentLevel) {
                $toc .= '</ul>';
            }
            
            $currentLevel = $level;
            
            // 添加目录项
            $toc .= '<li class="toc-item toc-level-' . $level . '">
                        <a href="#' . $id . '">#' . $title . '</a>
                     </li>';
        }
        
        // 关闭所有未关闭的UL标签
        while ($currentLevel > 0) {
            $toc .= '</ul>';
            $currentLevel--;
        }
        
        $toc .= '<div class="akarom-corner-symbol-rb" style="font-size:110px;">#</div></div><br>';
        
        // 返回目录和更新后的内容
        return array(
            'toc' => $toc,
            'content' => $content
        );
    }
    
    return array(
        'toc' => '',
        'content' => $content
    );
}


function get_post_view($archive) {
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    
    // 检查 views 字段是否存在
    try {
        // 尝试查询 views 字段
        $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    } catch (Exception $e) {
        // 如果字段不存在，则添加字段
        if ($db->getAdapterName() == 'pdo_sqlite') {
            // SQLite 的语法
            $db->query('ALTER TABLE ' . $prefix . 'contents ADD COLUMN "views" INTEGER DEFAULT 0');
        } else {
            // MySQL 的语法
            $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        }
        echo 0;
        return;
    }
    
    // 更新浏览次数
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views);
        }
    }
    
    echo $row['views'];
}

// 面包屑导航函数
function AKAROM_breadcrumb($archive) {
    $options = Helper::options();
    $seoBreadcrumb = $options->AKAROMseoBreadcrumb;
    
    // 检查是否启用面包屑导航
    if (!$seoBreadcrumb || !in_array('enable', $seoBreadcrumb)) {
        return;
    }
    
    $breadcrumb = '<nav class="mdui-breadcrumb mdui-m-t-2 mdui-m-b-2" aria-label="面包屑导航">
        <ol class="mdui-breadcrumb__list">
            <li class="mdui-breadcrumb__item">
                <a href="' . htmlspecialchars($options->siteUrl) . '" class="mdui-text-color-theme">首页</a>
            </li>';
    
    // 结构化数据
    $structuredData = '<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "首页",
                "item": "' . htmlspecialchars($options->siteUrl) . '"
            }';
    
    $position = 2;
    
    // 分类页面
    if ($archive->is('category')) {
        $category = $archive->getCategory();
        $breadcrumb .= '<li class="mdui-breadcrumb__item">
            <span class="mdui-text-color-theme-text">分类：' . htmlspecialchars($category->name) . '</span>
        </li>';
        
        $structuredData .= ',
            {
                "@type": "ListItem",
                "position": ' . $position . ',
                "name": "分类：' . htmlspecialchars($category->name) . '",
                "item": "' . htmlspecialchars($category->permalink) . '"
            }';
    }
    
    // 标签页面
    elseif ($archive->is('tag')) {
        $tag = $archive->getTag();
        $breadcrumb .= '<li class="mdui-breadcrumb__item">
            <span class="mdui-text-color-theme-text">标签：' . htmlspecialchars($tag->name) . '</span>
        </li>';
        
        $structuredData .= ',
            {
                "@type": "ListItem",
                "position": ' . $position . ',
                "name": "标签：' . htmlspecialchars($tag->name) . '",
                "item": "' . htmlspecialchars($tag->permalink) . '"
            }';
    }
    
    // 作者页面
    elseif ($archive->is('author')) {
        $author = $archive->getAuthor();
        $breadcrumb .= '<li class="mdui-breadcrumb__item">
            <span class="mdui-text-color-theme-text">作者：' . htmlspecialchars($author->screenName) . '</span>
        </li>';
        
        $structuredData .= ',
            {
                "@type": "ListItem",
                "position": ' . $position . ',
                "name": "作者：' . htmlspecialchars($author->screenName) . '",
                "item": "' . htmlspecialchars($author->permalink) . '"
            }';
    }
    
    // 搜索页面
    elseif ($archive->is('search')) {
        $keyword = htmlspecialchars($_GET['s']);
        $breadcrumb .= '<li class="mdui-breadcrumb__item">
            <span class="mdui-text-color-theme-text">搜索：' . $keyword . '</span>
        </li>';
    }
    
    // 文章页面
    elseif ($archive->is('single')) {
        $categories = $archive->categories;
        if ($categories->have()) {
            $categories->rewind();
            $category = $categories->current();
            $breadcrumb .= '<li class="mdui-breadcrumb__item">
                <a href="' . htmlspecialchars($category->permalink) . '" class="mdui-text-color-theme">' . htmlspecialchars($category->name) . '</a>
            </li>';
            
            $structuredData .= ',
                {
                    "@type": "ListItem",
                    "position": ' . $position . ',
                    "name": "' . htmlspecialchars($category->name) . '",
                    "item": "' . htmlspecialchars($category->permalink) . '"
                }';
            $position++;
        }
        
        $breadcrumb .= '<li class="mdui-breadcrumb__item">
            <span class="mdui-text-color-theme-text">' . htmlspecialchars($archive->title) . '</span>
        </li>';
        
        $structuredData .= ',
            {
                "@type": "ListItem",
                "position": ' . $position . ',
                "name": "' . htmlspecialchars($archive->title) . '",
                "item": "' . htmlspecialchars($archive->permalink) . '"
            }';
    }
    
    // 页面页面
    elseif ($archive->is('page')) {
        $breadcrumb .= '<li class="mdui-breadcrumb__item">
            <span class="mdui-text-color-theme-text">' . htmlspecialchars($archive->title) . '</span>
        </li>';
        
        $structuredData .= ',
            {
                "@type": "ListItem",
                "position": ' . $position . ',
                "name": "' . htmlspecialchars($archive->title) . '",
                "item": "' . htmlspecialchars($archive->permalink) . '"
            }';
    }
    
    $breadcrumb .= '</ol>
    </nav>';
    
    $structuredData .= '
        ]
    }
    </script>';
    
    echo $breadcrumb;
    echo $structuredData;
}

// Robots.txt生成函数
function AKAROM_generate_robots() {
    $options = Helper::options();
    $robotsContent = $options->AKAROMseoRobots;
    
    if (!$robotsContent) {
        $robotsContent = "User-Agent: *\nAllow: /";
    }
    
    $robotsPath = __TYPECHO_ROOT_DIR__ . '/robots.txt';
    
    // 确保路径安全
    $robotsPath = realpath(dirname($robotsPath)) . '/robots.txt';
    if (strpos($robotsPath, __TYPECHO_ROOT_DIR__) !== 0) {
        error_log("robots.txt路径不安全: $robotsPath");
        return;
    }
    
    if (!file_put_contents($robotsPath, $robotsContent)) {
        error_log("无法写入robots.txt: $robotsPath");
    }
}

// Sitemap.xml生成函数
function AKAROM_generate_sitemap() {
    $options = Helper::options();
    $seoSitemap = $options->AKAROMseoSitemap;
    
    if (!$seoSitemap || !in_array('enable', $seoSitemap)) {
        return;
    }
    
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    
    // 获取所有文章和页面
    $contents = $db->fetchAll($db->select('cid', 'title', 'type', 'created', 'modified', 'permalink')
        ->from('table.contents')
        ->where('status = ?', 'publish')
        ->where('type IN ?', array('post', 'page'))
        ->order('created', Typecho_Db::SORT_DESC));
    
    // 获取所有分类
    $categories = $db->fetchAll($db->select('mid', 'name', 'slug', 'count')
        ->from('table.metas')
        ->where('type = ?', 'category')
        ->where('count > ?', 0));
    
    // 获取所有标签
    $tags = $db->fetchAll($db->select('mid', 'name', 'slug', 'count')
        ->from('table.metas')
        ->where('type = ?', 'tag')
        ->where('count > ?', 0));
    
    // 生成sitemap.xml
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
    
    // 添加首页
    $sitemap .= '  <url>
    <loc>' . htmlspecialchars($options->siteUrl) . '</loc>
    <lastmod>' . date('Y-m-d') . '</lastmod>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>
';
    
    // 添加文章和页面
    foreach ($contents as $content) {
        $sitemap .= '  <url>
    <loc>' . htmlspecialchars($content['permalink']) . '</loc>
    <lastmod>' . date('Y-m-d', $content['modified']) . '</lastmod>
    <changefreq>' . ($content['type'] == 'post' ? 'weekly' : 'monthly') . '</changefreq>
    <priority>' . ($content['type'] == 'post' ? '0.8' : '0.7') . '</priority>
  </url>
';
    }
    
    // 添加分类
    foreach ($categories as $category) {
        $categoryUrl = $options->siteUrl . 'category/' . $category['slug'] . '/';
        $sitemap .= '  <url>
    <loc>' . htmlspecialchars($categoryUrl) . '</loc>
    <lastmod>' . date('Y-m-d') . '</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.6</priority>
  </url>
';
    }
    
    // 添加标签
    foreach ($tags as $tag) {
        $tagUrl = $options->siteUrl . 'tag/' . $tag['slug'] . '/';
        $sitemap .= '  <url>
    <loc>' . htmlspecialchars($tagUrl) . '</loc>
    <lastmod>' . date('Y-m-d') . '</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.5</priority>
  </url>
';
    }
    
    $sitemap .= '</urlset>';
    
    $sitemapPath = __TYPECHO_ROOT_DIR__ . '/sitemap.xml';
    
    // 确保路径安全
    $sitemapPath = realpath(dirname($sitemapPath)) . '/sitemap.xml';
    if (strpos($sitemapPath, __TYPECHO_ROOT_DIR__) !== 0) {
        error_log("sitemap.xml路径不安全: $sitemapPath");
        return;
    }
    
    if (!file_put_contents($sitemapPath, $sitemap)) {
        error_log("无法写入sitemap.xml: $sitemapPath");
    }
}

// 在主题初始化时生成robots.txt和sitemap.xml
function AKAROM_seo_init() {
    AKAROM_generate_robots();
    AKAROM_generate_sitemap();
}

//获取浏览器信息
function getBrowser($agent)
{
    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
        $outputer = '&nbsp;<i class="iconfont icon-Sougou_Browser comment-ua" mdui-tooltip="{content: \'IE\'}"></i>';
    } else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
      $str1 = explode('Firefox/', $regs[0]);
$FireFox_vern = explode('.', $str1[1]);
        $outputer = '&nbsp;<i class="iconfont icon-firefox comment-ua" mdui-tooltip="{content: \'Firefox\'}"></i>';
    } else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
      $str1 = explode('Maxthon/', $agent);
$Maxthon_vern = explode('.', $str1[1]);
        $outputer = '&nbsp;<i class="iconfont icon-edge comment-ua" mdui-tooltip="{content: \'original Edge\'}"></i>';
    } else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
$outputer = '&nbsp;<i class="iconfont icon-Sougou_Browser comment-ua" mdui-tooltip="{content: \'360浏览器\'}"></i>';
    } else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Edge/', $regs[0]);
$Edge_vern = explode('.', $str1[1]);
        $outputer = '&nbsp;<i class="iconfont icon-edge comment-ua" mdui-tooltip="{content: \'original Edge\'}"></i>';
    } else if (preg_match('/UC/i', $agent)) {
              $str1 = explode('rowser/',  $agent);
$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = '&nbsp;<i class="iconfont icon-Sougou_Browser comment-ua" mdui-tooltip="{content: \'UC浏览器\'}"></i>';
    }  else if (preg_match('/QQ/i', $agent, $regs)||preg_match('/QQBrowser\/([^\s]+)/i', $agent, $regs)) {
                  $str1 = explode('rowser/',  $agent);
$QQ_vern = explode('.', $str1[1]);
        $outputer = '&nbsp;<i class="iconfont icon-QQBrowser comment-ua" mdui-tooltip="{content: \'QQ\'}"></i>';
    } else if (preg_match('/UBrowser/i', $agent, $regs)) {
              $str1 = explode('rowser/',  $agent);
$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = '&nbsp;<i class="iconfont icon-Sougou_Browser comment-ua" mdui-tooltip="{content: \'UC浏览器\'}"></i>';
    }  else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
        $outputer = '&nbsp;<i class="iconfont icon-Sougou_Browser comment-ua" mdui-tooltip="{content: \'Opera\'}"></i>';
    } else if (preg_match('/edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
$str1 = explode('edge/', $agent);
$chrome_vern = explode('.', $str1[1]);
        $outputer = '&nbsp;<i class="iconfont icon-chrome comment-ua" mdui-tooltip="{content: \'original Edge\'}"></i>';
    } else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        if (preg_match('/Edg([\d]*)\/([^\s]+)/i', $agent, $regs)) {
            $str1 = explode('Edg/', $agent);
            $chrome_vern = explode('.', $str1[1]);
            $outputer = '&nbsp;<i class="iconfont icon-edge comment-ua" mdui-tooltip="{content: \'Edge\'}"></i>';
        }else{
            $str1 = explode('Chrome/', $agent);
            $chrome_vern = explode('.', $str1[1]);
            $outputer = '&nbsp;<i class="iconfont icon-chrome comment-ua" mdui-tooltip="{content: \'Chrome\'}"></i>';
        }
    } else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
         $str1 = explode('Version/',  $agent);
$safari_vern = explode('.', $str1[1]);
        $outputer = '&nbsp;<i class="iconfont icon-safari comment-ua" mdui-tooltip="{content: \'Safari\'}"></i>';
    } else{
        $outputer = '&nbsp;<i class="iconfont icon-chrome comment-ua" mdui-tooltip="{content: \'Chrome\'}"></i>';
    }
    echo $outputer;
}

// 获取操作系统信息
function getOs($agent)
{
    $os = false;
 
    if (preg_match('/win/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class="iconfont icon-windows comment-ua-second" mdui-tooltip="{content: \'Windows\'}"></i>';
    } else if (preg_match('/android/i', $agent)) {
            $os = '&nbsp;&nbsp;<i class="iconfont icon-android comment-ua-second" mdui-tooltip="{content: \'Android\'}"></i>';
     }else if (preg_match('/ubuntu/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="iconfont icon-linux comment-ua-second" mdui-tooltip="{content: \'Ubuntu\'}"></i>';
    } else if (preg_match('/linux/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="iconfont icon-linux comment-ua-second" mdui-tooltip="{content: \'Linux (exclude Ubuntu)\'}"></i>';
    } else if (preg_match('/iPhone/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="iconfont icon-ios comment-ua-second" mdui-tooltip="{content: \'iOS\'}"></i>';
    } else if (preg_match('/iPad/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="iconfont icon-ios comment-ua-second" mdui-tooltip="{content: \'iPadOS\'}"></i>';
    } else if (preg_match('/mac/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="iconfont icon-ios comment-ua-second" mdui-tooltip="{content: \'macOS\'}"></i>';
    }else if (preg_match('/fusion/i', $agent)) {
        $os = '&nbsp;&nbsp;<i class="iconfont icon-linux comment-ua-second" mdui-tooltip="{content: \'fusion\'}"></i>';
    } else {
        $os = '&nbsp;&nbsp;<i class="iconfont icon-linux comment-ua-second" mdui-tooltip="{content: \'Other OS\'}"></i>';
    }
    echo $os;
}
