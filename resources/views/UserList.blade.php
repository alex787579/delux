<x-header />
    <!-- Add in the <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <div class="row g-3 mb-4 align-items-center justify-content-between">
				    <div class="col-auto">
			            <h1 class="app-page-title mb-0">User Lists</h1>
				    </div>
			    </div><!--//row-->
			   
			    				
				
				<div class="tab-content" id="orders-table-tab-content">
			        <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
					    <div class="app-card app-card-orders-table shadow-sm mb-5">
						    <div class="app-card-body">
							    <div class="table-responsive">
									<table id="userTable" class="table app-table-hover mb-0 text-left">
										<thead>
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th>Password</th>
												<th>Active Status</th>
												<th>Contact</th>
												<th>Address</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($userList as $user)
												<tr>
													<td class="cell">{{ $user->name }}</td>
													<td class="cell">{{ $user->email }}</td>
													<td class="cell">{{ $user->password }}</td> <!-- Hide password for security -->
													<td class="cell">
														<span class="badge {{ $user->is_active == 1 ? 'bg-success' : 'bg-danger' }}">
															{{ $user->is_active == 1 ? 'Active' : 'Inactive' }}
														</span>
													</td>
													<td class="cell">{{ $user->contact }}</td>
													<td class="cell">{{ $user->address }}</td>
													<td class="cell"><a class="btn-sm app-btn-secondary" href="#">View</a></td>
												</tr>
											@endforeach
										</tbody>
									</table>
									
						        </div><!--//table-responsive-->
						       
						    </div><!--//app-card-body-->		
						</div><!--//app-card-->

						
			        </div><!--//tab-pane-->
			        
				</div><!--//tab-content-->
				
				
			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    
	    

<!-- Add before the closing </body> tag -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            "paging": true,  // Enables pagination
            "searching": true, // Enables search
            "ordering": true, // Enables column sorting
            "info": true, // Show table info
            "lengthChange": false, // Disable page length selection
            "language": {
                "search": "Search Users:" // Custom search box text
            }
        });
    });
</script>


        <x-footer />