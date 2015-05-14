<article id="album" class="section-wrapper clearfix" data-custom-background-img="{{ URL::Route('home') }}/assets/img/client/default_bg.jpg">
    <div class="content-wrapper clearfix">
        <div class="col-sm-11 col-md-10 pull-right">

            {{--<h1 class="section-title">{{ $category->title }}</h1>--}}

            <!-- grid -->
            <section class="grid row clearfix clearfix-for-2cols">
                @foreach($entity as $image)
                <!-- grid item -->
                <div class="grid-item col-md-3">
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
                {{ $entity->links(); }}
            </section><!-- end: grid -->

        </div><!-- .col-sm-11 -->
    </div><!-- .content-wrapper -->
</article><!-- .section-wrapper -->