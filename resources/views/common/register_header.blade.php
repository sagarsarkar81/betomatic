@if(Session::has('user_id'))
<script>$("body").removeClass("unregister");</script>
@endif
@if(Request::path() == 'home')
  @include('common/betting_slip')
@endif
<?php if(Session::get('language') == 'sek') { ?>
<script>$("body").addClass("bog_swe");</script>
<?php } ?>
<!-- Page header top -->
            <nav class="navbar navbar-default navbar-xs top_nav">
             <div class="container">
              <!-- Brand and toggle get grouped for better mobile display -->
              <!-- <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </div>
                    -->
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left ">
                  <li class="top_bar_logo">
                   <a href="{{url('login')}}">
                      <img src="{{asset('assets/front_end/images/logo.png')}}"/>
                   </a>
                  </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  @if(Session::has('user_id'))
                  <li class="header_search">
                   <div class="search_wrap">
                      <form role="search">
                      <div class="input-group">
                          <div class="input-group-btn">
                              <i class="fa fa-search"></i>
                          </div>
                          <input type="text" id="SearchInput" class="form-control" placeholder="{{__('label.Search for people...')}}" name="SearchUsername" onkeyup="SearchByUsername(this.value)"/>
                      </div>
                      <div class="Header_search_data" id="SearchData" style="display: none;"></div>
                      </form>
                      <div class="Search_loader" style="display: none;" id="search_loader">
                       <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                      </div>
                    </div>
                  </li>
                  @endif
                  @if(Session::has('user_id'))
                  <!--li class="top_icon"><a href="javascript:void(0);" onclick="MyNotification()"><img src="{{asset('assets/front_end/images/notification.png')}}"/></a></li-->
                  <li  class="currency_holder">
                    <div class="currency">
                        Available Balance
                        <span id="Available_balance">100 Gram$ </span>
                    </div>
                  </li>

                  <!--li class="dropdown betfair_connect">
                    <a data-toggle="modal" data-target="#open_betlogin" href="javascript:void(0);">
                        <i data-toggle="tooltip" data-placement="bottom" title="Connect" ><img width="30px" src="{{asset('assets/front_end/images/betfair.png')}}"/></i>
                    </a>

                  </li-->

                  <li class="dropdown top_icon drpdwnli">
                    <a href="javascript:void(0);" onclick="UnreadNotification()" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <img src="{{asset('assets/front_end/images/notification.png')}}"/>
                        <span class="cart_val" id="UnreadNotification" style="display:none"></span>
                    </a>
                    <ul class="dropdown-menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX" id="ReadNotification">
                    </ul>
                  </li>
                  <!--li class="top_icon" id="NoMessageList"><a href="{{url('visit-message-page')}}"><img src="{{asset('assets/front_end/images/messages.png')}}"/></a></li-->
                  <li class="dropdown top_icon drpdwnli" id="MessageList">
                    <a href="javascript:void(0);" onclick="DetailMessageNotification()" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <img src="{{asset('assets/front_end/images/messages.png')}}"/>
                        <span class="cart_val" id="MessageNotificationCount" style="display:none"></span>
                    </a>
                    <ul class="dropdown-menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX" id="MessageNotification">
                    </ul>
                  </li>

                  <!--li class="top_icon"><a href="#"><img src="{{asset('assets/front_end/images/cart_icon.png')}}"/></a><span class="cart_val">1</span></li-->
                  <!--li class="dropdown top_icon">
                    <a id="shopcart-btn" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <img src="{{asset('assets/front_end/images/cart_icon.png')}}"/>
                        <span class="cart_val">1</span>
                    </a>
                    <div class="dropdown-menu shopcart-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                        <div class="sd-hd">Shopping Cart (3 Items)</div>
                        <div class="sd-cart-items">
                            <div class="CartItem">
                                <ul>
                                   <li>
                                      <img src="{{asset('assets/front_end/images/shop-image/Football.png')}}"/>
                                   </li>
                                   <li class="productDes">
                                      <h3>Foodball</h3>
                                      <span>$100 <b>$150</b></span>
                                   </li>
                                   <li class="removeItem">
                                      <a href="#">
                                      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                      </a>
                                   </li>
                                </ul>
                            </div>
                            <div class="CartItem">
                                <ul>
                                   <li>
                                      <img src="{{asset('assets/front_end/images/shop-image/Football.png')}}"/>
                                   </li>
                                   <li class="productDes">
                                      <h3>Foodball</h3>
                                      <span>$100 <b>$150</b></span>
                                   </li>
                                   <li class="removeItem">
                                      <a href="#">
                                      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                      </a>
                                   </li>
                                </ul>
                            </div>
                            <div class="CartItem">
                                <ul>
                                   <li>
                                      <img src="{{asset('assets/front_end/images/shop-image/Football.png')}}"/>
                                   </li>
                                   <li class="productDes">
                                      <h3>Foodball</h3>
                                      <span>$100 <b>$150</b></span>
                                   </li>
                                   <li class="removeItem">
                                      <a href="#">
                                      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                      </a>
                                   </li>
                                </ul>
                            </div>
                        </div>
                        <div class="sd-checkout">
                            <a href="#">Checkout</a>
                        </div>
                    </div>
                </li-->
                  <li class="dropdown profile_drop">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <img src="{{asset('assets/front_end/images/settings.png')}}"/>
                    </a>
                    <ul class="dropdown-menu" role="menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                      <li><a href="{{url('profile')}}"><i class="fa fa-tachometer" aria-hidden="true"></i>{{__('label.User Dashboard')}}</a></li>
                      <li><a href="{{url('edit-profile')}}"><i class="fa fa-pencil" aria-hidden="true"></i>{{__('label.Edit Profile')}} </a></li>
                      <li><a href="{{url('change-password')}}"><i class="fa fa-key" aria-hidden="true"></i></i>{{__('label.Change Password')}} </a></li>
                      <li><a href="{{url('invite-friend')}}"><i class="fa fa-key" aria-hidden="true"></i></i>{{__('label.Invite Friends')}} </a></li>
                      <li><a href="{{url('logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i>{{__('label.Logout')}}</a></li>
                    </ul>
                  </li>
                  @endif
                </ul>
              </div><!-- /.navbar-collapse -->
             </div>
            </nav>
            <div class="nav_hight"></div>
          <!-- Page header end -->

