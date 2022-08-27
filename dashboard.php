
<ul class="nav nav-tabs  flex-column col-md-4">
  <li class="nav-item">
    <a class="nav-link active btn btn-outline-secondary text-left" title="Dashboard" href="#dashboard" data-toggle="tab">Dashboard</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-outline-secondary text-left" title="Profile" href="#profile" data-toggle="tab">Basic Information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-outline-secondary text-left" title="Chagnge Password" href="#change_password_tab" data-toggle="tab">Change Password</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-outline-secondary text-left" href="#address" title="Address" data-toggle="tab">Address</a>
  </li>
  <li class="nav-item">
    <a class="nav-link btn btn-outline-secondary text-left" href="<?php echo wp_logout_url( home_url('/signin/') ); ?>" title="Logout" >Logout</a>
  </li>
</ul>
<div class="tab-content col-md-8">
  <article class="tab-pane container active" id="dashboard">
   <div class="">
     <a href="<?php echo wp_logout_url( home_url('/signin/') ); ?>" title="Logout" class="pull-right mr-0 ml-auto">Signout?</a>
     <h3>Welcome <?php echo $current_user->nickname?>!</h3>
     
   </div>
  </article>
  <article class="tab-pane container" id="profile">
    <?php include PATH.'/inc/basic.php'?>
  </article>
<article class="tab-pane container" id="change_password_tab">
<?php include PATH.'/inc/password.php'?>
</article>
<article class="tab-pane container" id="address">
<?php include PATH.'/inc/address.php'?>
    </form>
</article>

</div>