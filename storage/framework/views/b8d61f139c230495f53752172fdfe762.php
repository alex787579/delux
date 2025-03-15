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
			    
			    <h1 class="app-page-title">Order List</h1>

              <a href="<?php echo e(url('/export/orders/xlsx')); ?>" class="btn btn-success">Export to Excel</a>
			  <a href="<?php echo e(url('/export/orders/csv')); ?>" class="btn btn-primary">Export to CSV</a>
  
			    
			    <div class="app-card shadow-sm mb-4 " role="alert">
					<?php if(session('success')): ?>
					<div class="alert alert-success"><?php echo e(session('success')); ?></div>
				<?php endif; ?>

				<?php if(session('error')): ?>
					<div class="alert alert-danger"><?php echo e(session('error')); ?></div>
				<?php endif; ?>

				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">
						    <div class="row gx-5 gy-3">
								<div class="row g-0 app-auth-wrapper">
									
									<div class="tab-content" id="orders-table-tab-content">
										<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
											<div class="app-card app-card-orders-table shadow-sm mb-5">
												<div class="app-card-body">
													<div class="table-responsive">
														
														<form id="bulkOrderForm">
                                                            <?php echo csrf_field(); ?>
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
                                                                        <th>Packs</th>
                                                                        <th>Package Status</th>
                                                                        <th>Order Status</th>
                                                                        <th>Actions</th> <!-- Edit & Delete -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="checkbox" class="orderCheckbox" name="order_ids[]" value="<?php echo e($orderList->id); ?>">
                                                                            </td>
                                                                            <td class="cell"><?php echo e($orderList->material_no); ?></td>
                                                                            <td class="cell"><?php echo e($orderList->qty); ?></td>
                                                                            <td class="cell"><?php echo e($orderList->std_pkg); ?></td>
                                                                            <td class="cell"><?php echo e(number_format($orderList->value_mrp_less_50, 2)); ?></td>
                                                                            <td class="cell"><?php echo e(number_format($orderList->total_value_mrp_less_50, 2)); ?></td>
                                                                            <td class="cell"><?php echo e($orderList->segment); ?></td>
                                                                            <td class="cell"><?php echo e($orderList->no_of_packs); ?></td>
                                                                            <td class="cell"><?php echo e($orderList->std_packing_ok_not_ok); ?></td>
                                                                            <td class="cell"><?php echo e(ucfirst($orderList->status)); ?></td>
                                                                            <td>
                                                                                <a href="<?php echo e(route('edit-trail-order', ['id' => Crypt::encryptString($orderList->id)])); ?>" class="btn btn-primary btn-sm">
                                                                                    <i class="fa fa-edit"></i>
                                                                                </a>
                                                                                
                                                                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo e($orderList->id); ?>)">
                                                                                    🗑️ 
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        
                                                            <div class="mt-3">
                                                                <button type="button" class="btn btn-primary" onclick="submitSelectedOrders()">Submit Selected</button>
                                                            </div>
                                                        </form>
                                                        
														
														
													</div><!--//table-responsive-->
												   
												</div><!--//app-card-body-->		
											</div><!--//app-card-->
					

                                            

                                            <!-- Bootstrap Modal for Editing -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderLabel">Edit Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addwfm">
                    <?php echo csrf_field(); ?>
                    <div class="row">
            
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
            

            
                    
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateOrder()">Save changes</button>
            </div>
        </div>
    </div>
</div>

                                            
											
										</div><!--//tab-pane-->
										
									</div><!--//tab-content-->
								</div><!--//row-->
						    </div><!--//row-->
						    
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
        alert("❌ Please select at least one order!");
        return;
    }

    $.ajax({
        url: "<?php echo e(url('submit-trail-orders')); ?>", // Backend route
        type: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            order_ids: selectedOrders
        },
        success: function(response) {
          console.log(response);
            
            // alert("✅ Orders submitted successfully!");
            // location.reload(); // Refresh page after submission
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
}



// Delete Record

// ✅ Confirm & Delete Order
function confirmDelete(orderId) {
    if (confirm("Are you sure you want to delete this order?")) {
        $.ajax({
            url: "<?php echo e(url('delete-order')); ?>/" + orderId,
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
<?php endif; ?><?php /**PATH E:\sanket-project\delux-project\resources\views/order_trail.blade.php ENDPATH**/ ?>