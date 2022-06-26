<p align="center"><a href="https://temporadapaulista.com.br" target="_blank"><img src="https://temporadapaulista.com.br/wp-content/uploads/2022/06/Logo-Grupo-Temporada-Completo-1.png" width="400"></a></p>

## Sobre o Projeto

O TP Backoffice é um projeto para realizar o controle e administração das acomodações disponíveis no site da Temporada Paulista, ele foi inteiramente desenvolvido em Laravel.

## Pré-requisitos do Projeto

Para que esse projeto funcione corretamente no Windows, você já deve possuir o WSL (Windows Subsystem for Linux) e o Docker configurados.

## Inicializando o Projeto

Primeiro é necessário clonar o projeto.

```bash
git clone git@github.com:CassioGenehrF/tp_backoffice.git
```

Então precisamos baixar as dependencias do projeto.

```bash
docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs
```

Agora precisamos criar o arquivo das variáveis de ambiente a partir do exemplo.

```bash
cp .env.example .env
```

Em seguida é necessário gerar a APP Key do projeto.

```bash
./vendor/bin/sail artisan key:generate
```

Após isso basta subir os containers.

```bash
./vendor/bin/sail up
```

Agora você já pode acessar sua [aplicação](http://localhost).

Serão criados 2 bancos de dados, 'testing' (Banco de Dados para testes) e 'tp_backoffice' (Banco de Dados da aplicação), que podem ser acessados na porta 3036.