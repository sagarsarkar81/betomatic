<footer class="main-footer">
    
    <!-- To the right -->
    <div class="pull-{{ trans('crudbooster.right') }} hidden-xs">
        {{ trans('crudbooster.powered_by') }} {{CRUDBooster::getSetting('appname')}}
    </div>
    <!-- Default to the left -->
    <strong>{{ trans('crudbooster.copyright') }} &copy; <?php echo date('Y') ?>. {{ trans('crudbooster.all_rights_reserved') }} .</strong>
</footer>
<!-- sumit custom ajax for selected leagues -->
<script>
function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}
function SaveTopLeague()
{
    var TopLeagueArray = [];
    $.each($("input[name='checkbox[]']:checked"), function(){            
        //if(inArray($(this).val(),TopLeagueArray)) == false)
        //{
            TopLeagueArray.push($(this).val());
        //};
    });
    $.ajax({
        type: "POST",
        url: "{{url('save-top-league')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'TopLeagueId':TopLeagueArray},
        success: function(result)
        {
            //console.log(result);
            swal({title: "Save", confirmButtonColor: "green",text: "Top leagues has been saved", type: "success"},
               function(){
                   location.reload();
               }
            );
        }
    });
}
function SaveFeaturedMatchForToday()
{
    var EventIdArray = [];
    $.each($("input[name='checkbox[]']:checked"), function(){            
        EventIdArray.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "{{url('save-featured-match')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'EventId':EventIdArray},
        success: function(result)
        {
            //console.log(result);
            swal({title: "Save", confirmButtonColor: "green",text: "Featured match has been saved ", type: "success"},
               function(){
                   location.reload();
               }
            );
        }
    });
}
</script>
<!-- end -->