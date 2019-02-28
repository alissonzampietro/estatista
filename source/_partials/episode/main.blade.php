<article class="episode">
    @include('_partials.episode.cover.main')
    @include('_partials.episode.player')
    <section class="episode__content">
        @yield('content')
    </section>
    @include('_partials.episode.recommendations.main', [
        'title' => 'Pra você entender mais ainda',
        'recommendations' => $page->recommended ?? []
    ])
</article>
