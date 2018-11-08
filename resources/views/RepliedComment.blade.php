<?php
use App\trending_replies;

if(!empty($GetRepliedComments))
{
    foreach($GetRepliedComments as $key=>$value)
    {
        $GetUserCredentials = trending_replies::select('name','profile_picture')->leftJoin('users', 'users.id', '=', 'trending_replies.replied_user_id')->where('replied_user_id',$value['replied_user_id'])->get()->toArray();
?>
    <img src="{{asset('assets/front_end/images/')}}<?php echo '/'.$GetUserCredentials[0]['profile_picture']; ?>"/>
    <p><?php echo $value['replied_text']; ?><span><?php echo date("d-m-Y H:i:s",strtotime($value['replied_date'])); ?></span></p>
<?php   
    }
}
?>