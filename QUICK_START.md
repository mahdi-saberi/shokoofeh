# 🚀 راهنمای سریع شروع

## ⚠️ نکته مهم: Script ها باید در HOST اجرا شوند!

**غلط:** اجرای script در container
```bash
# ❌ این کار اشتباه است
docker exec -it shokoofeh-app-prod ./generate-env.sh
docker exec -it shokoofeh-app-prod ./deploy-production.sh deploy
```

**درست:** اجرای script در HOST (سرور اصلی)
```bash
# ✅ این کار صحیح است
./generate-env.sh
./deploy-production.sh deploy
```

## 🔧 مراحل صحیح deployment

### گام 1: تولید فایل .env
```bash
# در HOST اجرا کنید (نه در container)
./generate-env.sh
```

این script:
- از شما domain اصلی را می‌پرسد
- database credentials را تنظیم می‌کند
- APP_KEY را تولید می‌کند
- فایل‌های `.env` و `env.production` را ایجاد می‌کند

### گام 2: Setup اولیه
```bash
# در HOST اجرا کنید
./deploy-production.sh setup
```

این command:
- ساختار دایرکتوری‌ها را ایجاد می‌کند
- فایل‌های environment را تنظیم می‌کند
- مجوزها را تنظیم می‌کند

### گام 3: Deployment
```bash
# در HOST اجرا کنید
./deploy-production.sh deploy
```

این command:
- از داده‌های فعلی backup می‌گیرد
- image های جدید را بارگزاری می‌کند
- سرویس‌ها را راه‌اندازی می‌کند
- health check را انجام می‌دهد

## 📁 ساختار فایل‌های Environment

```
project/
├── env.production.template  # Template اصلی (در git)
├── .env                     # فایل محلی (در .gitignore)
└── env.production          # فایل production (در .gitignore)
```

## 🔄 Update Process

### برای تغییر تنظیمات (بدون rebuild):
1. فایل `env.production` را ویرایش کنید
2. Container را restart کنید:
```bash
docker-compose -f docker-compose.prod.yml restart app
```

### برای تغییر کد (با rebuild):
1. Image جدید build کنید
2. Deployment script را اجرا کنید:
```bash
./deploy-production.sh deploy
```

## 🆘 مشکلات متداول

### مشکل 1: "این script نباید در container اجرا شود"
**راه‌حل:** script را در HOST اجرا کنید، نه در container

### مشکل 2: "فایل env.production یافت نشد"
**راه‌حل:** ابتدا `./generate-env.sh` را اجرا کنید

### مشکل 3: "Permission denied"
**راه‌حل:** از `sudo` استفاده کنید یا مجوزها را تنظیم کنید

### مشکل 4: Volume mount برای فایل .env
**راه‌حل:** از bind mount استفاده می‌کنیم:
```yaml
volumes:
  - ./env.production:/var/www/laravel-app/.env:ro
```

## 📋 دستورات مفید

### بررسی وضعیت:
```bash
# بررسی container ها
docker ps

# بررسی logs
docker-compose -f docker-compose.prod.yml logs

# بررسی health
./deploy-production.sh health
```

### Backup:
```bash
# پشتیبان‌گیری دستی
./deploy-production.sh backup

# پشتیبان‌گیری خودکار (cron)
0 2 * * * /path/to/deploy-production.sh backup
```

### Cleanup:
```bash
# تمیزکاری image های قدیمی
./deploy-production.sh cleanup
```

## 🎯 مزایای راه‌حل جدید

1. ✅ **فایل .env در image قرار می‌گیرد**
2. ✅ **از طریق bind mount قابل تغییر است**
3. ✅ **بدون rebuild image قابل ویرایش است**
4. ✅ **Script ها در HOST اجرا می‌شوند**
5. ✅ **Volume mount درست کار می‌کند**
6. ✅ **Backup خودکار از environment files**

## 🚨 نکات امنیتی

1. **فایل‌های .env در git commit نکنید**
2. **از password های قوی استفاده کنید**
3. **مجوزهای فایل را محدود کنید**
4. **قبل از deployment backup تهیه کنید**

---

**خلاصه:** Script ها را در HOST اجرا کنید، نه در container! 🎉 