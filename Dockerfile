# Usa a imagem base do Ubuntu 20.04
FROM ubuntu:20.04

# Evita prompts durante a instalação
ARG DEBIAN_FRONTEND=noninteractive

# Instalar o Apache w PHP
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php python3 python3-pip && \
    apt-get clean

# Copiar as páginas e webservices para o diretório padrão do Apache
COPY servidor_fw/ /var/www/html/

# Copia os arquivos de firmware para o container
COPY arquivos_firmware/ /var/www/html/arquivos_firmware

# Configura permissões para o diretório do Apache
RUN chown -R www-data:www-data /var/www/html

# Ativa o módulo de reescrita do Apache
RUN a2enmod rewrite

# Expoe a porta 80 para acesso HTTP
EXPOSE 80

# Comando para iniciar o Apache
CMD apachectl -D FOREGROUND
