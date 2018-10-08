<?php
use App\Users;
use App\user_profiles;
use App\favourite_sports;

$userId = Session::get('user_id');
?>
@if(Session::has('user_id'))
<!-- Sidebar -->
        <nav id="leftbar" class="navbar sidenav navbar-inverse showhide">
            <ul class="nav sidebar-nav">
                <div class="user_images">
                  <?php
                  $userData = Users::find($userId);
                  if(empty($userData->profile_picture))
                  { 
                  ?>
                  <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                  <?php }else{ ?>
                  <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$userData->profile_picture; ?>" class="img-responsive"/>
                  <?php } ?>
                  <a href="{{url('profile')}}">{{ $userData->name }}</a>
                </div>
                <div class="sidebar_pages">
                  <ul>
                    <li class="{{ Request::path() == 'home' ? 'active' : '' }}">
                     <a href="{{url('home')}}">
                       <img src="{{asset('assets/front_end/images/home.png')}}"/>
                       <span>{{__('label.Home')}}</span>
                     </a>
                    </li>
                     <li class="{{ Request::path() == 'leaderboard' ? 'active' : '' }}">
                     <a href="{{url('leaderboard')}}">
                       <img src="{{asset('assets/front_end/images/leaderboard.png')}}"/>
                       <span>{{__('label.Leaderboard')}} </span>
                     </a>
                    </li>
                     <li class="{{ Request::path() == 'academy' || Request::path() == 'travelodge-school' || Request::path() == 'bonus-trading' ? 'active' : '' }}">
                     <a href="{{url('academy')}}">
                       <img src="{{asset('assets/front_end/images/academy.png')}}"/>
                       <span>{{__('label.Academy')}}</span>
                     </a>
                    </li>
                     <li class="">
                     <a href="#">
                       <img src="{{asset('assets/front_end/images/shop.png')}}"/>
                       <span>{{__('label.Shop')}}</span>
                     </a>
                    </li>
                    <li class="{{ Request::path() == 'trending' ? 'active' : '' }}">
                     <a href="{{url('trending')}}">
                       <img src="{{asset('assets/front_end/images/trending.png')}}"/>
                       <span>{{__('label.Trending')}}</span>
                     </a>
                    </li>
                    <li class="{{ Request::path() == 'all-sports' ? 'active' : '' }}">
                     <a href="{{url('all-sports')}}">
                       <img src="{{asset('assets/front_end/images/all_icon.png')}}"/>
                       <span>{{__('label.All Sports')}}</span>
                     </a>
                    </li>
                    <div class="divider"></div>
                    <h3>My favourites</h3>
                    <?php
                    $GetUserFavouriteSports = user_profiles::select('favourite_sports')->where('user_id',$userId)->get()->toArray();
                    if(!empty($GetUserFavouriteSports))
                    {
                        $DecodedArray = json_decode($GetUserFavouriteSports[0]['favourite_sports'],true);
                        foreach($DecodedArray as $FavouriteSports)
                        {
                            $SportsName = favourite_sports::select('sports_name','sports_image')->where('id',$FavouriteSports)->get()->toArray();
                            foreach($SportsName as $Sports)
                            {
                                //echo $Sports[sports_name];
                                if($Sports['sports_name'] == 'Soccer')
                                {
                    ?>
                            <li class="">
                                <a href="{{url('soccer-odds')}}">
                                <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$Sports['sports_image']; ?>"/>
                                <span><?php echo $Sports['sports_name']; ?></span>
                                </a>
                            </li>
                    <?php
                                }else{
                    ?>
                            <li class="">
                                <a href="{{url('soccer-odds')}}">
                                <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$Sports['sports_image']; ?>"/>
                                <span><?php echo $Sports['sports_name']; ?></span>
                                </a>
                            </li>
                    <?php       }
                            }
                        }
                    }else{
                    ?>
                    <li class="">
                       <a href="{{url('soccer-odds')}}">
                         <img src="{{asset('assets/front_end/images/football.png')}}"/>
                         <span>{{__('label.Soccer')}}</span>
                       </a>
                    </li>
                    <li class="">
                       <a href="#">
                         <img src="{{asset('assets/front_end/images/hockey.png')}}"/>
                         <span>{{__('label.hockey')}} </span>
                       </a>
                    </li>
                    <li class="">
                       <a href="#">
                         <img src="{{asset('assets/front_end/images/basketball.png')}}"/>
                         <span>{{__('label.basketball')}}</span>
                       </a>
                    </li>
                    <li class="">
                       <a href="#">
                         <img src="{{asset('assets/front_end/images/boxing.png')}}"/>
                         <span>{{__('label.boxing')}}</span>
                       </a>
                    </li>
                    <li class="">
                       <a href="#">
                         <img src="{{asset('assets/front_end/images/american-football.png')}}"/>
                         <span>{{__('label.american football')}}</span>
                       </a>
                    </li>
                    <li class="">
                       <a href="#">
                         <img src="{{asset('assets/front_end/images/golf.png')}}"/>
                         <span>{{__('label.golf')}}</span>
                       </a>
                    </li>
                    <li class="">
                       <a href="#">
                         <img src="{{asset('assets/front_end/images/baseball.png')}}"/>
                         <span>{{__('label.baseball')}}</span>
                       </a>
                    </li>
                    <li class="">
                       <a href="#">
                         <img src="{{asset('assets/front_end/images/tennisball.png')}}"/>
                         <span>{{__('label.tennis')}}</span>
                       </a>
                    </li>
                    <?php
                    }
                    ?>
                  </ul>
                </div>
        </nav>
        <!-- sidebar-wrapper -->
@endif
