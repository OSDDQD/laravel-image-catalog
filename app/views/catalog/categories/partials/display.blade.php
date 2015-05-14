@include('catalog.categories.partials.intro')
@foreach($entity as $category)
    <article id="{{ $category->id }}" class="section-wrapper clearfix" data-custom-background-img="{{ \URL::Route('preview.managed', ['object' => 'category', 'mode' => 'background', 'format' => 'jpg', 'file' => $category->image]) }}">
        <div class="content-wrapper clearfix">
            <h2 class="headline">{{ $category->title }}</h2>
            <div id="{{ $category->id }}-carousel" class="carousel slide max-height" data-height-percent="70" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    <div class="item active">
                        <div class="carousel-text-content">
                            <p>{{ $category->description }}</p>
                        </div>
                    </div><!-- .item -->

                    <div class="item">
                        <div class="carousel-text-content">
                            <section class="feature-columns row clearfix">
                                @foreach($category->album as $album)
                                    <article class="feature-col col-md-4">
                                        <a href="{{ \URL::Route('album.show', ['id' => $album->id]) }}" class="thumbnail linked">
                                            <div class="image-container">
                                                <img data-img-src="{{ \URL::Route('preview.managed', ['object' => 'album', 'mode' => 'thumb', 'format' => 'jpg', 'file' => $album->image]) }}" class="lazy item-thumbnail" />
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


                </div><!-- .carousel-inner -->

                <!-- Controls -->
                <a class="left carousel-control" href="#{{ $category->id }}-carousel" data-slide="prev"></a>
                <a class="right carousel-control" href="#{{ $category->id }}-carousel" data-slide="next"></a>

            </div><!-- #about-carousel -->

        </div><!-- .content-wrapper -->
    </article><!-- .section-wrapper -->
@endforeach