$(function() {
  

  $('.main-nav').on('click', function() {
     if($(event.target).is('.main-nav')) $(this).children('ul').toggleClass("is-visible");
  });
});