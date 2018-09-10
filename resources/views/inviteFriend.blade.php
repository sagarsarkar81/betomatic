<?php
use App\Users;
use App\Countries;
use App\Country_codes;
use App\timezones;
use App\edit_profile_settings;
use App\cms_email_templates;
use App\favourite_sports;
use App\favourite_teams;
use App\favourite_players;
use App\albums;
use App\photo_albums;
use App\user_profiles;
use App\follow_users;
//print_r($FetchProfileData);die;
?>
@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
<!-- Page header top -->
@include('common/register_header')
<!-- Page body content -->
<div class="loader" style="display: none;" id="body_loader_invite_friend">
    <img src="{{asset('assets/front_end/images/spinner.gif')}}"/>
</div>
<div class="container">
    @if (session('status'))
    <div class="alert alert-danger" style="text-align:center">
    {{ session('status') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success" style="text-align:center">
    {{ session('success') }}
    </div>
    @endif
   <?php if(!empty($FetchUserData)) { ?>
   <div class="row">
      <div class="col-md-3 col-sm-12">
         <div class="profile_leftbar_wrap">
            <div class="user_detils">
                <?php if(!empty($FetchUserData[0]->profile_picture)){ ?>
               <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$FetchUserData[0]->profile_picture; ?>"/>
               <?php }else{ ?>
               <img src="{{asset('assets/front_end/images/avatar.jpg')}}" />
               <?php } ?>
               <h2><?php echo $FetchUserData[0]->name; ?></h2>
               <?php
               $GetCountryName = Countries::where('id',$FetchUserData[0]->country_id)->get();
               if(!empty($GetCountryName)) { ?>
               <h5><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $GetCountryName[0]->name; ?></h5>
               <?php } ?>
               
               <?php
               if(empty($FetchUserData[0]->id))
               {
               ?>
               <p>No favourite team selected</p>
               <?php }else{
                   $GetFavouriteTeam = user_profiles::where('user_id',$FetchUserData[0]->id)->get()->toArray();
                   if(!empty($GetFavouriteTeam))
                   {
                       $FavouriteTeam = json_decode($GetFavouriteTeam[0]['favourite_teams'],true);
                       if(!empty($FavouriteTeam))
                       {
                           foreach($FavouriteTeam as $TeamValue)
                           {
                                $TeamName = favourite_teams::where('id',$TeamValue)->get()->toArray();
                                if(!empty($TeamName))
                                {
                                    foreach($TeamName as $Team)
                                    {
                               ?>
                               <p><?php echo $Team['team_name'];?></p>
                               <?php         
                                    }
                               }
                           }
                       }else{ ?>
                       <p>{{__('label.No favourite team selected')}}</p>
                       <?php }
                    }else{ ?>
                    <p>{{__('label.No favourite team selected')}}</p>
               <?php 
               
                    }
               }
               ?>
               
            </div>
            <div class="follow_following">
               <a href="{{url('follow-following')}}">
               <?php if(!empty($CountFollowers)) { ?>
               <span><img src="{{asset('assets/front_end/images/follow_img.png')}}"/>{{__('label.Followers')}} <?php echo $CountFollowers; ?></span>
               <?php } else { ?>
               <span><img src="{{asset('assets/front_end/images/follow_img.png')}}"/>{{__('label.Followers')}} 0</span>
               <?php } if(!empty($CountFolowing)) { ?>
               <span><img src="{{asset('assets/front_end/images/following.png')}}"/>{{__('label.Following')}} <?php echo $CountFolowing; ?></span>
               <?php }else { ?>
               <span><img src="{{asset('assets/front_end/images/following.png')}}"/>{{__('label.Following')}} 0</span>
               <?php } ?>
               </a>
            </div>
            <!------done by sumit----->
            
            <!--div class="user_visit_follow">
                <?php 
                $user_id = Session::get('user_id');
                $UserFollowData = follow_users::where('from_userid',$user_id)->where('to_user_id',$FetchUserData[0]->id)->get()->toArray();
                ?>
                <?php if(empty($UserFollowData)) { ?>
                   <button type="button" id="follow<?php echo $FetchUserData[0]->id; ?>" class="user_follow active" onclick="FollowUser('<?php echo $FetchUserData[0]->id;?>','<?php echo $FetchUserData[0]->name;?>')">Follow</button>
                <?php }else{ ?>
                   <button type="button" id="follow<?php echo $FetchUserData[0]->id; ?>" class="user_follow active" onclick="FollowUser('<?php echo $FetchUserData[0]->id;?>','<?php echo $FetchUserData[0]->name;?>')">Unfollow</button>
                <?php } ?>
            </div-->
            
            <!----------------------------->
            <div class="bets_table">
               <img src="{{asset('assets/front_end/images/total.png')}}"/>
               <p>{{__('label.Total Bets')}} : 10</p>
               <ul>
                  <li class="lost">L</li>
                  <li class="win">w</li>
                  <li class="lost">L</li>
                  <li class="win">w</li>
                  <li class="lost">L</li>
                  <!--li class="win">w</li-->
               </ul>
            </div>
            <div class="Achievements_section">
               <h3>{{__('label.Achievements')}}</h3>
               <hr/>
               <ul>
                  <li class="active"><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g1.png')}}"/>
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g2.png')}}"/>
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g3.png')}}"/>
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g4.png')}}"/>
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g5.png')}}"/>
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g6.png')}}"/>
                     </a>
                  </li>
               </ul>
            </div>
            <div class="profile_update">
               <a href="{{url('edit-profile')}}"> {{__('label.Update Profile')}} </a>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-sm-12">
         
         <div class="Profit_wrap">
          <div class="user_point">
            <h3>{{__('label.See your point')}}</h3>
            <p> <span>{{$TotalPoint}}</span> Points earned. </p>
          </div>

         <div class="send_inviation">
          <h3>{{__('label.Invite yor friend')}}</h3>
            <form method="post"  action="javascript:void(0);" autocomplete="off">
            <input placeholder="Enter email" class="form-control" type="email" name="email" id="email">
            <span id="email_require" style="display:none;">Email Id Required!</span>
            <button class="invite_button" id="sendmail" onclick="SendMail();" >Invite Friend</button>
            </form>
            <div id="copy_mail_section" style="display: none;">
              Or<br>
              <div class="copybox"><div id="copy_mail" ></div>
                <button type="button" onclick="copy_button();" class="btn btn-default">
                  <span class="glyphicon glyphicon-copy"></span> 
                </button>
              </div>
              (You can also share this URL with your friend.)
              
             </div>
         </div>

         </div>

         <div class="Profit_wrap" >
          <h3>{{__('label.How to earn points.')}}</h3>
            <table border="1" width="100%" class="crud-table table table-bordered table-striped table-hover dataTable js-exportable">
              <tr>
                <th>Description</th>
                <th>Points</th>
              </tr>
                <tr>
                  <td>Login / day.</td>
                  <td>1</td>
                </tr>
                <!--<tr>
                  <td>Post a post. </td>
                  <td>1</td>
                </tr>-->
                <tr>
                  <td>Create discussion. </td>
                  <td>2</td>
                </tr>
                <!--<tr>
                  <td>Sign up gaming company.</td>
                  <td>100</td>
                </tr>
                <tr>
                  <td>Achieve achievement.</td>
                  <td>5</td>
                </tr>-->
                <tr>
                  <td>Invite players.</td>
                  <td>10</td>
                </tr>

                <tr>
                  <td>Share on social media.</td>
                  <td>1p/day even if you share it 10 times.</td>
                </tr>
            </table>
         </div>
         
         <div class="Profit_wrap" >
          <h3>{{__('label.Point table history')}}</h3>
            <table border="1" width="100%" id="pointTable" class="crud-table table table-bordered table-striped table-hover dataTable js-exportable">
              <thead>
              <tr>
                <th>Date</th>
                <th>Activity</th>
                <th>Points</th>
              </tr>
            </thead>
            <tbody>
              @foreach($Points as $key => $val)
                <tr>
                  <td>{{date("F jS, Y", strtotime($val->date))}}</td>
                  <td>{{$val->reason}}</td>
                  <td>{{$val->point}}</td>
                </tr>
              @endforeach
            </tbody>
            </table>
         </div>
      </div>
      <!-- Profile_rightbar start  -->
      <div class="col-md-3 col-sm-12">
         <div class="userlabel_meter">
            <ul>
               <li>
                  <h5>{{__('label.Risk level')}}</h5>
                  <hr/>
                  <div id="risk"></div>
               </li>
               <li>
                  <h5>{{__('label.User level')}}</h5>
                  <hr/>
                  <div id="user"></div>
               </li>
            </ul>
         </div>
         <div class="Connected_account">
            <h2>{{__('label.Connected Account')}}</h2>
            <ul>
               <li><a href="#">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                  facebook</a>
               </li>
               <li><a href="#">
                  <i class="fa fa-twitter" aria-hidden="true"></i> 
                  twitter</a>
               </li>
               <li><a href="#">
                  <i class="fa fa-google-plus" aria-hidden="true"></i>
                  Google</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
   <?php } ?>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/footer')
<!-- Bio update modal start -->





</div>






<!-- add album modal end -->
<!-- Bio update modal start -->
<!-- Bio update modal end -->
<!-- //////////////////////// -->
@include('common/footer_link')
<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/xy.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<!-- Chart code -->

<!-- data table -->
<script src="{{asset('assets/front_end/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/front_end/js/dataTables.bootstrap.js')}}"></script>
<script src="{{asset('assets/front_end/js/dataTables.buttons.min.js')}}"></script>

<script>

function BioModalFormSubmit()
{
   $("#body_loader").show();
   var biotext = $("textarea#biotext").val();
   var SelectedTab = "Info";
   $.ajax({
            type: "POST",
            url: "{{url('update-bio')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'bio':biotext,'SelectedTab':SelectedTab},
            success: function(result)
            {
                //console.log(result);
                if(result == 'success')
                {
                    $("#body_loader").hide();
                    location.reload();
                }else{
                    $("#body_loader").hide();
                    location.reload();
                }
            }
   }); 
}
</script>

<script src="{{asset('assets/front_end/js/jqmeter.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $('#risk').jQMeter({
    goal:'$10,000',
    raised:'$6,600',
    height:'20px',
    bgColor: "#ccc",
    barColor: "#d33737",
    counterSpeed: 2000,
    animationSpeed: 2000,
    displayTotal: true,
  });
   $('#user').jQMeter({
    goal:'$10,000',
    raised:'$8,600',
    height:'20px',
    bgColor: "#ccc",
    barColor: "#e3c707",
    counterSpeed: 2000,
    animationSpeed: 2000,
    displayTotal: true,
  });
