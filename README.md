# URI.CS16.SearchZipCodeTF

Trabalho desenvolvido para a matéria de Tolerância à Falhas (2020/1). Consiste em um *script* simples criado para simular um sistema tolerante à falhas no consumo de duas APIs REST que retornam as informações de um CEP, informado pelo usuário, através do console.

```plain
Desenvolver uma aplicação (em qualquer linguagem), que utilize da técnica de redundância de Software
A aplicação deve retornar informações de um cep (passado por parâmetro), utilizando os serviços:
ViaCEP e República Virtual
Caso ocorra erro com o primeiro serviço, utilize o segundo
Não precisa de interface gráfica
```

- **Acadêmicos**
  - [João Vitor Veronese Vieira](https://github.com/joao-vieira)
  - [Vinicius Emanoel Andrade](https://github.com/viniciusandd)

## :rocket: Como executar

Existem duas possibilidades de executar o script, são elas:

### :computer: Na minha máquina

A primeira etapa é mapear as classes do projeto.

`composer dumpautoload`

Agora, vamos intalar as dependências.

`composer install`

Por fim, basta executar o script.

`php index.php`

### :whale: Em um container

Primeiramente, vamos buildar uma nova imagem.

`docker build -t search_zipcode . --no-cache`

Agora, vamos iniciar nosso continer através da imagem criada.

`docker run -ti search_zipcode`
