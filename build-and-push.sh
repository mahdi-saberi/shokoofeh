#!/bin/bash

# تنظیمات registry
REGISTRY="registry.hamdocker.ir"
USERNAME="mahdi-saberi"

# ورژن‌بندی
APP_VERSION=$(date +"%Y.%m.%d-%H%M")
MYSQL_VERSION="8.0"

# رنگ‌ها برای output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 شروع فرآیند build و push unified image به registry شخصی${NC}"
echo -e "${YELLOW}Registry: ${REGISTRY}/${USERNAME}${NC}"
echo -e "${PURPLE}📅 ورژن unified app: ${APP_VERSION}${NC}"
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

# Build کردن unified Laravel image با ورژن جدید
echo -e "${GREEN}📦 Building unified Laravel image (ورژن: ${APP_VERSION})...${NC}"
echo -e "${BLUE}💡 این image شامل Laravel + Nginx + PHP-FPM است${NC}"
docker build -f Dockerfile -t ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION} .
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Unified Laravel image build شد${NC}"
else
    echo -e "${RED}❌ خطا در build کردن unified Laravel image${NC}"
    exit 1
fi

# Tag کردن latest برای unified app
echo -e "${BLUE}🏷️ Tagging latest برای unified app...${NC}"
docker tag ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION} ${REGISTRY}/${USERNAME}/shokoofeh-app:latest

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

# Push کردن unified Laravel image (هم latest و هم ورژن جدید)
echo -e "${GREEN}📤 Pushing unified Laravel image (ورژن: ${APP_VERSION})...${NC}"
docker push ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION}
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Unified Laravel image (ورژن: ${APP_VERSION}) push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن unified Laravel image${NC}"
    echo -e "${YELLOW}💡 ممکن است نیاز به login مجدد داشته باشید:${NC}"
    echo -e "${BLUE}docker login ${REGISTRY}${NC}"
    exit 1
fi

echo -e "${GREEN}📤 Pushing unified Laravel image (latest)...${NC}"
docker push ${REGISTRY}/${USERNAME}/shokoofeh-app:latest
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Unified Laravel image (latest) push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن unified Laravel image (latest)${NC}"
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

echo ""
echo -e "${GREEN}🎉 تمام image ها با موفقیت به registry ارسال شدند!${NC}"
echo ""
echo -e "${YELLOW}📋 خلاصه image های ارسال شده:${NC}"
echo -e "  • ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION} (ورژن جدید - شامل Laravel + Nginx + PHP-FPM)"
echo -e "  • ${REGISTRY}/${USERNAME}/shokoofeh-app:latest (آخرین ورژن)"
echo -e "  • ${REGISTRY}/${USERNAME}/mysql:${MYSQL_VERSION}"
echo ""
echo -e "${GREEN}✅ آماده استفاده!${NC}"
echo ""
echo -e "${BLUE}💡 نکات مهم:${NC}"
echo -e "  • برای production از ورژن دقیق استفاده کنید: ${APP_VERSION}"
echo -e "  • برای development از latest استفاده کنید"
echo -e "  • unified image شامل همه چیز است: Laravel + Nginx + PHP-FPM"
echo -e "  • نیازی به push کردن جداگانه nginx نیست"
echo -e "  • mysql ورژن ${MYSQL_VERSION} پایدار است"
echo ""
echo -e "${PURPLE}🔧 نحوه استفاده:${NC}"
echo -e "  • docker-compose up -d"
echo -e "  • یا: docker run -p 8080:80 ${REGISTRY}/${USERNAME}/shokoofeh-app:${APP_VERSION}" 