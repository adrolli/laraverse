<?php
use App\Models\PackagistPackage;
use Composer\Semver\Semver;
use Composer\Semver\VersionParser;

$slug = 'adrolli/filament-job-manager';
//$slug = 'laravel/framework';
//$slug = 'laravel/laravel';
//$slug = '00f100/cakephp-opauth';
//$slug = 'spatie/laravel-permission';
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
  $github_stars = $jsonData['github_stars'];
  $versions = $jsonData['versions'];

  $versionParser = new VersionParser();

  $stableVersions = [];
  $branches = [];
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

      $authors = $versionData["authors"];

      /* bugs out the latest version echo in Tinkerwell
      if ($authors) {
        foreach ($authors as $author) {
          $author_name = $author["name"];
          $author_role = $author["role"];
          $author_email = $author["email"];
          $author_homepage = $author["homepage"];
        }
      }
      */

      $licenses = $versionData["license"];

      if ($licenses) {
        foreach ($licenses as $license) {
          $lic = $license;
        }
      }

      $requires = $versionData["require"];
    
      if ($requires) {
        foreach ($requires as $require => $version) {
            $req = $require;
            $ver = $version;
          }
      }
      // maybe not need end

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

  $authors = $latestVersionData["authors"]; // loop

  if ($authors) {
    foreach ($authors as $author) {
      $name = $author["name"];
      $role = $author["role"];
      $email = $author["email"];
      $homepage = $author["homepage"];
    }
  }

  $licenses = $latestVersionData["license"]; // loop

  if ($licenses) {
    foreach ($licenses as $license) {
      $lic = $license;
    }
  }

  $requires = $latestVersionData["require"]; // loop

  if ($requires) {
    foreach ($requires as $require => $version) {
      if (preg_match('/^illuminate\/\w+/', $require)) {
        echo $require . " in version " . $version . " required \n";
      }
      if (preg_match('/^spatie\/\w+/', $require)) {
        echo $require . " in version " . $version . " required \n";
      }
      if (preg_match('/^filament\/\w+/', $require)) {
        echo $require . " in version " . $version . " required \n";
      }
    }
  }

  if ($requires['php']) {
    echo "PHP is required in version: " . $requires['php'];
  }

      // todo: that must be replaced by a more complex one
      // to keep all versions of all well-known packages
      // so to generate a version matrix and feed
      // the advanced version filters
  
  } else {
    // todo: errorhandling
  }
 
/*
$phpVersionConstraint = $versionData['require']['php'] ?? null;

if ($phpVersionConstraint) {
    // Use Composer's VersionParser to extract the PHP version
    $versionParser = new VersionParser();
    $phpVersion = $versionParser->parseConstraints($phpVersionConstraint)->getPrettyString();

    // Get the target PHP versions from the .env file
    $targetPhpVersions = explode(',', env('PHP_VERSIONS', '8.1,8.2'));

    // Initialize a variable to track compatibility
    $isCompatible = false;

    foreach ($targetPhpVersions as $targetPhpVersion) {
        if (version_compare($phpVersion, $targetPhpVersion, '>=')) {
            $isCompatible = true;
            break;
        }
    }

    if ($isCompatible) {
        echo "PHP 8 compat\n";
    }
}


// loop // support
      echo "  - ".$versionData["source"]["reference"]."\n";
      //var_dump($versionData);

    }

   $maintainers = $jsonData['maintainers'];

    foreach($maintainers as $maintainer => $maintainerData) {
  
      //echo $maintainer;
      //var_dump($maintainerData);

    }
*/


