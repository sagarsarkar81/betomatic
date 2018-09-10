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
                  <li class="dropdown top_icon drpdwnli">
                    <a href="javascript:void(0);" onclick="UnreadNotification()" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <img src="{{asset('assets/front_end/images/notification.png')}}"/>
                        <span class="cart_val" id="UnreadNotification"></span>
                    </a>
                    <ul class="dropdown-menu" data-dropdown-in="flipInX" data-dropdown-out="flipOutX" id="ReadNotification">
                    </ul>
                  </li>
                  <!--li class="top_icon" id="NoMessageList"><a href="{{url('visit-message-page')}}"><img src="{{asset('assets/front_end/images/messages.png')}}"/></a></li-->
                  <li class="dropdown top_icon drpdwnli" id="MessageList">
                    <a href="javascript:void(0);" onclick="DetailMessageNotification()" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <img src="{{asset('assets/front_end/images/messages.png')}}"/>
                        <span class="cart_val" id="MessageNotificationCount"></span>
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
</script>
