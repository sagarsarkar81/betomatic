<div class="col-md-3 col-sm-3 col-xs-12">
    <div class="left-menu">
       <ul>
          <li class="{{ Request::path() == 'service' ? 'active' : '' }}"><a href="{{url('service')}}"><i class="fa fa-angle-right" aria-hidden="true"></i> {{__('label.Our service')}}</a></li>
          <li class="{{ Request::path() == 'about-us' ? 'active' : '' }}"><a href="{{url('about-us')}}"><i class="fa fa-angle-right" aria-hidden="true"></i> {{__('label.About us')}}</a></li>
          <li class="{{ Request::path() == 'contact' ? 'active' : '' }}"><a href="{{url('contact')}}"><i class="fa fa-angle-right" aria-hidden="true"></i> {{__('label.Contact')}}</a></li>
          <li class="{{ Request::path() == 'faq' ? 'active' : '' }}"><a href="{{url('faq')}}"><i class="fa fa-angle-right" aria-hidden="true"></i> {{__('label.FAQ')}}</a></li>
          @if(Session::has('user_id'))
          <li class="{{ Request::path() == 'change-password' ? 'active' : '' }}"><a href="{{url('change-password')}}"><i class="fa fa-angle-right" aria-hidden="true"></i> {{__('label.Change Password')}}</a></li>
          @endif
       </ul>
    </div>
 </div>