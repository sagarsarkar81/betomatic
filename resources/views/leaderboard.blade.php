<?php
use App\Users;
use App\follow_users;
if(!empty($GetLeaderBoardsData))
{
    foreach($GetLeaderBoardsData as $Keyleader=>$valueLeader)
    {
        $GetUserData = Users::where('id',$valueLeader[user_id])->get()->toArray();
        {
            foreach($GetUserData as $KeyUserData=>$ValueUserData)
            {
?>
<div class="panel panel-default">
 <div class="panel-heading" role="tab" id="headingOne">
    <h4 class="panel-title">
       <div class="row">
          <div class="col-md-4">
             <div class="leader_user">
                <p>1</p>
                <div class="leader_userDetails">
                   <?php if($ValueUserData[profile_picture] == '') { ?>
                   <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                   <?php } else { ?>
                   <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$ValueUserData[profile_picture]; ?>"/>
                   <?php } ?>
                   <h3>
                      <a href="{{url('visit-user-profile')}}/<?php echo $ValueUserData[id]; ?>"> <?php echo $ValueUserData[name]; ?></a>
                   </h3>
                </div>
             </div>
          </div>
          <div class="col-md-8">
             <ul class="leader_user_content">
                <li class="loss">
                   <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                </li>
                <?php
                 $GetFollowers = follow_users::where('to_user_id',$ValueUserData[id])->get()->toArray();
                 $CountFollowers = count($GetFollowers);
                 ?>
                <li>
                   <p><?php echo $CountFollowers; ?></p>
                   <span><?php if($CountFollowers == 0 || $CountFollowers == 1) { echo 'follower'; }else{ echo 'followers'; }?></span>
                </li>
                <li>
                   <p>0</p>
                   <span>{{__('label.Placed bets')}}</span>
                </li>
                <li>
                   <i class="fa fa-line-chart" aria-hidden="true"></i>
                   <span>{{__('label.Profit')}}</span>
                </li>
                <li class="user_arrow">
                   <a role="button" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $Keyleader; ?>" aria-expanded="true" aria-controls="collapseOne"></a>
                </li>
             </ul>
          </div>
       </div>
    </h4>
 </div>
 <div id="collapse<?php echo $Keyleader; ?>" class="panel-collapse collapse " role="tabpanel">
    <div class="panel-body">
       <div class="row">
          <div class="leaderboard_body_content">
             <div class="col-md-4">
                <ul class="leaderboard_contentLeft">
                   <li class="loss">L</li>
                   <li class="loss">L</li>
                   <li class="loss">L</li>
                   <li class="loss">L</li>
                   <li class="win">W</li>
                </ul>
             </div>
             <div class="col-md-8">
                <ul class="leaderboard_contentRight">
                   <li>
                      <p>
                         <i class="fa fa-heartbeat active" aria-hidden="true"></i>
                         <i class="fa fa-heartbeat" aria-hidden="true"></i>
                         <i class="fa fa-heartbeat" aria-hidden="true"></i>
                      </p>
                      <span>{{__('label.Risk level')}}</span>
                   </li>
                   <li>
                      <p>
                         <i class="fa fa-bolt" aria-hidden="true"></i>
                         <i class="fa fa-bolt" aria-hidden="true"></i>
                         <i class="fa fa-bolt" aria-hidden="true"></i>
                      </p>
                      <span>{{__('label.Average odd')}}</span>
                   </li>
                   <li>
                      <p>36%</p>
                      <span>{{__('label.Win rate')}}</span>
                   </li>
                   <li>
                      <button type="button" class="user_view_profile" onclick="location.href='{{url('view-user-profile')}}/<?php echo $ValueUserData[id]; ?>'"> {{__('label.View Profile')}} </button>
                   </li>
                </ul>
             </div>
          </div>
       </div>
    </div>
 </div>
</div>
<?php
            }
        }
    }
}
?>