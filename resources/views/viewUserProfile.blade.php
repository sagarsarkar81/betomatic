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
use App\follow_users;
use App\user_profiles;
//print_r($FetchUserData);die;
?>
@include('common/header_link')
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function() {
		$('.alert-danger').fadeOut('fast');
        $('.alert-success').fadeOut('fast');
	}, 4000);
});
</script>
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
<!-- Page header top -->
@include('common/register_header')
<!-- Page body content -->
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
      <div class="col-md-3 col-sm-3">
         <div class="profile_leftbar_wrap">
            <div class="user_detils">
                <?php if($FetchUserData[0]['profile_picture'] != ''){ ?>
               <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$FetchUserData[0]['profile_picture']; ?>"/>
               <?php }else{ ?>
               <img src="{{asset('assets/front_end/images/avatar.jpg')}}" />
               <?php } ?>
               <h2><?php echo $FetchUserData[0]['name']; ?></h2>
               <?php
               $GetCountryName = Countries::where('id',$FetchUserData[0]['country_id'])->get()->toArray();
               if(!empty($GetCountryName)) { ?>
               <h5><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $GetCountryName[0]['name']; ?></h5>
               <?php } ?>
               <?php
               if(empty($FetchUserData[0]['id']))
               {
               ?>
               <p>No favourite team selected</p>
               <?php }else{
                   $GetFavouriteTeam = user_profiles::where('user_id',$FetchUserData[0]['id'])->get()->toArray();
                   //print_r($GetFavouriteTeam);
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
                       <p>No favourite team selected</p>
                       <?php }
                    }else{ ?>
                    <p>No favourite team selected</p>
               <?php 
               
                    }
               }
               ?>
            </div>
            <div class="follow_following">
               <a href="{{url('visitors-follow-following')}}/<?php echo $FetchUserData[0]['id']; ?>">
               <?php if(!empty($CountFollowers)) { ?>
               <span><img src="{{asset('assets/front_end/images/follow_img.png')}}"/>Followers <?php echo $CountFollowers; ?></span>
               <?php } else { ?>
               <span><img src="{{asset('assets/front_end/images/follow_img.png')}}"/>Followers 0</span>
               <?php } if(!empty($CountFolowing)) { ?>
               <span><img src="{{asset('assets/front_end/images/following.png')}}"/>Following <?php echo $CountFolowing; ?></span>
               <?php }else { ?>
               <span><img src="{{asset('assets/front_end/images/following.png')}}"/>Following 0</span>
               <?php } ?>
               </a>
            </div>
            <!------done by sumit----->
            
            <div class="user_visit_follow">
                <?php 
                $user_id = Session::get('user_id');
                $UserFollowData = follow_users::where('from_userid',$user_id)->where('to_user_id',$FetchUserData[0]['id'])->get()->toArray();
                ?>
                <?php if(empty($UserFollowData)) { ?>
                   <button type="button" id="follow<?php echo $FetchUserData[0]['id']; ?>" class="user_follow active" onclick="FollowUser('<?php echo $FetchUserData[0]['id'];?>','<?php echo $FetchUserData[0]['name'];?>')">Follow</button>
                <?php }else{ ?>
                   <button type="button" id="follow<?php echo $FetchUserData[0]['id']; ?>" class="user_follow active" onclick="FollowUser('<?php echo $FetchUserData[0]['id'];?>','<?php echo $FetchUserData[0]['name'];?>')">Unfollow</button>
                <?php } ?>
            </div>
            
            <!----------------------------->
            <div class="bets_table">
               <img src="{{asset('assets/front_end/images/total.png')}}"/>
               <p>Total Bets : 10</p>
               <ul>
                  <li class="lost">L</li>
                  <li class="win">w</li>
                  <li class="lost">L</li>
                  <li class="win">w</li>
                  <li class="lost">L</li>
                  <li class="win">w</li>
               </ul>
            </div>
            <div class="Achievements_section">
               <h3>Achievements</h3>
               <hr/>
               <ul>
                  <li class="active"><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g1.png')}}">
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g2.png')}}">
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g3.png')}}">
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g4.png')}}">
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g5.png')}}">
                     </a>
                  </li>
                  <li><a href="javascript:void(0)">
                     <img src="{{asset('assets/front_end/images/g6.png')}}">
                     </a>
                  </li>
               </ul>
            </div>
            <?php 
            $user_id = Session::get('user_id');
            if($FetchUserData[0]['id'] == $user_id) { ?> 
            <div class="profile_update">
               <a href="{{url('edit-profile')}}"> Update Profile </a>
            </div>
            <?php } ?>
         </div>
      </div>
      <div class="col-md-6 col-sm-6">
         <div class="Profit_wrap">
            <ul>
               <li>
                  <div class="roi circle" data-thickness="10">
                     <img src="{{asset('assets/front_end/images/roi.png')}}" /> 
                     <strong></strong>
                     <span>Roi</span>
                  </div>
               </li>
               <li>
                  <a href="#">
                     <div class="bets circle" data-thickness="10"> 
                        <img src="{{asset('assets/front_end/images/bet1.png')}}" /> 
                        <strong></strong>
                        <span>Open Bets</span>
                     </div>
                  </a>
               </li>
               <li>
                  <a href="#">
                     <div class="settled circle" data-thickness="10">
                        <img src="{{asset('assets/front_end/images/bet2.png')}}" /> 
                        <strong></strong>
                        <span>settled bets</span>
                     </div>
               </li>
               </a>
               <li>
                  <a href="#">
                     <div class="win circle" data-thickness="10">
                        <img src="{{asset('assets/front_end/images/win.png')}}" /> 
                        <strong></strong>
                        <span>Win</span>
                     </div>
               </li>
               <li>
               <a href="#">
               <div class="loss circle" data-thickness="10">
               <img src="{{asset('assets/front_end/images/loss.png')}}" /> 
               <strong></strong>
               <span>Loss</span>
               </div>
               </a>
               </li> 
               <li>
                  <a href="#">
                     <div class="draw circle" data-thickness="10">
                        <img src="{{asset('assets/front_end/images/draw.png')}}" /> 
                        <strong></strong>
                        <span>Draw</span>
                     </div>
               </li>
               </a>
            </ul>
         </div>
         <div class="userInfoWrap">
            <h3>Your Information</h3>
            <div class="rank_wrap">
               <h5>Ranking Section</h5>
               <ul class="Rank_section">
                  <li>Leaderboard <br/> Position<span>10</span></li>
                  <li>Number Of <br/> Achievements<span>6</span></li>
                  <li>Number Of <br/> gram$<span>30</span></li>
                  <div class="clearfix"></div>
               </ul>
            </div>
            <ul class="nav nav-tabs profile_tab" role="tablist">
               <li role="presentation" class="active"><a href="#information" aria-controls="information" role="tab" data-toggle="tab">Information</a></li>
               <li role="presentation"><a href="#Photo" aria-controls="Photo" role="tab" data-toggle="tab">Photos</a></li>
               <li role="presentation"><a href="#sports" aria-controls="Sports" role="tab" data-toggle="tab">Favourite Sports</a></li>
               <li role="presentation"><a href="#players" aria-controls="Players" role="tab" data-toggle="tab">Teams / Players</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
               <div role="tabpanel" class="tab-pane active" id="information">
                  <div class="information">
                     <p></p>
                     <p>Bio :  <span><?php if(!empty($FetchProfileData)) { echo $FetchProfileData[0]['bio']; } else{ echo "No content"; } ; ?></span></p>
                     <!--p>Gander :  <span>Male</span></p-->
                     <p> years of Member : <span>3 Years</span></p>
                     <?php 
                     $user_id = Session::get('user_id');
                     if($FetchUserData[0]['id'] == $user_id) 
                     { 
                        if(empty($FetchProfileData)) 
                        { 
                     ?>
                     <a data-toggle="modal" data-target="#informaion_modal" href="#">Add Information</a>
                     <?php } else { 
                     ?>
                     <a data-toggle="modal" data-target="#informaion_modal" href="#">Edit Information</a>
                     <?php } 
                     } 
                     ?>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane " id="Photo">
                  <div class="photo_section">
                    <div class="album_show_wrap">
                        <ul>
                            <?php 
                            //$user_id = Session::get('user_id');
                            //if($FetchUserData[0][id] == $user_id) { 
                            if(empty($GetAlbum))
                            {
                            ?> 
                              <li><a href="javascript:void(0);"><img src="{{asset('assets/front_end/images/no_album.gif')}}"/></a></li>
                            <?php 
                            } 
                            else
                            { 
                                foreach($GetAlbum as $Album)
                                {
                                    $ImagesInAlbum = photo_albums::where('album_id',$Album['id'])->get()->toArray();
                                    $CountImages = count($ImagesInAlbum);
                            ?>
                            <li>
                               <a href="javascript:void(0);" >
                                <!--img src="{{asset('assets/front_end/images/Lighthouse.jpg')}}"/-->
                                <?php if(empty($ImagesInAlbum[0]['images'])) { ?>
                                    <img src="{{asset('assets/front_end/images/no_image.png')}}"/>
                                <?php }else{ ?>
                                    <a href="#" data-toggle="modal" data-target="#show_album_img<?php echo $Album['id']; ?>">
                                    <img src="{{asset('assets/front_end/images/album')}}<?php echo '/'.$ImagesInAlbum[0]['images']; ?>"/>
                                <?php } ?>
                                <div class="album_description">
                                  <p><i><?php echo $Album['album_description']; ?></i> <span><?php echo $CountImages; ?></span></p>
                                </div>
                               </a>
                           </li>
                           <?php } 
                           }  
                           ?>
                        </ul>
                    </div> 
                    <div class="clearfix"></div>
                    <?php 
                    $user_id = Session::get('user_id');
                    if($FetchUserData[0]['id'] == $user_id) { 
                    ?> 
                    <a data-toggle="modal" data-target="#album_modal" href="#">Add album </a>
                    <?php } ?>
                  </div>
                  <!-- Album view start -->
                    <div class="album_images_view_wrap" style="display: none;">
                      <span class="BackToAlbum">
                        <a href="#">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                         Back to album </a>
                      </span>
                      <p>Your Album Name..... </p>
                      <div class="show_album_images">
                        <ul>
                          <li><img src="{{asset('assets/front_end/images/Tulips.jpg')}}"/></li>
                          <li><img src="{{asset('assets/front_end/images/Penguins.jpg')}}"/></li>
                          <li><img src="{{asset('assets/front_end/images/Lighthouse.jpg')}}"/></li>
                          <li><img src="{{asset('assets/front_end/images/Penguins.jpg')}}"/></li>
                          <li><img src="{{asset('assets/front_end/images/Tulips.jpg')}}"/></li>
                          <li><img src="{{asset('assets/front_end/images/Penguins.jpg')}}"/></li>
                        </ul>
                      </div>
                      <div class="clearfix"></div>
                    </div>
                  <!-- Album view start -->
               </div>
               <div role="tabpanel" class="tab-pane" id="sports">
                  <div class="favorite_game ">
                     <ul>
                        <?php
                        if(!empty($FetchProfileData))
                        {
                            foreach($FetchProfileData as $KeyFavourite=>$ValueFavourite)
                            {
                                $GetImage = json_decode($ValueFavourite['favourite_sports'],true);
                                if(!empty($GetImage))
                                {
                                    foreach($GetImage as $keyImage=>$ValueImage)
                                    {
                                        $GetImageName = favourite_sports::where('id',$ValueImage)->get()->toArray();
                                        if(!empty($GetImageName))
                                        {
                                            foreach($GetImageName as $key=>$value)
                                            {
                        ?>
                            <li>
                             <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$value['sports_image']; ?>"/>
                             <h5><?php echo $value['sports_name']; ?></h5>
                            </li>
                        <?php
                                            }
                                        }
                                    }
                                }        
                            }
                        }else { ?><p class="No_team_info"><?php echo "No sports available"; ?></p><?php } ?>
                     </ul>
                     <?php 
                    $user_id = Session::get('user_id');
                    if($FetchUserData[0]['id'] == $user_id) { ?> 
                     <a data-toggle="modal" data-target="#Favorite_Sports_modal" href="#">Add Favorite Sports </a>
                    <?php } ?>
                  </div>
               </div>
               <div role="tabpanel" class="tab-pane" id="players">
                  <div class="team_game ">
                    <h2>Favourite Teams</h2>
                    <hr />
                     <ul>
                        <?php 
                        if(!empty($FetchProfileData))
                        {
                            //echo "<pre>";
                            //print_r($FetchProfileData);
                            foreach($FetchProfileData as $KeyPlayerTeam=>$ValuePlayerTeam)
                            {
                                $GetImage = json_decode($ValuePlayerTeam['favourite_teams'],true);
                                if(!empty($GetImage))
                                {
                                    foreach($GetImage as $keyImageName=>$ValueImageName)
                                    {
                                        $GetTeamName =  favourite_teams::where('id',$ValueImageName)->get()->toArray();
                                        if(!empty($GetTeamName))
                                        {
                                            foreach($GetTeamName as $key=>$value)
                                            {
                        ?>
                        <li>
                          <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$value['team_pics']; ?>"/>
                          <h5><?php echo $value['team_name'];?></h5>
                        </li>
                        <?php
                                            }
                                        }
                                    }
                                }else{
                        ?>
                                <p class="No_team_info"><?php echo "No teams available"; ?></p>
                        <?php
                                    
                                }
                            }
                        } else{ ?><p class="No_team_info"><?php echo "No teams available"; ?></p>
                        <?php } ?>
                        <div class="clearfix"></div>
                     </ul>
                     <div class="clearfix"></div>
                     <h2>Favourite Players</h2>
                     <hr />
                     <ul>
                         <?php 
                         if(!empty($FetchProfileData))
                         {
                            //echo "<pre>";
                            //print_r($FetchProfileData);
                            foreach($FetchProfileData as $KeyPlayer=>$ValuePlayer)
                            {
                                $GetImage = json_decode($ValuePlayerTeam['favourite_players'],true);
                                if(!empty($GetImage))
                                {
                                    foreach($GetImage as $KeyPlayer=>$ValuePlayer)
                                    {
                                        $GetPlayerName =  favourite_players::where('id',$ValuePlayer)->get()->toArray();
                                        if(!empty($GetPlayerName))
                                        {
                                            foreach($GetPlayerName as $key=>$value)
                                            {
                         ?>
                         <li>
                          <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$value['players_image']; ?>"/>
                          <h5><?php echo $value['players_name'];?></h5>
                         </li>
                         <?php
                                            }
                                        }
                                    }
                                }else{
                         ?>
                                <p class="No_team_info"><?php echo "No players available"; ?></p>
                         <?php
                                }
                            }
                         } else { ?><p class="No_team_info"><?php echo "No players available"; ?></p>
                         <?php } ?>
                        <div class="clearfix"></div>
                     </ul>
                     <!--a data-toggle="modal" data-target="#Favorite_team_player_modal" href="#"><?php if(!empty($FetchProfileData)) { echo "Edit your Teams / Players"; }else{ echo "Add your Teams / Players"; } ?> </a-->
                    <?php 
                    $user_id = Session::get('user_id');
                    if($FetchUserData[0]['id'] == $user_id) { ?> 
                     <a data-toggle="modal" data-target="#Favorite_team_player_modal" href="#"><?php echo "Add your Teams / Players"; ?> </a>
                    <?php } ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="Profit_wrap" >
            <h3>Profit Section</h3>
            <div id="ProfitChat"></div>
            <div class="clearfix"></div>
         </div>
      </div>
      <!-- Profile_rightbar start  -->
      <div class="col-md-3 col-sm-3">
         <div class="userlabel_meter">
            <ul>
               <li>
                  <h5>Risk level</h5>
                  <hr/>
                  <div id="risk"></div>
               </li>
               <li>
                  <h5>User level</h5>
                  <hr/>
                  <div id="user"></div>
               </li>
            </ul>
         </div>
         <div class="Connected_account">
            <h2>Connected Account</h2>
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
<!-- Bio update modal start -->
<!-- Modal -->
<div id="informaion_modal" data-easein="expandIn" class="registration_modal modal fade informaion_modal" role="dialog">
  <div class="modal-dialog">
    <!---loader--->
    <div class="loader" style="display: none;" id="body_loader">
      <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
     </div>
     <!----------------------->
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php if(empty($FetchProfileData)) { echo "Add Information"; }else{ echo "Edit Information"; } ?></h4>
      </div>
      <div class="modal-body">
       <form class="col-md-8 col-md-offset-2" id="BioUpdateModal" action="javascript:void(0);" autocomplete="off" enctype="multipart/form-data" onsubmit="BioModalFormSubmit()">
        <div class="form-group">
         <label>Enter your BIO</label>
         <textarea rows="3" class="form-control" name="bio" id="biotext" placeholder="Write something about you"><?php if(!empty($FetchProfileData)) { echo $FetchProfileData[0]['bio']; } else{ echo "No Content"; }?></textarea>
        </div>
        <?php if(empty($FetchProfileData)) { ?>
         <button type="submit" class="btn">Save</button>
        <?php }else { ?>
         <button type="submit" class="btn">Edit</button>
        <?php } ?>
       </form>  
       <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<!-- Bio update modal end -->
