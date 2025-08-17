# راهنمای Troubleshooting

## 🚨 مشکلات رایج در Build

### ۱. **خطای Package های PHP**

#### **مشکل:**
```
ERROR: unable to select packages:
  php82-filter (no such package):
  php82-hash (no such package):
  php82-libxml (no such package):
  php82-pcre (no such package):
  php82-reflection (no such package):
  php82-spl (no such package):
  php82-standard (no such package):
```

#### **علت:**
- نام‌های package در Alpine Linux متفاوت است
- برخی package ها به صورت پیش‌فرض نصب هستند
- نام‌های package در Alpine vs Ubuntu متفاوت است

#### **راه حل:**
```bash
# استفاده از Dockerfile ساده‌تر
./build-unified.sh

# یا دستی
docker build -f Dockerfile.unified.simple -t laravel-unified .
```

### ۲. **خطای Composer Dependencies**

#### **مشکل:**
```
Could not find a version of package that matches the request
```

#### **علت:**
- فولدر `src` موجود نیست
- `composer.json` موجود نیست
- مشکل در network یا proxy

#### **راه حل:**
```bash
# بررسی وجود فولدر src
ls -la src/

# بررسی وجود composer.json
ls -la src/composer.json

# بررسی network
ping google.com
```

### ۳. **خطای Permission**

#### **مشکل:**
```
chown: changing ownership of '/var/www/storage': Operation not permitted
```

#### **علت:**
- مشکل در Dockerfile
- کاربر root در container

#### **راه حل:**
```bash
# بررسی Dockerfile
cat Dockerfile.unified.simple

# بررسی user در container
docker run --rm laravel-unified id
```

### ۴. **خطای Port Binding**

#### **مشکل:**
```
nginx: [emerg] bind() to 0.0.0.0:80 failed (98: Address already in use)
```

#### **علت:**
- port 80 قبلاً استفاده شده
- مشکل در startup script

#### **راه حل:**
```bash
# بررسی port های استفاده شده
netstat -tlnp | grep :80

# تغییر port در docker-compose
ports:
  - "8080:80"
```

## 🔧 راه حل‌های پیشنهادی

### **راه حل ۱: استفاده از Dockerfile ساده**
```bash
# Dockerfile.unified.simple استفاده از
docker build -f Dockerfile.unified.simple -t laravel-unified .
```

### **راه حل ۲: بررسی Alpine Packages**
```bash
# بررسی package های موجود
docker run --rm alpine:latest apk search php82

# بررسی package های نصب شده
docker run --rm alpine:latest apk info
```

### **راه حل ۳: استفاده از Base Image متفاوت**
```dockerfile
# استفاده از Ubuntu base
FROM ubuntu:22.04

# یا استفاده از Debian
FROM debian:bullseye
```

## 📋 Checklist قبل از Build

### ✅ **بررسی فایل‌ها:**
- [ ] فولدر `src` موجود است
- [ ] `composer.json` موجود است
- [ ] `Dockerfile.unified.simple` موجود است
- [ ] `nginx-unified.conf` موجود است
- [ ] `start-services.sh` موجود است

### ✅ **بررسی Docker:**
- [ ] Docker daemon در حال اجرا است
- [ ] Docker login انجام شده است
- [ ] فضای کافی موجود است
- [ ] Network در دسترس است

### ✅ **بررسی سیستم:**
- [ ] فضای دیسک کافی
- [ ] RAM کافی
- [ ] CPU کافی
- [ ] Internet connection

## 🚀 دستورات مفید

### **بررسی Image:**
```bash
# بررسی image های موجود
docker images | grep laravel

# بررسی history image
docker history laravel-unified

# بررسی layers
docker inspect laravel-unified
```

### **بررسی Container:**
```bash
# اجرای container
docker run --rm -it laravel-unified sh

# بررسی process ها
docker exec <container> ps aux

# بررسی logs
docker logs <container>
```

### **بررسی Network:**
```bash
# بررسی network ها
docker network ls

# بررسی port ها
docker port <container>

# بررسی IP
docker inspect <container> | grep IPAddress
```

## 🎯 بهترین Practices

### **۱. استفاده از Multi-stage Build:**
```dockerfile
# Stage 1: Build dependencies
FROM composer:2.5 AS composer
COPY . /app
RUN composer install --no-dev

# Stage 2: Final image
FROM nginx:alpine
COPY --from=composer /app /var/www
```

### **۲. استفاده از .dockerignore:**
```dockerignore
.git
.env
storage/logs/*
storage/framework/cache/*
vendor
node_modules
```

### **۳. استفاده از Health Check:**
```dockerfile
HEALTHCHECK --interval=30s --timeout=3s \
  CMD curl -f http://localhost/health || exit 1
```

### **۴. استفاده از Non-root User:**
```dockerfile
RUN adduser -D -s /bin/sh www
USER www
```

## 🔍 Debug کردن

### **۱. بررسی Logs:**
```bash
# Docker build logs
docker build -f Dockerfile.unified.simple -t laravel-unified . 2>&1 | tee build.log

# Container logs
docker logs <container> 2>&1 | tee container.log
```

### **۲. بررسی Environment:**
```bash
# بررسی Docker info
docker info

# بررسی Docker version
docker version

# بررسی system info
docker system info
```

### **۳. بررسی Resources:**
```bash
# بررسی disk usage
docker system df

# بررسی memory usage
docker stats

# بررسی network usage
docker network ls
```

## 📞 درخواست کمک

اگر مشکل حل نشد:

1. **Log ها را جمع‌آوری کنید:**
   ```bash
   docker build -f Dockerfile.unified.simple -t laravel-unified . 2>&1 | tee build.log
   ```

2. **Docker info را جمع‌آوری کنید:**
   ```bash
   docker info > docker-info.txt
   docker version > docker-version.txt
   ```

3. **System info را جمع‌آوری کنید:**
   ```bash
   uname -a > system-info.txt
   df -h > disk-usage.txt
   free -h > memory-usage.txt
   ```

4. **مشکل را با جزئیات توضیح دهید:**
   - خطای دقیق
   - سیستم عامل
   - Docker version
   - مراحل انجام شده 