<!-- betfair login  -->
<div id="open_betlogin" class="modal login_form  fade registration_modal " role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4 class="modal-title"> Connect with <span>Betfair</span> </h4>
      </div>
      <div class="modal-body">
         <div class="loader" style="display: none;" id="betfair_loader">
          <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
         </div>
         
         <div class="row">
           <div class="col-md-6 col-md-offset-3">
             <div class="betfair_img">
              <img width="75px" src="{{asset('assets/front_end/images/betfair.png')}}">
             </div>
                <div class="error_message">
                <p id="displayErrorLoginFail" style="display: none;">Login failed</p>
                <p id="displayErrorRestricted" style="display: none;">Your Betfair Account Restricted</p>
                </div> 
               <form id="BetfairLoginForm" action="javascript:void(0)" autocomplete="off" onsubmit="BetfairLogin();">
                 <div class="form-group">
                   <input class="form-control validate[required]" type="text" id="betfair_username" name="betfair_username" placeholder="Enter Betfair Username" />
                 </div>
                 <div class="form-group">
                   <input class="form-control validate[required]" type="Password" id="betfair_password" name="betfair_password" placeholder="Enter Betfair Password" />
                 </div>
                 <div class="form-group rember_me">
                   <input type="checkbox" name="remember_me" value="" id="check_id"> Remember Me
                 </div>
                 <div class="form-group">
                   <button id="login_btn" class="btn-block" type="submit">Login </button>
                 </div>
              </form>
           </div>
         </div>
      </div>
    </div>

  </div>
</div>




