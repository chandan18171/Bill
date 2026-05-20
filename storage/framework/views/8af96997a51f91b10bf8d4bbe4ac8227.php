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
        <h2 class="text-3xl font-black mb-8 text-gray-800">Dashboard & Analytics</h2>
        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
                <p class="text-indigo-100 text-sm font-medium uppercase tracking-wider">Properties</p>
                <h3 class="text-4xl font-bold mt-2"><?php echo e($propertiesCount); ?></h3>
            </div>
            <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
                <p class="text-rose-100 text-sm font-medium uppercase tracking-wider">Unpaid Amount</p>
                <h3 class="text-4xl font-bold mt-2">$<?php echo e(number_format($unpaidTotal, 2)); ?></h3>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
                <p class="text-emerald-100 text-sm font-medium uppercase tracking-wider">Billed This Month</p>
                <h3 class="text-4xl font-bold mt-2">$<?php echo e(number_format($thisMonthBills, 2)); ?></h3>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">Billed Last Month</p>
                <h3 class="text-4xl font-bold mt-2">$<?php echo e(number_format($lastMonthBills, 2)); ?></h3>
                <p class="text-sm mt-1">
                    <?php if($thisMonthBills > $lastMonthBills): ?> <span class="bg-rose-500 rounded px-2 py-1 text-xs">+<?php echo e(number_format((($thisMonthBills - $lastMonthBills) / ($lastMonthBills ?: 1)) * 100, 1)); ?>% increase</span>
                    <?php elseif($thisMonthBills < $lastMonthBills): ?> <span class="bg-green-500 rounded px-2 py-1 text-xs">-<?php echo e(number_format((($lastMonthBills - $thisMonthBills) / ($lastMonthBills ?: 1)) * 100, 1)); ?>% decrease</span>
                    <?php else: ?> <span class="bg-white/20 rounded px-2 py-1 text-xs">No change</span> <?php endif; ?>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Monthly Bar Chart -->
            <div class="bg-white p-8 shadow-xl sm:rounded-2xl border border-gray-100">
                <h3 class="font-bold text-xl text-gray-800 border-b pb-3 mb-6">Water vs Electricity (This Year)</h3>
                <div class="relative h-80 w-full"><canvas id="barChart"></canvas></div>
            </div>

            <!-- 12-Month Trend Line Chart -->
            <div class="bg-white p-8 shadow-xl sm:rounded-2xl border border-gray-100">
                <h3 class="font-bold text-xl text-gray-800 border-b pb-3 mb-6">12-Month Usage Trend</h3>
                <div class="relative h-80 w-full"><canvas id="lineChart"></canvas></div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bar Chart (Current Year)
            new Chart(document.getElementById('barChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($barLabels); ?>,
                    datasets: [
                        { label: 'Water', backgroundColor: '#3b82f6', borderRadius: 4, data: <?php echo json_encode($barWater); ?> },
                        { label: 'Electricity', backgroundColor: '#eab308', borderRadius: 4, data: <?php echo json_encode($barElec); ?> }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Line Chart (12-Month Trend)
            new Chart(document.getElementById('lineChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($twelveMonthsLabels); ?>,
                    datasets: [
                        { label: 'Water Trend', borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', fill: true, tension: 0.4, data: <?php echo json_encode($waterLineData); ?> },
                        { label: 'Electricity Trend', borderColor: '#eab308', backgroundColor: 'rgba(234, 179, 8, 0.1)', fill: true, tension: 0.4, data: <?php echo json_encode($elecLineData); ?> }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
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
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/dashboard.blade.php ENDPATH**/ ?>