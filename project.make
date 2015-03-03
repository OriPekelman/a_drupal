api = 2
core = 7.x

; Drupal core.
projects[drupal][type] = core
projects[drupal][version] = 7.31
projects[drupal][patch][] = "https://drupal.org/files/issues/install-redirect-on-empty-database-728702-36.patch"

; Drush make allows a default sub directory for all contributed projects.
defaults[projects][subdir] = contrib

; Platform indicator module.
projects[platform][version] = 1.3
projects[]= corporateclean
projects[]= ga_login
projects[]= tfa
projects[]= tfa_basic
projects[]= mobile_codes
projects[features][version] = "2.2"
projects[features][patch][] = "http://drupal.org/files/issues/features-fix-modules-enabled-2143765-1.patch"
projects[features][patch][] = "https://www.drupal.org/files/issues/alter_overrides-766264-45.patch"
