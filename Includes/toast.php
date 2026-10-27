<?php
function render_app_toast(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $toast = $_SESSION['app_toast'] ?? null;
    unset($_SESSION['app_toast']);
    if (!is_array($toast) || empty($toast['message'])) {
        return;
    }

    $type = in_array($toast['type'] ?? '', ['success', 'warning', 'error'], true)
        ? $toast['type']
        : 'error';
    $icons = [
        'success' => 'fa-circle-check',
        'warning' => 'fa-triangle-exclamation',
        'error' => 'fa-circle-exclamation',
    ];
    $role = $type === 'error' ? 'alert' : 'status';
    ?>
    <div class="app-toast app-toast--<?php echo $type; ?>" role="<?php echo $role; ?>" aria-live="<?php echo $type === 'error' ? 'assertive' : 'polite'; ?>" aria-atomic="true">
        <span class="app-toast-icon"><i class="fas <?php echo $icons[$type]; ?>" aria-hidden="true"></i></span>
        <span class="app-toast-message"><?php echo htmlspecialchars((string) $toast['message'], ENT_QUOTES, 'UTF-8'); ?></span>
        <button class="app-toast-close" type="button" aria-label="Dismiss notification"><i class="fas fa-xmark" aria-hidden="true"></i></button>
        <span class="app-toast-progress" aria-hidden="true"></span>
    </div>
    <?php
}
