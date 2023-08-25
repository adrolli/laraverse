<?php
use App\Models\PackagistPackage;
use Composer\Semver\VersionParser;

//$slug = '14four_oauth2-basecamp';
$slug = '14four_oauth2-basecamp';

$package = PackagistPackage::where('slug', $slug)->first();

if ($package) {
    $jsonData = $package->data; 
    $name = $jsonData['name'];
    $time = $jsonData['time'];
    // library, composer-plugin, project ... seems useless
    $type = $jsonData['type'];
    $favers = $jsonData['favers'];
    $language = $jsonData['language'];
    $description = $jsonData['description'];
    $dependents = $jsonData['dependents'];
    $repository = $jsonData['repository'];
    $github_stars = $jsonData['github_stars'];

    $versions = $jsonData['versions'];

    foreach($versions as $version => $versionData) {
  
//      echo "- ".$version."\n";
//      echo "  - ".$versionData["dist"]["url"]."\n";
//      echo "  - ".$versionData["dist"]["type"]."\n";
//      echo "  - ".$versionData["dist"]["shasum"]."\n";
//      echo "  - ".$versionData["dist"]["reference"]."\n";
//      echo "  - ".$versionData["name"]."\n";
//      echo "  - ".$versionData["time"]."\n";
//      echo "  - ".$versionData["type"]."\n";
//      echo "  - ".$versionData["source"]["url"]."\n";
//      echo "  - ".$versionData["source"]["type"]."\n";
//      echo "  - ".$versionData["source"]["reference"]."\n";
//loop      echo "  - ".$versionData["authors"]."\n";
//loop      echo "  - ".$versionData["license"]."\n";
// loop require
//var_dump($versionData);


$requirePhp = $versionData['require']['php'];
$requireLaravel = $$versionData['require']['laravel'];

if (!$requirePhp OR !$requireLaravel) {
  echo "not compat!\n";
}


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



    //  var_dump($jsonData);

} else {
    echo "Package not found.";
}