<!-- add album modal start -->
<!-- Modal -->
<div id="album_modal" data-easein="expandIn" class="registration_modal modal fade album_modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Album</h4>
      </div>
      <div class="modal-body">
       <form class="">
        <div class="form-group col-md-8 col-md-offset-2 album_name">
         <label>Provide album name</label>
         <input type="text" class="form-control" placeholder="Enter your album name">
        </div>
        <div class="clearfix"></div>
        <div class="form-group upload_album_wrap">
          <label>Choose your images</label>
          <span id="upload_album">
              <label class="btn btn-default" for="upload-file-selector">
                  <input id="upload-file-selector" type="file">
                  <span> 
                  <svg xmlns="#" width="18" height="15" viewBox="0 0 20 17">
                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                  </svg> Upload your images </span>
              </label>
          </span>
          <ul class="upload_image_view">
            <li><img src="{{asset('assets/front_end/images/Tulips.jpg')}}"/></li>
            <li><img src="{{asset('assets/front_end/images/Lighthouse.jpg')}}"/></li>
            <li><img src="{{asset('assets/front_end/images/Penguins.jpg')}}"/></li>
            <li><img src="{{asset('assets/front_end/images/Tulips.jpg')}}"/></li>
            <li><img src="{{asset('assets/front_end/images/Lighthouse.jpg')}}"/></li>
          </ul>
          <div class="album_progress">
            <svg id="AlbumProgress"></svg>
          </div>
        </div>
         <button type="submit" class="btn album_upload">Save Album</button>
       </form>  
       <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<!-- add album modal end -->
