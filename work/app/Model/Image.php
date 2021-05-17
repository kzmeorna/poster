<?php

namespace MyApp\Model;

class Image extends \MyApp\Model {

  // テンポラリーからDBにファイルパスを保存//
  public function insertImages($fileTmpPath,$imgType){  
    $storeDir=__DIR__ . '/../../public/img/';
    $fileName=$this->nameDecision($imgType);
    $filePath=$storeDir.$fileName;

    if(move_uploaded_file($fileTmpPath,$filePath)){
      $stmt=$this->_db->prepare('insert into images (userNumber,filePath,imgType) Values(:number,:path,:imgType)');
      $stmt->bindValue(':path',$filePath);
      $stmt->bindValue(':number',$_SESSION['me']);
      $stmt->bindValue(':imgType',$imgType);
      $res=$stmt->execute();
    }else{
      echo '画像のアップロードに失敗しました';
    }
  }

  // db内の画像のアップデート
  public function updateImages($fileTmpPath,$imgType){
    $storeDir=__DIR__ . '/../../public/img/';
    $fileName=$this->nameDecision($imgType);
    $filePath=$storeDir.$fileName;

    var_dump($filePath);

    if(move_uploaded_file($fileTmpPath,$filePath)){
      $stmt=$this->_db->prepare('update images set filePath=:path where userNumber=:number and imgType=:type');
      $stmt->bindValue(':path',$filePath);
      $stmt->bindValue(':type',$imgType);
      $stmt->bindValue(':number',$_SESSION['me']);
      $stmt->execute();
    }else{
      echo '画像のアップロードに失敗しました';
    }
  }

  // imagesテーブルに画像が保存されているかの確認start
  public function searchImg($imgType){
    $stmt=$this->_db->prepare('select userNumber from images where userNumber=:number AND imgType=:type');
    $stmt->bindValue(':number',$_SESSION['me']);
    $stmt->bindValue(':type',$imgType);
    $stmt->execute();

    $res=$stmt->fetchAll(\PDO::FETCH_COLUMN);
    // var_dump(empty($res[0]));
    return empty($res[0]);
  }
  // imagesテーブルに画像が保存されているかの確認fin

  // DBから画像のファイルパスを抽出start
  public function fetchImages($imgType,$userNumber){
    // $stmt=$this->_db->prepare('select * from images where userNumber=:userNumber order by imageNumber desc limit 1');
    $stmt=$this->_db->prepare('select * from images where userNumber=:userNumber and imgType=:type');
    $stmt->bindValue(':userNumber',$userNumber);
    $stmt->bindValue(':type',$imgType);
    $stmt->execute();

    $images=$stmt->fetchAll(\PDO::FETCH_CLASS);
    // if(empty($images)&&$imgType===typTop){
    //   return 'img/notTopImg.png';
    // }else{
    //   return $this->trimPath($images[0]->filePath);
    // }

    switch($imgType){
      case 0:
        if(empty($images)){
          return 'img/notHeaderImg.png';
        }else{
          return $this->trimPath($images[0]->filePath);
        }
        break;
        case 1:
          if(empty($images)){
            return 'img/notTopImg.png';
          }else{
            return $this->trimPath($images[0]->filePath);
          }
          break;
    }

  }
  // DBから画像のファイルパスを抽出fin

  // 画像のファイルパスの整形start
  public function trimPath($path){
    return strstr($path,'img');
  }
  // 画像のファイルパスの整形fin

  // バリデーション
  public function imgValidate($img){
    // ファイルサイズが1mb未満か
    // ファイルの形式は正しいか
    // ファイルがあるかどうか
    $_allowExt=array('jpg','jpeg','png');
    $_fileSize=$img['size'];
    $_fileName=$img['name'];
    $_fileTmp=$img['tmp_name'];

    $_fileExt=pathinfo($_fileName,PATHINFO_EXTENSION);

    if($_fileSize>1048576){
      echo 'ファイルサイズは1MB未満でなければなりません';
      // exit;
    }elseif(!in_array(strtolower($_fileExt),$_allowExt)){
      echo 'ファイル形式が正しくありません';
      // exit;
    }elseif(!is_uploaded_file($_fileTmp)){
      echo 'ファイルが選択されていません';
      // exit;
    }else{
      return true;
    }
  }
  // 画像のファイルパスの整形fin

  // ファイルネームの決定start
  public function nameDecision($imgType){
    switch ($imgType){
      case 0:
        return $fileName='header'.date('YmdHis',time()) . '.jpeg';
        break;
      case 1:
        return $fileName='top'.date('YmdHis',time()) . '.jpeg';
        break;
      case 2:
        return $fileName='tweet'.date('YmdHis',time()) . '.jpeg';
        break;
    }
  }
  // ファイルネームの決定fin

  // タイムライン上でのそれぞれのユーザーのトップ画像の抽出start
  public function getTopImg(){
    $stmt=$this->_db->query('select userNumber,filePath from images where imgType=1 ');
    $tmps=$stmt->fetchAll(\PDO::FETCH_CLASS);
    $topImg=[];
    for($i=0;$i<count($tmps);$i++){
      $topImg+=array($tmps[$i]->userNumber=>$this->trimPath($tmps[$i]->filePath));
    }
    return $topImg;
    // タイムライン上でのそれぞれのユーザーのトップ画像の抽出fin
  }

}
