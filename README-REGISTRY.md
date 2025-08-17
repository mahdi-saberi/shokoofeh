# 🐳 Container Registry Setup

## 📋 خلاصه

این پروژه برای استفاده از container registry شخصی شما در `registry.hamdocker.ir/mahdi-saberi` پیکربندی شده است.

## 🚀 مراحل استفاده

### 1. Login به Registry

ابتدا باید به registry شخصی خود login کنید:

```bash
docker login registry.hamdocker.ir
```

### 2. Build و Push Image ها

برای build و push کردن تمام image ها به registry:

```bash
./build-and-push.sh
```

### 3. اجرای پروژه

پس از push کردن image ها، می‌توانید پروژه را اجرا کنید:

```bash
cd src
docker-compose up -d
```

## 📦 Image های موجود

### Laravel App
- **Image:** `registry.hamdocker.ir/mahdi-saberi/shokoofeh-app:latest`
- **توضیحات:** Laravel application با PHP 8.2 و تمام dependencies

### MySQL
- **Image:** `registry.hamdocker.ir/mahdi-saberi/mysql:8.0`
- **توضیحات:** MySQL 8.0 database

### Nginx
- **Image:** `registry.hamdocker.ir/mahdi-saberi/nginx:alpine`
- **توضیحات:** Nginx web server

## 🔧 تنظیمات

### Docker Compose
فایل `docker-compose.yml` به‌روزرسانی شده تا از registry شخصی استفاده کند:

```yaml
services:
  app:
    image: registry.hamdocker.ir/mahdi-saberi/shokoofeh-app:latest
  mysql:
    image: registry.hamdocker.ir/mahdi-saberi/mysql:8.0
  nginx:
    image: registry.hamdocker.ir/mahdi-saberi/nginx:alpine
```

### Build Script
اسکریپت `build-and-push.sh` برای automatization فرآیند build و push ایجاد شده است.

## 🎯 مزایا

1. **سرعت بالا:** Image ها در registry شخصی شما ذخیره می‌شوند
2. **امنیت:** کنترل کامل روی image ها
3. **دسترسی آسان:** امکان استفاده در محیط‌های مختلف
4. **Backup:** نسخه‌های مختلف image ها

## 🚨 نکات مهم

- قبل از اجرای اسکریپت، حتماً به registry login کنید
- اطمینان حاصل کنید که دسترسی‌های لازم را دارید
- در صورت تغییر در کد، دوباره image ها را build و push کنید

## 📞 پشتیبانی

در صورت بروز مشکل، لطفاً با تیم توسعه تماس بگیرید. 