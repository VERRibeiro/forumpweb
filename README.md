# forumpweb
Projeto para disciplina de Programação WEB I.

## Configuração

1º Configure o arquivo de hosts do Windows adicionando as linhas a seguir no fim do seu arquivo de hosts.
```
192.168.92.11   forumpweb.com
10.0.1.11       forumpweb.com
```

2º Configure o arquivo do Vagrantfile.
```
Vagrant.configure("2") do |config|
  config.vm.box = "debian/jessie64"
  config.vm.network :forwarded_port, guest: 80, host: 8888, auto_correct: true
  config.vm.network :private_network, ip: "10.0.1.11"
  config.vm.network :private_network, ip: "192.168.92.11"
  config.vm.synced_folder ".", "/vagrant", type: "virtualbox"
end
```

**Obs:** após realizar estas configuraçãos, inicie a VM através do ``vagrant up`` e ``vagrant ssh`` para poder utilizar a VM através de linha de comandos.

## Instalando softwares necessários

1º Instale o [nginx](https://nginx.org/en/)
```
sudo apt-get install nginx -y
sudo service nginx start
```

2º Instalar o PHP 7.1 e suas dependências.
```
sudo apt-get install apt-transport-https lsb-release ca-certificates
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
sudo su
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
exit
sudo apt-get install -y php7.1 php7.1-zip php7.1-dom php7.1-mbstring 
```

3º Instalar o MongoDB.
```
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 2930ADAE8CAF5059EE73BB4B58712A2291FA4AD5
sudo su
echo "deb http://repo.mongodb.org/apt/debian jessie/mongodb-org/3.6 main" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.6.list
exit
sudo apt-get update
sudo apt-get install -y mongodb-org-server
sudo service mongod start
```

4º Configurando o servidor.

Crie um symlink para facilitar o trabalho. A pasta do projeto será localizada dentro de ``/www``. 
```
sudo ln -s /vagrant /www
```

Crie o arquivo controlador do servidor.
```
sudo nano /etc/nginx/sites-available/site.conf
```

Adicione o seguinte texto dentro do arquivo criado anteriormente.
```
server {
        listen 80;
        root /www/forumpweb/public/;
        index index.php index.html index.htm;
        server_name forumpweb.com;
        location / {
                try_files $uri $uri/ /index.php?$query_string;
        }
        error_page 404 /404.html;
        error_page 500 502 503 504 /50x.html;
        location = /50x.html {
                root /usr/share/nginx/www;
        }
        # pass the PHP scripts to FastCGI server listening on the php-fpm socket
        location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php7.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Agora, ative o site para poder acessá-lo.
```
sudo ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf
```

Reinicie o nginx.
```
sudo service nginx restart
```

5º Instale o Composer.
**Obs:** Siga a instalação fornecida na [página oficial](https://getcomposer.org/download/) substituindo a linha 3 ``php composer-setup.php`` por ``sudo php composer-setup.php --install-dir=/bin --filename=composer`` para uma instalação global.

Edite a variável **PATH** para utilizar as dependências do composer globalmente.
```
sudo nano /etc/profile
```

Substitua a linha ``PATH="/usr/local/bin:/usr/bin:/bin:/usr/local/games:/usr/games"`` por ``PATH="/usr/local/bin:/usr/bin:/bin:/usr/local/games:/usr/games:$HOME/.composer/vendor/bin"``.

Reinicie a VM.

6º Instalando o Laravel.

Vá para o diretório www.
```
cd /www
```

Instale o Laravel.
```
laravel new forumpweb
```

Este comando irá criar uma pasta com o nome *forumpweb* contendo o Laravel e suas dependências.
