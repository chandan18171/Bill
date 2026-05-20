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
            <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-600">My Properties</h2>
            <a href="<?php echo e(route('properties.create')); ?>" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition">Add Property</a>
        </div>
        <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr><th class="p-4 text-gray-600 font-semibold uppercase text-sm">Name</th><th class="p-4 text-gray-600 font-semibold uppercase text-sm">Address</th><th class="p-4 text-gray-600 font-semibold uppercase text-sm">Meter Number</th><th class="p-4 text-gray-600 font-semibold uppercase text-sm">Actions</th></tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 font-medium text-gray-800"><?php echo e($prop->name); ?></td>
                        <td class="p-4 text-gray-600"><?php echo e($prop->address); ?></td>
                        <td class="p-4 text-indigo-600 font-mono"><?php echo e($prop->meter_number); ?></td>
                        <td class="p-4 flex gap-3">
                            <a href="<?php echo e(route('properties.edit', $prop)); ?>" class="text-blue-500 hover:text-blue-700 font-medium">Edit</a>
                            <form method="POST" action="<?php echo e(route('properties.destroy', $prop)); ?>" onsubmit="return confirm('Delete this property?');">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                            </form>
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
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/properties/index.blade.php ENDPATH**/ ?>