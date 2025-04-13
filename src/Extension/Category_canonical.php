<?php
/**
 * @version      2.0.2 13.04.2025
 * @author       MAXXmarketing GmbH
 * @package      Jshopping
 * @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
 * @license      GNU/GPL
 */

namespace Joomla\Plugin\Jshoppingproducts\Category_canonical\Extension;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Component\Jshopping\Site\Helper\Helper;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Uri\Uri;
use function defined;

defined('_JEXEC') or die('Restricted access');

class Category_canonical extends CMSPlugin implements SubscriberInterface
{
    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return  array
     *
     * @since   4.0.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onAfterLoadCategory' => 'onAfterLoadCategory'
        ];
    }

    /**
     * @param   Event  $event
     * @see \Joomla\Component\Jshopping\Site\Controller\CategoryController::view
     *
     * @return void
     */
    function onAfterLoadCategory(Event $event): void
    {
        [$category, $user] = array_values($event->getArguments());

        $document = $this->getApplication()->getDocument();
		$uri = Uri::getInstance();
        $liveurlhost = $uri->toString(['scheme','host', 'port']);
        $url = $liveurlhost.Helper::SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$category->category_id);
        $document->addCustomTag('<link rel="canonical" href="'.$url.'"/>');        
    }
}