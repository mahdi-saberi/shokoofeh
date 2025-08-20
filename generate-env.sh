#!/bin/sh

# Script برای تولید فایل docker-compose.env از template
# این script فایل docker-compose.env را برای production آماده می‌کند
# ✅ حالا در HOST و Container قابل اجرا است

set -e

# رنگ‌ها
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m'

# تابع برای تولید APP_KEY صحیح (32 بایت)
generate_laravel_key() {
    # تولید 32 بایت random data و تبدیل به base64
    if command -v openssl >/dev/null 2>&1; then
        # استفاده از openssl اگر موجود باشد
        openssl rand -base64 32
    else
        # استفاده از /dev/urandom به عنوان جایگزین
        # تولید 32 بایت و تبدیل به base64
        cat /dev/urandom | tr -dc 'a-zA-Z0-9+/' | fold -w 32 | head -n 1 | tr -d '\n'
        # اضافه کردن padding برای base64
        echo "=="
    fi
}

# بررسی محیط اجرا
check_environment() {
    if [ -f /.dockerenv ] || grep -q 'docker\|lxc' /proc/1/cgroup 2>/dev/null; then
        echo -e "${BLUE}🌐 اجرا در Container/Kubernetes${NC}"
        CONTAINER_MODE=true
    else
        echo -e "${BLUE}🖥️ اجرا در HOST${NC}"
        CONTAINER_MODE=false
    fi
}

echo -e "${GREEN}🚀 تولید فایل docker-compose.env برای Production${NC}"

# بررسی محیط اجرا
check_environment

# بررسی وجود template
if [ ! -f "env.production.template" ]; then
    echo -e "${RED}❌ فایل env.production.template یافت نشد!${NC}"
    exit 1
fi

echo -e "${GREEN}✅ فایل template یافت شد!${NC}"

# کپی کردن template به docker-compose.env
echo -e "${YELLOW}📋 کپی کردن template...${NC}"
cp env.production.template docker-compose.env

# تولید APP_KEY صحیح (32 بایت)
if grep -q "APP_KEY=" docker-compose.env; then
    echo -e "${YELLOW}🔑 تولید APP_KEY صحیح (32 بایت)...${NC}"
    APP_KEY=$(generate_laravel_key)
    
    # بررسی طول کلید
    KEY_LENGTH=$(echo "$APP_KEY" | wc -c)
    if [ "$KEY_LENGTH" -ge 44 ]; then  # base64: + 32 بایت = حداقل 44 کاراکتر
        sed -i "s|APP_KEY=.*|APP_KEY=base64:${APP_KEY}|" docker-compose.env
        echo -e "${GREEN}✅ APP_KEY صحیح تولید شد (${KEY_LENGTH} کاراکتر)${NC}"
        echo -e "${BLUE}   کلید: base64:${APP_KEY:0:20}...${NC}"
    else
        echo -e "${RED}❌ خطا در تولید APP_KEY - طول نامناسب${NC}"
        exit 1
    fi
fi

# تنظیم APP_URL
echo -e "${YELLOW}🌐 تنظیم APP_URL...${NC}"
if [ "$CONTAINER_MODE" = true ]; then
    # در container، از مقادیر پیش‌فرض استفاده کن
    APP_URL="https://kubernetes.local"
    echo -e "${BLUE}   استفاده از APP_URL پیش‌فرض: ${APP_URL}${NC}"
else
    # در HOST، از کاربر بپرس
    read -p "لطفاً domain اصلی را وارد کنید (مثال: https://yourdomain.com): " APP_URL
    if [ ! -z "$APP_URL" ]; then
        echo -e "${GREEN}✅ APP_URL تنظیم شد: ${APP_URL}${NC}"
    fi
fi

if [ ! -z "$APP_URL" ]; then
    sed -i "s|APP_URL=https://your-domain.com|APP_URL=${APP_URL}|" docker-compose.env
fi

# تنظیم database credentials
echo -e "${YELLOW}🗄️ تنظیم database credentials...${NC}"
if [ "$CONTAINER_MODE" = true ]; then
    # در container، از مقادیر پیش‌فرض استفاده کن
    DB_USERNAME="laravel"
    DB_PASSWORD="laravel"
    echo -e "${BLUE}   استفاده از database credentials پیش‌فرض${NC}"
