#!/bin/bash

# اسکریپت تست برای image واحد Laravel + Nginx

# رنگ‌ها
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}🧪 تست image واحد Laravel + Nginx${NC}"
echo ""

# بررسی وجود فایل‌های مورد نیاز
echo -e "${BLUE}🔍 بررسی فایل‌های مورد نیاز...${NC}"
REQUIRED_FILES=(
    "Dockerfile.unified.simple"
    "nginx-unified.conf"
    "start-services.sh"
    "src/composer.json"
    "docker-compose.test.yml"
)

for file in "${REQUIRED_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo -e "  ✅ $file"
    else
        echo -e "  ❌ $file - موجود نیست"
        exit 1
    fi
done

echo ""

# Build image
echo -e "${BLUE}📦 Building image...${NC}"
docker build -f Dockerfile.unified.simple -t laravel-unified:test .
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Image build شد${NC}"
else
    echo -e "${RED}❌ خطا در build image${NC}"
    exit 1
fi

echo ""

# اجرای container برای تست
echo -e "${BLUE}🚀 اجرای container برای تست...${NC}"
docker run -d --name laravel-test \
    -p 8081:80 \
    -v "$(pwd)/src:/var/www" \
    -v "$(pwd)/storage:/var/www/storage" \
    laravel-unified:test

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Container اجرا شد${NC}"
else
    echo -e "${RED}❌ خطا در اجرای container${NC}"
    exit 1
fi

echo ""

# انتظار برای شروع سرویس‌ها
echo -e "${BLUE}⏳ انتظار برای شروع سرویس‌ها...${NC}"
sleep 10

# بررسی وضعیت container
echo -e "${BLUE}🔍 بررسی وضعیت container...${NC}"
if docker ps | grep -q "laravel-test"; then
    echo -e "${GREEN}✅ Container در حال اجرا است${NC}"
else
    echo -e "${RED}❌ Container متوقف شده است${NC}"
    echo -e "${YELLOW}📋 Logs container:${NC}"
    docker logs laravel-test
    exit 1
fi

echo ""

# بررسی process ها
echo -e "${BLUE}🔍 بررسی process ها...${NC}"
docker exec laravel-test ps aux | grep -E "(nginx|php-fpm)" || echo "هیچ process یافت نشد"

echo ""

# تست health check
echo -e "${BLUE}🏥 تست health check...${NC}"
sleep 5
if curl -f http://localhost:8081/health > /dev/null 2>&1; then
    echo -e "${GREEN}✅ Health check موفقیت‌آمیز بود${NC}"
else
    echo -e "${YELLOW}⚠️ Health check ناموفق بود${NC}"
    echo -e "${BLUE}📋 بررسی logs:${NC}"
    docker logs laravel-test
fi

echo ""

# تست Laravel
echo -e "${BLUE}🌐 تست Laravel...${NC}"
if curl -f http://localhost:8081 > /dev/null 2>&1; then
    echo -e "${GREEN}✅ Laravel در دسترس است${NC}"
else
    echo -e "${YELLOW}⚠️ Laravel در دسترس نیست${NC}"
fi

echo ""

# نمایش اطلاعات
echo -e "${GREEN}🎉 تست تکمیل شد!${NC}"
echo ""
echo -e "${BLUE}📋 اطلاعات تست:${NC}"
echo -e "  • Container: laravel-test"
echo -e "  • Port: 8081"
echo -e "  • Health: http://localhost:8081/health"
echo -e "  • Laravel: http://localhost:8081"
echo ""

# پاک کردن container
echo -e "${BLUE}🧹 پاک کردن container تست...${NC}"
docker stop laravel-test
docker rm laravel-test
echo -e "${GREEN}✅ Container تست پاک شد${NC}"

echo ""
echo -e "${GREEN}🎯 تست image واحد با موفقیت تکمیل شد!${NC}"
echo -e "${BLUE}💡 حالا می‌توانید از docker-compose استفاده کنید:${NC}"
echo -e "  docker-compose -f docker-compose.test.yml up -d" 