<?php if(isset($_SESSION['topmsg'])&& $_SESSION['topmsg']!='') {echo $_SESSION['topmsg']; $_SESSION['topmsg']='';} ?>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.html">NST Blog</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> Account <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#changePass" data-toggle="modal">Change Password</a></li>
              <li><a href="edit-profile">Update Information</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> <?php echo $_SESSION['LoggedUserName']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="edit-profile">Profile</a></li>
              <li><a href="logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li><a href="dashboard"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-comment"></i><span>Posts</span><b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="new-post">New Post</a></li>
            <li><a href="comments">Comments</a></li>
            <li><a href="posts">Posts</a></li>
          </ul>
        </li>
        <li><a href="menu"><i class="icon-list"></i><span>Menus</span> </a>
        </li>
        <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-indent-left"></i><span>Categories</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
               <li><a href="new-category">New Category</a></li>
               <li><a href="categories">All Categories</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-camera"></i><span>Media</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
               <li><a href="new-media">Add New Media</a></li>
               <li><a href="media">All Media</a></li>
            </ul>
        </li>
        <?php if(isset($_SESSION['USERTYPE'])&& $_SESSION['USERTYPE']=='Admin') { echo '<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-wrench"></i><span>Settings</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="users">Users</a></li>
            <li><a href="new-user">Add User</a></li>
            <li><a href="advert-manager">Manage Adverts</a></li>
          </ul>
        </li>'; }
        ?>
         <li><a href="logout"><i class="icon-signout"></i><span>Logout</span> </a> </li>
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<!-- Modal -->
<div id="changePass" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="changePassLabel" aria-hidden="true">
    <form name="changepassform" id="changepassform" action="change-password" method="post">
    <div class="modal-header">
        <button type="button" class="close btn-default" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="changePassLabel"><i class="icon-key"></i> Change Password</h3>
    </div>

    <div class="modal-body">
      <div class="control-group">											
          <label class="control-label" for="password1">Old Password</label>
          <div class="controls">
              <input type="password" class="span4" id="password1" name="password1" value="" placeholder="Old password">
          </div> <!-- /controls -->				
      </div> <!-- /control-group -->
      <div class="control-group">											
          <label class="control-label" for="password">New Password</label>
          <div class="controls">
              <input type="password" class="span4" id="password" name="password" value="" placeholder="New Password">
          </div> <!-- /controls -->				
      </div> <!-- /control-group -->
      <div class="control-group">											
            <label class="control-label" for="passwordagain">Confirm</label>
            <div class="controls">
                <input type="password" class="span4" name="passwordagain" id="passwordagain" value="" placeholder="Confirm New Password">
            </div> <!-- /controls -->				
      </div> <!-- /control-group -->
    </div>

    <div class="modal-footer">
        <button class="btn btn-danger" type="reset">Reset</button>
        <button class="btn btn-primary" type="submit" name="savechangepass" id="savechangepass" onclick="validatePassword()">Save changes</button>
    </div>
    </form>
</div>