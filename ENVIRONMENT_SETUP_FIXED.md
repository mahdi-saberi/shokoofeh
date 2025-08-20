# 🚀 راهنمای Environment Setup (اصلاح شده)

## 🎯 مشکل حل شده

**مشکل قبلی:** Volume mount برای فایل `.env` کار نمی‌کرد و باعث ایجاد دایرکتوری اضافی می‌شد.

**راه‌حل جدید:** استفاده از `docker-compose.env` برای environment variables

## 📁 ساختار جدید فایل‌های Environment

### 1. `env.production.template`
- **هدف:** Template اصلی برای production
- **محتوای پیش‌فرض:** تنظیمات production با مقادیر placeholder
- **نکته:** این فایل در git commit می‌شود

### 2. `docker-compose.env`
- **هدف:** فایل environment برای docker-compose
- **محتوای پیش‌فرض:** از template کپی می‌شود
- **نکته:** در `.gitignore` قرار دارد

## 🚀 نحوه استفاده صحیح

### گام 1: تولید فایل docker-compose.env
```bash
# در HOST اجرا کنید (نه در container)
./generate-env.sh
```

این script:
- از شما domain اصلی را می‌پرسد
- database credentials را تنظیم می‌کند
- APP_KEY را تولید می‌کند (اگر نیاز باشد)
- فایل `docker-compose.env` را ایجاد می‌کند

### گام 2: Setup اولیه
```bash
# در HOST اجرا کنید
./deploy-production.sh setup
```

### گام 3: Deployment
```bash
# در HOST اجرا کنید
./deploy-production.sh deploy
```

## 🔧 نحوه کارکرد

### در docker-compose.prod.yml:
```yaml
services:
  app:
    env_file:
      - docker-compose.env
  mysql:
    env_file:
      - docker-compose.env
```

### مزایای این روش:
- ✅ **بدون volume mount مشکل‌ساز**
- ✅ **Environment variables درست کار می‌کنند**
- ✅ **فایل قابل ویرایش است**
- ✅ **بدون rebuild image قابل تغییر است**

## 📋 فایل‌های Environment

### Database Configuration:
```bash
DB_HOST=mysql
DB_DATABASE=toyshop
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

### Application Settings:
```bash
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
FILESYSTEM_DISK=local
```

### Performance:
```bash
OPCACHE_ENABLE=1
OPCACHE_MEMORY_CONSUMPTION=128
CACHE_DRIVER=file
SESSION_DRIVER=file
```

## 🔄 Update Process

### برای تغییر تنظیمات:
1. فایل `docker-compose.env` را ویرایش کنید
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
- فایل `docker-compose.env` در `.gitignore` قرار دارد
- فقط `env.production.template` در git commit می‌شود

### 2. Database Credentials
- در production از password های قوی استفاده کنید
- database را در network جداگانه قرار دهید

### 3. File Permissions
```bash
# تنظیم مجوزهای فایل
chmod 600 docker-compose.env
```

## 🆘 Troubleshooting

### مشکل: "فایل docker-compose.env یافت نشد"
```bash
# راه‌حل: تولید فایل
./generate-env.sh
```

### مشکل: "Environment variables اعمال نمی‌شوند"
```bash
# راه‌حل: restart container
docker-compose -f docker-compose.prod.yml restart app
```

### مشکل: "Permission denied"
```bash
# راه‌حل: تنظیم مجوزها
chmod 600 docker-compose.env
```

## 📊 Monitoring

### بررسی Environment Variables:
```bash
# بررسی فایل
cat docker-compose.env

# بررسی در container
docker exec shokoofeh-app-prod env | grep -E "(DB_|APP_)"
```

### Health Check:
```bash
# بررسی سلامت سرویس
./deploy-production.sh health
```

## 🔄 Backup Strategy

### Environment Files Backup:
```bash
# پشتیبان‌گیری خودکار
./deploy-production.sh backup

# پشتیبان‌گیری دستی
cp docker-compose.env backup/docker-compose.env_$(date +%Y%m%d_%H%M%S).backup
```

## 📝 Best Practices

### 1. Environment Management:
- همیشه از template استفاده کنید
- تغییرات را در فایل `docker-compose.env` اعمال کنید
- قبل از deployment، تنظیمات را بررسی کنید

### 2. Security:
- فایل `docker-compose.env` را در git commit نکنید
- از password های قوی استفاده کنید
- مجوزهای فایل را محدود کنید

### 3. Deployment:
- همیشه قبل از deployment backup تهیه کنید
- از script های خودکار استفاده کنید
- health check را بررسی کنید

## 🎯 مزایای راه‌حل جدید

1. ✅ **بدون volume mount مشکل‌ساز**
2. ✅ **Environment variables درست کار می‌کنند**
3. ✅ **فایل قابل ویرایش است**
4. ✅ **بدون rebuild image قابل تغییر است**
5. ✅ **امنیت بالا با .gitignore**
6. ✅ **Backup خودکار از environment files**

---

**نکته مهم:** حالا از `docker-compose.env` استفاده می‌کنیم که درست کار می‌کند! 🎉 