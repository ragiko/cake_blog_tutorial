# CAKEPHPのブログチュートリアルを実際にコーディングしてみた

* ブログチュートリアル: http://book.cakephp.org/2.0/ja/tutorials-and-examples/blog/blog.html
* composerからcakeをinstall: http://book.cakephp.org/2.0/ja/installation/advanced-installation.html

### set up
* composerでcakephpをinstall
```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

* dbの設定
```
CREATE  TABLE IF NOT EXISTS `posts` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(50),
  `body` text,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  `photo` varchar(255),
  `photo_dir` varchar(255),
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB;
```
