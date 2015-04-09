@foreach($entity as $category)
    <article id="{{ $category->id }}" class="section-wrapper clearfix" data-custom-background-img="assets/images/other_images/bg6.jpg">
        <div class="content-wrapper clearfix">

            <div id="features-carousel" class="carousel slide with-title-indicators max-height" data-height-percent="70" data-ride="carousel">

                <!-- Indicators - slide navigation -->
                <ol class="carousel-indicators title-indicators">
                    <li data-target="#features-carousel" data-slide-to="0" class="active">Lorem Ipsum</li>
                    <li data-target="#features-carousel" data-slide-to="1">Suspendisse</li>
                    <li data-target="#features-carousel" data-slide-to="2">Maecenas</li>
                    <li data-target="#features-carousel" data-slide-to="3">Scelerisque</li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    <div class="item active">
                        <div class="carousel-text-content">
                            <img src="assets/images/other_images/transp-image1.png" class="icon" alt="Lorem Ipsum">
                            <h2 class="title">Lorem Ipsum</h2>
                            <p>Suspendisse molestie lorem odio, sit amet. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio.</p>
                            <p><a href="index.html" onclick="populate_and_open_modal(event, 'modal-content-2');" class="btn btn-outline-inverse btn-sm">read more</a></p>

                            <div class="content-to-populate-in-modal" id="modal-content-2">
                                <h1>Lorem Ipsum</h1>
                                <p><img data-img-src="assets/images/other_images/transp-image1.png" class="lazy rounded_border hover_effect pull-left" alt="Lorem Ipsum">Etiam at ligula sit amet arcu laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. <a href="index.html#">Suspendisse molestie lorem odio</a>, sit amet. </p>
                                <p>Laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio, sit amet.</p>
                                <p>Suspendisse molestie lorem odio, sit amet. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio test.</p>
                            </div><!-- #modal-content-2 -->
                        </div>
                    </div><!-- .item -->

                    <div class="item">
                        <div class="carousel-text-content">
                            <img src="assets/images/other_images/transp-image6.png" class="icon" alt="Lorem Ipsum">
                            <h2 class="title">Suspendisse molestie</h2>
                            <p>Etiam at ligula sit amet arcu laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Duis dictum lorem metus.</p>
                            <p><a href="index.html" onclick="populate_and_open_modal(event, 'modal-content-3');" class="btn btn-outline-inverse btn-sm">read more</a></p>

                            <div class="content-to-populate-in-modal" id="modal-content-3">
                                <h1>Suspendisse molestie</h1>
                                <p><img data-img-src="assets/images/other_images/transp-image6.png" class="lazy rounded_border hover_effect pull-left" alt="Lorem Ipsum">Etiam at ligula sit amet arcu laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. <a href="index.html#">Suspendisse molestie lorem odio</a>, sit amet. </p>
                                <p>Laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio, sit amet.</p>
                                <p>Suspendisse molestie lorem odio, sit amet. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio test.</p>
                            </div><!-- #modal-content-3 -->
                        </div>
                    </div><!-- .item -->

                    <div class="item">
                        <div class="carousel-text-content">
                            <img src="assets/images/other_images/transp-image7.png" class="icon" alt="Lorem Ipsum">
                            <h2 class="title">Maecenas id dolor</h2>
                            <p>Fusce erat augue, fermentum sit amet congue a, ullamcorper ac enim. Maecenas id dolor imperdiet, mollis felis ut, pellentesque ante. Sed id congue arcu. Nulla eget commodo sem. Suspendisse suscipit, sem ac.</p>
                            <p><a href="index.html" onclick="populate_and_open_modal(event, 'modal-content-4');" class="btn btn-outline-inverse btn-sm">read more</a></p>

                            <div class="content-to-populate-in-modal" id="modal-content-4">
                                <h1>Maecenas id dolor</h1>
                                <p><img data-img-src="assets/images/other_images/transp-image7.png" class="lazy rounded_border hover_effect pull-left" alt="Lorem Ipsum">Etiam at ligula sit amet arcu laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. <a href="index.html#">Suspendisse molestie lorem odio</a>, sit amet. </p>
                                <p>Laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio, sit amet.</p>
                                <p>Suspendisse molestie lorem odio, sit amet. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio test.</p>
                            </div><!-- #modal-content-4 -->
                        </div>
                    </div><!-- .item -->

                    <div class="item">
                        <div class="carousel-text-content">
                            <img src="assets/images/other_images/transp-image4.png" class="icon" alt="Lorem Ipsum">
                            <h2 class="title">Sed scelerisque</h2>
                            <p>Aenean a est fringilla, malesuada eros vel, condimentum augue. Sed lorem sapien, vestibulum quis nisl volutpat, fermentum adipiscing massa. Cras ac faucibus nisl. Proin ac convallis sapien. </p>
                            <p><a href="index.html" onclick="populate_and_open_modal(event, 'modal-content-5');" class="btn btn-outline-inverse btn-sm">read more</a></p>

                            <div class="content-to-populate-in-modal" id="modal-content-5">
                                <h1>Sed scelerisque</h1>
                                <p><img data-img-src="assets/images/other_images/transp-image4.png" class="lazy rounded_border hover_effect pull-left" alt="Lorem Ipsum">Etiam at ligula sit amet arcu laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. <a href="index.html#">Suspendisse molestie lorem odio</a>, sit amet. </p>
                                <p>Laoreet consequat. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio, sit amet.</p>
                                <p>Suspendisse molestie lorem odio, sit amet. Duis dictum lorem metus, vitae dapibus risus imperdiet nec. Suspendisse molestie lorem odio test.</p>
                            </div><!-- #modal-content-5 -->
                        </div>
                    </div><!-- .item -->

                </div><!-- .carousel-inner -->

                <!-- Controls -->
                <a class="left carousel-control" href="index.html#features-carousel" data-slide="prev"></a>
                <a class="right carousel-control" href="index.html#features-carousel" data-slide="next"></a>

            </div><!-- #about-carousel -->

        </div><!-- .content-wrapper -->
    </article><!-- .section-wrapper -->
@endforeach