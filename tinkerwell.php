<?php
use App\Models\PackagistPackage;
use Composer\Semver\Semver;
use Composer\Semver\VersionParser;

/*
Todo:

- maintainers 
    - name
    - avatar_url

- Get repository url and run the repo-job
- Andor Create item
- Create Item relations
  - composer-require
  - composer-require-dev
  - the is ones (fork etc., ough)
- Create Tags
- Category
  - Laravel Package
  - PHP Package
  - Laravel App
  - Other
- Well known compatibility (at least PHP/Laravel)
- Tech-Stack (main stacks or all stacks, will there even be all stacks?)
  - ... wire ... by require
- Category or Type
  - ... wire ... from Tags?

*/

$slug = 'adrolli/filament-job-manager';
$slug = 'laravel/framework';
$slug = 'laravel/laravel';
$slug = '00f100/cakephp-opauth';
$slug = 'spatie/laravel-permission';
//$slug = 'filament/spatie-laravel-media-library-plugin';
//$slug = 'bezhansalleh/filament-shield';
$package = PackagistPackage::where('slug', $slug)->first();

if ($package) {

  $id = $package->id;
  $title = $package->title;
  $slug = $package->slug;
  $jsonData = $package->data;

  $name = $jsonData['name'];
  $time = $jsonData['time'];
  $type = $jsonData['type'];
  $favers = $jsonData['favers'];
  $language = $jsonData['language'];
  $description = $jsonData['description'];
  $dependents = $jsonData['dependents'];
  $repository = $jsonData['repository'];

  // todo: this is probably a GitHub Repo URL
  // then run the Repository Job
  // for GitHub Repos
  echo $repository . " \n";
  
  $github_stars = $jsonData['github_stars'];
  $versions = $jsonData['versions'];

  $versionParser = new VersionParser();

  $stableVersions = [];
  $branches = [];
  $allphp = [];
  $alllaravel = [];
  $allfilament = [];
  foreach ($versions as $versionString => $versionData) {

      // the full data of all versions may not be needed
      $ver = $versionString;
      $versionData["dist"]["url"];
      $versionData["dist"]["type"];
      $versionData["dist"]["shasum"];
      $versionData["dist"]["reference"];
      $versionData["name"];
      $versionData["time"];
      $versionData["type"];
      $versionData["source"]["url"];
      $versionData["source"]["type"];
      $versionData["source"]["reference"];

      $requires = $versionData["require"];

      if ($requires) {
        if ($requires['php']) {
          $allphp[] = $requires['php'];
        }
        foreach ($requires as $require => $version) {
          if (preg_match('/^illuminate\/\w+/', $require)) {
            $alllaravel[] = $version;
          }
          if (preg_match('/^filament\/\w+/', $require)) {
            $allfilament[] = $version;
          }
        }
      }

      // todo: if "self.version" set version, check in
      // filament/spatie-laravel-media-library-plugin
      // then get and sort all versions of the array

      try {
          $normalizedVersion = $versionParser->normalize($versionString);

          if (preg_match('/^\d+\.\d+(\.\d+)?(\.\d+)?$/', $normalizedVersion)) {
              $stableVersions[$normalizedVersion] = $versionString;
          } else {
              $branches[$versionString] = strtotime($versionData['time']);
          }
      } catch (\UnexpectedValueException $e) {
          $branches[$versionString] = strtotime($versionData['time']);
      }
  }

  $majorVersions = [];

  foreach ($alllaravel as $constraint) {
      $versions = explode('|', $constraint);

      foreach ($versions as $version) {

          $normalizedVersion = str_replace(["~", "^"], "", $version);
          list($majorVersion) = explode('.', $normalizedVersion);

          $majorVersions[$majorVersion] = true;
      }
  }

  $uniqueMajorVersions = array_keys($majorVersions);
  rsort($uniqueMajorVersions, SORT_NUMERIC);


  if (!empty($stableVersions)) {
      krsort($stableVersions, SORT_NATURAL);
      $latestVersion = reset($stableVersions);

      echo "Latest version of $name: $latestVersion\n";
  } else {
      arsort($branches);
      $latestVersion = key($branches);

      echo "Latest branch of $name: $latestVersion\n";
  }

  $latestVersionData = $versions[$latestVersion];

  $latestVersionData["dist"]["url"];
  $latestVersionData["dist"]["url"];
  $latestVersionData["dist"]["type"];
  $latestVersionData["dist"]["shasum"];
  $latestVersionData["dist"]["reference"];
  $latestVersionData["name"];
  $latestVersionData["time"];
  $latestVersionData["type"];
  $latestVersionData["source"]["url"];
  $latestVersionData["source"]["type"];
  $latestVersionData["source"]["reference"];

  $authors = $latestVersionData["authors"];

  if ($authors) {
    foreach ($authors as $author) {
      $name = $author["name"];
      $role = $author["role"];
      $email = $author["email"];
      $homepage = $author["homepage"];
    }
  }

  $licenses = $latestVersionData["license"];

  if ($licenses) {
    foreach ($licenses as $license) {
      $lic = $license;
    }
  }

  $requires = $latestVersionData["require"];

  if ($requires) {
    echo "Latest version: \n";
    if ($requires['php']) {
      echo "PHP is required in version: " . $requires['php'];
    }
    foreach ($requires as $require => $version) {

      // todo: this is the place where to
      // create all the item-relations

      if (preg_match('/^illuminate\/\w+/', $require)) {
        echo $require . " is required in version: " . $version . " \n";
      }
      if (preg_match('/^spatie\/\w+/', $require)) {
        echo $require . " is required in version: " . $version . " \n";
      }
      if (preg_match('/^filament\/\w+/', $require)) {
        echo $require . " is required in version: " . $version . " \n";
      }
    }
  }
  
} else {
    // todo: errorhandling
}
