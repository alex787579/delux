<x-header />
        <!-- Add in the <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Order List</h1>

              <a href="{{ url('/export/orders/xlsx') }}" class="btn btn-success">Export to Excel</a>
			  <a href="{{ url('/export/orders/csv') }}" class="btn btn-primary">Export to CSV</a>
  
			    
			    <div class="app-card shadow-sm mb-4 " role="alert">
					@if (session('success'))
					<div class="alert alert-success">{{ session('success') }}</div>
				@endif

				@if (session('error'))
					<div class="alert alert-danger">{{ session('error') }}</div>
				@endif

				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">
						    <div class="row gx-5 gy-3">
								<div class="row g-0 app-auth-wrapper">
									
									<div class="tab-content" id="orders-table-tab-content">
										<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
											<div class="app-card app-card-orders-table shadow-sm mb-5">
												<div class="app-card-body">
													<div class="table-responsive">
														
														<table id="userTable" class="table app-table-hover mb-0 text-left">
															<thead>
																<tr>
																	<th>Order ID</th>
																	<th>Distributor Channel</th>
																	<th>Sold To Party</th>
																	<th>Ship To Cust</th>
																	<th>Material Number</th>
																	<th>Quantity</th>
																	<td>Action</td>
																	<th>Standard Package</th>
																	<th>Material Price</th>
																	<th>Total Price</th>
																	<th>Segment</th>
																	<th>Packs</th>
																	<th>Package Status</th>
																	<th>Order Status</th>
																</tr>
															</thead>
															<tbody>
																@foreach ($order as $orderList)
																	<tr>
																		<td class="cell">{{ $orderList->order_id }}</td>
																		<td class="cell">{{ $orderList->dist_ch }}</td>
																		<td class="cell">{{ $orderList->sold_to_party_cust_code }}</td>
																		<td class="cell">{{ $orderList->ship_to_cust_code }}</td>
																		<td class="cell">{{ $orderList->material_no }}</td>
																		<td class="cell">{{ $orderList->qty }}</td>
																		<td class="cell">{{ $orderList->std_pkg }}</td>
																		<td class="cell">{{ number_format($orderList->value_mrp_less_50, 2) }}</td>
																		<td class="cell">{{ number_format($orderList->total_value_mrp_less_50, 2) }}</td>
																		<td class="cell">{{ $orderList->segment }}</td>
																		<td class="cell">{{ $orderList->no_of_packs }}</td>
																		<td class="cell">{{ $orderList->std_packing_ok_not_ok }}</td>
																		<td class="cell">{{ ucfirst($orderList->status) }}</td>
																		<td>
																			<div align="center">
																				<button type="button" class="btn btn-success btn-sm btn-rounded" 
																				onclick="window.location='{{ url('approvedOrder/'.Crypt::encryptString($orderList->order_id)) }}'">
																					<i class="fa fa-check"></i>
																				</button>
																		
																				</div>
																		</td>
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
        <x-footer />