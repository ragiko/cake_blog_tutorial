# Cake PHP & Twilio MASHUP!!!

### 1. composerにてinstall 
```
make install
```

### 2. dbの設定
```
make copy-db-config
vi .dbup/properties.ini # dbupの設定
vi Config/database.php  # cakephpのdbの設定
make mig-up             # dbのマイグレーション
```

### other
* httpd.confを適宜設定する
```
<Directory <your/folder/path>>
    Sllowoverride All
</Directory>
```
