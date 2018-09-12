<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
require_once(__DIR__ . '/vendor/fortune.php');

/**
 * Class FortunePlugin
 * @package Grav\Plugin
 */
class FortunePlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main event we are interested in
        $this->enable([
            'onPagesInitialized' => ['onPagesInitialized', 0]
        ]);
    }

    /**
     * Do some work for this event, full details of events can be found
     * on the learn site: http://learn.getgrav.org/plugins/event-hooks
     *
     * @param Event $e
     */
    public function onPagesInitialized(Event $e)
    {
        $config = $this->grav['config'];
        $fn = $this->resolveFolder($config->get('plugins.fortune.data'));
        if ( (! is_null($fn)) && (is_dir($fn)) )
        {
            $f = new \Fortune;
            $fortune = $f->quoteFromDir($fn.'/');
            $this->grav['twig']->twig_vars['fortune'] = $fortune;
        }
    }

    private function resolveFolder($fn)
    {
        if (strpos($fn, '://') !== false ){
            $path = $this->grav['locator']->findResource($fn, true);
        } else {
            $path = $this->grav['page']->path() . DS . $fn;
        }
        if (file_exists($path)) {
            return $path;
        }
        return null;        
    }
}
