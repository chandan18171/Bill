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
    <div class="py-12 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            <div class="flex justify-between items-start border-b pb-6 mb-6">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight"><?php echo e($bill->type); ?> INVOICE</h2>
                    <p class="text-gray-500 mt-1">Invoice #INV-<?php echo e(str_pad($bill->id, 5, '0', STR_PAD_LEFT)); ?></p>
                </div>
                <div class="text-right">
                    <a href="<?php echo e(route('bills.pdf', $bill)); ?>" class="inline-block bg-gray-900 text-white font-bold px-4 py-2 rounded-lg shadow hover:bg-gray-800 transition">Download PDF</a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Billed To</p>
                    <p class="font-bold text-gray-900"><?php echo e(Auth::user()->name); ?></p>
                    <p class="text-gray-600"><?php echo e($bill->property->address); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Dates</p>
                    <p class="text-gray-900"><span class="font-bold">Billed:</span> <?php echo e($bill->billing_date); ?></p>
                    <p class="text-gray-900"><span class="font-bold">Due:</span> <span class="<?php echo e($bill->status == 'unpaid' ? 'text-rose-600' : ''); ?>"><?php echo e($bill->due_date); ?></span></p>
                </div>
            </div>

            <table class="w-full text-left mb-8">
                <thead class="border-b">
                    <tr><th class="py-3 text-gray-600 font-medium">Description</th><th class="py-3 text-right text-gray-600 font-medium">Amount</th></tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr><td class="py-4">Utility Consumption Charges (Slab logic applied)</td><td class="py-4 text-right">$<?php echo e(number_format($subtotal, 2)); ?></td></tr>
                    <tr class="border-b"><td class="py-4">Government Tax (5%)</td><td class="py-4 text-right">$<?php echo e(number_format($tax, 2)); ?></td></tr>
                </tbody>
                <tfoot>
                    <tr><td class="py-6 font-bold text-gray-900 text-xl">Total Amount Due</td><td class="py-6 font-black text-indigo-600 text-3xl text-right">$<?php echo e(number_format($bill->amount, 2)); ?></td></tr>
                </tfoot>
            </table>

            <?php if($bill->status == 'unpaid'): ?>
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl flex items-center justify-between border border-gray-200">
                <p class="text-gray-600">Please pay before <strong class="text-rose-600"><?php echo e($bill->due_date); ?></strong> to avoid late fees.</p>
                <form method="POST" action="<?php echo e(route('bills.pay', $bill)); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="bg-indigo-600 text-white font-bold px-8 py-3 rounded-xl shadow-lg hover:opacity-90 transform hover:scale-105 transition">Pay Now</button>
                </form>
            </div>
            <?php endif; ?>
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
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/bills/show.blade.php ENDPATH**/ ?>