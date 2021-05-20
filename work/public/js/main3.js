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

  // tweetの表示start
  const id=[];
  const post=[];

  for(i=0;i<guest.length;i++){
    id.push(guest[i].postNumber);
    post.push(guest[i].post);
  }

  const template=$($('.template').html());

  for(i=0;i<guest.length;i++){
    var clone =template.clone(true);
    clone.find('.postedText').text(post[i]);
    // clone.find('.post-list').attr('id',id[i]);
    clone.attr('id',id[i]);
    clone.find('.contributor').parent().attr('id',guest[i].userId);
    var topImgPath=topImg[guest[i].userNumber];
    clone.find('.contributor').attr('src',topImgPath);
    clone.attr('data-user',guest[i].userNumber);
    clone.attr('data-post',guest[i].postNumber);
    
    var text=clone.find('.postedText').text();
    clone.find('.text').html(
            '<span class="username">'+guest[i].name +'</span>'+
            '<span class="userid">@'+guest[i].userId+'</span>'+
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

});