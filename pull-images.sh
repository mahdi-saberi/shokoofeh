#!/bin/bash

# تنظیمات registry
REGISTRY="registry.hamdocker.ir"
USERNAME="mahdi-saberi"

# رنگ‌ها برای output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}📥 شروع فرآیند pull image ها از registry شخصی${NC}"
echo -e "${YELLOW}Registry: ${REGISTRY}/${USERNAME}${NC}"
echo ""

# Pull کردن Laravel app image
echo -e "${GREEN}📥 Pulling Laravel app image...${NC}"
docker pull ${REGISTRY}/${USERNAME}/laravel-app:latest
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Laravel app image pull شد${NC}"
else
    echo -e "${RED}❌ خطا در pull کردن Laravel app image${NC}"
    exit 1
fi

# Pull کردن MySQL image
echo -e "${GREEN}📥 Pulling MySQL image...${NC}"
docker pull ${REGISTRY}/${USERNAME}/mysql:8.0
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ MySQL image pull شد${NC}"
else
    echo -e "${RED}❌ خطا در pull کردن MySQL image${NC}"
    exit 1
fi

# Pull کردن Nginx image
echo -e "${GREEN}📥 Pulling Nginx image...${NC}"
docker pull ${REGISTRY}/${USERNAME}/nginx:alpine
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Nginx image pull شد${NC}"
else
    echo -e "${RED}❌ خطا در pull کردن Nginx image${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}🎉 تمام image ها با موفقیت از registry دریافت شدند!${NC}"
echo ""
echo -e "${YELLOW}📋 خلاصه image های دریافت شده:${NC}"
echo -e "  • ${REGISTRY}/${USERNAME}/laravel-app:latest"
echo -e "  • ${REGISTRY}/${USERNAME}/mysql:8.0"
echo -e "  • ${REGISTRY}/${USERNAME}/nginx:alpine"
echo ""
echo -e "${GREEN}✅ آماده اجرا!${NC}"
echo -e "${YELLOW}💡 برای اجرای پروژه: cd src && docker-compose up -d${NC}" 