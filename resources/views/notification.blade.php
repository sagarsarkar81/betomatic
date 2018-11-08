@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <div class="shop_wrap">
      <!-- Page header top -->
      @include('common/register_header')
      <!-- Page body content -->
      <div class="container">
         <!--shop section start (18-9-17)-->
         <div class="col-md-8 col-sm-7" id="">
            <div class="notification-section">
               <div class="ns-hd">Notifications</div>
               <div class="ns-content-container">
               <?php
               if(!empty($CheckUnreadNotification))
               {
                    foreach($CheckUnreadNotification as $Key=>$value)
                    {
                        $EncryptedKey = SetEncodedId($value['id']);
               ?>
               <div class="ns-c-notifrow <?php if($value['detail_seen_status'] == 0){ echo "unread"; }?>">
                 <div class="ns-c-notifrow-date"><?php echo date("j M Y",strtotime($value['creation_date'])); ?></div>
                 <div class="ns-c-notifrow-event">
                        <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                            <?php if($value['incident_type'] == 'Likes') { ?>
                            <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                            <i class="fa fa-thumbs-up"></i>
                            <?php }elseif($value['incident_type'] == 'Comment'){ ?>
                            <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                            <i class="fa fa-commenting"></i>
                            <?php }elseif($value['incident_type'] == 'Post'){ ?>
                            <a href="{{url('trending')}}/<?php echo $EncryptedKey; ?>">
                            <i class="fa fa-thumbs-up"></i>
                            <?php }elseif($value['incident_type'] == 'Post Comment'){ ?>
                            <a href="{{url('trending')}}/<?php echo $EncryptedKey; ?>">
                            <i class="fa fa-commenting"></i>
                            <?php }elseif($value['incident_type'] == 'Comment Like'){ ?>
                            <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                            <i class="fa fa-thumbs-up"></i>
                            <?php }elseif($value['incident_type'] == 'Reply'){ ?>
                            <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                            <i class="fa fa-reply-all"></i>
                            <?php }else{ ?>
                            <a href="{{url('follow-following')}}/<?php echo $EncryptedKey; ?>">
                            <i class="fa fa-user-plus"></i>
                            <?php } ?>
                            <div class="ns-c-notifrow-event-msg"><span><?php echo $value['text']; ?></span></div>
                        </a>
                        <!--<?php if($value['incident_type'] == 'Likes') { ?>
                        <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                        <i class="fa fa-thumbs-up"></i>
                        </a>
                        <?php }elseif($value['incident_type'] == 'Comment'){ ?>
                        <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                        <i class="fa fa-commenting"></i>
                        </a>
                        <?php }elseif($value['incident_type'] == 'Post'){ ?>
                        <a href="{{url('trending')}}/<?php echo $EncryptedKey; ?>">
                        <i class="fa fa-thumbs-up"></i>
                        </a>
                        <?php }elseif($value['incident_type'] == 'Post Comment'){ ?>
                        <a href="{{url('trending')}}/<?php echo $EncryptedKey; ?>">
                        <i class="fa fa-commenting"></i>
                        </a>
                        <?php }elseif($value['incident_type'] == 'Comment Like'){ ?>
                        <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                        <i class="fa fa-thumbs-up"></i>
                        </a>
                        <?php }elseif($value['incident_type'] == 'Reply'){ ?>
                        <a href="{{url('visit-news-feed-page')}}/<?php echo $EncryptedKey; ?>">
                        <i class="fa fa-reply-all">
                        </a>
                        <?php }else{ ?>
                        <a href="{{url('follow-following')}}">
                        <i class="fa fa-user-plus"></i>
                        </a>
                        <?php } ?>
                        <div class="ns-c-notifrow-event-msg"><span><?php echo $value['text']; ?></span></div-->
                 </div>
               </div>
               <?php 
                    }
               }
               ?>
               </div>
            </div>
         </div>
         <!--shop section end-->
         @include('common/rightbar') 
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/footer')
@include('common/footer_link')
