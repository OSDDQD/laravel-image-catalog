<section class="yellow">
    <div class="middle">
        <div class="news">
            <p>новости</p>
        </div>
        <div class="b-carousel">
            <div class="b-carousel-button-left"></div>
            <div class="b-carousel-button-right"></div>
            <div class="h-carousel-wrapper">
                <div class="h-carousel-items" style="left: 0px;">
                    @foreach($latestNews as $news)
                        <div class="b-carousel-block">
                            <h2><a href="{{ URL::Route('materials.news.display', ['id' => $news->id]) }}">{{ $news->title }}</a></h2>
                            <time>{{ date('d.m.Y', strtotime($news->created_at)) }}</time>
                            <p>{{ mb_substr(strip_tags($news->text), 0, 175, 'UTF-8') }}</p>
                            <a href="{{ URL::Route('materials.news.display', ['id' => $news->id]) }}">Далее...</a>
                            <div class="clear"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>