</script>
<script type="text/javascript" src="{{asset('assets/front_end/js/sticky-sidebar.js')}}"></script>
<script>
    $(document).ready(function() {
      $('#pointTable').dataTable();
        $('#content, #rightSidebar')
            .theiaStickySidebar({
                additionalMarginTop: 30
            });
        //$("#sports").click();
    });
</script>
<script>
  var checkReturn = false;
  function SendMail(){
    var mailId = $("#email").val();

    if(mailId == ""){
      $("#email_require").show();
      setTimeout(function(){ $("#email_require").fadeOut() }, 5000);
      return false;
    }else{
      if(checkReturn)
        return false;
      $("#body_loader_invite_friend").show();
      checkReturn = true;
      var path="{{url('send-mail')}}";
      $.ajax({
        type: "POST",
        url: path,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'email':mailId},
        success: function(result)
        {
          $("#body_loader_invite_friend").hide();
          checkReturn = false;
          $("#email").val('');
          $("#copy_mail_section").show();
          $("#copy_mail").text(result);
          swal({
                title: "Email sent successfully.",
                html : true,
                type: "success",
                confirmButtonColor: "green",
                closeOnConfirm: false,
                closeOnCancel: true,
                customClass: 'invite_succes',
              });
            
        }
     });
    }
  }

  function copy_button(){
    var value = $("#copy_mail").text();
    var $temp = $("<input>");
      $("body").append($temp);
      $temp.val(value).select();
      document.execCommand("copy");
      $temp.remove();
      swal("Copied Successfully.");
  }
</script>

