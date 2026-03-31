#!/bin/bash
# =====================================================
# Shoe Store Database Export Script
# =====================================================

OUTPUT_FILE="shosedb_complete_export_$(date +%Y%m%d_%H%M%S).sql"

echo "Starting export..."

# Create header
cat > "$OUTPUT_FILE" << 'EOF'
-- =====================================================
-- Shoe Store Database Export
-- =====================================================
-- IMPORTANT: This file contains INSERT statements with
-- foreign key constraints disabled for safe import
-- =====================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

USE shosedb;

EOF

# Export data
mysqldump -u root -p'123456' shosedb \
    --skip-extended-insert \
    --complete-insert \
    --skip-comments \
    --no-create-info \
    --skip-triggers \
    --order-by-primary \
    2>/dev/null | \
    grep -v "^/\*" | \
    grep -v "^--" | \
    sed '/^$/d' >> "$OUTPUT_FILE"

# Create footer
cat >> "$OUTPUT_FILE" << 'EOF'

-- Re-enable foreign key checks
COMMIT;
SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- End of export
-- =====================================================
EOF

echo "✅ Export completed successfully!"
echo "📁 File: $OUTPUT_FILE"
ls -lh "$OUTPUT_FILE"
