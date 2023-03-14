

## Requirements:
* Tested on PHP8.1 with ext-dom, ext-xml,  ext-pdo, ext-pdo_sqlite and ext-curl

## Installation
* Copy `.env.dist` as `.env`.
* Run `composer install` to install external libraries
* Run `composer start` to install local database and start PHP server
* Open the app in your browser at [127.0.0.1:8088](127.0.0.1:8088)

---
### Console tasks

To view the users list in the CLI, run the following command:
```shell
php ./bin/console.php users:list
```

To create user in the CLI, run the following command:
```shell
php ./bin/console.php users:create "Tom Tom"
```

To display user details in the CLI, run the following command:
```shell
php ./bin/console.php users:show [id]
```
