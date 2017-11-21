<?php

namespace Inhere\Asset\Tests;

use Inhere\Asset\Interfaces\AssetBagInterface;
use PHPUnit\Framework\TestCase;
use Inhere\Asset\AssetManager;

/**
 * @covers AssetManager
 */
class AssetManagerTest extends TestCase
{
    /**
     * @var AssetManager
     */
    protected $am;

    protected function createManager($new = false)
    {
        if ($new || !$this->am) {
            $this->am = new AssetManager();
        }

        return $this->am;
    }

    /**
     *
     */
    public function testCss()
    {
        $am = $this->createManager();

        $am->addCss('assets/app.css');
        $am->addCss('https://cdn.bootcss.com/pure/1.0.0/grids-core-min.css');

        $this->assertTrue($am->has('css'));
        $this->assertEquals(null, $am->get('no-exists'));

        if ($bag = $am->get('css')) {
            $this->assertInstanceOf(AssetBagInterface::class, $bag);
            $this->assertNotEquals(null, $bag);
            $this->assertEquals(1, $bag->count());
            $this->assertEquals('css', $bag->getName());
        }

        $this->expectException(\RuntimeException::class);
        $am->get('no-exist', true);

        $am->addJs('assets/app.js');
        $this->assertTrue($am->has('js'));
    }
}
