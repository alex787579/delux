<x-header />
        <!-- Add in the <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    

                <div class="mb-2 d-flex align-items-center gap-2">
                    <a href="{{ url('/export-order-trail/xlsx') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel" style="color: white;"></i>
                    </a>
                    <a href="{{ url('/export-order-trail/csv') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-file-csv" style="color: white;"></i>
                    </a>
                    <div>
                        <button type="button" class="btn btn-sm btn-success text-white" onclick="submitSelectedOrders()">Submit Order</button>
                    </div>
                </div>
  
			    
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
                                        <!-- Order Summary Box -->
                                        <div class="app-card shadow-sm mb-4 p-3 bg-light" id="orderSummary" style="display: none;">
                                            <h6 class="mb-3"><i class="fas fa-shopping-cart"></i> Order Summary</h6>
                                            <p><strong>Selected Orders:</strong> <span id="selectedOrdersCount">0</span></p>
                                            <p><strong>Total Quantity:</strong> <span id="totalQty">0</span></p>
                                            <p><strong>Total Price:</strong> ₹<span id="totalPrice">0.00</span></p>
                                        </div>

													<div class="table-responsive">
														
														<form id="bulkOrderForm">
                                                            @csrf
                                                            <table id="userTable" class="table app-table-hover mb-0 text-left">
                                                                <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox" id="selectAll"></th> <!-- Select All Checkbox -->
                                                                        <th>Material Number</th>
                                                                        <th>Quantity</th>
                                                                        <th>Standard Package</th>
                                                                        <th>Material Price</th>
                                                                        <th>Total Price</th>
                                                                        <th>Segment</th>
                                                                        <th>Order Status</th>
                                                                        <th>Actions</th> <!-- Edit & Delete -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($order as $orderList)
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox" data-qty="{{ $orderList->qty }}"
                                                                                data-price="{{ $orderList->total_value_mrp_less_50 }}" class="orderCheckbox" name="order_ids[]" value="{{ $orderList->id }}">
                                                                            </td>
                                                                            <td class="cell">{{ $orderList->material_no }}</td>
                                                                            <td class="cell">{{ $orderList->qty }}</td>
                                                                            <td class="cell">{{ $orderList->std_pkg }}</td>
                                                                            <td class="cell">{{ number_format($orderList->value_mrp_less_50, 2) }}</td>
                                                                            <td class="cell">{{ number_format($orderList->total_value_mrp_less_50, 2) }}</td>
                                                                            <td class="cell">{{ $orderList->segment }}</td>
                                                                            <td class="cell">{{ ucfirst($orderList->status) }}</td>
                                                                                <td>
                                                                                    @if (session('role') == 'user' && $orderList->status == 'P')
                                                                                    <!-- User can Edit & Delete when status is 'P' -->
                                                                                    <a href="{{ route('edit-trail-order', ['id' => Crypt::encryptString($orderList->id)]) }}" class="btn btn-primary btn-sm">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </a>
                                                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $orderList->id }})">
                                                                                        🗑️
                                                                                    </button>
                                                                        
                                                                                @elseif (session('role') == 'admin' && $orderList->status == 'I')
                                                                                    <!-- Admin can Edit & Delete when status is 'I' -->
                                                                                    <a href="{{ route('edit-trail-order', ['id' => Crypt::encryptString($orderList->id)]) }}" class="btn btn-primary btn-sm">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </a>
                                                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $orderList->id }})">
                                                                                        🗑️
                                                                                    </button>
                                                                        
                                                                                @elseif (session('role') == 'user' && $orderList->status == 'I')
                                                                                    <!-- User sees a message instead of Edit/Delete when status is 'I' -->
                                                                                    <span class="text-muted">Not Editable</span>
                                                                        
                                                                                @endif
                                                                                </td>   
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        

                                                        </form>
                                                        
														
														
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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

    $(document).ready(function() {
    // Select All Checkbox
    $("#selectAll").click(function() {
        $(".orderCheckbox").prop('checked', $(this).prop('checked'));
    });
});

