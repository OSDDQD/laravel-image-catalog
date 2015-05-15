<article id="{{ $category->id }}" data-overlay="true" data-overlay-opacity="1" class="section-wrapper clearfix" data-custom-background-img="{{ \URL::Route('preview.managed', ['object' => 'category', 'mode' => 'background', 'format' => 'jpg', 'file' => $category->image]) }}">
    <div class="content-wrapper clearfix">
        <div class="col-sm-11 col-md-10 pull-right">

            <h1 class="section-title">{{ $category->title }}</h1>
            {{--{{ $category }}--}}
            <!-- grid -->
            <section class="grid row clearfix clearfix-for-2cols">
                @foreach($entity as $image)
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
                {{ $entity->links(); }}
            </section><!-- end: grid -->
        </div><!-- .col-sm-11 -->
    </div><!-- .content-wrapper -->
</article><!-- .section-wrapper -->