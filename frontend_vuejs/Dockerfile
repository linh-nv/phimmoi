# Sử dụng image NodeJS
FROM node:18

WORKDIR /app

COPY package*.json ./

RUN npm install && npm install -g serve

COPY . .

RUN npm run build

EXPOSE 8080

CMD ["serve", "-s", "dist", "-l", "8080"]
