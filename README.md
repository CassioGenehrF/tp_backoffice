<p align="center"><a href="https://temporadapaulista.com.br" target="_blank"><img src="https://temporadapaulista.com.br/wp-content/uploads/2022/06/Logo-Grupo-Temporada-Completo-1.png" width="400"></a></p>

## Sobre o Projeto

O TP Backoffice é um projeto para realizar o controle e administração das acomodações disponíveis no site da Temporada Paulista, ele foi inteiramente desenvolvido em Laravel.

## Inicializando o Projeto

Primeiro é necessário clonar o projeto.

```bash
git clone git@github.com:CassioGenehrF/tp_backoffice.git
```

Após isso será necessário subir os containers.

```bash
./vendor/bin/sail up
```

Para que esse comando funcione corretamente no Windows, você já deve possuir o WSL (Windows Subsystem for Linux) e o Docker configurados corretamente.

Agora você já pode acessar sua [aplicação](http://localhost).

Serão criados 2 bancos de dados, 'testing' (Banco de Dados para testes) e 'tp_backoffice' (Banco de Dados da aplicação), que podem ser acessados na porta 3036.