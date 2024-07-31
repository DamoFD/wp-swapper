<?php

namespace WP_Swapper\Tests;

use WP_Swapper\Component_Router;
use WP_Swapper\Handlers\Buffer_Handler;
use Mockery;

class Component_Router_Test extends TestCase {
    /**
    * Create mock of bot detector
    *
    * @since 0.0.1
    *
    * @param bool $isBot true if User Agent is a search engine bot
    *
    * @return BotDetector
    */
    private function mockBotDetector($isBot)
    {
        $component_router = Mockery::mock('WP_Swapper\Component_Router')->makePartial();
        $component_router->shouldReceive('is_bot')->andReturn($isBot);
        return $component_router;
    }

    /**
    * Test constructor method.
    * Method should hook into template_redirect and
    * wp_print_footer_scripts.
    *
    * @since 0.0.1
    */
    public function testConstructor() {
        $component_router = new Component_Router();

        $this->assertNotFalse(has_action('template_redirect', [$component_router, 'start_buffer']));
        $this->assertNotFalse(has_action('wp_print_footer_scripts', [$component_router, 'process_content']));
    }

    /**
    * Test start buffer method
    *
    * @since 0.0.1
    */
    public function testStartBuffer() {
        $component_router = new Component_Router();

        $component_router->start_buffer();

        echo 'test content';

        $this->assertTrue(ob_get_length() > 0);

        ob_end_clean();
    }
}
