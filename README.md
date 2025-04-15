Projeto de gerenciamento de salas

Projeto em Ambiente Docker em PHP Laravel e banco de dados MySQL.

Os seguintes requisitos solicitados foram desenvolvidos:
 - Criar agendamento de sala (data, horário de inicio/fim, nome da sala)
 - Criar sala (nome e status (status 0 como inativo e 1 ativo))
 - Criar usuário (login, senha e adm (campo para indicar se o usuário é um administrador ou não))
 - Listar reservas realizadas
 - Listar salas
 - Listar usuários
 - Checagem de disponibilidade da sala
 - Validar conflitos de horário antes de inserir o agendamento
 - Cancelar ou editar uma reserva
 - Login de usuário gerando token para validação
 - Criptografia de senha ao inserir no banco de dados
 - Checagem de autenticação do usuário

Para realizar qualquer ação será necessário de um usuário, nas rotas de autenticação é possível se registrar passando como parâmetros login, senha e se é um usuário administrador ou não, após criar o usuário será necessário realizar o login, existe a rota para realizar o login que é necessário passar os parâmetros login e senha, onde o sistema irá verificar a existência do usuário e irá autenticá-lo devolvendo um token que irá expirar em 1 hora. Também é possível checar a autenticação no GET authenticaion.
Após passar pelas rotas de autenticação o usuário terá acesso as outras rotas disponíveis, tais são:
 - Room:
     - Register: Na rota Room será possível registrar uma nova sala se o usuário tiver o campo "adm" como 1, ou seja, se o usuário for um administrador, os parâmetros dessa rota será apenas o nome da sala.
     - checkRoom: Nessa rota o usuário verifica a disponibilidade dessa sala, passando como parâmetros o nome da sala, a data e horário de inicio e fim da possível reserva
     - List: Nessa rota o usuário consegue olhar todas as salas existentes no sistema
 - Booking:
       - Create: Nessa rota o usuário pode criar uma reserva, passando como parâmetro o nome da sala e a data e hora que gostaria de reservar, o sistema irá verificar se é possível realizar essa reserva(caso tenha uma reserva para a sala com a data de inicio menor que 1 hora, o sistema não irá permitir a reserva).
       - Cancel: Nessa rota é possível cancelar uma reserva passando como parâmetro o id da reserva, o sistema não permitirá cancelamento se a hora para começar a reserva for menor que 1 hora.
       - Update: Nessa rota é possível modificar a data/hora de uma reserva, parâmetros serão id da reserva, data/hora de inicio e fim da reserva e novamente o sistema irá verificar a disponibilidade da sala.
       - List: Nessa rota será listado todas as reservas feitas no sistema.
 - User:
       - List: Rota para listar todos os usuários na base.

Configuração:
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs para instalar as dependências do projeto.
Configurar o .env de forma adequada para rodar no ambiente desejado, com foco nos campos de aplicação (APP_), banco de dados (DB_).
./vendor/bin/sail up -d para subir o container do projeto.
./vendor/bin/sail artisan jwt:secret para gerar a chave do JWT.
./vendor/bin/sail artisan migrate para configurar a estrutura das tabelas.
