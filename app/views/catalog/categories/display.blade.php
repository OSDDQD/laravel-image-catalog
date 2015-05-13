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
                            {{--<p><a href="index.html" onclick="populate_and_open_modal(event, 'modal-content-2');" class="btn btn-outline-inverse btn-sm">read more</a></p>--}}

                            {{--<div class="content-to-populate-in-modal" id="modal-content-2">--}}
                                {{--<h1>Lorem Ipsum</h1>--}}
                                {{--<p><img data-img-src="assets/images/other_images/transp-image1.png" class="lazy rounded_border hover_effect pull-left" alt="Lorem Ipsum">Etiam at ligula sit amet arcu laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. <a href="index.html#">Suspendisse molestie lorem odio</a>, sit amet. </p>--}}
                                {{--<p>Laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio, sit amet.</p>--}}
                                {{--<p>Suspendisse molestie lorem odio, sit amet. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio test.</p>--}}
                            {{--</div><!-- #modal-content-2 -->--}}
                        </div>
                    </div><!-- .item -->

                    <div class="item">
                        <div class="carousel-text-content">
                            <img src="assets/images/other_images/transp-image7.png" class="icon" alt="Lorem Ipsum">
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