# Servidor de firmware com Docker

Neste repositório, você encontra o servidor de firmware feito com Docker.
Trata-se de um servidor simples, *não seguro*, feito com propósito de auxiliar os testes de atualização remota de firmwareem microcontroladores e SoCs.

O projeto consiste em um servidor de arquivos, utilizando Ubuntu 20.04 LTS como sistema operacional, com Apache (servidor de páginas) e PHP. A organização adotada possui a seguinte hierarquia:

- Podem existir N projetos
- Cada projeto pode possuir N microcontroladores
- Cada microcontrolador pod possuir N versões de firmware
- Cada versão de firmware possui 1 arquivo de firmware

# Instruções

Abaixo seguem as instruções para uso

## Passo 1: popular diretório de firmwares

Antes de criar a imagem Docker e executar o container Docker, é preciso coloca os arquivos de firmware no diretório arquivos_firmware. Atente para seguir a hierarquia descrita acima. Você pode ter quantos projetos quiser, com quantos microcontroladores quiser e disponibilizando quantas versões de firmware desejar.

## Passo 2: criação da imagem e execução do container

Uma vez populado o diretório de arquivos de firmware, é preciso criar a imagem Docker. 
Utilize o comando abaixo para criar uma imagem Docker com base no Dockerfile do projeto, onde essa imagem se chamará img_servidor_fw:

```
sudo docker build -t img_servidor_fw .
```

Uma vez criada a imagem, é o momento de rodar o container Docker.
Utilize o comando abaixo para rodar o container Docker, utilizando a imagem criada como base:

```
sudo docker run -d -p 80:80 img_servidor_fw
```

A partir desse momento, o container Docker está rodando. Você pode testá-lo acessando a página de teste no endereço http://127.0.0.1/index.html


*Atenção:* uma vez criada a imagem, não é possível mudar os arquivos de firmware. Caso desejar modificar os arquivos de firmware e/ou itens da hierarquia, é preciso:

* Parar o container
* Excluir o container
* Excluir a imagem Docker
* Recriar uma nova imagem Docker
* Rodar um novo container Docker com base na imagem recém criada


## Passo 3: uso do projeto

Para testar a requisição de firmware, você pode utilizar a seguinte URL no seu navegador:

http://127.0.0.1/requisita_firmware.php?projeto=P&target=M&versao=V

Onde:
* P: nome do projeto
* M: nome do microcontrolador
* V: nome da versão de firmware

