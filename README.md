# Community Connect

Este projeto foi desenvolvido no âmbito da Unidade Curricular **Laboratório de Bases de Dados e Aplicações Web (LBAW)** do 1º semestre do 3º ano da **Licenciatura em Engenharia Informática e Computação (LEIC)** da **Faculdade de Engenharia da Universidade do Porto (FEUP)**, no ano letivo 2023/2024.

## lbaw23114 - *Community Connect*

O ***Community Connect*** é um sistema de informação web-based que permite aos utilizadores partilharem perguntas e obterem respostas sobre diversos temas, tendo como intuito fornecer respostas para problemas comuns, num ambiente de interajuda solidária.

### Instalação

O comando para iniciar a imagem disponível no *GitLab Container Registry* (usando a base de dados de produção) é o seguinte:
```bash
docker run -it -p 8000:80 --name=lbaw23114 -e DB_DATABASE="lbaw23114" -e DB_SCHEMA="lbaw23114" -e DB_USERNAME="lbaw23114" -e DB_PASSWORD="ypBZFVzH" git.fe.up.pt:5050/lbaw/lbaw2324/lbaw23114
```

### URL

O ***Community Connect*** encontra-se disponível em: https://lbaw23114.lbaw.fe.up.pt.

### Credenciais

As credenciais para acesso ao ***Community Connect*** são as expostas na tabela abaixo.

| Tipo | Username | Email | Password |
| ---- | -------- | ----- | -------- |
| Utilizador Autenticado | user | user@email.com | CCpassword |
| Moderador | johnmod | johnmod@gmail.com | CCpassword |
| Administrador | admin | admin@email.com | Lbaw23114 |

### Equipa

* António Henrique Martins Azevedo, up202108689@up.pt
* António Marujo Rama, up202108801@up.pt
* Manuel Ramos Leite Carvalho Neto, up202108744@up.pt
* Matilde Isabel da Silva Simões, up202108782@up.pt