else
    # در HOST، از کاربر بپرس
    read -p "Database username (پیش‌فرض: laravel): " DB_USERNAME
    DB_USERNAME=${DB_USERNAME:-laravel}
    
    read -s -p "Database password (پیش‌فرض: laravel): " DB_PASSWORD
    echo
    DB_PASSWORD=${DB_PASSWORD:-laravel}
fi

sed -i "s/DB_USERNAME=laravel/DB_USERNAME=${DB_USERNAME}/" docker-compose.env
sed -i "s/DB_PASSWORD=laravel/DB_PASSWORD=${DB_PASSWORD}/" docker-compose.env

# تنظیم mail configuration
echo -e "${YELLOW}📧 تنظیم mail configuration...${NC}"
if [ "$CONTAINER_MODE" = true ]; then
    # در container، از مقادیر پیش‌فرض استفاده کن
    MAIL_FROM="noreply@kubernetes.local"
    echo -e "${BLUE}   استفاده از mail configuration پیش‌فرض${NC}"
else
    # در HOST، از کاربر بپرس
    read -p "Mail from address (پیش‌فرض: noreply@yourdomain.com): " MAIL_FROM
    MAIL_FROM=${MAIL_FROM:-noreply@yourdomain.com}
fi

sed -i "s|MAIL_FROM_ADDRESS=\"noreply@your-domain.com\"|MAIL_FROM_ADDRESS=\"${MAIL_FROM}\"|" docker-compose.env

# بررسی نهایی APP_KEY
echo -e "${YELLOW}🔍 بررسی نهایی APP_KEY...${NC}"
FINAL_KEY=$(grep "APP_KEY=" docker-compose.env | cut -d'=' -f2)
if [[ "$FINAL_KEY" == base64:* ]]; then
    KEY_CONTENT=${FINAL_KEY#base64:}
    KEY_LENGTH=${#KEY_CONTENT}
    if [ "$KEY_LENGTH" -ge 32 ]; then
        echo -e "${GREEN}✅ APP_KEY صحیح است (${KEY_LENGTH} بایت)${NC}"
    else
        echo -e "${RED}❌ APP_KEY نامعتبر است (${KEY_LENGTH} بایت)${NC}"
        exit 1
    fi
else
    echo -e "${RED}❌ APP_KEY فرمت نامعتبر دارد${NC}"
    exit 1
fi

echo -e "${GREEN}✅ فایل docker-compose.env با موفقیت ایجاد شد!${NC}"
echo -e "${GREEN}📁 فایل ایجاد شده:${NC}"
echo "   - docker-compose.env (برای docker-compose)"

echo -e "${YELLOW}⚠️ نکات مهم:${NC}"
echo "   1. فایل docker-compose.env در .gitignore قرار دارد"
echo "   2. قبل از deployment، تنظیمات را بررسی کنید"
echo "   3. برای تغییرات بعدی، فایل docker-compose.env را ویرایش کنید"
echo "   4. این فایل برای environment variables docker-compose استفاده می‌شود"
echo "   5. APP_KEY صحیح (32 بایت) تولید شد"

if [ "$CONTAINER_MODE" = true ]; then
    echo -e "${GREEN}🚀 حالا می‌توانید deployment را شروع کنید:${NC}"
    echo "   ./deploy-production.sh setup"
    echo "   ./deploy-production.sh deploy"
else
    echo -e "${GREEN}🚀 حالا می‌توانید deployment را شروع کنید:${NC}"
    echo "   ./deploy-production.sh setup"
    echo "   ./deploy-production.sh deploy"
fi

echo -e "${BLUE}💡 نکته: فایل docker-compose.env برای environment variables استفاده می‌شود${NC}"
echo -e "${BLUE}💡 نکته: APP_KEY صحیح تولید شد و خطای cipher نخواهید گرفت${NC}"
echo -e "${BLUE}💡 نکته: Script حالا در HOST و Container قابل اجرا است${NC}" 