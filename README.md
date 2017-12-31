# forumpweb
Projeto para disciplina de Programação WEB I.

## Configuração

1º Configure o arquivo de hosts do Windows adicionando as linhas a seguir no fim do seu arquivo de hosts.
```
forum.ifpb               10.0.1.11
forum.ifpb               192.168.92.11
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

*Obs:* após realizar estas configuraçãos, inicie a VM através do ``vagrant up`` e ``vagrant ssh`` para poder utilizar a VM através de linha de comandos.

## Instalando softwares necessários

1º Instale o [nginx](https://nginx.org/en/)
```
sudo apt-get install nginx -y
```

