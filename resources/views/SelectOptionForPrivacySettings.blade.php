<select class="selectpicker validate[required] ReportSelect" id="PrivacySettings" name="privacy">
   <option value="1" <?php if($GetSelectedPrivacy[0]['privacy_status'] == '1') { echo "selected"; } ?>>{{__('label.Public')}}</option>
   <option value="2" <?php  if($GetSelectedPrivacy[0]['privacy_status'] == '2') { echo "selected"; } ?>>{{__('label.Private')}}</option>
</select>