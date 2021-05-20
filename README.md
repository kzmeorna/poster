# Posterの使用方法

  
## オンラインで使用する場合

下記リンクからアクセスすることができます。

<http://35.74.93.123/>

## ローカルで使用する場合
  docker、docker-composeをインストールしたのちに、
  
  ターミナルで任意のディレクトリに移動
  
  次に、
  
  ```
  $git clone https://github.com/kzmeorna/poster.git
  ```
  
  を実行
  
  次に、
  
  ```
  $ docker-compose up -d
  ```
  
  の実行
  
  次に、データベーステーブルの作成を行います。
  
  ```
  $ docker exec -it poster_db_1 bash
  ```
  
  を実行します。
  
  そしたら、MySQLコンテナ内に入れます。
  
  次に、
  
  ```
  $ mysql -u root -p
  ```
  
  を実行します。
  
  実行後、パスワードを求められるので、
  
  rootpass
  
  と入力します。
  
  その次に、
  
  ./work/app/init.sqlのコードを以下順に実行します。
  
  ```
  $ create database poster;
  ```
  
  ```
  create user 'dbuser'@'%' identified by 'aaa';
  ```
  
  ```
  grant all on *.* to 'dbuser'@'%' with grant option;
  ```
  
  ```
  use poster;
  ```
  
  ユーザーテーブル
  
  ```
  create table users(
  userNumber int not null auto_increment primary key,
  name varchar(20),
  userId varchar(255) unique,
  email varchar(255) unique,
  password varchar(255),
  selfIntroduction text
);
  ```
  
  記事テーブル
  
  ```
create table posts(
  postNumber int not null auto_increment primary key,
  userNumber int not null,
  post text,
  favorites int default 0
);
  ```
  
  いいねテーブル
  
   ```
   create table favorites(
  favoriteNumber int not null auto_increment primary key,
  userNumber int not null,
  postNumber int not null
);
   ```
   
   画像ファイルパステーブル
   
   ```
   create table images(
  imageNumber int primary key not null auto_increment,
  userNumber int not null,
  filePath varchar(255),
  imgType int
);

   ```
  
  そしたらlocalhost:80にアクセスすることができます。
  
  サーバーを止めたいときは
  
  ```
  $ docker-compose down
  ```
  
  と実行すればOKです。

