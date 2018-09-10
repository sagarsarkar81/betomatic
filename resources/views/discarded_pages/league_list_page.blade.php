@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header')
   <!-- Page body content -->
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-sm-7" id="content">
            <!-- League list start -->
            <div class="League_list_wrap">
               <div class="match_heading">
                  <img class="" src="{{asset('assets/front_end/images/football.png')}}"/>
                  <span>Soccer</span>
               </div>
               <div class="row">
                  <div style="display: none;" id="nextData">
                    0
                    </div>
                  <div class="col-md-12">
                     
                     <!-- code done on 15/12/2017 -->
                     <h2>{{__('label.Select League')}}</h2>
                       <form action="{{url('soccer-odds-listing-page')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="League_submit top_League_submit">
                          <button class="submit" type="submit">{{__('label.View selected league')}}</button>
                        </div>
                        <div class="clearfix"></div>
                        <!-- code for load league -->
                        <div class="League_list_checkbox" id="LeagueList">
                          
                          <div class="clearfix"></div>
                        </div>
                        <div class="feed_loader" style="display: none;" id="body_loader">
                            <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
                        </div>
                        <!-- end -->
                        <div class="clearfix"></div>
                        <div class="League_submit">
                           <button class="submit" type="submit">{{__('label.View selected league')}}</button>
                        </div>
                        <div class="clearfix"></div>
                       </form>
                     <!-- code done on 15/12/2017 -->
                     
                  </div>
               </div>
            </div>
            <!-- League list end -->
         </div>
         <!-- rightbar part Start -->
         @include('common/rightbar')
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/footer')
@include('common/footer_link')
<script>
$(document).ready(function(){
    $(document).scrollTop();
    var device='';
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {   
        device='Mobile';
        PageLoadData(device);
    }
    else{
        device='Desktop';
        PageLoadData(device);  
    }
});
function PageLoadData(device)
{
    var sendValue = $("#nextData").html();
    $("#body_loader").show();
    $.ajax({
        type: "POST",
        url: "{{url('scroll-league-list')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'sendValue':sendValue,'device':device},
        success: function(result)
        {
            //console.log(result);
            $("#LeagueList").html(result);
            $("#body_loader").hide();
            setTimeout(function() {
                 var nextStartFrom =  $("div.nextDataAjax:last").html();
                 $("#nextData").html(nextStartFrom);
         	}, 100);
            
        }
    });
}
/*************Load data with scroll **********/
$(window).scroll(function() {
    var device='';
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {   
    device='Mobile';
      var divheight = $(".League_list_wrap").height();
      if(divheight >= 550)
      {
        ManageDevice(device); 
      }
    }
    else{
        device='Desktop';
        var x = document.documentElement.clientHeight + $(document).scrollTop();
        var y = document.body.offsetHeight;
        if (x == y)
        {
            ManageDevice(device);
        }
    }
});
function ManageDevice(device)
{
    if( !$(".loadMoreData").is(':visible'))
    {
         var sendValue = parseInt($("#nextData").html());
         $("#body_loader").show();
         $.ajax({
            type: "POST",
            async: false,
            url: "{{url('scroll-league-list')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'sendValue':sendValue,'device':device},
            success: function(result)
            {
                //alert(result);
                $("#LeagueList").append(result);
                $("#body_loader").hide();
                sendValue = parseInt($("#nextData").html());
                if(device == 'Desktop')
                {
                  sendValue+=80;  
                }
                else{
                   sendValue+=10;    
                }
                $("#nextData").html(sendValue);
                setTimeout(function() {
                     var nextStartFrom =  $("div.nextDataAjax:last").html();
                     $("#nextData").html(nextStartFrom);
             	}, 100);
            }
        });
    }
}
/*****************************/
</script>