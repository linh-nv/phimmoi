# Sử dụng image NodeJS
FROM node:18

# Tạo thư mục làm việc
WORKDIR /app

# Copy package.json và cài đặt dependencies
COPY package*.json ./
RUN npm install

# Copy mã nguồn Vue vào container
COPY . .

# Mở cổng 8080 cho frontend Vue
EXPOSE 8080
