</body>
<script src="{{asset('assets/front_end/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/front_end/js/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/front_end/js/velocity.min.js')}}" type="text/javascript"></script>
<!-- <script src="{{asset('assets/front_end/js/mCustomScrollbar.concat.min.js')}}" type="text/javascript"></script> -->
<script src="{{asset('assets/front_end/js/dropdownanimation.js')}}" type="text/javascript"></script>
<!-- <script>
    (function($){
      $(window).load(function(){

        $(".sidenav").mCustomScrollbar({
          autoHideScrollbar:true,
          theme:"dark"
        });

      });

    })(jQuery);
  </script> -->
  <script>
  $('.sidenav').click (function(){
      $('.sidenav').hasClass('showhide')
      $(this).toggleClass ('showhide');
  });
</script>
<script type="text/javascript" src="{{asset('assets/front_end/js/velocity.ui.min.js')}}"></script>
<script type="text/javascript">
// add the animation to the modal
$(".modal").each(function(index) {
  $(this).on('show.bs.modal', function(e) {
    var open = $(this).attr('data-easein');
    if (open == 'shake') {
      $('.modal-dialog').velocity('callout.' + open);
    } else if (open == 'pulse') {
      $('.modal-dialog').velocity('callout.' + open);
    } else if (open == 'tada') {
      $('.modal-dialog').velocity('callout.' + open);
    } else if (open == 'flash') {
      $('.modal-dialog').velocity('callout.' + open);
    } else if (open == 'bounce') {
      $('.modal-dialog').velocity('callout.' + open);
    } else if (open == 'swing') {
      $('.modal-dialog').velocity('callout.' + open);
    } else {
      $('.modal-dialog').velocity('transition.' + open);
    }
  });
});
</script>
<script>
 $('.selectpicker').selectpicker();
</script>
<script type="text/javascript">
  /*$(document).on('click', '.submit', function (e) {
  	$( ".registration_form").hide();
  	$( ".verify_email" ).show();
  });*/
  function openSuccessModal()
  {
    $( ".registration_form").hide();
  	$( ".verify_email" ).show();
  }
  $('.dismiss').click(function(){
	  location.reload();
  });
</script>
<!-- beting slip js -->
<script type="text/javascript">
  /*$(".bet_place").click(function(){
    $(".betPlace_show").fadeIn();
    var count=0;
    $(".BetStake").each(function(){
            var CheckStakeInput = $(this).val();
            //alert(CheckStakeInput);
            if(CheckStakeInput == '')
            {
               count++;
                //$("#PlaceBet").css('pointer-events','none');
            }
        });
       if(count==0){

       }
       else{
        return;
       }

  });
  $(".Got_section").click(function(){
      PlaceBet();
      $(".betPlace_show").fadeOut();
  });*/
</script>
<script type="text/javascript">
  jQuery.each(jQuery('textarea[data-autoresize]'), function() {
    var offset = this.offsetHeight - this.clientHeight;

    var resizeTextarea = function(el) {
        jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
    };
    jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
});
</script>

<script type="text/javascript">
    if (screen.width <= 980) {
       $(".desktop_feed").html('');
    }
</script>
<script>
  setInterval(function(){
    $(document.body).find('[data-toggle="tooltip"]').tooltip({
      trigger : 'hover'
    });
  },1000);
</script>
<!-- sticky right sidebar
<script type="text/javascript" src="{{asset('assets/front_end/js/sticky-sidebar.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#content, #rightSidebar')
            .theiaStickySidebar({
                additionalMarginTop: 30
            });
    });
</script>-->
<script>
     $('.open_slip').click(function(){
        $("#BetSlipWrapSticky").css({
          right : '0px',
       });
        $('.open_slip').fadeOut();
    });
     $('.closeBet').click(function(){
        $("#BetSlipWrapSticky").css({
          right : '-280px',
       });
        $('.open_slip').fadeIn(1000);
    });
 </script>
