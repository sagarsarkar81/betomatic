<?php
use App\follow_users;
if(!empty($SearchQuery))
{
    foreach($SearchQuery as $SearchKey=>$SearchValue)
    {
        $user_id = Session::get('user_id');
        if($SearchValue['id'] != $user_id) 
        {
            $GetFollowersNumber = follow_users::where('to_user_id',$SearchValue['id'])->get()->toArray();
            $CountFollowers = count($GetFollowersNumber);
?>
    <div class="Search_list" id="SearchData">
    <?php if($SearchValue['profile_picture'] == '') { ?>
    <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
    <?php } else { ?>
    <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$SearchValue['profile_picture'] ?>"/>
    <?php } ?>
     <a href="{{url('view-user-profile')}}/<?php echo $SearchValue['id']; ?>"> 
       <?php echo $SearchValue['user_name']; ?> 
       <span><?php if($CountFollowers == 0 || $CountFollowers == 1) { echo $CountFollowers.' Follower'; }else{ echo $CountFollowers.' Followers'; }?></span>
     </a>
     </div>
<?php } } ?>
     <div class="serach_view_all">
       <a href="{{url('search-view-all')}}/<?php echo $username; ?>">View all <span>"<?php echo $username; ?>"</span></a>
     </div>
<?php } else{ ?>
    <p>{{__('label.No data found')}} <span>"<?php echo $username; ?>"</span></p>
<?php  
}
?>