<script>
//setInterval(function(){UnreadMessageNotification()},5000);
//setInterval(function(){ReadNotification()},5000);
$(document).ready(function() {
  $("#SearchInput").val('');
  UnreadMessageNotification();
  ReadNotification();
  RechageUserAccount();
});
function SearchByUsername(username)
{
    if(username !='')
    {
        $("#search_loader").show();
        $.ajax({
            type: "POST",
            url: "{{url('search-username')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'username':username},
            success: function(result)
            {
                //console.log(result);
                $("#SearchData").show();
                $("#SearchData").html('');
                $("#SearchData").html(result);
                $("#search_loader").hide();
            }
        });
    }else{
        $("#SearchData").html('');
        $("#SearchData").hide();

    }
}
function UnreadMessageNotification()
{
    $.ajax({
        type: "GET",
        url: "{{url('get-unread-message-notification')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result)
        {
            //console.log(result);
            if(result == 0)
            {
                $("#MessageNotificationCount").html('');
                $("#MessageNotificationCount").hide();
            }else{
                $("#MessageNotificationCount").html(result);
            }
        }
    });
}
/*function GetReadMeassage()
{
    $.ajax({
        type: "GET",
        url: "{{url('get-read-message-notification')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result)
        {
            //console.log(result);
            $("#MessageNotificationCount").html('');
            $("#MessageNotificationCount").hide();
            $("#MessageNotification").html(result);
        }
    });
}*/
function DetailMessageNotification()
{
    $.ajax({
        type: "GET",
        url: "{{url('get-detail-message-notification')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result)
        {
            //console.log(result);
            $("#MessageNotificationCount").html('');
            $("#MessageNotificationCount").hide();
            $("#MessageNotification").html(result);
        }
    });
}
function UnreadNotification()
{
    $.ajax({
        type: "GET",
        url: "{{url('get-detail-notification')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result)
        {
            //console.log(result);
            $("#UnreadNotification").html('');
            $("#UnreadNotification").hide();
            $("#ReadNotification").html(result);
        }
    });
}

function ReadNotification()
{
    $.ajax({
            type: "GET",
            url: "{{url('get-notifications')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result)
            {
                //console.log(result);
                if(result > 0)
                {
                    $("#UnreadNotification").html(result);
                }else{
                    $("#UnreadNotification").hide();
                }

            }
        });
}

function CheckMessageText()
{
    var CheckUser = $("#UserId").text();
    if(CheckUser == '')
    {
        $("#MessageText").prop('disabled', true);
        $("#SubmitButton").attr("disabled", "disabled");
    }else{
        $("#MessageSettings").show();
        $("#MessageText").prop('disabled', false);
        $("#SubmitButton").removeAttr('disabled');
    }
}

function RechageUserAccount()
{
    $.ajax({
            type: "GET",
            url: "{{url('get-user-account-info')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result)
            {
                $("#Available_balance").html('');
                $("#Available_balance").html(result+" Gram$");
            }
        });
}

function BetfairLogin() {
  var valid = $("#BetfairLoginForm").validationEngine('validate');
  if(valid == true) {
    var betfair_username = $("#betfair_username").val();
    var betfair_password = $("#betfair_password").val();
    if ($('#check_id').is(":checked"))
    {
      $("#betfair_loader").show();
      $.ajax({
          type: "POST",
          url: "{{url('betfair-login')}}",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {'betfair_username':betfair_username,'betfair_password':betfair_password},
          success: function(result)
          {
              $("#betfair_loader").hide();
              if(result == "success") {
                window.location.href = "{{url('home')}}";
              } else if (result == "fail") {
                $("#displayErrorLoginFail").css('display','block').delay(3000).fadeOut();
              } else if (result == "restricted") {
                $("#displayErrorRestricted").css('display','block').delay(3000).fadeOut();
              }
          }
      });
    } else {
      $("#betfair_loader").show();
      $.ajax({
          type: "POST",
          url: "{{url('betfair-login-normal')}}",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {'betfair_username':betfair_username,'betfair_password':betfair_password},
          success: function(result)
          {
              $("#betfair_loader").hide();
              if(result == "success") {
                window.location.href = "{{url('home')}}";
              } else if (result == "fail") {
                $("#displayErrorLoginFail").css('display','block').delay(3000).fadeOut();
              } else if (result == "restricted") {
                $("#displayErrorRestricted").css('display','block').delay(3000).fadeOut();
              }
          }
      });
    }
  }
}

</script>
