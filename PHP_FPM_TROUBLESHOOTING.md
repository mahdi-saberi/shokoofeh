# راهنمای Troubleshooting مشکل PHP-FPM

## 🚨 مشکل اصلی
```
laravel-unified | /start-services.sh: line 25: php-fpm82: not found
laravel-unified exited with code 127
```

## 🔍 علت مشکل
- نام command `php-fpm82` در Alpine Linux موجود نیست
- PHP-FPM با نام‌های مختلف نصب می‌شود
- نیاز به تشخیص خودکار نام command

## ✅ راه حل‌های ارائه شده

### **۱. Startup Script بهبود یافته**
- ✅ تشخیص خودکار نام PHP-FPM command
- ✅ پشتیبانی از نام‌های مختلف
- ✅ بررسی وجود command قبل از اجرا

### **۲. Dockerfile بهبود یافته**
- ✅ بررسی نصب PHP-FPM در build time
- ✅ ایجاد دایرکتوری‌های مورد نیاز
- ✅ تنظیم مجوزهای مناسب

### **۳. فایل‌های تست**
- ✅ `docker-compose.test.yml` برای تست
- ✅ `test-image.sh` برای تست کامل
- ✅ بررسی step-by-step

## 🔧 نحوه استفاده

### **مرحله ۱: تست image**
```bash
# اجرای اسکریپت تست
./test-image.sh
```

### **مرحله ۲: استفاده از docker-compose**
```bash
# اجرای docker-compose
docker-compose -f docker-compose.test.yml up -d
```

### **مرحله ۳: بررسی logs**
```bash
# بررسی logs container
docker logs laravel-unified-test

# بررسی process ها
docker exec laravel-unified-test ps aux
```

## 📋 نام‌های مختلف PHP-FPM

### **Alpine Linux:**
- `php-fpm` - نام استاندارد
- `php82-fpm` - نام با ورژن
- `php-fpm82` - نام قدیمی (غیرقابل استفاده)

### **Ubuntu/Debian:**
- `php8.2-fpm` - نام استاندارد
- `php-fpm` - نام عمومی

## 🚀 تشخیص خودکار در startup script

```bash
# بررسی نام command PHP-FPM
if command -v php-fpm82 >/dev/null 2>&1; then
    PHP_FPM_CMD="php-fpm82"
elif command -v php-fpm >/dev/null 2>&1; then
    PHP_FPM_CMD="php-fpm"
elif command -v php82-fpm >/dev/null 2>&1; then
    PHP_FPM_CMD="php82-fpm"
else
    echo "❌ PHP-FPM command یافت نشد"
    exit 1
fi
```

## 🔍 بررسی مشکلات

### **۱. بررسی نصب PHP-FPM:**
```bash
# بررسی package های نصب شده
docker exec laravel-unified-test apk list --installed | grep php

# بررسی command های موجود
docker exec laravel-unified-test which php-fpm
docker exec laravel-unified-test which php82-fpm
```

### **۲. بررسی process ها:**
```bash
# بررسی process های در حال اجرا
docker exec laravel-unified-test ps aux

# بررسی port های استفاده شده
docker exec laravel-unified-test netstat -tlnp
```

### **۳. بررسی logs:**
```bash
# بررسی nginx logs
docker exec laravel-unified-test tail -f /var/log/nginx/error.log

# بررسی PHP-FPM logs
docker exec laravel-unified-test tail -f /var/log/php-fpm.log
```

## 🛠️ راه حل‌های جایگزین

### **راه حل ۱: استفاده از Base Image متفاوت**
```dockerfile
# استفاده از Ubuntu
FROM ubuntu:22.04

# نصب PHP-FPM
RUN apt-get update && apt-get install -y php8.2-fpm nginx
```

### **راه حل ۲: استفاده از Official PHP Image**
```dockerfile
# استفاده از PHP official
FROM php:8.2-fpm

# نصب nginx
RUN apt-get update && apt-get install -y nginx
```

### **راه حل ۳: استفاده از Multi-stage Build**
```dockerfile
# Stage 1: PHP
FROM php:8.2-fpm AS php

# Stage 2: Nginx
FROM nginx:alpine AS nginx

# Stage 3: Final
FROM alpine:latest
COPY --from=php /usr/local /usr/local
COPY --from=nginx /usr/sbin/nginx /usr/sbin/nginx
```

## 📊 مقایسه Base Image ها

| Base Image | مزایا | معایب |
|------------|-------|-------|
| **php:8.2-fpm-alpine** | سبک، سریع | نیاز به نصب nginx |
| **php:8.2-fpm** | کامل، پایدار | سنگین‌تر |
| **nginx:alpine** | سبک، سریع | نیاز به نصب PHP |
| **ubuntu:22.04** | کامل، سازگار | سنگین‌تر |

## 🎯 بهترین Practice

### **برای Development:**
- استفاده از `php:8.2-fpm-alpine`
- نصب nginx به صورت جداگانه
- تست کامل قبل از production

### **برای Production:**
- استفاده از image تست شده
- health check مناسب
- monitoring و logging

## 🔄 مراحل Debug

### **۱. Build Image:**
```bash
docker build -f Dockerfile.unified.simple -t laravel-unified:test .
```

### **۲. اجرای Container:**
```bash
docker run -d --name laravel-test \
    -p 8081:80 \
    -v "$(pwd)/src:/var/www" \
    laravel-unified:test
```

### **۳. بررسی Logs:**
```bash
docker logs laravel-test
```

### **۴. ورود به Container:**
```bash
docker exec -it laravel-test sh
```

### **۵. بررسی Process ها:**
```bash
ps aux | grep -E "(nginx|php-fpm)"
```

## 📞 درخواست کمک

اگر مشکل حل نشد:

1. **Log ها را جمع‌آوری کنید:**
   ```bash
   docker logs laravel-unified-test > container-logs.txt
   ```

2. **Docker info را جمع‌آوری کنید:**
   ```bash
   docker info > docker-info.txt
   docker version > docker-version.txt
   ```

3. **System info را جمع‌آوری کنید:**
   ```bash
   uname -a > system-info.txt
   ```

4. **مشکل را با جزئیات توضیح دهید:**
   - خطای دقیق
   - سیستم عامل
   - Docker version
   - مراحل انجام شده
   - فایل‌های موجود 