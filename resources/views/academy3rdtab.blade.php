@include('common/header_link')
<!-- Sidebar -->
@include('common/leftbar')
<!-- Page Content -->
<div class="bog_content">
    <div class="shop_wrap">
        <!-- Page header top -->
        @include('common/register_header')
        <!-- Page body content -->
        <div class="container">
            <!-- academy content start -->
            <div class="academy-page-main">
                <div class="apm-top">
                    <div class="apm-hd">Academy</div>
                    <p>Here you will find guides for how to best play on different things.</p>
                </div> 
                <div class="apm-tabarea">
                    <ul>
                        <li><a href="{{url('academy')}}">Game School</a></li>
                        <li><a href="{{url('travelodge-school')}}">Travelodge School</a></li>
                        <li class="active"><a href="{{url('bonus-trading')}}">Bonus Trading</a></li>
                    </ul>
                    <?php if(!empty($GetAcademyContent)) { ?>
                    <div class="apm-tab-content">
                        <div class="apm-tc-hd"><?php echo $GetAcademyContent[0][module_name]; ?></div>
                        <div class="apm-tc-subhd"><?php echo $GetAcademyContent[0][lesson]; ?></div>
                        <div class="pull-right imgdv"><img src="{{asset('')}}<?php echo $GetAcademyContent[0][image1]; ?>" alt="Bet Image"/></div>
                        <p><?php echo $GetAcademyContent[0][articles]; ?></p>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!-- academy content end -->
        </div>
    </div>
    <!-- Page body content -->
</div>
<!-- page-content-wrapper -->
@include('common/footer')
@include('common/footer_link')

