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
    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">Log Water Reading</h2>
        <?php if($errors->any()): ?>
            <div class="mb-4 bg-red-100 text-red-600 p-4 rounded-lg">
                <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($err); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(route('water-readings.store')); ?>" class="bg-white p-8 shadow-xl rounded-2xl border border-gray-100">
            <?php echo csrf_field(); ?>
            <label class="block mb-4 font-medium text-gray-700">Property: 
                <select name="property_id" class="w-full border-gray-300 rounded-lg mt-1 p-3" required>
                    <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($prop->id); ?>"><?php echo e($prop->name); ?> (Meter: <?php echo e($prop->meter_number); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label class="block mb-4 font-medium text-gray-700">Reading Date: <input type="date" max="<?php echo e(date('Y-m-d')); ?>" name="reading_date" class="w-full border-gray-300 rounded-lg mt-1 p-3" required></label>
            <div class="flex gap-4 mb-4">
                <label class="block w-1/2 font-medium text-gray-700">Previous Value: <input type="number" step="0.01" min="0" name="previous_value" class="w-full border-gray-300 rounded-lg mt-1 p-3" required></label>
                <label class="block w-1/2 font-medium text-gray-700">Current Value: <input type="number" step="0.01" min="0" name="current_value" class="w-full border-gray-300 rounded-lg mt-1 p-3" required></label>
            </div>
            <label class="block mb-6 font-medium text-gray-700">Unit Type:
                <select name="unit_type" class="w-full border-gray-300 rounded-lg mt-1 p-3" required>
                    <option value="litres">Litres</option>
                    <option value="cubic m">Cubic Meters</option>
                </select>
            </label>
            <button class="w-full bg-blue-600 text-white font-bold px-4 py-3 rounded-lg shadow hover:opacity-90 transition">Submit Reading</button>
        </form>
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
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/water-readings/create.blade.php ENDPATH**/ ?>