FROM node:alpine

WORKDIR /usr/src/app

COPY . /usr/src/app
COPY ./nginx.conf ./conf.d/default.conf

RUN npm install -g @angular/cli
EXPOSE 4200
RUN npm install

CMD ["ng", "serve", "--host", "0.0.0.0"]