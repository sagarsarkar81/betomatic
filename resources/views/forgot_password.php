<?php include "header_link.php"; ?>
<?php include "unregister_header.php"; ?>



<!-- Page body content -->
<div class="logincontant">
	<div class="container">
	    <div class="row">
	     <div class="login_wrap">
	       <div class="col-md-4 col-md-offset-4">
	           <div class="login_form">
	              <form>
	                  <h3>{{__('label.Forgot Your Password')}}</h3>
	                  <div class="form-group">
	                    <input class="form-control" type="text" placeholder="{{__('label.Username Or Email Id')}}" name=""/>
	                  </div>
	                  <a href="login.php">{{__('label.Click here to Login')}}</a>
	                  <p><button type="button">{{__('label.Submit')}} </button></p>
	              </form>
	           </div>
	       </div>
	     </div>
	    </div>
	</div>
</div>
<!-- Page body content -->




<?php include "footer.php"; ?>
<?php include "footer_link.php"; ?>