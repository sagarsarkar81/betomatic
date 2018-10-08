@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header')
   <!-- Page body content -->
   <div class="container">
      <!--div class="row">
         <div class="col-md-12">
            <div class="GameSearchHeading">
               <div class="gameListSearch pull-right">
                  <div class="input-group">
                     <input type="text" class="search-query form-control" placeholder="{{__('label.Search leagues...')}}" />
                     <span class="input-group-btn">
                     <button class="btn btn-success" type="button">
                     <span class=" glyphicon glyphicon-search"></span>
                     </button>
                     </span>
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
         </div-->
         <div class="clearfix"></div>
         <div class="col-md-12">
            <div class="AllSportsWrap">
               <div class="gameListHeading">
                  <h3>{{__('label.Select Game')}}</h3>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="{{url('competitions')}}">
                        <img src="{{asset('assets/front_end/images/game_list/soccer.png')}}" alt=""/>
                        <p>{{__('label.Soccer')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/hockey.png')}}" alt=""/>
                        <p>{{__('label.hockey')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/basketball.png')}}" alt=""/>
                        <p>{{__('label.basketball')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/boxing.png')}}" alt=""/>
                        <p>{{__('label.boxing')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/american-football.png')}}" alt=""/>
                        <p>{{__('label.american football')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/golf.png')}}" alt=""/>
                        <p>{{__('label.golf')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/baseball.png')}}" alt=""/>
                        <p>{{__('label.baseball')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/tennis.png')}}" alt=""/>
                        <p>{{__('label.tennis')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/racing.png')}}" alt=""/>
                        <p>{{__('label.Racing')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/pool.png')}}" alt=""/>
                        <p>{{__('label.Pool')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/handball.png')}}" alt=""/>
                        <p>{{__('label.Handball')}}</p>
                     </a>
                  </div>
               </div>
               <div class="col-md-3 col-sm-6">
                  <div class="allGameHolder">
                     <a href="#">
                        <img src="{{asset('assets/front_end/images/game_list/darts.png')}}" alt=""/>
                        <p>{{__('label.Darts')}}</p>
                     </a>
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
<!-- Modal -->
<div id="headtohdad" data-easein="expandIn" class="modal fade headtohead_modal" role="dialog">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal">×</button>
            <h4 class="modal-title">Head To Head</h4>
         </div>
         <div class="modal-body">
            <div class="head2head_chat col-md-10 col-md-offset-1">
               <div class="chat_one">
                  <h3>Previous Meetings</h3>
                  <div id="chartdiv5"></div>
               </div>
               <div class="chat_one">
                  <h3>Statistic for Home and Away</h3>
                  <div id="chartdiv"></div>
               </div>
               <div class="chat_one">
                  <h3>Latest matches: Home</h3>
                  <div id="chartdiv1"></div>
               </div>
               <div class="chat_one">
                  <h3>Statistic for Home and Away</h3>
                  <div id="chartdiv2"></div>
               </div>
               <div class="chat_one">
                  <h3>Statistic Total Goals for Home and Away</h3>
                  <div id="chartdiv3"></div>
               </div>
               <div class="chat_one">
                  <h3>OverAll</h3>
                  <div id="chartdiv4"></div>
               </div>
               <br/>
               <br/>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</div>
@include('common/footer')
@include('common/footer_link')
<script>
/*function ListLeaguePage()
{
    $.ajax({
        type: "GET",
        url: "{{url('soccer-odds')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: '',
        success: function(result)
        {
            //console.log(result);
            if(result == 'success')
            {
                window.location.href="{{url('soccer-league-list')}}";
            }else{
                window.location.href="{{url('login')}}";
            }
        }
    });
}*/
</script>