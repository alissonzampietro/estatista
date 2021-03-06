<?php

namespace PODEntender\Infrastructure\Application\StaticSite;

use PODEntender\Application\Service\Post\FetchExistentCategoryNames;
use PODEntender\Application\Service\Post\FetchLatestEpisodes;
use PODEntender\Application\Service\Post\FetchRecommendationsForPost;
use PODEntender\Infrastructure\Domain\Factory\JigsawPostFactory;
use TightenCo\Jigsaw\Jigsaw;
use TightenCo\Jigsaw\PageVariable;

class JigsawDecoratePagesAfterCollections implements JigsawEventHandler
{
    const NUMBER_OF_RECOMMENDED_EPISODES = 3;

    public function handle(Jigsaw $jigsaw): void
    {
        $factory = $jigsaw->app->make(JigsawPostFactory::class);
        $recommendationsService = $jigsaw->app->make(FetchRecommendationsForPost::class);
        $latestEpisodeService = $jigsaw->app->make(FetchLatestEpisodes::class);
        $categoryNames = $jigsaw->app->make(FetchExistentCategoryNames::class)->execute();

        $latestEpisodesPerCategory = [];
        foreach ($categoryNames as $categoryName) {
            $latestEpisodesPerCategory[$categoryName] = $latestEpisodeService->execute(3, $categoryName);
        }

        $jigsaw->setConfig('lastEpisode', $latestEpisodeService->execute(1, null)->first());
        $jigsaw->setConfig('latestEpisodesPerCategory', $latestEpisodesPerCategory);

        $jigsaw->getCollection('episodes')
            ->each(function (PageVariable $page) use ($factory, $recommendationsService) {
                // AudioEpisode
                $page->audioEpisode = $factory->newAudioEpisodeFromPageVariable($page);

                // Recommended episodes
                $recommendedEpisodes = $recommendationsService->execute(
                    $page->audioEpisode,
                    self::NUMBER_OF_RECOMMENDED_EPISODES
                );

                $page->recommendations = $recommendedEpisodes;
            });
    }
}
