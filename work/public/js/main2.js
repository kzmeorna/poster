$(function() {
 
  // tweetの投稿start
  $('.post').on('click',function(){
    $('.post_Text').submit();
  });
  // tweetの投稿fin

  // モーダルウィンドウからのtweetの投稿start
  $('.post').on('click',function(){
    $('.modal_post').submit();
  });
  // tweetの投稿fin

  // tweetの表示start
  const id=[];
  const post=[];

  for(i=0;i<php.length;i++){
    id.push(php[i].postNumber);
    post.push(php[i].post);
  }

  const template=$($('.template').html());

  for(i=0;i<php.length;i++){
    var clone =template.clone(true);
    clone.find('.postedText').text(post[i]);
    // clone.find('.post-list').attr('id',id[i]);
    clone.attr('id',id[i]);
    clone.find('.contributor').parent().attr('id',php[i].userId);
    var topImgPath=topImg[php[i].userNumber];
    clone.find('.contributor').attr('src',topImgPath);
    clone.attr('data-user',php[i].userNumber);
    clone.attr('data-post',php[i].postNumber);
    
    var text=clone.find('.postedText').text();
    clone.find('.text').html(
            '<span class="username">'+php[i].name +'</span>'+
            '<span class="userid">@'+php[i].userId+'</span>'+
            '<span class="postedText">'+
            text.replace(/\n/g,'<br>')+
            '</span>'+
            '<i class="far fa-heart"></i>'+
            '<span class="fav_count">'+favs[i]+'</span>'

          );

    $('.content'+'.tl').append(clone);
  }

  // tweetの表示fin

  // tlからプロフ頁の表示 start
    $('.contributor').on('click',function(){
      // console.log('hello');
      const id=$(this).parent().attr('id');
      $.ajax({
        type:'post',
        url:"/../_ajax.php",
        data:{
          userId:id,
        },
        dataType:'json',
        scriptCharset:'utf-8'
      });
    });
  // tlからプロフ頁の表示 fin

  

   // いいねボタンの実装start
   $('.fa-heart').on('click',function(){
    var postlist=$(this).parents('.post-list');
    const userNumber=userNumber2;
    const postNumber=postlist.data('post');
    const fav=Number(postlist.find('.fav_count').text());
    $(this).toggleClass('done');
    const booldone=postlist.find('.fav_count').hasClass('done');
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
        // console.log(data)
        postlist.find('.fav_count').text(data)
      },
      function(data){
        console.log(data)
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

  // 投稿モーダルウィンドウstart
  $('.doPost').on('click',function(){
    $('.container').append('<div class="modal_bg"></div>');
    $('.modalContent').fadeIn();
  });
  
  $('.close').on('click',function(){
    $('.modalContent').fadeOut();
    $('.modal_bg').fadeOut();
  });
  // 投稿モーダルウィンドウfin
  
});