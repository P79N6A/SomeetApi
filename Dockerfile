FROM daocloud.io/boxplay/docker-php7:latest
CMD ['nohup php /var/www/html/component/websocket.php &']