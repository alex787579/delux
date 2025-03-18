<x-header />
        <!-- Add in the <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">  
                <h1 class="app-page-title">
                    Create Order 
                    <span class="cart-container" style="float: right; cursor: pointer;" onclick="redirectToOrderTrail()">
                        🛒 <span id="cart-count" class="badge bg-danger">0</span>
                    </span>
                </h1>
            
                <div class="app-card shadow-sm mb-4">
                    @if (session('success'))
                        <div class="alert alert-success py-1 px-2 small">{{ session('success') }}</div>
                    @endif
            
                    @if (session('error'))
                        <div class="alert alert-danger py-1 px-2 small">{{ session('error') }}</div>
                    @endif
            
                    <form id="addOrderForm">
                        @csrf
                        <div class="row p-5">
                            <input type="hidden" id="dist_ch" name="dist_ch">
                            <input type="hidden" id="no_of_packs" name="no_of_packs">
                            <input type="hidden" id="segment" name="segment">
            
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Material No</label>
                                    <select id="materialSelect" name="material_no" class="form-control">
                                        <option value="">Search and Select Material</option>
                                    </select>
                                    <span class="text-danger error-message" id="error-material_no"></span>
                                </div>
            
                                <div class="col-md-4">
                                    <label class="form-label">Standard Package</label>
                                    <input type="number" readonly class="form-control" id="std_pkg" name="std_pkg">
                                    <span class="text-danger error-message" id="error-std_pkg"></span>
                                </div>
            
                                <div class="col-md-4">
                                    <label class="form-label">MRP</label>
                                    <input type="text" readonly id="value_mrp_less_50" class="form-control" name="value_mrp_less_50">
                                    <span class="text-danger error-message" id="error-value_mrp_less_50"></span>
                                </div>
                            </div>
            
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label class="form-label">Order Type</label>
                                    <select id="orderType" name="order_type" class="form-control">
                                        <option selected disabled value="">Select Order</option>
                                        <option value="Regular">Regular</option>
                                        <option value="Advance">Advance</option>
                                    </select>
                                    <span class="text-danger error-message" id="error-order_type"></span>
                                </div>
            
                                <div class="col-md-4">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="qty" name="qty">
                                    <span class="text-danger error-message" id="error-qty"></span>
                                </div>
            
                                <div class="col-md-4">
                                    <label class="form-label">Ship to code</label>
                                    <input type="text" id="ship_to_customer_code" class="form-control" name="ship_to_customer_code">
                                    <span class="text-danger error-message" id="error-ship_to_customer_code"></span>
                                </div>
                            </div>
            
                            <div class="mt-4">
                                <button type="button" class="btn btn-primary" onclick="submitOrder()">Add to Cart</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
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
                        segment: item.segment, // Store segment
                        dist_ch: item.dist_ch // Store segment
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
        $('#dist_ch').val(data.dist_ch);

        // ✅ Merge details and show in an input field
        var details = `Std Pkg: ${data.std_pkg}, Part No: ${data.part_number}, MRP: ${data.value_mrp_less_50}`;
        $('#materialDetails').val(details);
    });
});



function submitOrder() {
    $('.error-message').text(''); // Clear previous errors
    let isValid = true;

    // Validate input fields
    if ($('#materialSelect').val() === '') {
        $('#error-material_no').text('Material No is required.');
        isValid = false;
    }
    if ($('#orderType').val() === '') {
        $('#error-order_type').text('Order Type is required.');
        isValid = false;
    }
    if ($('#qty').val() === '') {
        $('#error-qty').text('Quantity is required.');
        isValid = false;
    }

    if (!isValid) return; // Stop if validation fails

    var formData = new FormData($('#addOrderForm')[0]);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: "{{ url('store-material-order') }}",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.success) {
                alert('Order added successfully!');
                updateCartCount(); // Update cart count without refreshing
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) { // Laravel validation errors
                var errors = xhr.responseJSON.errors;
                $('.error-message').text(''); // Clear previous errors

                $.each(errors, function (key, messages) {
                    let fieldError = $('#error-' + key);
                    if (fieldError.length > 0) {
                        fieldError.text(messages[0]);
                    }
                });
            } else {
                alert('Something went wrong!');
            }
        }
    });
}

// Function to update the cart count dynamically
function updateCartCount() {
    $.ajax({
        url: "{{ url('get-cart-count') }}",
        type: "GET",
        success: function (response) {
            $('#cart-count').text(response.count);
        }
    });
}

// Redirect to order trail page when cart is clicked
function redirectToOrderTrail() {
    window.location.href = "{{ url('order-trail') }}";
}

// Call function to update cart count on page load
$(document).ready(function() {
    updateCartCount();
});

</script>

<script>
    document.getElementById("qty").addEventListener("input", function() {
        let qty = parseFloat(this.value) || 0; // Get Quantity
        let std_pkg = parseFloat(document.getElementById("std_pkg").value) || 1; // Get Standard Package (default to 1)
        
        if (qty > 0) {
            document.getElementById("no_of_packs").value = (qty / std_pkg).toFixed(2); // Calculate No of Packs
        } else {
            document.getElementById("no_of_packs").value = ""; // Clear if qty is empty
        }
    });
    </script>
        <x-footer />