<!-- Modal -->
<?php if(!empty($GetAlbum)) { 
    foreach($GetAlbum as $Album)
    {
    ?>
    <div id="show_album_img<?php echo $Album['id'];?>" data-easein="expandIn" class="registration_modal modal fade show_album_img" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo $Album['album_description']; ?></h4>
          </div>
          <div class="modal-body">
               <!-- Album view start -->
                        <div class="album_images_view_wrap">
                          <div class="show_album_images">
                            <ul>
                            <?php 
                            $ImagesInAlbum = photo_albums::where('album_id',$Album['id'])->get()->toArray();
                            foreach($ImagesInAlbum as $Images)
                            {
                            ?>
                              <li>
                               <img src="{{asset('assets/front_end/images/album')}}<?php echo '/'.$Images['images']; ?>"/>
                               
                               <div class="dropdown feed_more open" style="display: none;">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                                  <img src="http://127.0.0.1:8000/assets/front_end/images/arrow_down.png">
                                  </a>
                                  <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Demo </a></li>
                                    <li><a href="#">Demo </a></li>
                                    <li><a href="#">Demo</a></li>
                                  </ul>
                              </div>
                              
                              </li>
                            <?php
                            }
                            ?>
                            </ul>
                            
                          </div>
                          <div class="clearfix"></div>
                          <!--form class="" id="imageAlbumUpload2" name="imageAlbumUpload2" method="post" action="javascript:void(0);"  enctype="multipart/form-data">
                              <div class="form-group upload_album_wrap">
                              <span id="upload_album " class="show_upload_album">
                                  <label class="btn btn-default" for="upload-file-selector2">
                                      <input id="upload-file-selector2" type="file" name="file[]" multiple="" />
                                      <span> 
                                      <svg xmlns="#" width="18" height="15" viewBox="0 0 20 17">
                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                      </svg> Upload New Images </span>
                                  </label>
                              </span>
                              <p id="DisplayMsgFileSize" style="display: none;">Your uploaded file size is too large. Please select a valid file up to 5 mb.</p>
                              <p id="DisplayMsgFileSize2" style="display: none;">One of your uploaded file size is too large. Please select a valid file up to 5 mb.</p>
                              <p id="DisplayMsgFileSize3" style="display: none;">This is not a valid format. Please upload any image.</p>
                              <p id="DisplayMsgFileSize4" style="display: none;">This browser does not support HTML5 FileReader.</p>
                              </div>
                              <div class="upload_image_view">
                                 <div class="thumbnail_img" id="thumbnail_imgtwo"></div>
                              </div>
                              <div class="prgrsbar album_prgrsbar" id="prgrsbarAlbumImage2" style="display: none;">
                                  <div class="progress" style="display: block;">
                                     <div class="bar" id="barAlbumImage2"></div >
                                     <div class="percent" id="percentAlbumImage2">0%</div >
                                  </div>
                              </div>
                              <button type="submit" id="SaveAlbum2" style="display: none;" class="btn album_upload" onclick="SubmitImageForm2(<?php echo $Album['id']; ?>)">Save Album</button>
                        </form-->
                        </div>
                      <!-- Album view start -->
           <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
<?php } } ?>
<!-- add album modal end -->




