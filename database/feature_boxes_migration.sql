-- Migration برای اضافه کردن فیلدهای باکس‌های راهنما به جدول site_settings
-- این فایل را در phpMyAdmin یا هر ابزار مدیریت دیتابیس دیگری اجرا کنید

ALTER TABLE `site_settings` 
ADD COLUMN `feature_box_1_title` VARCHAR(255) NULL AFTER `header_announcement_text_color`,
ADD COLUMN `feature_box_1_description` TEXT NULL AFTER `feature_box_1_title`,
ADD COLUMN `feature_box_1_icon` VARCHAR(50) NULL AFTER `feature_box_1_description`,
ADD COLUMN `feature_box_1_enabled` BOOLEAN DEFAULT TRUE AFTER `feature_box_1_icon`,
ADD COLUMN `feature_box_2_title` VARCHAR(255) NULL AFTER `feature_box_1_enabled`,
ADD COLUMN `feature_box_2_description` TEXT NULL AFTER `feature_box_2_title`,
ADD COLUMN `feature_box_2_icon` VARCHAR(50) NULL AFTER `feature_box_2_description`,
ADD COLUMN `feature_box_2_enabled` BOOLEAN DEFAULT TRUE AFTER `feature_box_2_icon`,
ADD COLUMN `feature_box_3_title` VARCHAR(255) NULL AFTER `feature_box_2_enabled`,
ADD COLUMN `feature_box_3_description` TEXT NULL AFTER `feature_box_3_title`,
ADD COLUMN `feature_box_3_icon` VARCHAR(50) NULL AFTER `feature_box_3_description`,
ADD COLUMN `feature_box_3_enabled` BOOLEAN DEFAULT TRUE AFTER `feature_box_3_icon`,
ADD COLUMN `feature_box_4_title` VARCHAR(255) NULL AFTER `feature_box_3_enabled`,
ADD COLUMN `feature_box_4_description` TEXT NULL AFTER `feature_box_4_title`,
ADD COLUMN `feature_box_4_icon` VARCHAR(50) NULL AFTER `feature_box_4_description`,
ADD COLUMN `feature_box_4_enabled` BOOLEAN DEFAULT TRUE AFTER `feature_box_4_icon`;

-- اضافه کردن مقادیر پیش‌فرض برای باکس‌های راهنما
UPDATE `site_settings` SET 
`feature_box_1_title` = 'ارسال رایگان',
`feature_box_1_description` = 'برای خریدهای بالای ۵۰۰ هزار تومان در سراسر کشور',
`feature_box_1_icon` = '🚚',
`feature_box_1_enabled` = TRUE,
`feature_box_2_title` = 'خرید امن',
`feature_box_2_description` = 'پرداخت آنلاین با بالاترین سطح امنیت',
`feature_box_2_icon` = '🔒',
`feature_box_2_enabled` = TRUE,
`feature_box_3_title` = 'ضمانت کیفیت',
`feature_box_3_description` = 'تمام محصولات دارای گارانتی اصالت و کیفیت',
`feature_box_3_icon` = '🏆',
`feature_box_3_enabled` = TRUE,
`feature_box_4_title` = 'پشتیبانی ۲۴/۷',
`feature_box_4_description` = 'آماده پاسخگویی در تمام ساعات شبانه‌روز',
`feature_box_4_icon` = '📞',
`feature_box_4_enabled` = TRUE
WHERE id = 1; 