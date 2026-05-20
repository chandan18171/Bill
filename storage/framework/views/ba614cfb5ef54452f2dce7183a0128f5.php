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
            <h2 class="text-3xl font-black text-gray-800">Bills & Invoices</h2>
            <!-- Generate Bill Modal Trigger -->
            <button onclick="document.getElementById('generateModal').classList.remove('hidden')"
                class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transform hover:scale-105 transition">
                + Generate Bill
            </button>
        </div>

        <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium"><?php echo e(session('success')); ?></span>
        </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0z"></path></svg>
            <span class="font-medium"><?php echo e(session('error')); ?></span>
        </div>
        <?php endif; ?>

        <?php if($bills->isEmpty()): ?>
        <div class="text-center py-24">
            <p class="text-gray-400 font-medium text-lg">No bills yet. Click <strong>+ Generate Bill</strong> after logging readings.</p>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-6 border-l-4 <?php echo e($bill->status == 'paid' ? 'border-green-500' : 'border-rose-500'); ?>">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400"><?php echo e($bill->type); ?> Bill</span>
                    <?php if($bill->status == 'paid'): ?>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">PAID</span>
                    <?php else: ?>
                        <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-sm font-bold">UNPAID</span>
                    <?php endif; ?>
                </div>
                <h3 class="text-4xl font-black text-gray-900">$<?php echo e(number_format($bill->amount, 2)); ?></h3>
                <p class="text-gray-500 mt-2 text-sm"><?php echo e($bill->property->name); ?></p>
                <div class="mt-6 pt-4 border-t flex justify-between items-center">
                    <p class="text-xs text-gray-500">Due: <span class="<?php echo e($bill->status == 'unpaid' ? 'text-rose-600 font-bold' : ''); ?>"><?php echo e($bill->due_date); ?></span></p>
                    <a href="<?php echo e(route('bills.show', $bill)); ?>" class="text-indigo-600 font-bold hover:underline">Details &rarr;</a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Generate Bill Modal -->
    <div id="generateModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
            <h3 class="text-xl font-black mb-6 text-gray-800">Generate Bill for This Month</h3>
            <form method="POST" action="<?php echo e(route('bills.generate')); ?>">
                <?php echo csrf_field(); ?>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Property</label>
                <select name="property_id" class="w-full border-gray-300 rounded-lg shadow-sm mb-6 p-3 focus:ring-indigo-500" required>
                    <option value="">-- Choose a property --</option>
                    <?php $__currentLoopData = Auth::user()->properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($prop->id); ?>"><?php echo e($prop->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs text-gray-500 mb-6 bg-gray-50 p-3 rounded-lg">This will total all water &amp; electricity readings logged <strong>this month</strong> and apply slab tariffs to generate invoices.</p>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white font-bold py-3 rounded-xl shadow hover:bg-indigo-700 transition">Generate Now</button>
                    <button type="button" onclick="document.getElementById('generateModal').classList.add('hidden')" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-200 transition">Cancel</button>
                </div>
            </form>
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
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/bills/index.blade.php ENDPATH**/ ?>