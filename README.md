# CAKEPHPのブログチュートリアルを実際にコーディングしてみた

* ブログチュートリアル: http://book.cakephp.org/2.0/ja/tutorials-and-examples/blog/blog.html
* composerからcakeをinstall: http://book.cakephp.org/2.0/ja/installation/advanced-installation.html

### set up
* composerでcakephpをinstall
```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

### dbの設定
* config/database.phpと.dbup/propaties.iniを変更

```
curl -SslO https://raw.githubusercontent.com/brtriver/dbup/master/dbup.phar
php dbup.phar up
```

### ディレクトリの追加
mkdir .dbup/applied
mkdir tmp
chmod 777 tmp
chmod 777 webroot 
