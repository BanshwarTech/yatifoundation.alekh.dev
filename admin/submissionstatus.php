<?php
require_once __DIR__ . '/includes/admin_helpers.php';
admin_require_auth();
require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Includes/toast.php';
$sets = [
    'donation' => ['Donations', 'donate', 'dId', ['Pending','Received','Declined']],
    'volunteer' => ['Volunteer applications', 'vounteer', 'vId', ['Pending','Contacted','Accepted','Closed']],
    'contact' => ['Contact messages', 'contact', 'cId', ['New','In Progress','Replied','Closed']],
];
function status_rows(mysqli $con, string $table, string $id): mysqli_result|bool { return mysqli_query($con, "SELECT `$id` AS id,name,email,status,addedOn FROM `$table` WHERE isDel=1 ORDER BY addedOn DESC LIMIT 200"); }
?>
<!doctype html><html lang="en"><?php $adminPageTitle = 'Submission Follow-up'; include __DIR__ . '/includes/head.php'; ?><body class="sb-nav-fixed">
<?php include __DIR__.'/includes/topheader.php'; ?><div id="layoutSidenav"><div id="layoutSidenav_nav"><?php include __DIR__.'/includes/sidebar.php'; ?></div><div id="layoutSidenav_content"><main><div class="container-fluid px-4"><div class="admin-page-heading mt-4"><div><span class="admin-eyebrow">Community</span><h1>Submission follow-up</h1><p>Track incoming requests. Mark donations received only after payment has been verified.</p></div></div>
<?php foreach ($sets as $kind => [$title,$table,$key,$options]):
    if ($kind === 'donation') {
        $rows = mysqli_query($con, "SELECT d.dId AS id,d.name,d.email,d.status,d.addedOn,p.gateway,p.gatewayPaymentId,p.status AS providerStatus FROM donate d LEFT JOIN donation_payments p ON p.paymentId=(SELECT dp.paymentId FROM donation_payments dp WHERE dp.donationId=d.dId ORDER BY dp.paymentId DESC LIMIT 1) WHERE d.isDel=1 ORDER BY d.addedOn DESC LIMIT 200");
    } else {
        $rows = status_rows($con,$table,$key);
    }
?>
<section class="card mb-4"><div class="card-header"><strong><?php echo admin_h($title); ?></strong></div><div class="card-body table-responsive"><table class="table align-middle"><thead><tr><th>Name</th><th>Email</th><th>Received</th><?php if($kind==='donation'): ?><th>Gateway payment</th><?php endif; ?><th>Status</th><th>Save</th></tr></thead><tbody><?php if ($rows && mysqli_num_rows($rows)): while ($row=mysqli_fetch_assoc($rows)): ?><tr><td><?php echo admin_h($row['name']); ?></td><td><?php echo admin_h($row['email']); ?></td><td><?php echo admin_h($row['addedOn']); ?></td><?php if($kind==='donation'): ?><td><?php echo !empty($row['gateway']) ? admin_h(ucfirst($row['gateway']) . ' · ' . ($row['providerStatus'] ?? 'pending') . (!empty($row['gatewayPaymentId']) ? ' · ' . $row['gatewayPaymentId'] : '')) : 'Pledge / no online payment'; ?></td><?php endif; ?><td colspan="2"><form class="d-flex gap-2" action="code.php?msg=update-submission-status" method="post"><input type="hidden" name="csrf_token" value="<?php echo admin_h(admin_csrf_token()); ?>"><input type="hidden" name="kind" value="<?php echo admin_h($kind); ?>"><input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>"><select class="form-select" name="status" aria-label="Status for <?php echo admin_h($row['name']); ?>"><?php foreach($options as $option): ?><option value="<?php echo admin_h($option); ?>" <?php echo ($row['status']??'')===$option?'selected':''; ?>><?php echo admin_h($option); ?></option><?php endforeach; ?></select><button class="btn btn-admin-primary btn-sm" type="submit">Save</button></form></td></tr><?php endwhile; else: ?><tr><td colspan="<?php echo $kind==='donation'?'6':'5'; ?>" class="text-center text-muted">No submissions yet.</td></tr><?php endif; ?></tbody></table></div></section>
<?php endforeach; ?></div></main></div></div><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script><script src="js/scripts.js"></script></body></html>
