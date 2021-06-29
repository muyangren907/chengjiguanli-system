<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;








class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => 'd032473687aaf9c350709bb5fe69ec09e6d92504',
    'name' => 'topthink/think',
  ),
  'versions' => 
  array (
    'league/flysystem' => 
    array (
      'pretty_version' => '1.0.46',
      'version' => '1.0.46.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f3e0d925c18b92cf3ce84ea5cc58d62a1762a2b2',
    ),
    'league/flysystem-cached-adapter' => 
    array (
      'pretty_version' => '1.1.0',
      'version' => '1.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd1925efb2207ac4be3ad0c40b8277175f99ffaff',
    ),
    'liliuwei/thinkphp-auth' => 
    array (
      'pretty_version' => 'v2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '1eddf9fe6c549c11f1b3a212aaaf7a50165412c9',
    ),
    'liliuwei/thinkphp-jump' => 
    array (
      'pretty_version' => 'v1.5',
      'version' => '1.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '481d41b922095f08230609919be5d19354c50540',
    ),
    'markbaker/complex' => 
    array (
      'pretty_version' => '1.5.0',
      'version' => '1.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c3131244e29c08d44fefb49e0dd35021e9e39dd2',
    ),
    'markbaker/matrix' => 
    array (
      'pretty_version' => '1.2.3',
      'version' => '1.2.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '44bb1ab01811116f01fe216ab37d921dccc6c10d',
    ),
    'overtrue/pinyin' => 
    array (
      'pretty_version' => '4.0.7',
      'version' => '4.0.7.0',
      'aliases' => 
      array (
      ),
      'reference' => '083de406907d42df2e0feaaeb83f1a3c2e0095eb',
    ),
    'phpoffice/phpspreadsheet' => 
    array (
      'pretty_version' => '1.12.0',
      'version' => '1.12.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f79611d6dc1f6b7e8e30b738fc371b392001dbfd',
    ),
    'psr/cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.4',
      'version' => '1.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd49695b909c3b7628b6289db5479a1c204601f11',
    ),
    'psr/simple-cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.23.0',
      'version' => '1.23.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '2df51500adbaebdc4c38dea4c89a2e131c45c8a1',
    ),
    'symfony/polyfill-php72' => 
    array (
      'pretty_version' => 'v1.23.0',
      'version' => '1.23.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9a142215a36a3888e30d0a9eeea9766764e96976',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.23.0',
      'version' => '1.23.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'eca0bf41ed421bed1b57c4958bab16aa86b757d0',
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v4.4.25',
      'version' => '4.4.25.0',
      'aliases' => 
      array (
      ),
      'reference' => '31ea689a8e7d2410016b0d25fc15a1ba05a6e2e0',
    ),
    'topthink/framework' => 
    array (
      'pretty_version' => 'v6.0.8',
      'version' => '6.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => '4789343672aef06d571d556da369c0e156609bce',
    ),
    'topthink/think' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => 'd032473687aaf9c350709bb5fe69ec09e6d92504',
    ),
    'topthink/think-captcha' => 
    array (
      'pretty_version' => 'v3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '1eef3717c1bcf4f5bbe2d1a1c704011d330a8b55',
    ),
    'topthink/think-helper' => 
    array (
      'pretty_version' => 'v3.1.5',
      'version' => '3.1.5.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f98e3ad44acd27ae85a4d923b1bdfd16c6d8d905',
    ),
    'topthink/think-migration' => 
    array (
      'pretty_version' => 'v3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '5717d9e5f3ea745f6dbfd1e30b4402aaadff9a79',
    ),
    'topthink/think-multi-app' => 
    array (
      'pretty_version' => 'v1.0.14',
      'version' => '1.0.14.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ccaad7c2d33f42cb1cc2a78d6610aaec02cea4c3',
    ),
    'topthink/think-orm' => 
    array (
      'pretty_version' => 'v2.0.40',
      'version' => '2.0.40.0',
      'aliases' => 
      array (
      ),
      'reference' => '1119d979b850849f3725856460cf108eec1c3eb8',
    ),
    'topthink/think-template' => 
    array (
      'pretty_version' => 'v2.0.8',
      'version' => '2.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => 'abfc293f74f9ef5127b5c416310a01fe42e59368',
    ),
    'topthink/think-trace' => 
    array (
      'pretty_version' => 'v1.4',
      'version' => '1.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9a9fa8f767b6c66c5a133ad21ca1bc96ad329444',
    ),
    'topthink/think-view' => 
    array (
      'pretty_version' => 'v1.0.14',
      'version' => '1.0.14.0',
      'aliases' => 
      array (
      ),
      'reference' => 'edce0ae2c9551ab65f9e94a222604b0dead3576d',
    ),
    'wamkj/thinkphp6.0-databackup' => 
    array (
      'pretty_version' => 'v1.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '28a0e406d827132942723a3c9f69bb20c98e652f',
    ),
    'whitehat101/apr1-md5' => 
    array (
      'pretty_version' => 'v1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8b261c9fc0481b4e9fa9d01c6ca70867b5d5e819',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}

if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}








public static function getRawData()
{
@trigger_error('getRawData only returns the first dataset loaded, which may not be what you expect. Use getAllRawData() instead which returns all datasets for all autoloaders present in the process.', E_USER_DEPRECATED);

return self::$installed;
}







public static function getAllRawData()
{
return self::getInstalled();
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}





private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
