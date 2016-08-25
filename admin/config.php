<?php
// HTTP
define('HTTP_SERVER', 'http://opencart/admin/');
define('HTTP_CATALOG', 'http://opencart/');

// HTTPS
define('HTTPS_SERVER', 'http://opencart/admin/');
define('HTTPS_CATALOG', 'http://opencart/');

// DIR
define('DIR_APPLICATION', '/home/mcmxx/www/opencart/admin/');
define('DIR_SYSTEM', '/home/mcmxx/www/opencart/system/');
define('DIR_IMAGE', '/home/mcmxx/www/opencart/image/');
define('DIR_LANGUAGE', '/home/mcmxx/www/opencart/admin/language/');
define('DIR_TEMPLATE', '/home/mcmxx/www/opencart/admin/view/template/');
define('DIR_CONFIG', '/home/mcmxx/www/opencart/system/config/');
define('DIR_CACHE', '/home/mcmxx/www/opencart/system/storage/cache/');
define('DIR_DOWNLOAD', '/home/mcmxx/www/opencart/system/storage/download/');
define('DIR_LOGS', '/home/mcmxx/www/opencart/system/storage/logs/');
define('DIR_MODIFICATION', '/home/mcmxx/www/opencart/system/storage/modification/');
define('DIR_UPLOAD', '/home/mcmxx/www/opencart/system/storage/upload/');
define('DIR_CATALOG', '/home/mcmxx/www/opencart/catalog/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'htpthdfwbz');
define('DB_DATABASE', 'opencart');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');

//ORDERING
define('ORDER_ASC', 1 << 0);
define('ORDER_DESC', 1 << 1);
define('ORDER_BY_ID', 1 << 2);
define('ORDER_BY_NAME', 1 << 3);
define('ORDER_BY_EMAIL', 1 << 4);
define('ORDER_BY_STATUS', 1 << 5);
define('ORDER_BY_FEATURED' 1 << 6);



//VIDEO
define("RECENT", 1 << 0);
define("FEATURED", 1 << 1);
define("TO_DOWNLOAD", 1 << 2);
define("TO_UPLOAD", 1 << 3);
define("UPLOADED", 1 << 4);
define("DOWNLOADED", 1 << 5);
define("ERRORS", 1 << 6);
define("READY", 1 << 7);


//YOUTUBE
define("YOUTUBE_CLIENT_KEY", "");