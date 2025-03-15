<x-header />
    
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Overview</h1>
			    
			    <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">
						    <h3 class="mb-3">Welcome, developer!</h3>
						    <div class="row gx-5 gy-3">
								<div class="row g-0 app-auth-wrapper">
									<div class="col-12 col-md-7 col-lg-12 auth-main-col text-center p-5">
										<div class="d-flex flex-column align-content-end">
											<div class="app-auth-body mx-auto">	
												<div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" src="assets/images/app-logo.svg" alt="logo"></a></div>
												<h2 class="auth-heading text-center mb-4">Sign up to Portal</h2>					
								
												<div class="auth-form-container text-start mx-auto">
													<form class="auth-form auth-signup-form">         
														<div class="email mb-3">
															<label class="sr-only" for="signup-email">Bill Code</label>
															<input id="bill-code" name="bill-code" type="text" class="form-control signup-name" placeholder="Bill Code" required="required">
														</div>
														<div class="email mb-3">
															<label class="sr-only" for="signup-email">Ship Code</label>
															<input id="ship-code" name="ship-code" type="email" class="form-control" placeholder="Ship Code" required="required">
														</div>
														<div class="password mb-3">
															<label class="sr-only" for="signup-password">Order Qty</label>
															<input id="order-qty" name="order-qty" type="number" class="form-control" placeholder="Order Qty" required="required">
														</div>
														<div class="password mb-3">
															<label class="sr-only" for="signup-password">STD PKG</label>
															<input id="std-pkg" name="std-pkg" type="text" class="form-control" placeholder="STD PKG" required="required">
														</div>
														<div class="extra mb-3">

														</div><!--//extra-->
														
														<div class="text-center">
															<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Submit</button>
														</div>
													</form><!--//auth-form-->
												
												</div><!--//auth-form-container-->	

												
												
											</div><!--//auth-body-->
											
										</div><!--//flex-column-->   
									</div><!--//auth-main-col-->
									
								</div><!--//row-->
						    </div><!--//row-->
						    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
					    </div><!--//app-card-body-->
					    
				    </div><!--//inner-->
			    </div><!--//app-card-->
				    

			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    


        <x-footer />