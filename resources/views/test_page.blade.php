<form class="form-horizontal well" action="{{url('post-upload')}}" method="post" name="upload_excel" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <fieldset >
		<legend>Import CSV file</legend>
		<div class="control-group">
			<div class="control-label">
				<label>CSV File:</label>
			</div>
			
			<div class="controls">
				<input type="file" name="file" id="file" class="input-large">
			</div>
		</div>
		<div id="error" class="error_message"></div>
		<div class="control-group">
			<div class="controls">
			<button type="submit" id="submit" name="Import" class="btn btn-info button-loading" data-loading-text="Loading...">Upload</button>
			</div>
		</div>
	</fieldset>
</form>