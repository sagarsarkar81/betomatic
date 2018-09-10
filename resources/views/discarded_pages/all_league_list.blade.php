<!--h2>{{__('label.Select League')}}</h2>
<form action="{{url('soccer-odds-listing-page')}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="League_submit top_League_submit">
  <button class="submit" type="submit">{{__('label.View selected league')}}</button>
</div>
<div class="clearfix"></div-->
<div style="display:none" class="nextDataAjax"><?php echo $nextData; ?></div>
<?php
if(!empty($GetLeagueDetails))
{
    foreach($GetLeagueDetails as $League)
    {
?>
<div class="col-md-4">
   <div class="checkbox">
      <label>
      <input type="checkbox" value="<?php echo $League[league_id]; ?>" name="league[]" class="mycheckbox"/>
      <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
      <?php echo $League[league_name]; ?>
      </label>
   </div>
</div>
<?php
    }
}else{
?>
<div style="display:block" class="loadMoreData"></div>
<?php
}
?>
<!--div class="clearfix"></div>
<div class="League_submit">
   <button class="submit" type="submit">{{__('label.View selected league')}}</button>
</div>
<div class="clearfix"></div>
</form-->