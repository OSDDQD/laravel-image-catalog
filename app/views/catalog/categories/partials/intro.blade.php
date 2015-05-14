@foreach($intro as $data)
<article id="intro" class="section-wrapper clearfix" data-custom-background-img="{{ \URL::Route('preview.managed', ['object' => 'category', 'mode' => 'background', 'format' => 'jpg', 'file' => $data->image]) }}">
	<div class="content-wrapper clearfix wow fadeInDown" data-wow-delay="0.3s">
		<div class="col-sm-10 col-md-9 pull-right">

			<section class="feature-text">
				<h1>{{ $data->title  }}</h1>
				<p>{{ $data->description }}</p>
			</section>

		</div><!-- .col-sm-10 -->
	</div><!-- .content-wrapper -->
</article><!-- .section-wrapper -->
@endforeach