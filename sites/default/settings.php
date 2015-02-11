<?php

/**
 * Access control for update.php script.
 */
$update_free_access = FALSE;

/**
 * Salt for one-time login links and cancel links, form tokens, etc.
 *
 * If this variable is empty, a hash of the serialized database credentials
 * will be used as a fallback salt.
 */
$drupal_hash_salt = '';

/**
 * PHP settings.
 */
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 200000);
ini_set('session.cookie_lifetime', 2000000);

/**
 * Fast 404 pages.
 */
$conf['404_fast_paths_exclude'] = '/\/(?:styles)\//';
$conf['404_fast_paths'] = '/\.(?:txt|png|gif|jpe?g|css|js|ico|swf|flv|cgi|bat|pl|dll|exe|asp)$/i';
$conf['404_fast_html'] = '<html xmlns="http://www.w3.org/1999/xhtml"><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>';

// Configure relationships.
$relationships = json_decode(base64_decode($_ENV['PLATFORM_RELATIONSHIPS']), TRUE);

if (empty($databases['default']['default'])) {
  foreach ($relationships['database'] as $endpoint) {
    $database = array(
      'driver' => $endpoint['scheme'],
      'database' => $endpoint['path'],
      'username' => $endpoint['username'],
      'password' => $endpoint['password'],
      'host' => $endpoint['host'],
    );

    if (!empty($endpoint['query']['compression'])) {
      $database['pdo'][PDO::MYSQL_ATTR_COMPRESS] = TRUE;
    }

    if (!empty($endpoint['query']['is_master'])) {
      $databases['default']['default'] = $database;
    }
    else {
      $databases['default']['slave'][] = $database;
    }
  }
}

$routes = json_decode(base64_decode($_ENV['PLATFORM_ROUTES']), TRUE);

if (!isset($conf['file_private_path'])) {
  if(!$application_home = getenv('PLATFORM_APP_DIR')) {
    $application_home = '/app';
  }
  $conf['file_private_path'] = $application_home . '/private';
  $conf['file_temporary_path'] = $application_home . '/tmp';
}

$variables = json_decode(base64_decode($_ENV['PLATFORM_VARIABLES']), TRUE);

$prefix_len = strlen('drupal:');
foreach ($variables as $name => $value) {
  if (substr($name, 0, $prefix_len) == 'drupal:') {
    $conf[substr($name, $prefix_len)] = $value;
  }
}
