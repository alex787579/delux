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
																<?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																	<tr>
																		<td class="cell"><?php echo e($orderList->order_id); ?></td>
																		<td class="cell"><?php echo e($orderList->dist_ch); ?></td>
																		<td class="cell"><?php echo e($orderList->sold_to_party_cust_code); ?></td>
																		<td class="cell"><?php echo e($orderList->ship_to_cust_code); ?></td>
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
																			<div align="center">
																				<button type="button" class="btn btn-success btn-sm btn-rounded" 
																				onclick="window.location='<?php echo e(url('approvedOrder/'.Crypt::encryptString($orderList->order_id))); ?>'">
																					<i class="fa fa-check"></i>
																				</button>
																		
																				</div>
																		</td>
																	</tr>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
															</tbody>
														</table>
														
														
													</div><!--//table-responsive-->
												   
												</div><!--//app-card-body-->		
											</div><!--//app-card-->
					
											
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
<?php endif; ?><?php /**PATH E:\sanket-project\delux-project\resources\views/uploadForm.blade.php ENDPATH**/ ?>