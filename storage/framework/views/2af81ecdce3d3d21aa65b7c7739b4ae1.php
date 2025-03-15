<?php if (isset($component)) { $__componentOriginal2a2e454b2e62574a80c8110e5f128b60 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a2e454b2e62574a80c8110e5f128b60 = $attributes; } ?>
<?php $component = App\View\Components\Header::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Header::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a2e454b2e62574a80c8110e5f128b60)): ?>
<?php $attributes = $__attributesOriginal2a2e454b2e62574a80c8110e5f128b60; ?>
<?php unset($__attributesOriginal2a2e454b2e62574a80c8110e5f128b60); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a2e454b2e62574a80c8110e5f128b60)): ?>
<?php $component = $__componentOriginal2a2e454b2e62574a80c8110e5f128b60; ?>
<?php unset($__componentOriginal2a2e454b2e62574a80c8110e5f128b60); ?>
<?php endif; ?>
        <!-- Add in the <head> section -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Create Order <?php echo e(session('EMPID')); ?></h1>



              
  
			    
              <div class="app-card shadow-sm mb-4" role="alert">
                <?php if(session('success')): ?>
                <div class="alert alert-success py-1 px-2 small"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger py-1 px-2 small"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

                <?php if(session('import_errors')): ?>
                    <div class="alert alert-warning py-1 px-2 small">
                        <strong>Import Errors:</strong>
                        <?php $__currentLoopData = session('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p class="mb-1"><?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            
                <div class="app-card-body p-3 p-lg-4">            
                    <form action="<?php echo e(route('upload.file')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <input type="file" name="file" class="form-control">
                            <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
                
                <form id="addwfm">
                    <?php echo csrf_field(); ?>
                    <div class="row p-5">
            
                    <div class="row mt-3">
                        <div class="col-md-4">
                           <label class="form-label">Material No</label>
                           <select id="materialSelect" name="material_no" class="form-control">

                        
                            <option value="">Search and Select Material</option>
                        </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Standard Package</label>
                            <input type="number" readonly class="form-control" id="std_pkg" name="std_pkg">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Value MRP Less 50</label>
                            <input type="text" step="0.01" readonly id="value_mrp_less_50" class="form-control" name="value_mrp_less_50">
                        </div>


                    
                    </div>
            
                    <div class="row mt-3">


                        <div class="col-md-4">
                            <label class="form-label">Segment</label>
                            <input type="text" readonly id="segment" class="form-control" name="segment">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Order Type</label>
                            <select id="orderType" name="order_type" class="form-control">
                                <option selected disabled>Select Order</option>
                                <option value="Regular">Regular</option>
                                <option value="Advance">Advance</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="qty" name="qty">
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
    var form_data = new FormData($('#addwfm')[0]);

    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery.ajax({
        type: 'POST',
        url: "<?php echo e(url('store-material-order')); ?>",
        data: form_data,
        contentType: false,
        processData: false,
        success: function (result) {
            console.log(result);
            if (result.success) {
                alert('Order added successfully!');
                $('#addwfm')[0].reset(); // Reset form
                $('.error-message').remove(); // Remove previous error messages
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) { // Laravel validation error
                var errors = xhr.responseJSON.errors;
                $('.error-message').remove(); // Remove previous error messages

                $.each(errors, function (key, messages) {
                    let field = $('#' + key);
                    
                    // Ensure field exists before appending error message
                    if (field.length > 0) {
                        field.after('<span class="text-danger error-message">' + messages[0] + '</span>');
                    }
                });
            } else {
                alert('Something went wrong!');
            }
        }
    });
}



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
        <?php if (isset($component)) { $__componentOriginal99051027c5120c83a2f9a5ae7c4c3cfa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal99051027c5120c83a2f9a5ae7c4c3cfa = $attributes; } ?>
<?php $component = App\View\Components\Footer::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Footer::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal99051027c5120c83a2f9a5ae7c4c3cfa)): ?>
<?php $attributes = $__attributesOriginal99051027c5120c83a2f9a5ae7c4c3cfa; ?>
<?php unset($__attributesOriginal99051027c5120c83a2f9a5ae7c4c3cfa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal99051027c5120c83a2f9a5ae7c4c3cfa)): ?>
<?php $component = $__componentOriginal99051027c5120c83a2f9a5ae7c4c3cfa; ?>
<?php unset($__componentOriginal99051027c5120c83a2f9a5ae7c4c3cfa); ?>
<?php endif; ?><?php /**PATH E:\sanket-project\delux-project\resources\views/order_create.blade.php ENDPATH**/ ?>