$(function() {

  //新規登録　表示完成版start
  $('.user-create').click(function(){
    window.open('/../signup.php',"_blank");
  });
  //新規登録　表示完成版fin

  // ログイン画面の表示完成版start
  $('.user-login').click(function(){
    window.open('/../login.php',"_blank");
  });
  // ログイン画面の表示完成版fin

  // ゲストユーザーログイン処理start
  $('.guest-login').click(function(){
    window.open('/../guest.php',"_blank");
  });
  // ゲストユーザーログイン処理fin

  //登録ボタンの処理start
  $('.button').click(function(){
    $('.button').parents().submit();
  });
  //登録ボタンの処理fin

  // プロフィール編集モーダルstart
  $('.modal_open').on('click',function(){
    $('.container').append('<div class="modal_bg"></div>');
    $('.modal_content').fadeIn();
  });
  
  $('.close').on('click',function(){
    $('.modal_content').fadeOut();
    $('.modal_bg').fadeOut();
  });
  
  // プロフィール編集モーダルfin

  // トップ画、ヘッダーのサムネイル表示start
  $('.imageFile').on('change',function(){
    var file=this.files[0];
    var tagName=$(this).attr('name');
    var tag=$('.'+tagName).data('tag');

    var reader=new FileReader()
    reader.onload = function(){
      $('.'+tag).attr('src',reader.result);
    }
    reader.readAsDataURL(file);
  });
  // トップ画、ヘッダーのサムネイル表示fin

  //プロフィールのタブの切替start
  let tabs=$('.tab');
  $(".tab").on('click',function(){
    $('.active').removeClass('active');
    $(this).addClass('active');
    const index = tabs.index(this);
    $(".content").removeClass("show").eq(index).addClass('show');
  });
  //プロフィールのタブの切替fin
  
  // tweetの投稿start
  // $('.post').on('click',function(){
  //   $('.postTweet').submit();
  // });
  // tweetの投稿fin

    // モーダルウィンドウからのtweetの投稿start
    $('.post').on('click',function(){
      $('.modal_post').submit();
    });
    // tweetの投稿fin

  // プロフィールページのtweet表示start
  // console.log(tweetsPersonal);
  const personal=$($('.template').html());
  for(i=0;i<postsPersonal.length;i++){
    var clone2 =personal.clone(true);
    clone2.attr('data-user',clickedUser.userNumber);
    clone2.attr('data-post',postsPersonal[i].postNumber);
    clone2.attr('id',postsPersonal[i].postNumber);
    clone2.find('.postedText').text(postsPersonal[i].post);
    clone2.find('.contributor').attr('src',topPath);
    var text=clone2.find('.postedText').text();
    clone2.find('.text').html(
            '<span class="username">'+clickedUser.name +'</span>'+
            '<span class="userid">@'+clickedUser.userId+'</span>'+
            '<span class="postedText">'+
            text.replace(/\n/g,'<br>')+
            '</span>'+
            '<i class="far fa-heart"></i>'+         // class= done
            '<span class="fav_count">'+favs[i]+'</span>'+  //favoriteNumber.length class=done
            '<span class="delete">[x]</span>'
          );

    $('.content'+'#posts').append(clone2);
    
  }
  // プロフィールページのtweet表示fin

  // プロフィールページのいいね欄のツイートの表示start
  console.log(favedPost);
  if(!(favedPost[0]===0)){
    for(i=favedPost.length-1;i>=0;i--){
      var clone3 =personal.clone(true);
      clone3.attr('data-user',favedPost[i].userNumber);
      clone3.attr('data-post',favedPost[i].postNumber);
      clone3.attr('id',favedPost[i].postNumber);
      clone3.find('.contributor').attr('src',favedTopPath[i]);
      clone3.find('.postedText').text(favedPost[i].post);
      
      var text=clone3.find('.postedText').text();
      clone3.find('.text').html(
              '<span class="username">'+nameId[i][0].name+'</span>'+
              '<span class="userid">@'+nameId[i][0].userId+'</span>'+
              '<span class="postedText">'+
              text.replace(/\n/g,'<br>')+
              '</span>'+
              '<i class="far fa-heart"></i>'+         // class= done
              '<span class="fav_count">'+favedPost[i].favorites+'</span>'   //favoriteNumber.length class=done
              
            );
            $('.content'+'#favs').append(clone3);
    }
  }
  // プロフィールページのいいね欄のツイートの表示fin
  
  // 表示更新 start 
  $('.save').on('click',function(){
    var formData=new FormData($('#modal_form').get(0));
    $.ajax({
      type:'POST',
      url:'/../_ajaxImg.php',
      data:formData,
      processData:false,
      contentType:false,
      dataType:'json',
      scriptCharset:'utf-8'
    }).then(console.log('success'),console.log('error')
    );
  });
  // 表示更新 fin

  // いいねボタンの実装start
  $('.fa-heart').on('click',function(){
    var postlist=$(this).parents('.post-list');
    const userNumber=prof.userNumber;
    const postNumber=postlist.data('post');
    const fav=Number(postlist.find('.fav_count').text());
    $(this).toggleClass('done');
    const booldone=postlist.find('.fav_count').hasClass('done');

    if(!($(this).hasClass('done'))){
      $('#favs').find('#'+postNumber).hide();
    }else{
      $('#favs').find('#'+postNumber).show();
    }
    $.ajax({
      type:"POST",
      url:"/../_ajax.php",
      data:{
        'userNumber':userNumber,
        'postNumber':postNumber,
        'fav':fav,
        'booldone':booldone
      },
      dataType:"json",
      context:this
    }).then(
      function(data){
        postlist.find('.fav_count').text(data)
      },
      function(data){
        console.log(data+'failure')
      }
    );
  });
    // いいねボタンの実装fin
    
  // いいね数の登録start 
  for(i=0;i<$('.post-list').length;i++){
    const postList=$('.post-list').eq(i);
    const postNumber2=postList.data('post');
    $.ajax({
      type:'POST',
      url:"/../_ajax.php",
      data:{
        'postNumber':postNumber2
      },
      dataType:"json"
    })
  }
  // いいね数の登録fin

  // いいね状態の保持start
  for(i=0;i<favedPostNum.length;i++){
    for(j=0;j<$('.post-list').length;j++){
      if(favedPostNum[i]===$('.post-list').eq(j).attr('id')){
        // console.log($('.post-list').eq(j).attr('id'));
        $('.post-list').find('.fa-heart').eq(j).addClass('done');
      }
    }
  }
  // いいね状態の保持fin

  // 削除ボタン start
  $('.delete').on('click',function(){
    var deletePostNumber=$(this).parents('.post-list').data('post');
    if(confirm('投稿を削除しますか?')){
      $.ajax({
        type:'POST',
        url:"/../_ajaxDelete.php",
        data:{
          deletePostNumber:deletePostNumber
        },
        dataType:'json',
        context:this
      }).then(
        function(data){
          if(data){
            $(this).parents('.post-list').remove();
          }
        },
        function(XMLHTTPRequest,textStatus,errorThrown){
          console.log(XMLHTTPRequest)
          console.log(textStatus)
          console.log(errorThrown)
        }
      )
    }
  });
  // 削除ボタン fin

  // ツイート投稿モーダルウィンドウstart
  $('.doPost').on('click',function(){
    $('.container').append('<div class="modal_bg"></div>');
    $('.modalContent').fadeIn();
  });
  
  $('.close').on('click',function(){
    $('.modalContent').fadeOut();
    $('.modal_bg').fadeOut();
  });
  // ツイート投稿モーダルウィンドウfin

  // 自分以外のユーザーがプロフ編集できなくする処理start
  console.log(notChange);
  if(!notChange){
    $('.prof_refix').addClass('hidden_profrefix');
    $('.delete').addClass('hidden_profrefix');
  }
  // 自分以外のユーザーがプロフ編集できなくする処理fin

});