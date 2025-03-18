<x-header />
        <!-- Add in the <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Order List</h1>

				<div class="mb-2">
					<a href="{{ url('/export/orders/xlsx') }}" class="btn btn-sm btn-success">
						<i class="fas fa-file-excel" style="color: white;"></i>
					</a>
					<a href="{{ url('/export/orders/csv') }}" class="btn btn-sm btn-primary">
						<i class="fas fa-file-csv" style="color: white;"></i>
					</a>
					
				</div>
			    
			    <div class="app-card shadow-sm mb-4 " role="alert">
					@if (session('success'))
					<div class="alert alert-success">{{ session('success') }}</div>
				@endif

				@if (session('error'))
					<div class="alert alert-danger">{{ session('error') }}</div>
				@endif

					
				@if (session('role') == 'admin')
				<div class="container mt-3 mb-3">
					<form action="{{ route('export-orders') }}" method="POST">
						@csrf
						<div class="row ">
							<div class="col-md-3">
								<label for="customer_code">Customer Code:</label>
								<input type="text" name="customer_code" class="form-control" >
							</div>
							<div class="col-md-3">
								<label for="from_date">From Date:</label>
								<input type="date" name="from_date" class="form-control" >
							</div>
							<div class="col-md-3">
								<label for="to_date">To Date:</label>
								<input type="date" name="to_date" class="form-control" >
							</div>
							<div class="col-md-3 mt-4">
								<button type="submit" class="btn btn-success">Export Excel</button>
							</div>
						</div>
					</form>
				</div>
				@endif

				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">
						    <div class="row gx-5 gy-3">
								<div class="row g-0 app-auth-wrapper">
									
									<div class="tab-content" id="orders-table-tab-content">
										<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
											<div class="app-card app-card-orders-table shadow-sm mb-5">
												<div class="app-card-body">
													<div class="table-responsive p-5">
														
														<table id="userTable" class="table app-table-hover mb-0 text-left">
															<thead>
																<tr>
																	<th>Distributor Channel</th>
																	<th>Bill to</th>
																	<th>Material Number</th>
																	<th>Quantity</th>
																	{{-- <td>Action</td> --}}
																	<th>Std Pkg</th>
																	<th>Material Price</th>
																	<th>Total Price</th>
		
																</tr>
															</thead>
															<tbody>
																@foreach ($order as $orderList)
																	<tr>
																		<td class="cell">{{ $orderList->dist_ch }}</td>
																		<td class="cell">{{ $orderList->customer_code }}</td>
																		<td class="cell">{{ $orderList->material_no }}</td>
																		<td class="cell">{{ $orderList->qty }}</td>
																		<td class="cell">{{ $orderList->std_pkg }}</td>
																		<td class="cell">{{ number_format($orderList->value_mrp_less_50, 2) }}</td>
																		<td class="cell">{{ number_format($orderList->total_value_mrp_less_50, 2) }}</td>
																	</tr>
																@endforeach
															</tbody>
														</table>
														
														
													</div><!--//table-responsive-->
												   
												</div><!--//app-card-body-->		
											</div><!--//app-card-->
					
											
										</div><!--//tab-pane-->
										
									</div><!--//tab-content-->
								</div><!--//row-->
						    </div><!--//row-->
						    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
					    </div><!--//app-card-body-->
					    
				    </div><!--//inner-->
			    </div><!--//app-card-->
				    

			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    


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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fromDate = document.querySelector('input[name="from_date"]');
        const toDate = document.querySelector('input[name="to_date"]');
        const form = document.querySelector('form');

        form.addEventListener("submit", function(event) {
            if (fromDate.value && !toDate.value) {
                alert("Please select To Date if From Date is selected.");
                event.preventDefault(); // Prevent form submission
            }
        });
    });
</script>

        <x-footer />