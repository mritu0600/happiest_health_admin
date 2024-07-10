<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
  <div class="m-header">
    <a class="mobile-menu" id="mobile-collapse" href="javascript:void(0);"><span></span></a>
    <a href="{FULL_SITE_URL}" class="b-brand">
      <img src="{ASSET_INCLUDE_URL}image/logo.png" alt="" class="logo" style="width:90%;margin-top:90px;margin-bottom:10px;">
      <img src="{ASSET_INCLUDE_URL}image/logo.png" alt="" class="logo-thumb">
    </a>
    <a href="javascript:void(0);" class="mob-toggler">
      <i class="feather icon-more-vertical"></i>
    </a>
  </div>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav ml-auto">
      <li class="navigation-name">Welcome <?=sessionData('ILCADM_ADMIN_FIRST_NAME')?></li>
      <li>
        <div class="dropdown drp-user">
          <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
            <i class="feather icon-user"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right profile-notification">
            <div class="pro-head">
              <img src="<?php echo showCorrectImage(sessionData('ILCADM_ADMIN_IMAGE'),'thumb','profile'); ?>" class="img-radius" alt="User-Profile-Image">
              <span><?php echo stripslashes(sessionData('ILCADM_ADMIN_FIRST_NAME')); ?></span>
            </div>
            <ul class="pro-body">
             
              <li><a href="{FULL_SITE_URL}profile" class="dropdown-item"><i class="feather icon-user"></i> My Profile</a></li>
              <li><a href="{FULL_SITE_URL}logout" class="dropdown-item"><i class="feather icon-log-out"></i> Logout</a></li>
            </ul>
          </div>
        </div>
      </li>
      <li><a href="{FULL_SITE_URL}logout"><i class="feather icon-log-out"></i></a></li>
    </ul>
  </div>
</header>