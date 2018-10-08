<?php
use App\Users;
use App\Countries;
use App\Country_codes;
use App\timezones;
use App\edit_profile_settings;
use App\cms_email_templates;
//print_r($FetchProfileData);die;
?>
@include('common/header_link')
<script type="text/javascript">
$(document).ready(function(){
	setTimeout(function() {
		$('.alert-danger').fadeOut('fast');
        $('.alert-success').fadeOut('fast');
	}, 4000);
});
</script>
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
   <!-- Page header top -->
   @include('common/register_header')
   <!-- Page body content -->
   @if (session('status'))
    <div class="alert alert-danger" style="text-align:center">
        {{ session('status') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success" style="text-align:center">
        {{ session('success') }}
    </div>
    @endif
   <div class="container">
      <div class="row">
         <div class="col-md-8 col-sm-7" id="content">
            <div class="profile_edit_wrap">
               <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#Edit_Profile" aria-controls="Edit_Profile" role="tab" data-toggle="tab">{{__('label.Edit Your Profile')}}</a></li>
                  <li role="presentation"><a href="#Settings" aria-controls="Settings" role="tab" data-toggle="tab">{{__('label.Edit Your Settings')}}</a></li>
                  <li role="presentation"><a href="#Accounts" aria-controls="Accounts" role="tab" data-toggle="tab">{{__('label.Connected Account')}}</a></li>
               </ul>
               <!-- Tab panes -->
               <div class="tab-content">
               
                  <div role="tabpanel" class="tab-pane active" id="Edit_Profile">
                     <div class="edit_profile_main">
                     <div class="loader" style="display: none;" id="body_loader">
                      <img src="{{asset('assets/front_end/images/loading.gif')}}"/>
                     </div>
                        <form class="edit_form" id="edit_form" action="javascript:void(0);" enctype="multipart/form-data" method="post" autocomplete="off">
                            <div class="row">
                              <div class="col-md-6">
                                 <h3>{{__('label.Personal details')}}</h3>
                                 <div class="form-group">
                                    <label>{{__('label.Name')}}</label>
                                    <input class="form-control validate[required,custom[onlyLetterSp]]" placeholder="{{__('label.Name')}}" name="Firstname" type="text" value="<?php if(isset($FetchUserData)){ echo $FetchUserData[0]->name; } ?>"/>
                                 </div>
                                 <div class="form-group">
                                    <label>{{__('label.Username')}}</label>
                                    <input class="form-control" placeholder="{{__('label.Username')}}" disabled="disabled" name="user_name" type="text" value="<?php if(isset($FetchUserData)){ echo $FetchUserData[0]->user_name; } ?>"/>
                                 </div>
                                 <div class="form-group email_info">
                                    <label>{{__('label.Email')}}</label>
                                    <input class="form-control validate[required,custom[email]]" placeholder="{{__('label.Email')}}" name="email" type="email" value="<?php if(isset($FetchUserData)){ echo $FetchUserData[0]->email; } ?>" onkeyup="CheckUserEmail(this.value)"/>
                                    <?php
                                     $userId = Session::get('user_id');
                                     $GetEmailVerfification = Users::where('id',$userId)->get()->toArray();
                                     if(!empty($GetEmailVerfification)) { if($GetEmailVerfification[0]['email_verification'] == 0){ ?>
                                     <div class="email_info_wrap">
                                       <div class="email_info_content" id="email_info" style="display: none;">
                                         <span class="email_info_icon">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                         </span>
                                         <div class="info_contant" style="display: none;">
                                            <p>{{__('label.Please check your inbox to verify your email')}}</p>
                                         </div>
                                       </div>
                                    </div>
                                    <?php } else{ ?>
                                    <div class="email_info_wrap">
                                       <div class="email_info_content" id="email_info" style="display: block;">
                                         <span class="email_info_icon">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                         </span>
                                         <div class="info_contant" style="display: none;">
                                            <p>{{__('label.Please check your inbox to verify your email')}}</p>
                                         </div>
                                       </div>
                                    </div>
                                    <?php } } ?>
                                    <div id='email_availability_result' style="display:none" class="email_availability_result"></div>
                                 </div>
                                 <div class="form-group">
                                    <label>{{__('label.Select age')}}</label>
                                    <select class="btn-group selectpicker AgeGroup validate[required]" name="age_group" data-live-search="true">
                                       <option value="">{{__('label.Age')}}</option>
                                       <?php if(isset($FetchUserData)) { ?>
                                       <option value="18-20" <?php  if($FetchUserData[0]->age_group == '18-20') { echo "selected"; } ?>>18-20</option>
                                       <option value="21-25" <?php if($FetchUserData[0]->age_group == '21-25') { echo "selected"; } ?>>21-25</option>
                                       <option value="26-30" <?php if($FetchUserData[0]->age_group == '26-30'){ echo "selected"; } ?>>26-30</option>
                                       <option value="30+" <?php if($FetchUserData[0]->age_group == '30+') { echo "selected"; } ?>>30+</option>
                                       <?php } ?>
                                    </select>
                                 </div>
                                  <div class="radioButton">
                                    <label> {{__('label.Gender')}} : </label>
                                    <bdo>
                                    <input value="Male" name="gender" class="validate[required]" type="radio" <?php if(isset($FetchUserData)) { if($FetchUserData[0]->gender == 'male') { echo 'checked="checked"' ; }} ?>/>
                                    <span></span>
                                    <abbr> {{__('label.Male')}} </abbr>
                                    </bdo>
                                    <bdo>
                                    <input value="Female" name="gender" class="validate[required]" type="radio" <?php if(isset($FetchUserData)) { if($FetchUserData[0]->gender == 'female') { echo 'checked="checked"' ; }} ?>/>
                                    <span></span>
                                    <abbr> {{__('label.Female')}} </abbr>
                                    </bdo>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group EditImageUpload">
                                    <?php if(empty($FetchUserData[0]->profile_picture)) { ?>
                                    <img id="profile_photo" src="{{asset('assets/front_end/images/avatar.jpg')}}" class="img-responsive"/>
                                    <?php } else{ ?>
                                    <img id="profile_photo" src="{{asset('assets/front_end/images/')}}<?php echo '/'.$FetchUserData[0]->profile_picture; ?>" class="img-responsive"/>
                                    <?php } ?>
                                    <input type="file" name="image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple=""/>
                                    <label for="file-1">
                                       <svg xmlns="#" width="20" height="17" viewBox="0 0 20 17">
                                          <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                       </svg>
                                    </label>
                                 </div>
                                  <div class="form-group">
                                    <label>{{__('label.Select country')}}</label>
                                    <select class="AgeGroup selectpicker validate[required]" name="country" data-live-search="true" onchange="SelectCountry(this.value)">
                                       <option>{{__('label.Country')}}</option>
                                       <?php if(isset($get_country)) 
                                        { 
                                             foreach ($get_country as $country)
                                             {
                                             ?>
                                                <option value="<?php echo $country->id;?>" <?php if($FetchUserData[0]->country_id == $country->id) { echo "selected"; } ?>><?php echo $country->name;?></option>
                                             <?php
                                             }
                                        } 
                                       ?>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label>{{__('label.Select city')}}</label>
                                    <input class="form-control" placeholder="{{__('label.City')}}" name="city" type="text" value="<?php if(isset($FetchUserData)) { echo $FetchUserData[0]->city; } ?>"/>
                                 </div>
                                 <div class="row">
                                    <div class="form-group">
                                       <label class="col-md-12">{{__('label.Phone No')}}</label>
                                       <div class="clearfix"></div>
                                       <div class="col-md-4 col-sm-4">
                                          <select class=" AgeGroup selectpicker validate[required]" id="countryCode" name="country_code">
                                             <option>{{__('label.Code')}}</option>
                                             <?php if(isset($FetchUserData)) { ?> 
                                             <option value="<?php echo $FetchUserData[0]->country_code; ?>" <?php echo "selected"; ?>><?php echo '+'.$FetchUserData[0]->country_code; ?></option>
                                             <?php } ?>
                                          </select>
                                       </div>
                                       <div class="col-md-8 col-sm-8 paddingLeftLess">
                                          <div class="form-group">
                                             <input class="form-control validate[required] number-only" type="text" placeholder="{{__('label.Mobile Number')}}" name="contact_no" max="10" value="<?php if(isset($FetchUserData)) { echo $FetchUserData[0]->contact_no; } ?>"/>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="">
                                    <div class="radioButton">
                                       <label> {{__('label.Select your currency')}} : </label>
                                       <bdo>
                                       <input value="GBP" name="currency" class="validate[required]" type="radio" <?php if(isset($FetchUserData)) { if($FetchUserData[0]->currency == 'GBP') { echo 'checked="checked"' ; }} ?>/>
                                       <span></span>
                                       <abbr> GBP </abbr>
                                       </bdo>
                                       <bdo>
                                       <input value="SEK" name="currency" class="validate[required]" type="radio" <?php if(isset($FetchUserData)) { if($FetchUserData[0]->currency == 'SEK') { echo 'checked="checked"' ; }} ?>/>
                                       <span></span>
                                       <abbr> SEK </abbr>
                                       </bdo>
                                    </div>
                                 </div>
                                 <button type="button " id="edit_button" class="bth btn-default submit">{{__('label.SAVE CHANGES')}}</button> 
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div role="tabpanel" class="tab-pane " id="Settings">
                     <div class="settings_wrap">
                        <div class="row">
                           <form class="settings_form" action="{{url('edit-settings-form')}}" method="post">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                              <div class="col-md-6">
                                 <h3>{{__('label.General Settings')}}</h3>
                                 <div class="form-group">
                                    <label>{{__('label.Time Zone')}}</label>
                                    <select class="btn-group selectpicker AgeGroup" id="TimeZone" name="timezone" data-live-search="true">
                                       <option>{{__('label.Select Timezone')}}</option>
                                       <?php if(isset($GetTimezone)) 
                                        { 
                                             foreach ($GetTimezone as $zone)
                                             {
                                             ?>
                                                <option value="<?php echo $zone->TZ;?>" <?php if($FetchEditDataSettings[0]->timezone == $zone->TZ) { echo "selected"; } ?>><?php echo $zone->TZ;?></option>
                                             <?php
                                             }
                                        } 
                                       ?>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label>{{__('label.Odd Format')}}</label>
                                    <select class="btn-group selectpicker AgeGroup" id="OddsFormat" name="oddsFormat" data-live-search="true">
                                       <?php if(isset($FetchEditDataSettings)) { ?>
                                       <option value="decimal" <?php  if($FetchEditDataSettings[0]->oddsFormat == 'decimal') { echo "selected"; } ?>>{{__('label.Decimal')}} (1.16) </option>
                                       <option value="fractional" <?php if($FetchEditDataSettings[0]->oddsFormat == 'fractional') { echo "selected"; } ?>>{{__('label.Fractional')}} (4/5)</option>
                                       <?php } ?>
                                    </select>
                                 </div>
                                 <button type="submit" class="bth btn-default submit">{{__('label.SAVE CHANGES')}}</button> 
                              </div>
                              <div class="col-md-6">
                                 <h3>{{__('label.Notifications')}}</h3>
                                 <p>{{__('label.Receive email notifications for')}}:</p>
                                 <ul class="list-group">
                                    <li class="list-group-item">
                                       {{__('label.Comment')}}
                                       <div class="material-switch pull-right">
                                          <input id="Comment" name="Comment" type="checkbox" value="1" <?php if(isset($FetchEditDataSettings)) { if($FetchEditDataSettings[0]->comment == 1) { echo 'checked'; }} ?>/>
                                          <label for="Comment" class="label-success"></label>
                                       </div>
                                    </li>
                                    <li class="list-group-item">
                                       {{__('label.Mention')}}
                                       <div class="material-switch pull-right">
                                          <input id="Mention" name="Mention" type="checkbox" value="1" <?php if(isset($FetchEditDataSettings)) { if($FetchEditDataSettings[0]->mention == 1) { echo 'checked'; }} ?>/>
                                          <label for="Mention" class="label-success"></label>
                                       </div>
                                    </li>
                                    <li class="list-group-item">
                                       {{__('label.Follow')}}
                                       <div class="material-switch pull-right">
                                          <input id="Follow" name="Follow" type="checkbox" value="1" <?php if(isset($FetchEditDataSettings)) { if($FetchEditDataSettings[0]->follow == 1) { echo 'checked'; }} ?>/>
                                          <label for="Follow" class="label-success"></label>
                                       </div>
                                    </li>
                                    <li class="list-group-item">
                                       {{__('label.Badges')}}
                                       <div class="material-switch pull-right">
                                          <input id="Badges" name="Badges" type="checkbox" value="1" <?php if(isset($FetchEditDataSettings)) { if($FetchEditDataSettings[0]->badges == 1) { echo 'checked'; }} ?>/>
                                          <label for="Badges" class="label-success"></label>
                                       </div>
                                    </li>
                                 </ul>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="Accounts">
                     <div class="connected_wrap">
                        <h3>{{__('label.Betting Accounts')}}</h3>
                        <div class="lr_section">
                           <img src="{{asset('assets/front_end/images/lr.png')}}"/>
                           <a href="#">{{__('label.Connect')}}</a>
                        </div>
                        <h3>{{__('label.Social Accounts')}}</h3>
                        <div class="fb_section ">
                           <img src="{{asset('assets/front_end/images/fb.png')}}"/>
                           <a class="active" href="#">{{__('label.Connected')}}</a>
                        </div>
                        <div class="tw_section">
                           <img src="{{asset('assets/front_end/images/tw.png')}}"/>
                           <a href="#">{{__('label.Connect')}}</a>
                        </div>
                     </div>
                  </div>
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
function SelectCountry(country_id)
{
    $.ajax({
        type: "POST",
        contentType: 'multipart/form-data',
        url: "{{url('getCountryCode')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {'countryId':country_id},
        success: function(result)
        {
            //console.log(result);
            $("#countryCode").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
    });
}
$('.number-only').on('input', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
/*function UpdateProfileFormSubmit()
{
    //var data  = $("#edit_form").serialize();
    //console.log(data);
    var valid = $("#edit_form").validationEngine('validate');
    if (valid == true) {
    $("#edit_button").prop('disabled', 'true');
        $.ajax({
            type: "POST",
            url: "{{url('update-profile')}}",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $("#edit_form").serialize(),
            success: function(result)
            {
                alert(result);
                if(result == 'success')
                {
                    window.location.href = "{{url('profile')}}";
                }
                else if(result == 'unsupported')
                {
                    location.reload();
                }
                else{
                    location.reload();
                }
            }
        });
    }else {
        $('#edit_button').removeAttr('disabled');
        $("#edit_form").validationEngine();
    }
}*/
function CheckUserEmail(emailid)
{
    if(emailid !='')
    {
        var GetIndex = emailid.indexOf("@");
        if(GetIndex > 0)
        {
            $.ajax({
                type: "POST",
                url: "{{url('checkUserEmailId')}}",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'emailid':emailid},
                success: function(result)
                {
                    //console.log(result);
                    if(result == "has"){
        				$('#email_availability_result').html(emailid + ' is not Available').show();
        				$("#edit_button").prop('disabled', 'true');
        			}else{    
        				$('#email_availability_result').html('').hide();
                        $('#edit_button').removeAttr('disabled');
                    }
                }
            });
        }
    }
    else{
        $('#email_availability_result').html('').hide();
    }
}
$("form#edit_form").submit(function(){
    var valid = $("#edit_form").validationEngine('validate');
    if (valid == true) 
    {
        $("#edit_button").prop('disabled', 'true');
        $("#body_loader").show();
        $.ajax({
          url:"{{url('update-profile')}}",
          type:'POST',
          headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
          data:new FormData($("#edit_form")[0]),
          processData: false,
          contentType: false,
          success:function(result)
          {
                //console.log(result);
                if(result == 'success')
                {
                    $("#body_loader").hide();
                    location.reload();
                }
                else{
                    $("#body_loader").hide();
                    location.reload();
                }
          },
        });
    }else {
        $('#edit_button').removeAttr('disabled');
        $("#edit_form").validationEngine();
    }
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#profile_photo').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#file-1").change(function () {
    var imgpath = document.getElementById('file-1').value;

    if(!/(\.png|\.jpeg|\.jpg|\.jpe|\.gif|\.tif)$/i.test(imgpath))
    {
        alert('Invalid file format');
        $('#edit_button').prop('disabled', true);
        return false;
    } else {
        $('#edit_button').prop('disabled', false);
        readURL(this);
    }
});
</script>