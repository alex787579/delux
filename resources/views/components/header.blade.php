<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Delux Bearings</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Delux Bearings">
    <meta name="author" content="Delux Bearings is a premier manufacturer of clutch release bearings, actuators systems and precision bearings in India.">    
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- FontAwesome JS-->
    <script defer src="{{ asset('/assets/plugins/fontawesome/js/all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href={{ asset('/assets/css/portal.css') }}>

</head> 

<body class="app">   	
    <header class="app-header fixed-top">	   	            
        <div class="app-header-inner">  
	        <div class="container-fluid py-2">
		        <div class="app-header-content"> 
		            <div class="row justify-content-between align-items-center">
			        
				    <div class="col-auto">
					    <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
						    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>Menu</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
					    </a>
				    </div><!--//col-->
		            <div class="search-mobile-trigger d-sm-none col">
			            <i class="search-mobile-trigger-icon fa-solid fa-magnifying-glass"></i>
			        </div><!--//col-->
		            
		            <div class="app-utilities col-auto">
		            
						<div class="app-utility-item app-user-dropdown dropdown">
							<a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
								 <i class="fa-solid fa-user"></i>
							</a>
							<ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">

									<li><a class="dropdown-item">{{ session('EMP_NAME') }}</a></li>
									<li><a class="dropdown-item" href="/logout">Logout</a></li>

							</ul>
						</div><!--//app-user-dropdown-->
						
		            </div><!--//app-utilities-->
		        </div><!--//row-->
	            </div><!--//app-header-content-->
	        </div><!--//container-fluid-->
        </div><!--//app-header-inner-->
        <div id="app-sidepanel" class="app-sidepanel"> 
	        <div id="sidepanel-drop" class="sidepanel-drop"></div>
	        <div class="sidepanel-inner d-flex flex-column">
		        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
		        <div class="app-branding">
		            <a class="app-logo" href="index.html">
						<img class="rounded-circle" style="width: 150px;" src="/logo/1.png" alt="logo">	
		        </div><!--//app-branding-->  
		        
				<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
					<ul class="app-menu list-unstyled accordion" id="menu-accordion">
						<li class="nav-item">
							<?php if (session('role') == 'admin'): ?>
							<a class="nav-link active" href="/user-lists">
								<span class="nav-icon"><i class="fas fa-users"></i></span>
								<span class="nav-link-text">User List</span>
							</a>
							<?php endif; ?>
						</li>
						<?php if (session('role') == 'user'): ?>
						<li class="nav-item">
							<a class="nav-link" href="/create-order">
								<span class="nav-icon"><i class="fas fa-plus-square"></i></span>
								<span class="nav-link-text">Order Creation</span>
							</a>
						</li>
						<?php endif; ?>
						<li class="nav-item">
							<a class="nav-link" href="/order-trail">
								<span class="nav-icon"><i class="fas fa-tasks"></i></span>
								<span class="nav-link-text">My Orders</span>
							</a>
						</li>

						<?php if (session('role') == 'admin'): ?>
						<li class="nav-item">
							<a class="nav-link" href="/pending-order">
								<span class="nav-icon"><i class="fas fa-plus-square"></i></span>
								<span class="nav-link-text">Pending Approval</span>
							</a>
						</li>
						<?php endif; ?>
						<li class="nav-item">
							<a class="nav-link" href="/order-list">
								<span class="nav-icon"><i class="fas fa-list-alt"></i></span>
								<span class="nav-link-text">View Orders</span>
							</a>
						</li>
						<?php if (session('role') == 'admin' || session('role') == 'sales'): ?>
						<li class="nav-item">
							<a class="nav-link" href="/order-create-admin">
								<span class="nav-icon"><i class="fas fa-list-alt"></i></span>
								<span class="nav-link-text">Admin Order Creation</span>
							</a>
						</li>
						<?php endif; ?>
					</ul>
				</nav>
				
				
			  
			    <div class="app-sidepanel-footer">

			    </div><!--//app-sidepanel-footer-->
		       
	        </div><!--//sidepanel-inner-->
	    </div><!--//app-sidepanel-->
    </header><!--//app-header-->