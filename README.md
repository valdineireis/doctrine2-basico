# Doctrine2 básico
Exemplo de utilização do Framework ORM Doctrine2

## Composer
https://getcomposer.org/

Instalar as dependências com base no composer.json
```
composer install
```

## Doctrine
http://www.doctrine-project.org/

### Documentação Query Language
http://doctrine-orm.readthedocs.io/en/latest/reference/dql-doctrine-query-language.html

### Documentação QueryBuilder
http://doctrine-orm.readthedocs.io/en/latest/reference/query-builder.html

## Principais Comandos do Doctrine Console

### Validar os mapeamentos
```
vendor/bin/doctrine orm:validate-schema
```

### Criar as entidades
```
vendor/bin/doctrine orm:schema-tool:create
```

### Exibir as alterações
```
vendor/bin/doctrine orm:schema-tool:update --dump-sql
```

### Aplicar as alterações no banco de dados
```
vendor/bin/doctrine orm:schema-tool:update --force
```

### Efetuar engenharia reversa do banco de dados
```
vendor/bin/doctrine orm:generate-entities
```