// Function to Submit Selected Orders
function submitSelectedOrders() {
    var selectedOrders = [];

    $(".orderCheckbox:checked").each(function() {
        selectedOrders.push($(this).val());
    });

    if (selectedOrders.length === 0) {
        alert("❌ No Orders Selected\nPlease select at least one order!");
        return;
    }

    var confirmation = confirm("Are you sure you want to submit the selected orders?");
    if (!confirmation) {
        return;
    }

    $.ajax({
        url: "submit-trail-orders",
        type: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            order_ids: selectedOrders
        },
        success: function(response) {
            console.log(response)
            alert("✅ Orders Submitted\nYour selected orders have been submitted successfully!");
            location.reload();
        },
        error: function(xhr) {
            let errorMessage = "Something went wrong. Please try again!";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            alert("❌ Submission Failed\n" + errorMessage);
        }
    });
}



// Delete Record

// ✅ Confirm & Delete Order
function confirmDelete(orderId) {
    if (confirm("Are you sure you want to delete this order?")) {
        $.ajax({
            url: "{{ url('delete-order') }}/" + orderId,
            type: "DELETE",
            data: { _token: $("input[name=_token]").val() },
            success: function(response) {
                alert("✅ Order deleted successfully!");
                location.reload();
            },
            error: function(xhr) {
                alert("❌ Error deleting order!");
            }
        });
    }
}

// ✅ Open Edit Modal
function openEditModal(orderId, materialNo, qty) {
    $("#editOrderId").val(orderId);
    $("#editMaterialNo").val(materialNo);
    $("#editQuantity").val(qty);
    $("#editOrderModal").modal("show");
}



$(document).ready(function() {
    $('#materialSelect').select2({
        ajax: {
            url: '/get-materials',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { search: params.term }; // Pass search term to backend
            },
            processResults: function(data) {
                return {
                    results: data.map(item => ({
                        id: item.material_no,
                        text: item.material_no + ' - ' + item.part_number,
                        std_pkg: item.std_pkg, // Store std_pkg
                        part_number: item.part_number, // Store part_number
                        value_mrp_less_50: item.value_mrp_less_50, // Store value_mrp_less_50
                        segment: item.segment // Store segment
                    }))
                };
            }
        }
    });

    // When selecting a material, show related standard package
    $('#materialSelect').on('select2:select', function(e) {
        var data = e.params.data; // Fetch selected data
        $('#std_pkg').val(data.std_pkg);
        $('#value_mrp_less_50').val(data.value_mrp_less_50);
        $('#segment').val(data.segment);

        // ✅ Merge details and show in an input field
        var details = `Std Pkg: ${data.std_pkg}, Part No: ${data.part_number}, MRP: ${data.value_mrp_less_50}`;
        $('#materialDetails').val(details);
    });
});



document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll(".orderCheckbox");
    const selectAll = document.getElementById("selectAll");
    const orderSummary = document.getElementById("orderSummary");
    const selectedOrdersCount = document.getElementById("selectedOrdersCount");
    const totalQty = document.getElementById("totalQty");
    const totalPrice = document.getElementById("totalPrice");

    function updateSummary() {
        let selectedCount = 0;
        let totalQuantity = 0;
        let totalOrderPrice = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCount++;
                totalQuantity += parseInt(checkbox.getAttribute("data-qty"));
                totalOrderPrice += parseFloat(checkbox.getAttribute("data-price"));
            }
        });

        selectedOrdersCount.textContent = selectedCount;
        totalQty.textContent = totalQuantity;
        totalPrice.textContent = totalOrderPrice.toFixed(2);

        // Show summary only if at least one item is selected
        orderSummary.style.display = selectedCount > 0 ? "block" : "none";
    }

    // Event listeners for checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateSummary);
    });

    // Select All checkbox functionality
    selectAll.addEventListener("change", function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
        updateSummary();
    });
});

</script>
        <x-footer />