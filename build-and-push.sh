#!/bin/bash

# تنظیمات registry
REGISTRY="registry.hamdocker.ir"
USERNAME="mahdi-saberi"

# ورژن‌بندی
APP_VERSION=$(date +"%Y.%m.%d-%H%M")
NGINX_VERSION="1.29.1-alpine"
MYSQL_VERSION="8.0"

# رنگ‌ها برای output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 شروع فرآیند build و push image ها به registry شخصی${NC}"
echo -e "${YELLOW}Registry: ${REGISTRY}/${USERNAME}${NC}"
echo -e "${PURPLE}📅 ورژن app: ${APP_VERSION}${NC}"
echo -e "${PURPLE}🌐 ورژن nginx: ${NGINX_VERSION}${NC}"
echo -e "${PURPLE}🗄️ ورژن mysql: ${MYSQL_VERSION}${NC}"
echo ""

# بررسی اینکه آیا Docker login شده است
echo -e "${BLUE}🔍 بررسی وضعیت login به registry...${NC}"

# بررسی login status با استفاده از docker config
if docker config ls | grep -q "${REGISTRY}" || docker info 2>/dev/null | grep -q "Username"; then
    echo -e "${GREEN}✅ قبلاً به registry login شده است${NC}"
else
    echo -e "${YELLOW}⚠️ نیاز به login به registry${NC}"
    echo -e "${BLUE}لطفاً اطلاعات login خود را وارد کنید:${NC}"
    docker login ${REGISTRY}
    
    # بررسی مجدد login
    if [ $? -ne 0 ]; then
        echo -e "${RED}❌ Login ناموفق بود. لطفاً دوباره تلاش کنید.${NC}"
        exit 1
    fi
    echo -e "${GREEN}✅ Login موفقیت‌آمیز بود${NC}"
fi

echo ""

# Build کردن Laravel app image با ورژن جدید
echo -e "${GREEN}📦 Building Laravel app image (ورژن: ${APP_VERSION})...${NC}"
docker build -t ${REGISTRY}/${USERNAME}/laravel-app:${APP_VERSION} .
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Laravel app image build شد${NC}"
else
    echo -e "${RED}❌ خطا در build کردن Laravel app image${NC}"
    exit 1
fi

# Tag کردن latest برای app
echo -e "${BLUE}🏷️ Tagging latest برای app...${NC}"
docker tag ${REGISTRY}/${USERNAME}/laravel-app:${APP_VERSION} ${REGISTRY}/${USERNAME}/laravel-app:latest

# Pull کردن MySQL image و tag کردن آن
echo -e "${GREEN}📦 Pulling و tagging MySQL image (ورژن: ${MYSQL_VERSION})...${NC}"
docker pull mysql:${MYSQL_VERSION}
docker tag mysql:${MYSQL_VERSION} ${REGISTRY}/${USERNAME}/mysql:${MYSQL_VERSION}
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ MySQL image آماده شد${NC}"
else
    echo -e "${RED}❌ خطا در آماده‌سازی MySQL image${NC}"
    exit 1
fi

# Pull کردن Nginx image و tag کردن آن
echo -e "${GREEN}📦 Pulling و tagging Nginx image (ورژن: ${NGINX_VERSION})...${NC}"
docker pull nginx:${NGINX_VERSION}
docker tag nginx:${NGINX_VERSION} ${REGISTRY}/${USERNAME}/nginx:${NGINX_VERSION}
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Nginx image آماده شد${NC}"
else
    echo -e "${RED}❌ خطا در آماده‌سازی Nginx image${NC}"
    exit 1
fi

# Tag کردن stable برای nginx
echo -e "${BLUE}🏷️ Tagging stable برای nginx...${NC}"
docker tag ${REGISTRY}/${USERNAME}/nginx:${NGINX_VERSION} ${REGISTRY}/${USERNAME}/nginx:stable

# Push کردن Laravel app image (هم latest و هم ورژن جدید)
echo -e "${GREEN}📤 Pushing Laravel app image (ورژن: ${APP_VERSION})...${NC}"
docker push ${REGISTRY}/${USERNAME}/laravel-app:${APP_VERSION}
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Laravel app image (ورژن: ${APP_VERSION}) push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن Laravel app image${NC}"
    echo -e "${YELLOW}💡 ممکن است نیاز به login مجدد داشته باشید:${NC}"
    echo -e "${BLUE}docker login ${REGISTRY}${NC}"
    exit 1
fi

echo -e "${GREEN}📤 Pushing Laravel app image (latest)...${NC}"
docker push ${REGISTRY}/${USERNAME}/laravel-app:latest
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Laravel app image (latest) push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن Laravel app image (latest)${NC}"
    exit 1
fi

# Push کردن MySQL image
echo -e "${GREEN}📤 Pushing MySQL image (ورژن: ${MYSQL_VERSION})...${NC}"
docker push ${REGISTRY}/${USERNAME}/mysql:${MYSQL_VERSION}
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ MySQL image push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن MySQL image${NC}"
    exit 1
fi

# Push کردن Nginx image (هم ورژن و هم stable)
echo -e "${GREEN}📤 Pushing Nginx image (ورژن: ${NGINX_VERSION})...${NC}"
docker push ${REGISTRY}/${USERNAME}/nginx:${NGINX_VERSION}
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Nginx image (ورژن: ${NGINX_VERSION}) push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن Nginx image${NC}"
    exit 1
fi

echo -e "${GREEN}📤 Pushing Nginx image (stable)...${NC}"
docker push ${REGISTRY}/${USERNAME}/nginx:stable
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Nginx image (stable) push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن Nginx image (stable)${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}🎉 تمام image ها با موفقیت به registry ارسال شدند!${NC}"
echo ""
echo -e "${YELLOW}📋 خلاصه image های ارسال شده:${NC}"
echo -e "  • ${REGISTRY}/${USERNAME}/laravel-app:${APP_VERSION} (ورژن جدید)"
echo -e "  • ${REGISTRY}/${USERNAME}/laravel-app:latest (آخرین ورژن)"
echo -e "  • ${REGISTRY}/${USERNAME}/mysql:${MYSQL_VERSION}"
echo -e "  • ${REGISTRY}/${USERNAME}/nginx:${NGINX_VERSION} (ورژن دقیق)"
echo -e "  • ${REGISTRY}/${USERNAME}/nginx:stable (ورژن پایدار)"
echo ""
echo -e "${GREEN}✅ آماده استفاده!${NC}"
echo ""
echo -e "${BLUE}💡 نکات مهم:${NC}"
echo -e "  • برای production از ورژن دقیق استفاده کنید: ${APP_VERSION}"
echo -e "  • برای development از latest استفاده کنید"
echo -e "  • nginx 1.29.1-alpine برای production مناسب است"
echo -e "  • mysql ورژن ${MYSQL_VERSION} پایدار است" 