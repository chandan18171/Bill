<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #INV-<?php echo e(str_pad($bill->id, 5, '0', STR_PAD_LEFT)); ?></title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; padding: 20px; }
        .header { border-bottom: 2px solid #cbd5e1; padding-bottom: 20px; margin-bottom: 30px; }
        .title { font-size: 28px; font-weight: bold; text-transform: uppercase; margin: 0; color: #1e293b; }
        .details { width: 100%; margin-bottom: 40px; }
        .details td { vertical-align: top; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .right { text-align: right; }
        .total { font-size: 24px; font-weight: bold; color: #4f46e5; }
        .status { padding: 5px 10px; border-radius: 4px; font-weight: bold; }
        .paid { background: #dcfce7; color: #166534; }
        .unpaid { background: #ffe4e6; color: #be123c; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title"><?php echo e($bill->type); ?> INVOICE</h1>
        <p>Invoice #: <strong>INV-<?php echo e(str_pad($bill->id, 5, '0', STR_PAD_LEFT)); ?></strong></p>
        <span class="status <?php echo e($bill->status == 'paid' ? 'paid' : 'unpaid'); ?>"> STATUS: <?php echo e(strtoupper($bill->status)); ?></span>
    </div>
    
    <table class="details">
        <tr>
            <td>
                <span style="color: #64748b; font-size: 12px; font-weight: bold;">BILLED TO</span><br>
                <strong><?php echo e($bill->property->user->name); ?></strong><br>
                <?php echo e($bill->property->address); ?>

            </td>
            <td class="right">
                <span style="color: #64748b; font-size: 12px; font-weight: bold;">DATES</span><br>
                <strong>Billing Date:</strong> <?php echo e($bill->billing_date); ?><br>
                <strong>Due Date:</strong> <span style="color: #be123c;"><?php echo e($bill->due_date); ?></span>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr style="background: #f8fafc;">
                <th>Description</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Utility Consumption Charges</td>
                <td class="right">$<?php echo e(number_format($subtotal, 2)); ?></td>
            </tr>
            <tr>
                <td>Government Tax (5%)</td>
                <td class="right">$<?php echo e(number_format($tax, 2)); ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="font-weight: bold; padding-top: 20px; font-size: 18px;">TOTAL DUE</td>
                <td class="right total" style="padding-top: 20px;">$<?php echo e(number_format($bill->amount, 2)); ?></td>
            </tr>
        </tfoot>
    </table>
    
    <div style="margin-top: 50px; text-align: center; color: #64748b; font-size: 12px;">
        <p>Thank you for using the utility tracker! If you have queries, please reach out to admin support.</p>
    </div>
</body>
</html>
<?php /**PATH /Users/chandankumar/Desktop/CA2/water-electricity-tracker/resources/views/bills/pdf.blade.php ENDPATH**/ ?>