<?php

namespace App\Traits\PackagistItem;

trait ErrorHandler
{
    public function handleError($Function, $Item, $Exception)
    {
        $errorMessage = "{$Function} failed for {$Item} because of {$Exception}";

        activity()->log($errorMessage);

        return null;

    }
}
