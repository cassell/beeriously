<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference;

use Beeriously\Brewery\BrewerySharingPreferences;
use PHPUnit\Framework\TestCase;

class BrewerySharingPreferencesTest extends TestCase
{
    public function testTapList()
    {
        $prefs = BrewerySharingPreferences::defaultNotSharing();
        $this->assertFalse($prefs->isSharingTapList());
        $prefs->shareTapList();
        $this->assertTrue($prefs->isSharingTapList());
        $prefs->unshareTapList();
        $this->assertFalse($prefs->isSharingTapList());
    }
}
