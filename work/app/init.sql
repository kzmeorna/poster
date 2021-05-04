create database poster;

create user 'dbuser'@'%' identified by 'aaa';

grant all on *.* to 'dbuser'@'%' with grant option;

use poster;

-- アカウント作成時のテーブル
create table users(
  userNumber int not null auto_increment primary key,
  name varchar(20),
  userId varchar(255) unique,
  email varchar(255) unique,
  password varchar(255),
  selfIntroduction text
);

-- tweet_table
create table posts(
  postNumber int not null auto_increment primary key,
  userNumber int not null,
  post text,
  favorites int default 0
);

-- favorite table
create table favorites(
  favoriteNumber int not null auto_increment primary key,
  userNumber int not null,
  postNumber int not null
);

create table images(
  imageNumber int primary key not null auto_increment,
  userNumber int not null,
  filePath varchar(255),
  imgType int
);

-- tl_table start
select * from posts inner join users on posts.email=users.email;
-- tl_table fin




