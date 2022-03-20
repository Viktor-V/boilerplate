<?php

declare(strict_types=1);

namespace UI\Http\Common\EventSubscriber;

use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Generator;

class PaginateSubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event): void
    {
        if (!$event->target instanceof Generator) {
            return;
        }

        $objects = [];
        foreach ($event->target as $object) {
            $objects[] = $object;
        }

        $event->items = $objects;
        $event->count = $event->target->getReturn();
        $event->stopPropagation();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 1]
        ];
    }
}
