@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header')
   <!-- Page body content -->
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-sm-7" id="content">
            <div class="academy_block">
               <div class="ask_question">
                  <a href="javascript:void(0)" class="talk_close">X</a>
                  <form method="post" action="javascript:void(0);" id="ask_q_form">
                     <div class="">
                        <input type="text" name="question" placeholder="Ask a question and start discussion" class="question validate[required]" />
                     </div>
                     <div id="TrendingPostId" style="display: none;"><?php echo $PostId; ?></div>
                     <div class="">
                        <textarea rows="3" placeholder="Description (Optional)" class="description" name="description"></textarea>
                     </div>
                     <button type="submit" onclick="SubmitStory()" class="que_sub">Post</button>
                  </form>
                  <div class="clearfix"></div>
               </div>
               <div class="popular_task_row">
                  <h3  class="pull-left popular_task_title">Popular Posts</h3>
                  <div class="pull-right">
                     <div class="wrap-select">
                        <div id="dd" class="wrapper-dropdown-3">
                           <span>Latest Post</span>
                           <ul class="dropdown">
                              <li><a href="javascript:void(0);" onclick="SearchPostByChoice('Popular')">Popular Post</a></li>
                              <li><a href="javascript:void(0);" onclick="SearchPostByChoice('Latest')">Latest Post</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
               </div>
               <div class="clearfix"></div>
               <div class="PostListSearch">
                  <div class="gameListSearch">
                     <div class="input-group">
                        <input type="text" class="  search-query form-control" placeholder="Search Post by keyword..." onkeyup="SearchByKeyword(this.value)"/>
                        <span class="input-group-btn">
                        <button class="btn btn-success" type="button">
                        <span class=" glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                     </div>
                  </div>
                  <div class="clearfix"></div>
               </div>
               <div class="clearfix"></div>
               <div class="loader" style="display: none;" id="body_loader">
                  <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
               </div>
               <div id="PostedStory">
               </div>
            </div>
         </div>
         <!-- rightbar part Start -->
        @include('common/rightbar')
      </div>
   </div>
   <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/footer')
@include('common/footer_link')

<script>
   $(document).ready(function(){
        
        //-------------page load get post--------------------------//
        //PageloadData();
        var postId = $("#TrendingPostId").text();
        $.ajax({
            type: "GET",
            url: "{{url('visit-selected-user-post')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'postId':postId},
            success: function(result)
            {
                //console.log(result);
                $("#PostedStory").html(result);
            }
        });
        //-----------------------------------------------------------------//
        $(".question").click(function(){
            $("#ask_q_form").addClass("show");
            $("#ask_q_form").parent(".ask_question").children(".talk_close").addClass("show");
            $(".talk_close").click(function(){
                $(this).removeClass("show")
                $("#ask_q_form").removeClass("show");
            });
        })
   })
   //-------------page load get post--------------------------//
    /*function PageloadData()
    {
        $.ajax({
            type: "GET",
            url: "{{url('Get-Post-Story')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //data: {''},
            success: function(result)
            {
                //console.log(result);
                $("#PostedStory").html(result);
            }
        });
    }*/
   //-----------------------------------------------------------------//
   function genericSocialShare(url){
    var path="{{url('point-for-social-share')}}";
    $.ajax({
        type: "GET",
        url: path,
        success: function(result)
        {
          //console.log(result);
            
        }
     });
    window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
    return true;
    }
   function OpenReplyModal(PostId)
   {
        if($("#OpenModal-"+PostId).hasClass('active'))
        {
            $("#OpenBox-"+PostId).hide();
            $("#OpenModal-"+PostId).removeClass('active');
        }else{
            $("#OpenBox-"+PostId).show();
            $("#OpenModal-"+PostId).addClass('active');
        }
   }
   function DropDown(el) {
            this.dd = el;
            this.placeholder = this.dd.children('span');
            this.opts = this.dd.find('.dropdown a');
            this.val = '';
            this.index = -1;
            this.initEvents();
        }
        DropDown.prototype = {
            initEvents : function() {
                var obj = this;
                obj.dd.on('click', function(event){
                    $(this).toggleClass('active');
                    return false;
                });
                obj.opts.on('click',function(){
                    var opt = $(this);
                    obj.val = opt.text();
                    obj.index = opt.index();
                    obj.placeholder.text(obj.val);
                });
            },
            getValue : function() {
                return this.val;
            },
            getIndex : function() {
                return this.index;
            }
        }
        $(function() {
            var dd = new DropDown( $('#dd') );
        });
    function SubmitStory()
    {
        //alert('sumit');
        $.ajax({
            type: "POST",
            url: "{{url('Post-Story')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $("#ask_q_form").serialize(),
            success: function(result)
            {
                //console.log(result);
                //$("#PostedStory").html(result);
                location.reload();
            }
        });
    }
    function TrendingPost(PostId)
    {
        $.ajax({
            type: "POST",
            url: "{{url('Trending-Post')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'PostId':PostId},
            success: function(result)
            {
                //console.log(result);
                $("#PostData"+PostId).html(result);
            }
        });
    }
    function LikesPost(PostId,PostedUserId)
    {
        $.ajax({
            type: "POST",
            url: "{{url('Likes-Trending-Post')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'PostId':PostId,'PostedUserId':PostedUserId},
            success: function(result)
            {
                //console.log(result);
                TrendingPost(PostId);
            }
        });
    }
    
    function DislikePost(PostId,PostedUserId)
    {
        $.ajax({
            type: "POST",
            url: "{{url('DisLike-Trending-Post')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'PostId':PostId,'PostedUserId':PostedUserId},
            success: function(result)
            {
                //console.log(result);
                TrendingPost(PostId);
            }
        });
    }
    function SearchByKeyword(SearchData)
    {
        if(SearchData !='')
        {
            //$("#body_loader").show();
            $.ajax({
                type: "POST",
                url: "{{url('Search-by-keyword-trending')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'SearchData':SearchData},
                success: function(result)
                {
                    //console.log(result);
                   $("#PostedStory").html(result);
                   //$("#body_loader").hide();
                }
            });
        }else{
            PageloadData();
        }
    }
    function SearchPostByChoice(UserChoice)
    {
        $.ajax({
            type: "POST",
            url: "{{url('Search-by-user-choice')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'UserChoice':UserChoice},
            success: function(result)
            {
                //console.log(result);
                $("#PostedStory").html(result);
                //$("#body_loader").hide();
            }
        });
        
    }
    function TrendingPeopleLikeDetails(PostId)
    {
        if(PostId != '')
        {
            $("#modal_loader").show();
            $.ajax({
                type: "POST",
                url: "{{url('get-people-trending-like-details')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'PostId':PostId},
                success: function(result)
                {
                    //console.log(result);
                    $("#PeopleLikedDetails").html('');
                    $("#PeopleLikedDetails").html(result);
                    $("#modal_loader").hide();
                }
            });
        }
    }
</script>