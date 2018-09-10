@if(empty($BlockArray))
<div style="display:block" class="loadMoreData"></div>
@else
<div class="row" id="leftPartData">
   <div style="display:none" class="nextDataAjax"><?php echo $nextData; ?></div>
   @foreach($BlockArray as $blockLeftKey => $blockData)
      @if($blockLeftKey == 0 || $blockLeftKey == 2 || $blockLeftKey == 4)
       <div class="col-sm-12 feed_left win">
          <div class="feed_wrapper">
             <div class="feed_content_wrapper">
                <div class="feed_profile_details">
                   <div class="feed_img">
                      <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                   </div>
                   <div class="feed_user_name">
                      <a href="">
                         <h4>Morkan Doe <span>2hrs. ago</span></h4>
                         <p>Place a bet via ladbrokers</p>
                      </a>
                   </div>
                </div>
                <div class="feed_body">
                   <h4>Braga v Benfica</h4>
                   <p>Match Betting : <span>7th July | 20:30</span></p>
                </div>
                <div class="feed_chart">
                   <h3>Benfica <span>@2.80</span></h3>
                   <h3>Single <span><b>Win</b> @2.80</span></h3>
                </div>
             </div>
             <div class="feed_social_wrap">
                <ul class="feed_social">
                   <li>
                      <a href="#">
                      4
                      <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                      Like
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      1
                      <i class="fa fa-clone" aria-hidden="true"></i>
                      Copy
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      <i class="fa fa-facebook" aria-hidden="true"></i>
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      <i class="fa fa-twitter" aria-hidden="true"></i>
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      <i class="fa fa-share-alt" aria-hidden="true"></i>
                      </a>
                   </li>
                </ul>
             </div>
             <div class="comment_section">
                <input class="form-control" type="text" name="" placeholder="Add a Comment ...">
                <div class="comment_wrap">
                   <a href="#"><img src="{{asset('assets/front_end/images/avatar.jpg')}}"/></a>
                   <p>
                      <a href="#"> Sumit <span>05:04pm, 18.02.2017</span></a>
                      Hello world
                   </p>
                </div>
                <div class="comment_wrap">
                   <a href="#"><img src="{{asset('assets/front_end/images/avatar.jpg')}}"/></a>
                   <p>
                      <a href="#"> Sumit <span>05:04pm, 18.02.2017</span></a>
                      A social betting network where you can place
                   </p>
                </div>
             </div>
          </div>
       </div>
     @endif
    @endforeach
</div>
@endif
<!-- right part -->
<?php
    if(!empty($BlockArray))
    {
?>
<div class="row" id="rightPartData">
     <?php foreach($BlockArray as $blockRightKey => $blockData)
     {
          if($blockRightKey == 1 || $blockRightKey == 3 || $blockRightKey == 5)
          {
     ?>
       <div class="col-sm-12 feed_right loss">
          <div class="feed_wrapper">
             <div class="feed_content_wrapper">
                <div class="feed_profile_details">
                   <div class="feed_img">
                      <img src="{{asset('assets/front_end/images/avatar.jpg')}}"/>
                   </div>
                   <div class="feed_user_name">
                      <a href="">
                         <h4>Morkan Doe <span>2hrs. ago</span></h4>
                         <p>Place a bet via ladbrokers</p>
                      </a>
                   </div>
                </div>
                <div class="feed_body">
                   <h4>Braga v Benfica</h4>
                   <p>Match Betting : <span>7th July | 20:30</span></p>
                </div>
                <div class="feed_chart">
                   <h3>Benfica <span>@2.80</span></h3>
                   <h3>Single <span><b>Loss</b> @2.80</span></h3>
                </div>
             </div>
             <div class="feed_social_wrap">
                <ul class="feed_social">
                   <li>
                      <a href="#">
                      4
                      <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                      Like
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      1
                      <i class="fa fa-clone" aria-hidden="true"></i>
                      Copy
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      <i class="fa fa-facebook" aria-hidden="true"></i>
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      <i class="fa fa-twitter" aria-hidden="true"></i>
                      </a>
                   </li>
                   <li>
                      <a href="#">
                      <i class="fa fa-share-alt" aria-hidden="true"></i>
                      </a>
                   </li>
                </ul>
             </div>
             <div class="comment_section">
                <input class="form-control" type="text" name="" placeholder="Add a Comment ...">
             </div>
          </div>
       </div>
     <?php  }
     }
     ?>
</div>
<?php } else{ ?>
<div style="display:block" class="loadMoreData"></div>
<?php } ?>
