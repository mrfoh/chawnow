<!-- .header -->
<div class="header navbar navbar-inverse">
	<!-- .navbar -->
	<div class="navbar-inner">
		<div class="header-seperation">
			<ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">	
				<li class="dropdown">
					<a id="main-menu-toggle" href="#main-menu" class=""> <div class="iconset top-menu-toggle-white"></div> </a>
				</li>		 
			</ul>
			<!-- BEGIN LOGO -->	
			<a href="/"><img src="/assets/img/backend/logo.png" class="logo pull-left" width="106" height="92" /></a>
			<!-- END LOGO --> 
			<ul class="nav pull-right notifcation-center">	
			    <li class="dropdown" id="header_task_bar">
			        <a href="/" class="dropdown-toggle active" data-toggle=""><div class="iconset top-home"></div></a>
			    </li>
			</ul>
		</div>

		<div class="header-quick-nav">
			<div class="pull-left">
				<ul class="nav quick-section">
					<li class="quicklinks">
						<a href="#" class="" id="layout-condensed-toggle"><div class="iconset top-menu-toggle-dark"></div></a>
					</li>        
			  	</ul>
				<ul class="nav quick-section">
					<div class="input-prepend inside search-form no-boarder">
						<span class="add-on"> <a href="#" class=""><div class="iconset top-search"></div></a></span>
						<input name="" type="text" class="no-boarder " placeholder="Search" style="width:250px;" />
					</div>
				</ul>
			</div>

			<div class="pull-right">
				<div class="chat-toggler">
					<div class="user-details"> 
						<div class="username">
							<!--<span class="badge badge-important">3</span> -->
							{{ $firstname }} <span class="bold"> {{ $lastname }}</span>									
						</div>						
					</div>
					<div class="iconset top-down-arrow"></div> 
					<div class="profile-pic"> 
						<img alt="" src="/assets/img/backend/b.jpg" width="35" height="35" /> 
					</div>       			
				</div>
				<ul class="nav quick-section ">
					<li class="quicklinks"> 
						<a data-toggle="dropdown" class="dropdown-toggle  pull-right" href="#">						
							<div class="iconset top-settings-dark "></div> 	
						</a>
						<ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="dropdownMenu">
		                  <li><a href="/logout"><i class="icon-off"></i>&nbsp;&nbsp;Log Out</a></li>
		               </ul>
					</li> 
				</ul>
			</div>

		</div>
	</div>
	<!-- end .navbar -->
</div>
<!-- end .header -->