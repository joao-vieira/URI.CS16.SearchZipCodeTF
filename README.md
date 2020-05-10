# URI.CS16.SearchZipCodeTF

Trabalho desenvolvido para a matéria de Tolerância à Falhas (2020/1). Ele consiste em, um script simples criado para simular tolerância à falhas quando o usuário informa, através do console, um CEP que deseja buscar.

## Como executar

Existem duas possibilidades de executar o script, são elas:

### Na minha máquina

A primeira etapa é mapear as classes do projeto.

`composer dumpautoload`

Agora, vamos intalar as dependências.

`composer install`

Por fim, basta executar o script.

`php index.php`

### Em um container

Primeiramente, vamos buildar uma nova imagem.

`docker build -t search_zipcode . --no-cache`

Agora, vamos iniciar nosso continer através da imagem criada.

`docker run -ti search_zipcode`