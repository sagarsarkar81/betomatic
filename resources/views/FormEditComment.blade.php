<form class="col-md-8 col-md-offset-2" id="EditCommentForm" action="javascript:void(0);" autocomplete="off" enctype="multipart/form-data">
    <div class="form-group">
     <label>{{__('label.Edit your comment')}}</label>
     <input type="hidden" name="CommentedUserId" value="<?php echo $GetOldComment[0]['user_id']; ?>"/>
     <input type="hidden" name="PostId" value="<?php echo $postid; ?>"/>
     <input type="hidden" name="CommentId" value="<?php echo $GetOldComment[0]['id']; ?>"/>
     <textarea rows="3" class="form-control" name="NewComment" id="InputComment" onkeyup="CheckBlankValue(this.value)"><?php if(!empty($GetOldComment[0])) { echo $GetOldComment[0]['comments']; } ?></textarea>
    </div>
    <button type="button" onclick="SubmitEditComment('<?php echo $postid; ?>')" class="btn" id="SaveComment">{{__('label.Edit')}}</button>
</form>
<div class="clearfix"></div> 