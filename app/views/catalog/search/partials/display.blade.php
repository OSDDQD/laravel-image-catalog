<article id="search" data-overlay="true" data-overlay-opacity="1" class="section-wrapper clearfix" data-custom-background-img="{{ URL::Route('home') }}/assets/img/client/default_bg.jpg">
    <div class="content-wrapper clearfix">
        <div class="col-sm-11 col-md-10 pull-right">

            <h4 class="section-title">{{ Lang::get('search.categories') }}</h4>
            <!-- grid -->
            <section class="grid row clearfix clearfix-for-1cols">
                @if(empty($categories))
                    {{ Lang::get('search.err.search_error') }}
                @else
                    @foreach($categories as $category)
                        <!-- grid item -->
                        <div class="grid-item col-md-3 preview-width">
                            <div class="item-content clearfix">
                                <h4>{{ $category->title }}</h4>
                                <p>{{ $category->description }} <br />
                                    <a href="{{ URL::Route('home') }}/#{{ $category->id }}">{{ $category->title }}</a>
                                </p>
                            </div><!-- end: .item-content -->
                        </div><!-- end: .grid-item -->
                    @endforeach
                @endif
            </section><!-- end: grid -->
            <h4 class="section-title">{{ Lang::get('search.albums') }}</h4>
            <!-- grid -->
            <section class="grid row clearfix clearfix-for-1cols">
                @if(empty($albums))
                    {{ Lang::get('search.err.search_error') }}
                @else
                    <div class="item">
                        <div class="carousel-text-content">
                            <section class="feature-columns row clearfix">
                                @foreach($albums as $album)
                                    <article class="feature-col col-md-4">
                                        <a href="{{ \URL::Route('album.show', ['id' => $album->id]) }}" class="thumbnail linked">
                                            <div class="image-container">
                                                <img src="{{ \URL::Route('preview.managed', ['object' => 'album', 'mode' => 'thumb', 'format' => 'jpg', 'file' => $album->image]) }}" class="item-thumbnail" />
                                            </div>
                                            <div class="caption">
                                                <h5>{{ $album->title }}</h5>
                                                <p>{{ $album->description }}</p>
                                            </div><!-- .caption -->
                                        </a><!-- .thumbnail -->
                                    </article>
                                @endforeach
                            </section>
                        </div>
                    </div><!-- .item -->
                @endif
            </section><!-- end: grid -->
            <h4 class="section-title">{{ Lang::get('search.images') }}</h4>
            <!-- grid -->
            <section class="grid row clearfix clearfix-for-1cols">
                @if(empty($images))
                    {{ Lang::get('search.err.search_error') }}
                @else
                    @foreach($images as $image)
                        <!-- grid item -->
                        <div class="grid-item col-md-3 preview-width">
                            <div class="item-content clearfix">
                                <section class="feature-columns row clearfix">
                                    @foreach($images as $image)
                                        <!-- grid item -->
                                        <div class="grid-item col-md-3 preview-width">
                                            <div class="item-content clearfix">
                                                <div class="image">
                                                    <a class="viewimg" title="{{ $image->description }}" href="{{ \URL::Route('preview.managed', ['object' => 'image', 'mode' => 'full', 'format' => 'jpg', 'file' => $image->image]) }}">
                                                        <img src="{{ \URL::Route('preview.managed', ['object' => 'image', 'mode' => 'show', 'format' => 'jpg', 'file' => $image->image]) }}" />
                                                    </a>
                                                    <div class="image-title">
                                                        {{ $image->title }}
                                                    </div>
                                                </div>
                                            </div><!-- end: .item-content -->
                                        </div><!-- end: .grid-item -->
                                    @endforeach
                                </section>
                            </div><!-- end: .item-content -->
                        </div><!-- end: .grid-item -->
                    @endforeach
                @endif
            </section><!-- end: grid -->
        </div><!-- .col-sm-11 -->
    </div><!-- .content-wrapper -->
</article><!-- .section-wrapper -->