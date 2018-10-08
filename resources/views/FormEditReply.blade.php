<form class="col-md-8 col-md-offset-2" id="EditReplyForm" action="javascript:void(0);" autocomplete="off" enctype="multipart/form-data">
    <div class="form-group">
     <label>{{__('label.Edit your reply')}}</label>
     <input type="hidden" name="RepliedUserId" value="<?php echo $GetOldReply[0][from_user_id]; ?>"/>
     <input type="hidden" name="PostId" value="<?php echo $postid; ?>"/>
     <input type="hidden" name="CommentId" value="<?php echo $commentId; ?>"/>
     <input type="hidden" name="RepliedId" value="<?php echo $replyId; ?>"/>
     <textarea rows="3" class="form-control" name="NewReply" id="InputReply" onkeyup="CheckBlankReply(this.value)"><?php if(!empty($GetOldReply[0])) { echo $GetOldReply[0][replied_text]; } ?></textarea>
    </div>
    <button type="button" class="btn" id="SaveReply" onclick="SubmitEditReply('<?php echo $postid; ?>')">{{__('label.Edit')}}</button>
</form>
<div class="clearfix"></div> 