<!-- Bio update modal start -->
<!-- Modal -->
<div id="Favorite_Sports_modal" data-easein="expandIn" class="registration_modal modal fade Favorite_Sports_modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Favorite Sports </h4>
      </div>
      <div class="modal-body">
       <form class="">
        <div class="form-group">
         <label>Add Your Favorite Sports</label>
         <ul class="FavoriteSportsList">
           <li>
             <div class="info-block block-info clearfix">
                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                    <label class="btn btn-default">
                        <div class="bizcontent">
                            <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                            <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                            <img src="{{asset('assets/front_end/images/football.png')}}">
                            <h5>Football</h5>
                        </div>
                    </label>
                </div>
            </div>
           </li>
           <li>
             <div class="info-block block-info clearfix">
                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                    <label class="btn btn-default">
                        <div class="bizcontent">
                            <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                            <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                            <img src="{{asset('assets/front_end/images/hockey.png')}}">
                            <h5>Hockey</h5>
                        </div>
                    </label>
                </div>
            </div>
           </li>
           <li>
             <div class="info-block block-info clearfix">
                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                    <label class="btn btn-default">
                        <div class="bizcontent">
                            <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                            <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                            <img src="{{asset('assets/front_end/images/basketball.png')}}">
                            <h5>Basketball</h5>
                        </div>
                    </label>
                </div>
            </div>
           </li>
           <li>
             <div class="info-block block-info clearfix">
                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                    <label class="btn btn-default">
                        <div class="bizcontent">
                            <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                            <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                            <img src="{{asset('assets/front_end/images/boxing.png')}}">
                            <h5>Boxing</h5>
                        </div>
                    </label>
                </div>
            </div>
           </li>
           <li>
             <div class="info-block block-info clearfix">
                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                    <label class="btn btn-default">
                        <div class="bizcontent">
                            <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                            <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                            <img src="{{asset('assets/front_end/images/american-football.png')}}">
                            <h5>American-Football</h5>
                        </div>
                    </label>
                </div>
            </div>
           </li>
           <li>
             <div class="info-block block-info clearfix">
                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                    <label class="btn btn-default">
                        <div class="bizcontent">
                            <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                            <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                            <img src="{{asset('assets/front_end/images/golf.png')}}">
                            <h5>Golf</h5>
                        </div>
                    </label>
                </div>
            </div>
           </li>
           <li>
             <div class="info-block block-info clearfix">
                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                    <label class="btn btn-default">
                        <div class="bizcontent">
                            <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                            <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                            <img src="{{asset('assets/front_end/images/baseball.png')}}">
                            <h5>Baseball</h5>
                        </div>
                    </label>
                </div>
            </div>
           </li>
           <li>
             <div class="info-block block-info clearfix">
                <div data-toggle="buttons" class="btn-group bizmoduleselect">
                    <label class="btn btn-default">
                        <div class="bizcontent">
                            <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                            <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                            <img src="{{asset('assets/front_end/images/tennisball.png')}}">
                            <h5>Tennisball</h5>
                        </div>
                    </label>
                </div>
            </div>
           </li>
         </ul>
        </div> 
         <div class="clearfix"></div>
         <button type="submit" class="btn sports_submit">Save</button>
       </form>  
       <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<!-- Bio update modal end -->
