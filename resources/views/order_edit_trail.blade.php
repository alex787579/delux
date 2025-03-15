<x-header />
        <!-- Add in the <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Create Order {{session('EMPID')}}</h1>



              {{-- <a href="{{ url('/export/orders/xlsx') }}" class="btn btn-success">Export to Excel</a>
			  <a href="{{ url('/export/orders/csv') }}" class="btn btn-primary">Export to CSV</a> --}}
  
			    
              <div class="app-card shadow-sm mb-4" role="alert">
                @if (session('success'))
                <div class="alert alert-success py-1 px-2 small">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger py-1 px-2 small">{{ session('error') }}</div>
                @endif

                @if(session('import_errors'))
                    <div class="alert alert-warning py-1 px-2 small">
                        <strong>Import Errors:</strong>
                        @foreach(session('import_errors') as $error)
                            <p class="mb-1">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
        
                
                <form id="updatewfm">
                    @csrf
                    <div class="row p-5">
            
                    <div class="row mt-3">
                        <div class="col-md-4">
                           <label class="form-label">Material No</label>
                           <select id="materialSelect"value="{{ $order->material_no }}" name="material_no" class="form-control">
                            <option value="">Search and Select Material</option>
                        </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Standard Package</label>
                            <input type="number" readonly class="form-control" id="std_pkg"value="{{ $order->std_pkg }}" name="std_pkg">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Value MRP Less 50</label>
                            <input type="text" step="0.01" readonly id="value_mrp_less_50" class="form-control"value="{{ $order->value_mrp_less_50 }}" name="value_mrp_less_50">
                        </div>


                    
                    </div>
            
                    <div class="row mt-3">


                        <div class="col-md-4">
                            <label class="form-label">Segment</label>
                            <input type="text" readonly id="segment" class="form-control"value="{{ $order->segment }}" name="segment">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Order Type</label>
                            <select id="orderType" name="order_type" class="form-control">
                                <option disabled>Select Order</option>
                                <option value="Regular" {{ $order->order_type == 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="Advance" {{ $order->order_type == 'Advance' ? 'selected' : '' }}>Advance</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="qty" value="{{ $order->qty }}" name="qty">
                        </div>
                       
                    </div>
            

            
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Add</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
            
				    

			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    


		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<script>

        // Set default selected material number
let selectedMaterial = "{{ $order->material_no }}";
    if (selectedMaterial) {
        let selectedOption = new Option(selectedMaterial, selectedMaterial, true, true);
        $('#materialSelect').append(selectedOption).trigger('change');
    }


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


function submitForm() {
    $.ajax({
        url: "/update-order-trail/{{ $order->id }}",
        type: "POST",
        data: $('#updatewfm').serialize(),
        success: function(response) {
            if (response.success) {
                alert("Order updated successfully!");
                location.reload();
            } else {
                alert("Failed to update order!");
            }
        }
    });
}

// function submitForm() {
//     var form_data = new FormData($('#addwfm')[0]);

//     jQuery.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     jQuery.ajax({
//         type: 'POST',
//         url: "{{url('store-material-order')}}",
//         data: form_data,
//         contentType: false,
//         processData: false,
//         success: function (result) {
//             console.log(result);
//             if (result.success) {
//                 alert('Order added successfully!');
//                 $('#addwfm')[0].reset(); // Reset form
//                 $('.error-message').remove(); // Remove previous error messages
//             }
//         },
//         error: function (xhr) {
//             if (xhr.status === 422) { // Laravel validation error
//                 var errors = xhr.responseJSON.errors;
//                 $('.error-message').remove(); // Remove previous error messages

//                 $.each(errors, function (key, messages) {
//                     let field = $('#' + key);
                    
//                     // Ensure field exists before appending error message
//                     if (field.length > 0) {
//                         field.after('<span class="text-danger error-message">' + messages[0] + '</span>');
//                     }
//                 });
//             } else {
//                 alert('Something went wrong!');
//             }
//         }
//     });
// }



// $(document).ready(function() {
//  // ✅ AJAX Form Submission
//  $('form').on('submit', function(e) {
//         e.preventDefault(); // Prevent form from refreshing the page
//         jQuery.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         });
//         $.ajax({
//             url: '/store-material-order', // Laravel route to store data
//             method: 'POST',
//             data: {
//                 // _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
//                 material_no: $('#materialSelect').val(),
//                 std_pkg: $('#std_pkg').val(),
//                 value_mrp_less_50: $('#value_mrp_less_50').val(),
//                 segment: $('#segment').val(),
//                 order_type: $('#orderType').val(),
//                 qty: $('#qty').val()
//             },
//             success: function(response) {
//                 console.log(response);
                
//                 // alert('Order added successfully!');
//                 // $('form')[0].reset(); // Reset form fields
//                 // $('#materialSelect').val(null).trigger('change'); // Clear select2
//             }
//         });
//     });
//     });
</script>
        <x-footer />