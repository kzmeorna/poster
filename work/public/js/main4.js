$(function() {

  //プロフィールのタブの切替start
  let tabs=$('.tab');
  $(".tab").on('click',function(){
    $('.active').removeClass('active');
    $(this).addClass('active');
    const index = tabs.index(this);
    $(".content").removeClass("show").eq(index).addClass('show');
  });
  //プロフィールのタブの切替fin

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
            '<span class="fav_count">'+favs[i]+'</span>' //favoriteNumber.length class=done
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


});

