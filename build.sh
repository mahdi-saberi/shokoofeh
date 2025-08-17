#!/bin/bash

# اسکریپت build برای image واحد Laravel + Nginx
# این اسکریپت یک image تولید می‌کند که هم nginx و هم PHP-FPM را دارد

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

echo -e "${GREEN}🚀 شروع فرآیند build image واحد Laravel + Nginx${NC}"
echo -e "${YELLOW}Registry: ${REGISTRY}/${USERNAME}${NC}"
echo -e "${PURPLE}📅 ورژن app: ${APP_VERSION}${NC}"
echo -e "${PURPLE}🗄️ ورژن mysql: ${MYSQL_VERSION}${NC}"
echo ""

# انتخاب Dockerfile
echo -e "${BLUE}🔍 انتخاب Dockerfile...${NC}"
if [ -f "Dockerfile.simple" ]; then
    DOCKERFILE="Dockerfile.simple"
    echo -e "${GREEN}✅ استفاده از Dockerfile ساده (Dockerfile.simple)${NC}"
elif [ -f "Dockerfile" ]; then
    DOCKERFILE="Dockerfile"
    echo -e "${GREEN}✅ استفاده از Dockerfile اصلی (Dockerfile)${NC}"
else
    echo -e "${RED}❌ هیچ Dockerfile یافت نشد${NC}"
    exit 1
fi

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

# Build کردن image واحد
echo -e "${GREEN}📦 Building image واحد Laravel + Nginx (ورژن: ${APP_VERSION})...${NC}"
echo -e "${BLUE}📄 استفاده از: ${DOCKERFILE}${NC}"
docker build -f ${DOCKERFILE} -t ${REGISTRY}/${USERNAME}/laravel-unified:${APP_VERSION} .
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Image واحد build شد${NC}"
else
    echo -e "${RED}❌ خطا در build کردن image واحد${NC}"
    echo -e "${YELLOW}💡 نکات troubleshooting:${NC}"
    echo -e "  • مطمئن شوید که فولدر src موجود است"
    echo -e "  • مطمئن شوید که composer.json موجود است"
    echo -e "  • مطمئن شوید که Docker daemon در حال اجرا است"
    exit 1
fi

# Tag کردن latest برای image واحد
echo -e "${BLUE}🏷️ Tagging latest برای image واحد...${NC}"
docker tag ${REGISTRY}/${USERNAME}/laravel-unified:${APP_VERSION} ${REGISTRY}/${USERNAME}/laravel-unified:latest

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

# Push کردن image واحد (هم latest و هم ورژن جدید)
echo -e "${GREEN}📤 Pushing image واحد (ورژن: ${APP_VERSION})...${NC}"
docker push ${REGISTRY}/${USERNAME}/laravel-unified:${APP_VERSION}
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Image واحد (ورژن: ${APP_VERSION}) push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن image واحد${NC}"
    echo -e "${YELLOW}💡 ممکن است نیاز به login مجدد داشته باشید:${NC}"
    echo -e "${BLUE}docker login ${REGISTRY}${NC}"
    exit 1
fi

echo -e "${GREEN}📤 Pushing image واحد (latest)...${NC}"
docker push ${REGISTRY}/${USERNAME}/laravel-unified:latest
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Image واحد (latest) push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن image واحد (latest)${NC}"
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
echo -e "  • ${REGISTRY}/${USERNAME}/laravel-unified:${APP_VERSION} (ورژن جدید)"
echo -e "  • ${REGISTRY}/${USERNAME}/laravel-unified:latest (آخرین ورژن)"
echo -e "  • ${REGISTRY}/${USERNAME}/mysql:${MYSQL_VERSION}"
echo ""
echo -e "${GREEN}✅ آماده استفاده!${NC}"
echo ""
echo -e "${BLUE}💡 نکات مهم:${NC}"
echo -e "  • برای production از ورژن دقیق استفاده کنید: ${APP_VERSION}"
echo -e "  • برای development از latest استفاده کنید"
echo -e "  • image واحد شامل nginx و PHP-FPM است"
echo -e "  • mysql ورژن ${MYSQL_VERSION} پایدار است"
echo ""
echo -e "${PURPLE}🚀 دستورات deployment:${NC}"
echo -e "  # Docker Compose:"
echo -e "  docker-compose -f docker-compose.unified.yml up -d"
echo -e ""
echo -e "  # Kubernetes Development:"
echo -e "  kubectl apply -f k8s-unified-deployment.yaml"
echo -e ""
echo -e "  # Kubernetes Production:"
echo -e "  kubectl apply -f k8s-unified-statefulset.yaml" 