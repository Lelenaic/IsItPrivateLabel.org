FROM node:26 AS ssr

WORKDIR /app

COPY . .

RUN npm ci
RUN npm run build

CMD node bootstrap/ssr/app.js
