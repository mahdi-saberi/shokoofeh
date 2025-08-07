#!/bin/bash

# تنظیمات registry
REGISTRY="registry.hamdocker.ir"
USERNAME="mahdi-saberi"

# رنگ‌ها برای output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 شروع فرآیند build و push image ها به registry شخصی${NC}"
echo -e "${YELLOW}Registry: ${REGISTRY}/${USERNAME}${NC}"
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

# Build کردن Laravel app image
echo -e "${GREEN}📦 Building Laravel app image...${NC}"
docker build -t ${REGISTRY}/${USERNAME}/laravel-app:latest .
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Laravel app image build شد${NC}"
else
    echo -e "${RED}❌ خطا در build کردن Laravel app image${NC}"
    exit 1
fi

# Pull کردن MySQL image و tag کردن آن
echo -e "${GREEN}📦 Pulling و tagging MySQL image...${NC}"
docker pull mysql:8.0
docker tag mysql:8.0 ${REGISTRY}/${USERNAME}/mysql:8.0
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ MySQL image آماده شد${NC}"
else
    echo -e "${RED}❌ خطا در آماده‌سازی MySQL image${NC}"
    exit 1
fi

# Pull کردن Nginx image و tag کردن آن
echo -e "${GREEN}📦 Pulling و tagging Nginx image...${NC}"
docker pull nginx:alpine
docker tag nginx:alpine ${REGISTRY}/${USERNAME}/nginx:alpine
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Nginx image آماده شد${NC}"
else
    echo -e "${RED}❌ خطا در آماده‌سازی Nginx image${NC}"
    exit 1
fi

# Push کردن Laravel app image
echo -e "${GREEN}📤 Pushing Laravel app image...${NC}"
docker push ${REGISTRY}/${USERNAME}/laravel-app:latest
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Laravel app image push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن Laravel app image${NC}"
    echo -e "${YELLOW}💡 ممکن است نیاز به login مجدد داشته باشید:${NC}"
    echo -e "${BLUE}docker login ${REGISTRY}${NC}"
    exit 1
fi

# Push کردن MySQL image
echo -e "${GREEN}📤 Pushing MySQL image...${NC}"
docker push ${REGISTRY}/${USERNAME}/mysql:8.0
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ MySQL image push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن MySQL image${NC}"
    exit 1
fi

# Push کردن Nginx image
echo -e "${GREEN}📤 Pushing Nginx image...${NC}"
docker push ${REGISTRY}/${USERNAME}/nginx:alpine
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Nginx image push شد${NC}"
else
    echo -e "${RED}❌ خطا در push کردن Nginx image${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}🎉 تمام image ها با موفقیت به registry ارسال شدند!${NC}"
echo ""
echo -e "${YELLOW}📋 خلاصه image های ارسال شده:${NC}"
echo -e "  • ${REGISTRY}/${USERNAME}/laravel-app:latest"
echo -e "  • ${REGISTRY}/${USERNAME}/mysql:8.0"
echo -e "  • ${REGISTRY}/${USERNAME}/nginx:alpine"
echo ""
echo -e "${GREEN}✅ آماده استفاده!${NC}" 