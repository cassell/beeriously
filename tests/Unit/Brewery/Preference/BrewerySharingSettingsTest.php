<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference;

use Beeriously\Brewery\Settings\BrewerySharingSettings;
use PHPUnit\Framework\TestCase;

class BrewerySharingSettingsTest extends TestCase
{
    public function testTapList()
    {
        $prefs = BrewerySharingSettings::defaultNotSharing();
        $this->assertFalse($prefs->isSharingTapList());
        $prefs->shareTapList();
        $this->assertTrue($prefs->isSharingTapList());
        $prefs->unshareTapList();
        $this->assertFalse($prefs->isSharingTapList());
    }
}