@include('common/footer_link')
<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/xy.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<!-- Chart code -->
<script>
function BioModalFormSubmit()
{
   $("#body_loader").show();
   var biotext = $("textarea#biotext").val();
   $.ajax({
            type: "POST",
            url: "{{url('update-bio')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'bio':biotext},
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
<script>
var chart = AmCharts.makeChart("ProfitChat", {
  "type": "xy",
  "theme": "light",
  "dataDateFormat": "YYYY-MM-DD",
  "startDuration": 1.5,
  "trendLines": [],
  "balloon": {
    "adjustBorderColor": false,
    "shadowAlpha": 0,
    "fixedPosition": true
  },
  "graphs": [{
    "balloonText": "<div style='margin:5px;'><b>[[x]]</b><br>y:<b>[[y]]</b><br>value:<b>[[value]]</b></div>",
    "bullet": "diamond",
    "maxBulletSize": 25,
    "lineAlpha": 0.8,
    "lineThickness": 2,
    "lineColor": "#32AE4B",
    "fillAlphas": 0,
    "xField": "date",
    "yField": "ay",
    "valueField": "aValue"
  }, {
    "balloonText": "<div style='margin:5px;'><b>[[x]]</b><br>y:<b>[[y]]</b><br>value:<b>[[value]]</b></div>",
    "bullet": "round",
    "maxBulletSize": 25,
    "lineAlpha": 0.8,
    "lineThickness": 2,
    "lineColor": "#e77575",
    "fillAlphas": 0,
    "xField": "date",
    "yField": "by",
    "valueField": "bValue"
  }],
  "valueAxes": [{
    "id": "ValueAxis-1",
    "axisAlpha": 0
  }, {
    "id": "ValueAxis-2",
    "axisAlpha": 0,
    "position": "bottom"
  }],
  "allLabels": [],
  "titles": [],
  "dataProvider": [{
    "date": 1,
    "ay": 6.5,
    "by": 2.2,
    "aValue": 15,
    "bValue": 10
  }, {
    "date": 2,
    "ay": 12.3,
    "by": 4.9,
    "aValue": 8,
    "bValue": 3
  }, {
    "date": 3,
    "ay": 12.3,
    "by": 5.1,
    "aValue": 16,
    "bValue": 4
  }, {
    "date": 5,
    "ay": 2.9,
    "aValue": 9
  }, {
    "date": 7,
    "by": 8.3,
    "bValue": 13
  }, {
    "date": 10,
    "ay": 2.8,
    "by": 13.3,
    "aValue": 9,
    "bValue": 13
  }, {
    "date": 12,
    "ay": 3.5,
    "by": 6.1,
    "aValue": 5,
    "bValue": 2
  }, {
    "date": 13,
    "ay": 5.1,
    "aValue": 10
  }, {
    "date": 15,
    "ay": 6.7,
    "by": 10.5,
    "aValue": 3,
    "bValue": 10
  }, {
    "date": 16,
    "ay": 8,
    "by": 12.3,
    "aValue": 5,
    "bValue": 13
  }, {
    "date": 20,
    "by": 4.5,
    "bValue": 11
  }, {
    "date": 22,
    "ay": 9.7,
    "by": 15,
    "aValue": 15,
    "bValue": 10
  }, {
    "date": 23,
    "ay": 10.4,
    "by": 10.8,
    "aValue": 1,
    "bValue": 11
  }, {
    "date": 24,
    "ay": 1.7,
    "by": 19,
    "aValue": 12,
    "bValue": 3
  }],
});
</script>
<script src="{{asset('assets/front_end/js/circle-progress.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $('.roi.circle').circleProgress({
      value: 0.7,
      fill: { color: '#32bbc6' }
  }).on('circle-animation-progress', function(event, progress) {
      $(this).find('strong').html(parseInt(70 * progress) + '<i>%</i>');
  });
  $('.bets.circle').circleProgress({
      value: 0.6,
      fill: { color: '#138ad5' }
  }).on('circle-animation-progress', function(event, progress) {
      $(this).find('strong').html(parseInt(60 * progress) + '<i>%</i>');
  });
  $('.settled.circle').circleProgress({
      value: 0.9,
      fill: { color: '#06b2cc' }
  }).on('circle-animation-progress', function(event, progress) {
      $(this).find('strong').html(parseInt(90 * progress) + '<i>%</i>');
  });
  $('.win.circle').circleProgress({
      value: 0.5,
      fill: { color: '#33af4d' }
  }).on('circle-animation-progress', function(event, progress) {
      $(this).find('strong').html(parseInt(50 * progress) + '<i>%</i>');
  });
  $('.loss.circle').circleProgress({
      value: 0.3,
      fill: { color: '#e77575' }
  }).on('circle-animation-progress', function(event, progress) {
      $(this).find('strong').html(parseInt(30 * progress) + '<i>%</i>');
  });
  $('.draw.circle').circleProgress({
      value: 0.8,
      fill: { color: '#9033b5' }
  }).on('circle-animation-progress', function(event, progress) {
      $(this).find('strong').html(parseInt(80 * progress) + '<i>%</i>');
  });
</script>
<script src="{{asset('assets/front_end/js/jqmeter.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $('#risk').jQMeter({
    goal:'$10,000',
    raised:'$6,600',
    width:'240px',
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
    width:'240px',
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
        $('#content, #rightSidebar')
            .theiaStickySidebar({
                additionalMarginTop: 30
            });
    });
</script>
<script type="text/javascript" src="{{asset('assets/front_end/js/jquery.progress.js')}}"></script>
<script type="text/javascript">
  var AlbumProgress = $("#AlbumProgress").Progress({
    percent: 50,
    width: 500,
    height: 25,
    backgroundColor: '#ccc',
    barColor: '#3DB355', 
    fontColor: '#fff', 
    radius: 2, 
    fontSize: 14,
    increaseSpeed: 2
  });
  setTimeout(function(){
    AlbumProgress.percent(100);
  }, 4000);
  function FollowUser(FollowingUserId,FollowingUserName)
  {
        if(FollowingUserId != '')
        {
            $.ajax({
                  url:"{{url('Follwing-User')}}",
                  type:'POST',
                  headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                  data: {'FollowingUserId':FollowingUserId,'FollowingUserName':FollowingUserName},
                  success:function(result)
                  {
                        if(result == 'follow')
                        {
                            //$("#follow3").text('Unfollow');
                            $("#follow"+FollowingUserId).text('Unfollow');
                            location.reload();
                        }else{
                            $("#follow"+FollowingUserId).text('Follow');
                            location.reload();
                        }
                  }
            });
        }
  }
</script>