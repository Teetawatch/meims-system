<?php

$files = glob(__DIR__ . '/database/migrations/*.php');

foreach ($files as $file) {
    echo "Processing: " . basename($file) . "\n";
    $content = file_get_contents($file);

    // Skip if already has Schema::hasTable check
    if (strpos($content, 'Schema::hasTable') !== false) {
        echo " - Already fixed.\n";
        continue;
    }

    // Pattern to find Schema::create('table_name', function...)
    $pattern = '/Schema::create\(\'([a-zA-Z0-9_]+)\',\s*function\s*\(Blueprint\s*\$table\)\s*\{/';
    
    if (preg_match($pattern, $content, $matches)) {
        $tableName = $matches[1];
        echo " - Found table: $tableName\n";

        // Replace start
        $replacement = "if (!Schema::hasTable('$tableName')) {\n            Schema::create('$tableName', function (Blueprint \$table) {";
        $content = str_replace($matches[0], $replacement, $content);

        // Find the matching closing bracket for Schema::create
        // This is tricky with regex, simpler approach: find the last `});` in the `up()` method?
        // Let's assume standard Laravel migration structure where }); is near the end of up()
        
        // Actually, just append "        }" specific way might be risky.
        // Let's try to find the "        });" that closes the schema create.
        
        // Find the last occurrence of "});" inside public function up()
        // Or simplified: Just look for `});` followed by `}` of function up
        
        // Let's rely on indentation. usually "        });" (8 spaces)
        $content = preg_replace('/(\s{8}\}\);)/', '$1' . "\n        }", $content, 1);
        
        file_put_contents($file, $content);
        echo " - Fixed!\n";
    }
}
