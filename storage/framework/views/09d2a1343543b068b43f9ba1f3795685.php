<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <?php echo e(__('Readings History')); ?>

            </h2>
            <a href="<?php echo e(route('readings.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                + Add Reading
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8">
                <?php if($readings->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-xl">Date</th>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Meter No.</th>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Previous</th>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Current</th>
                                    <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Consumed</th>
                                    <?php if(Auth::user()->role === 'admin'): ?>
                                        <th class="px-6 py-4 bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-xl">User</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <?php $__currentLoopData = $readings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reading): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-indigo-50/30 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium"><?php echo e(\Carbon\Carbon::parse($reading->reading_date)->format('M d, Y')); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($reading->meter->type == 'water' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                                <?php echo e($reading->meter->meter_number); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right"><?php echo e(number_format($reading->previous_value, 2)); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold text-right"><?php echo e(number_format($reading->current_value, 2)); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 font-bold text-right"><?php echo e(number_format($reading->units_consumed, 2)); ?></td>
                                        <?php if(Auth::user()->role === 'admin'): ?>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($reading->meter->user->name); ?></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">No readings found</h3>
                        <p class="mt-2 text-gray-500">It looks like no readings have been recorded yet.</p>
                        <a href="<?php echo e(route('readings.create')); ?>" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            Record a Reading
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/readings/index.blade.php ENDPATH**/ ?>