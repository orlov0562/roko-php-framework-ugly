function showScroller(){
    var freeSpace = $(window).width()/2 - $('body>div.container:first').width()/2 - $('#page-scroller').width();
    var showScroller = (freeSpace>50) && ($(this).scrollTop() > 0);
    if (showScroller) {
        $('#page-scroller:hidden').fadeIn();
    } else {
        $('#page-scroller:visible').fadeOut();
    }
}

$(function(){

  $(window).resize(function(){
    showScroller();
  });


  $(window).scroll(function () {
    showScroller();
  });

  $('#page-scroller').click(function(){
    $('body,html').animate({scrollTop: 0}, 400);
    return false;
  });

  showScroller();

});