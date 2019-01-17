<?php

use PODEntender\EventHandler\Episode\GenerateRecommendedEpisodeListAfterCollect;
use PODEntender\EventHandler\Sitemap\GenerateSitemapXml;

/** @var $container \Illuminate\Container\Container */
/** @var $events \TightenCo\Jigsaw\Events\EventBus */

/**
 * You can run custom code at different stages of the build process by
 * listening to the 'beforeBuild', 'afterCollections', and 'afterBuild' events.
 *
 * For example:
 *
 * $events->beforeBuild(function (Jigsaw $jigsaw) {
 *     // Your code here
 * });
 */

$events->afterCollections([
    $container->make(GenerateRecommendedEpisodeListAfterCollect::class),
]);

$events->afterBuild([
    $container->make(GenerateSitemapXml::class),
]);
