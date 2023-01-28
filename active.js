 $(window).on('load',function () {
     var current = location.pathname;
     console.log(current);
     $('#navbarSupportedContent ul li a').each(function(){
         var $this = $(this);
         // if the current path is like this link, make it active
         if($this.attr('href').indexOf(current) !== -1){
             $this.parent().addClass('active');
             $this.parents('.menu-submenu').addClass('show-dropdown');
             $this.parents('.menu-submenu').parent().addClass('active');
         }else{
             $this.parent().removeClass('active');
        }
    })
});