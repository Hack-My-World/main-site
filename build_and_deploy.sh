docker build -t hmw_main-site .
docker run -p 80:80 -d --name hmw_main-site -v $PWD/src/:/var/www/html --restart=unless-stopped hmw_main-site
