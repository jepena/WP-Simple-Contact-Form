jQuery(function ($) {
  
  $(document).ready(function(){
    // Tabs Panel
    var activeIndex = $('.active-tab').index(),
      $contentlis = $('.tabs-content .postbox'),
      $tabslis = $('.tabs .postbox');
  
  // Show content of active tab on loads
  $contentlis.eq(activeIndex).show();

  $('.tabs').on('click', 'li', function (e) {
    var $current = $(e.currentTarget),
        index = $current.index();
    
    $(this).addClass('active-tab').siblings().removeClass('active-tab');
    $contentlis.hide().eq(index).show();
	 });


  });

});