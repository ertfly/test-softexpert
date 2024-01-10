FROM node:18

# Criação do diretório de trabalho do aplicativo
WORKDIR /app

COPY package.json /app

RUN apt-get update && \
    apt-get install -y openssl

RUN npm install --global serve

RUN yarn install

COPY . /app

CMD yarn $YARN_COMMAND
