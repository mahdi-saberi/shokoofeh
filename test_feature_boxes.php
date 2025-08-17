<?php
/**
 * فایل تست برای بررسی عملکرد باکس‌های راهنما
 * این فایل را در مرورگر اجرا کنید تا نتیجه را ببینید
 */

// تنظیمات اولیه
error_reporting(E_ALL);
ini_set('display_errors', 1);

// شبیه‌سازی تنظیمات سایت
$mockSettings = [
    'feature_box_1_title' => 'ارسال رایگان',
    'feature_box_1_description' => 'برای خریدهای بالای ۵۰۰ هزار تومان در سراسر کشور',
    'feature_box_1_icon' => '🚚',
    'feature_box_1_enabled' => true,
    
    'feature_box_2_title' => 'خرید امن',
    'feature_box_2_description' => 'پرداخت آنلاین با بالاترین سطح امنیت',
    'feature_box_2_icon' => '🔒',
    'feature_box_2_enabled' => true,
    
    'feature_box_3_title' => 'ضمانت کیفیت',
    'feature_box_3_description' => 'تمام محصولات دارای گارانتی اصالت و کیفیت',
    'feature_box_3_icon' => '🏆',
    'feature_box_3_enabled' => false, // غیرفعال
    
    'feature_box_4_title' => 'پشتیبانی ۲۴/۷',
    'feature_box_4_description' => 'آماده پاسخگویی در تمام ساعات شبانه‌روز',
    'feature_box_4_icon' => '📞',
    'feature_box_4_enabled' => true
];

// شبیه‌سازی متد getFeatureBoxesAttribute
function getFeatureBoxes($settings) {
    $boxes = [];
    
    if ($settings['feature_box_1_enabled']) {
        $boxes[] = [
            'title' => $settings['feature_box_1_title'] ?: 'ارسال رایگان',
            'description' => $settings['feature_box_1_description'] ?: 'برای خریدهای بالای ۵۰۰ هزار تومان در سراسر کشور',
            'icon' => $settings['feature_box_1_icon'] ?: '🚚'
        ];
    }
    
    if ($settings['feature_box_2_enabled']) {
        $boxes[] = [
            'title' => $settings['feature_box_2_title'] ?: 'خرید امن',
            'description' => $settings['feature_box_2_description'] ?: 'پرداخت آنلاین با بالاترین سطح امنیت',
            'icon' => $settings['feature_box_2_icon'] ?: '🔒'
        ];
    }
    
    if ($settings['feature_box_3_enabled']) {
        $boxes[] = [
            'title' => $settings['feature_box_3_title'] ?: 'ضمانت کیفیت',
            'description' => $settings['feature_box_3_description'] ?: 'تمام محصولات دارای گارانتی اصالت و کیفیت',
            'icon' => $settings['feature_box_3_icon'] ?: '🏆'
        ];
    }
    
    if ($settings['feature_box_4_enabled']) {
        $boxes[] = [
            'title' => $settings['feature_box_4_title'] ?: 'پشتیبانی ۲۴/۷',
            'description' => $settings['feature_box_4_description'] ?: 'آماده پاسخگویی در تمام ساعات شبانه‌روز',
            'icon' => $settings['feature_box_4_icon'] ?: '📞'
        ];
    }
    
    return $boxes;
}

// دریافت باکس‌های فعال
$featureBoxes = getFeatureBoxes($mockSettings);

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تست باکس‌های راهنما</title>
    <style>
        body {
            font-family: 'Vazirmatn', 'Tahoma', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
            direction: rtl;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        .test-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }
        .test-section h3 {
            color: #495057;
            margin-top: 0;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .feature-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .feature-item:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .feature-title {
            color: #2c3e50;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .feature-description {
            color: #6c757d;
            line-height: 1.6;
            font-size: 0.9rem;
        }
        .status {
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 10px;
        }
        .status.disabled {
            background: #dc3545;
        }
        .code-block {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            overflow-x: auto;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 تست باکس‌های راهنمای قابل ویرایش</h1>
        
        <div class="test-section">
            <h3>📊 اطلاعات تنظیمات</h3>
            <p>تعداد باکس‌های فعال: <strong><?php echo count($featureBoxes); ?></strong> از ۴ باکس</p>
            
            <div class="code-block">
                <strong>تنظیمات فعلی:</strong><br>
                <?php foreach ($mockSettings as $key => $value): ?>
                    <?php 
                        $status = strpos($key, '_enabled') !== false ? 
                            ($value ? '✅ فعال' : '❌ غیرفعال') : 
                            $value;
                    ?>
                    <?php echo $key . ': ' . $status; ?><br>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="test-section">
            <h3>🎯 نمایش باکس‌های راهنما</h3>
            <p>این بخش شبیه‌سازی صفحه اصلی فروشگاه است:</p>
            
            <div class="features-grid">
                <?php foreach ($featureBoxes as $box): ?>
                    <div class="feature-item">
                        <div class="feature-icon"><?php echo $box['icon']; ?></div>
                        <h3 class="feature-title"><?php echo $box['title']; ?></h3>
                        <p class="feature-description"><?php echo $box['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="test-section">
            <h3>💡 نحوه استفاده در کد</h3>
            <div class="code-block">
// دریافت تنظیمات سایت
$siteSettings = \App\Models\SiteSetting::current();

// دریافت باکس‌های فعال
$featureBoxes = $siteSettings->feature_boxes;

// نمایش در صفحه
foreach ($featureBoxes as $box) {
    echo '&lt;div class="feature-item"&gt;';
    echo '&lt;div class="feature-icon"&gt;' . $box['icon'] . '&lt;/div&gt;';
    echo '&lt;h3&gt;' . $box['title'] . '&lt;/h3&gt;';
    echo '&lt;p&gt;' . $box['description'] . '&lt;/p&gt;';
    echo '&lt;/div&gt;';
}
            </div>
        </div>
        
        <div class="test-section">
            <h3>🔧 نحوه ویرایش در پنل مدیریت</h3>
            <ol>
                <li>به پنل مدیریت بروید</li>
                <li>از منوی "تنظیمات سایت" استفاده کنید</li>
                <li>در بخش "باکس‌های راهنمای صفحه فروشگاه" تنظیمات را تغییر دهید</li>
                <li>تغییرات را ذخیره کنید</li>
                <li>تغییرات بلافاصله در صفحه اصلی اعمال می‌شود</li>
            </ol>
        </div>
        
        <div class="test-section">
            <h3>✅ نتیجه تست</h3>
            <?php if (count($featureBoxes) === 3): ?>
                <p style="color: #28a745; font-weight: bold;">✅ تست موفق! باکس‌های راهنما به درستی کار می‌کنند.</p>
                <p>باکس سوم (ضمانت کیفیت) غیرفعال است و نمایش داده نمی‌شود.</p>
            <?php else: ?>
                <p style="color: #dc3545; font-weight: bold;">❌ مشکلی در عملکرد باکس‌های راهنما وجود دارد.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 