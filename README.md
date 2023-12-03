# Site de Receitas

1. Definição de uma área de negócio, ou domínio de aplicação, que será tratada nesta aplicação. Com o domínio de aplicação, é possível entender quais dados precisam ser mantidos no BD. Exemplo: comércio eletrônico, academia esportiva, rede social etc.

2. Criação de uma base de dados no MySQL para manter os dados necessários ao negócio da sua aplicação web. Você deve criar pelo menos duas tabelas que tenham relacionamento 1xN. Exemplos: cadastro de produtos de uma loja, ou cadastro de professores da academia, ou cadastro de participantes de uma rede social, ou cadastro de carros de uma revendedora etc. Você deve preencher as tabelas no MySQL com dados mínimos para que seja possível demonstrar as funcionalidades do CRUD.

3. Complementação da base de dados no MySQL para manter os dados de usuário e senha da aplicação web: criar uma área (tabela nova ou adaptação de outra tabela) para manter o usuário e sua senha criptografada, preenchida a partir de um cadastro na aplicação.

4. Realizar o tratamento de login para garantir acesso apenas a usuários autenticados.

5. Desenvolvimento de interface padronizada para a aplicação (front-end): (HTML+CSS+JavaScript), em que apenas será possível visualizar o resultado das funcionalidades de CRUD se for usuário autenticado. É possível criar uma interface padronizada ou utilizar um framework CSS, como o W3.CSS ou Boorstrap.

6. Desenvolvimento do tratamento das funcionalidades da aplicação (back-end). Habilite o acesso ao BD no PHP para realizar um CRUD completo nos dados do MySQL (INSERT, SELECT, UPDATE e DELETE). Todas essas operações devem ser realizadas a partir da interface da aplicação (navegador) apenas para usuários autenticados.