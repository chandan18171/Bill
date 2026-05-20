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
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black text-gray-800">Alerts & Notifications</h2>
            <form method="POST" action="<?php echo e(route('alerts.check')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="px-6 py-2 bg-rose-600 text-white font-bold rounded-xl shadow-lg hover:bg-rose-700 transform hover:scale-105 transition">
                    🔔 Check Thresholds Now
                </button>
            </form>
        </div>

        <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium"><?php echo e(session('success')); ?></span>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Alerts List -->
            <div class="lg:col-span-2">
                <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-xl mb-4 border-b pb-2">Recent Alerts</h3>
                    <?php $__empty_1 = true; $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4 mb-4 rounded-xl flex justify-between items-center <?php echo e($alert->is_read ? 'bg-gray-50' : 'bg-rose-50 border border-rose-100'); ?>">
                        <div>
                            <p class="font-medium text-gray-800"><?php echo e($alert->message); ?></p>
                            <p class="text-xs text-gray-500 mt-1 font-mono"><?php echo e($alert->created_at->diffForHumans()); ?> — <?php echo e($alert->property->name); ?></p>
                        </div>
                        <?php if(!$alert->is_read): ?>
                        <form method="POST" action="<?php echo e(route('alerts.read', $alert)); ?>" class="ml-4 shrink-0">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button class="text-xs bg-rose-600 text-white px-3 py-1 rounded font-bold shadow hover:bg-rose-700">Mark Read</button>
                        </form>
                        <?php else: ?>
                        <span class="ml-4 text-xs text-green-600 font-bold bg-green-50 px-3 py-1 rounded border border-green-200 shrink-0">✓ Read</span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-10">
                        <p class="text-gray-400 font-medium">No alerts yet. Click <strong>Check Thresholds Now</strong> after setting limits.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Configure Thresholds -->
            <div>
                <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100 sticky top-6">
                    <h3 class="font-bold text-xl mb-4 border-b pb-2 text-indigo-900">Configure Thresholds</h3>
                    <?php $__empty_1 = true; $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <form method="POST" action="<?php echo e(route('alerts.thresholds', $prop)); ?>" class="mb-6 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <h4 class="font-bold text-indigo-700 mb-3"><?php echo e($prop->name); ?></h4>

                        <label class="block text-xs font-bold uppercase tracking-wider mb-1 text-gray-500">Water Threshold (Liters)</label>
                        <input type="number" step="0.1" min="0" name="water_threshold"
                            value="<?php echo e(old('water_threshold', $prop->water_threshold)); ?>"
                            placeholder="e.g. 40"
                            class="w-full rounded-lg border-gray-300 mb-4 p-2 text-sm focus:ring-indigo-500 font-mono text-indigo-700 shadow-sm">

                        <label class="block text-xs font-bold uppercase tracking-wider mb-1 text-gray-500">Electricity Threshold (kWh)</label>
                        <input type="number" step="0.1" min="0" name="electricity_threshold"
                            value="<?php echo e(old('electricity_threshold', $prop->electricity_threshold)); ?>"
                            placeholder="e.g. 100"
                            class="w-full rounded-lg border-gray-300 mb-4 p-2 text-sm focus:ring-indigo-500 font-mono text-indigo-700 shadow-sm">

                        <button class="w-full bg-indigo-600 text-white text-sm font-bold py-3 rounded-lg shadow-md hover:bg-indigo-700 transform hover:scale-[1.02] transition">
                            Save Thresholds
                        </button>
                    </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-sm">No properties found. <a href="<?php echo e(route('properties.create')); ?>" class="text-indigo-600 underline">Add one first.</a></p>
                    <?php endif; ?>
                </div>
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
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/alerts/index.blade.php ENDPATH**/ ?>