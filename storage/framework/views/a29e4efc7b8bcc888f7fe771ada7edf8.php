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
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Electricity Readings</h2>
            <a href="<?php echo e(route('electricity-readings.create')); ?>" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow transition">Add Reading</a>
        </div>
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-yellow-50 border-b border-yellow-100 text-yellow-800">
                    <tr><th class="p-4">Date</th><th class="p-4">Property</th><th class="p-4">Previous</th><th class="p-4">Current</th><th class="p-4">Consumed (kWh)</th><th class="p-4">Peak/Off-Peak</th></tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $readings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b hover:bg-gray-50 uppercase text-sm font-medium">
                        <td class="p-4"><?php echo e($r->reading_date); ?></td>
                        <td class="p-4"><?php echo e($r->property->name); ?></td>
                        <td class="p-4"><?php echo e($r->previous_value); ?></td>
                        <td class="p-4 font-bold text-gray-900"><?php echo e($r->current_value); ?></td>
                        <td class="p-4 text-yellow-600"><?php echo e($r->units_consumed); ?></td>
                        <td class="p-4">
                            <?php if($r->is_peak): ?> <span class="text-red-500 font-bold">Peak</span>
                            <?php else: ?> <span class="text-green-500 font-bold">Off-Peak</span> <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
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
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/electricity-readings/index.blade.php ENDPATH**/ ?>