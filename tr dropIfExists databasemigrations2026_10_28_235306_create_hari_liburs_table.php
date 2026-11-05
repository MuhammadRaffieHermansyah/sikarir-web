[1mdiff --git a/database/migrations/2026_10_28_235306_create_hari_liburs_table.php b/database/migrations/2026_10_28_235306_create_hari_liburs_table.php[m
[1mindex 7604cc6..8bb3bfe 100644[m
[1m--- a/database/migrations/2026_10_28_235306_create_hari_liburs_table.php[m
[1m+++ b/database/migrations/2026_10_28_235306_create_hari_liburs_table.php[m
[36m@@ -23,8 +23,8 @@[m [mpublic function up(): void[m
     /**[m
      * Reverse the migrations.[m
      */[m
[31m-    public function down(): void[m
[32m+[m[32m   public function down(): void[m
     {[m
[31m-        Schema::dropIfExists('hari_liburs');[m
[32m+[m[32m    Schema::dropIfExists('hari_libur');[m
     }[m
 };[m
