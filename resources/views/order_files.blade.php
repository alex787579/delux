<x-header />
        <!-- Add in the <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Order Page</h1>
				<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
	Launch demo modal
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		<div class="col-12 col-md-7 col-lg-12 auth-main-col text-center p-5">
										<div class="d-flex flex-column align-content-end">
											
                                            <h2>Upload Excel/CSV File</h2>

											@if(session('success'))
												<div class="alert alert-success">{{ session('success') }}</div>
											@endif

											@if(session('error'))
												<div class="alert alert-danger">{{ session('error') }}</div>
											@endif

											@if(session('import_errors'))
												<div class="alert alert-warning">
													<strong>Import Errors:</strong>
													{{-- <ul> --}}
														@foreach(session('import_errors') as $error)
															<p>{{ $error }}</p>
														@endforeach
													{{-- </ul> --}}
												</div>
											@endif


                                            {{-- @if(session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif
                                            @if(session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif --}}
                                        
											<form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <input type="file" name="file" class="form-control">
                                                    @error('file')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </form>
										</div><!--//flex-column-->   
									</div><!--//auth-main-col-->
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		  <button type="button" class="btn btn-primary">Save changes</button>
		</div>
	  </div>
	</div>
  </div>

  <?php

// echo "<pre>";
// print_r($order );
// exit;
  ?>
			


			    <div class="app-card shadow-sm mb-4 " role="alert">
				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">
						    <div class="row gx-5 gy-3">
								<div class="row g-0 app-auth-wrapper">
									
									<div class="tab-content" id="orders-table-tab-content">
										<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
											<div class="app-card app-card-orders-table shadow-sm mb-5">
												<div class="app-card-body">
                                                    @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
													<div class="table-responsive">
														
                                                        <table id="userTable" class="table app-table-hover mb-0 text-left">
                                                            <thead>
                                                                <tr>
                                                                    <th>Order ID</th>
                                                                    <th>File Name</th>
                                                                    <th>Created At</th>
                                                                    <th>Download</th> <!-- Added Download Column -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($data as $file)
                                                                    <tr>
                                                                        <td class="cell">{{ $file->order_id }}</td>
                                                                        <td class="cell">{{ $file->filename }}</td>
                                                                        <td class="cell">{{ $file->created_at }}</td>
                                                                        <td class="cell">
                                                                            <a href="{{ route('file.download', ['filename' => $file->order_id]) }}" class="btn btn-primary btn-sm">
                                                                                Download
                                                                            </a>
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