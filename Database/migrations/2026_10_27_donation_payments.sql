-- Multi-provider online donation tracking for Razorpay and Cashfree.
-- Apply after 2026_10_26_foundation_features.sql.
CREATE TABLE IF NOT EXISTS donation_payments (
    paymentId INT NOT NULL AUTO_INCREMENT,
    donationId INT NOT NULL,
    paymentToken CHAR(64) NOT NULL,
    internalOrderId VARCHAR(40) NOT NULL,
    gateway VARCHAR(20) NOT NULL,
    gatewayOrderId VARCHAR(100) DEFAULT NULL,
    gatewaySessionId VARCHAR(255) DEFAULT NULL,
    gatewayPaymentId VARCHAR(100) DEFAULT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency CHAR(3) NOT NULL DEFAULT 'INR',
    status VARCHAR(20) NOT NULL DEFAULT 'creating',
    createdOn DATETIME NOT NULL,
    updatedOn DATETIME NOT NULL,
    PRIMARY KEY (paymentId),
    UNIQUE KEY uq_donation_payment_token (paymentToken),
    UNIQUE KEY uq_donation_internal_order (internalOrderId),
    UNIQUE KEY uq_donation_gateway_order (gateway, gatewayOrderId),
    KEY idx_donation_payment_status (donationId, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
