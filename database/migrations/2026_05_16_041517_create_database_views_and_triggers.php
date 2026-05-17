<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // Drop elements if existing
        DB::statement("DROP VIEW IF EXISTS user_purchases");
        DB::statement("DROP VIEW IF EXISTS order_summary");
        DB::statement("DROP TRIGGER IF EXISTS trg_coupon_usage");
        DB::statement("DROP TRIGGER IF EXISTS trg_generate_downloads");

        // 1. Create View: user_purchases
        DB::statement("
            CREATE VIEW user_purchases AS
            SELECT so.user_id, op.product_id, so.id AS order_id, so.order_date, op.price AS price_paid
            FROM sales_orders so
            JOIN order_products op ON op.order_id = so.id
            WHERE so.status = 'paid' AND op.product_id IS NOT NULL
        ");

        // 2. Create View: order_summary
        DB::statement("
            CREATE VIEW order_summary AS
            SELECT so.id AS order_id, so.order_date, so.status, so.total, u.email AS customer_email,
                   CONCAT(u.first_name, ' ', u.last_name) AS customer_name,
                   c.code AS coupon_code, c.value AS coupon_value, c.value_type AS coupon_type,
                   ct.processor, ct.processor_trans_id, ct.cc_last4, ct.cc_type, ct.status AS payment_status
            FROM sales_orders so
            LEFT JOIN users u ON u.id = so.user_id
            LEFT JOIN coupons c ON c.id = so.coupon_id
            LEFT JOIN cc_transactions ct ON ct.order_id = so.id AND ct.status = 'success'
        ");

        // 3. Create Trigger: Coupon Usage Counter Tracker
        DB::unprepared("
            CREATE TRIGGER trg_coupon_usage
            AFTER UPDATE ON sales_orders
            FOR EACH ROW
            BEGIN
                IF NEW.status = 'paid' AND OLD.status <> 'paid' AND NEW.coupon_id IS NOT NULL THEN
                    UPDATE coupons
                    SET used_count = used_count + 1
                    WHERE id = NEW.coupon_id AND (usage_limit IS NULL OR used_count < usage_limit);
                END IF;
            END
        ");

        // 4. Create Trigger: Automated Download Link Generator
        DB::unprepared("
            CREATE TRIGGER trg_generate_downloads
            AFTER UPDATE ON sales_orders
            FOR EACH ROW
            BEGIN
                IF NEW.status = 'paid' AND OLD.status <> 'paid' THEN
                    INSERT IGNORE INTO downloads (id, order_id, product_file_id, token, expires_at)
                    SELECT UUID(), NEW.id, pf.id, SHA2(CONCAT(UUID(), NOW(), RAND()), 256), DATE_ADD(NOW(), INTERVAL 30 DAY)
                    FROM order_products op
                    JOIN product_files pf ON pf.product_id = op.product_id
                    WHERE op.order_id = NEW.id;
                END IF;
            END
        ");
    }

    public function down(): void {
        DB::statement("DROP VIEW IF EXISTS user_purchases");
        DB::statement("DROP VIEW IF EXISTS order_summary");
        DB::statement("DROP TRIGGER IF EXISTS trg_coupon_usage");
        DB::statement("DROP TRIGGER IF EXISTS trg_generate_downloads");
    }
};