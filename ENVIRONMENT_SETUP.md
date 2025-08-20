# راهنمای مدیریت Environment Files در Production

## 🎯 مشکل حل شده

**مشکل:** فایل `.env` در image قرار نمی‌گرفت چون در `.dockerignore` بود.

**راه‌حل:** 
1. فایل `.env` از `.dockerignore` حذف شد
2. Volume mount برای فایل `.env` اضافه شد
3. Script های خودکار برای مدیریت environment files ایجاد شد

## 📁 فایل‌های Environment

### 1. `env.production.template`
- **هدف:** Template اصلی برای production
- **محتوای پیش‌فرض:** تنظیمات production با مقادیر placeholder
- **نکته:** این فایل در git commit می‌شود

### 2. `.env`
- **هدف:** فایل environment محلی (development)
- **محتوای پیش‌فرض:** از template کپی می‌شود
- **نکته:** در `.gitignore` قرار دارد

### 3. `env.production`
- **هدف:** فایل environment برای docker-compose
- **محتوای پیش‌فرض:** کپی از `.env`
- **نکته:** در `.gitignore` قرار دارد

## 🚀 نحوه استفاده

### گام 1: تولید فایل .env
```bash
# اجرای script تولید environment
./generate-env.sh
```

این script:
- از شما domain اصلی را می‌پرسد
- database credentials را تنظیم می‌کند
- APP_KEY را تولید می‌کند
- فایل‌های .env و env.production را ایجاد می‌کند

### گام 2: تنظیم اولیه
```bash
# ایجاد ساختار دایرکتوری‌ها و environment
./deploy-production.sh setup
```

### گام 3: Deployment
```bash
# اجرای deployment کامل
./deploy-production.sh deploy
```

## 🔧 تنظیمات مهم

### Database Configuration
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=toyshop
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

### Application Settings
```bash
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
FILESYSTEM_DISK=local
```

### Security
```bash
APP_KEY=base64:generated-key
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIES=true
```

## 📋 Volume Mounting

### در docker-compose.prod.yml:
```yaml
volumes:
  - ./env.production:/var/www/laravel-app/.env
```

### مزایا:
- ✅ فایل `.env` از خارج container قابل ویرایش است
- ✅ تغییرات بدون rebuild image اعمال می‌شوند
- ✅ تنظیمات production قابل تغییر هستند

## 🔄 Update Process

### برای تغییر تنظیمات:
1. فایل `env.production` را ویرایش کنید
2. Container را restart کنید:
```bash
docker-compose -f docker-compose.prod.yml restart app
```

### برای تغییر کد:
1. Image جدید build کنید
2. Deployment script را اجرا کنید:
```bash
./deploy-production.sh deploy
```

## 🚨 نکات امنیتی

### 1. فایل‌های حساس
- فایل `.env` در `.gitignore` قرار دارد
- فایل `env.production` در `.gitignore` قرار دارد
- فقط `env.production.template` در git commit می‌شود

### 2. Database Credentials
- در production از password های قوی استفاده کنید
- database را در network جداگانه قرار دهید
- از secrets management استفاده کنید

### 3. File Permissions
```bash
# تنظیم مجوزهای فایل .env
chmod 600 .env
chmod 600 env.production
```

## 🆘 Troubleshooting

### مشکل: فایل .env پیدا نمی‌شود
```bash
# بررسی وجود فایل
ls -la .env env.production

# تولید مجدد
./generate-env.sh
```

### مشکل: تنظیمات اعمال نمی‌شوند
```bash
# restart container
docker-compose -f docker-compose.prod.yml restart app

# بررسی logs
docker-compose -f docker-compose.prod.yml logs app
```

### مشکل: APP_KEY نامعتبر
```bash
# تولید مجدد APP_KEY
APP_KEY=$(openssl rand -base64 32)
sed -i "s/APP_KEY=.*/APP_KEY=base64:${APP_KEY}/" .env
sed -i "s/APP_KEY=.*/APP_KEY=base64:${APP_KEY}/" env.production
```

## 📊 Monitoring

### بررسی وضعیت Environment:
```bash
# بررسی فایل‌های environment
ls -la .env*

# بررسی محتوای فایل
cat .env | grep -E "(APP_ENV|APP_DEBUG|DB_HOST)"

# بررسی در container
docker exec shokoofeh-app-prod cat /var/www/laravel-app/.env
```

### Health Check:
```bash
# بررسی سلامت سرویس
./deploy-production.sh health

# بررسی endpoint
curl -f http://localhost:8080/health
```

## 🔄 Backup Strategy

### Environment Files Backup:
```bash
# پشتیبان‌گیری خودکار
./deploy-production.sh backup

# پشتیبان‌گیری دستی
cp .env backup/env_$(date +%Y%m%d_%H%M%S).backup
cp env.production backup/env_production_$(date +%Y%m%d_%H%M%S).backup
```

## 📝 Best Practices

### 1. Environment Management:
- همیشه از template استفاده کنید
- تغییرات را در فایل‌های جداگانه اعمال کنید
- قبل از deployment، تنظیمات را تست کنید

### 2. Security:
- فایل‌های .env را در git commit نکنید
- از password های قوی استفاده کنید
- مجوزهای فایل را محدود کنید

### 3. Deployment:
- همیشه قبل از deployment backup تهیه کنید
- از script های خودکار استفاده کنید
- health check را بررسی کنید

---

**نکته مهم:** فایل `.env` حالا در image قرار می‌گیرد و از طریق volume mount قابل تغییر است! 🎉 