<?php

class MaterialsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        Material::truncate();
        MaterialTranslation::truncate();

        for ($i = 1; $i <= 5; $i++) {
            Material::create([
                'type' => Material::TYPE_PAGE,
                'is_visible' => 1,
                'ru' => [
                    'title' => 'Страница' . $i . ' (рус)',
                    'text'  => '<p>Текст страницы' . $i . ' (рус)</p></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare neque magna, non ultricies diam lobortis ac. Morbi feugiat, ipsum at sagittis maximus, tortor sapien sodales velit, eget imperdiet nisl quam eu lacus. Nam consectetur, metus non sagittis tempor, enim velit condimentum dui, a sagittis dui sapien interdum tellus. Ut in lacus congue mi congue laoreet. Fusce iaculis odio id turpis tempus dictum. Nullam ultrices erat vitae turpis ullamcorper viverra. Vestibulum condimentum, nisl sit amet scelerisque tincidunt, diam erat tincidunt nunc, vitae eleifend arcu libero ut sem. Integer commodo semper sagittis. Donec ac purus eros. Maecenas sagittis dolor ac facilisis congue. Donec finibus aliquam metus, sed commodo odio dictum vel.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris faucibus blandit augue ac viverra. Donec lobortis porttitor odio quis luctus. Phasellus ac ante sodales, porttitor urna volutpat, vulputate diam. Ut finibus molestie lorem, at mattis magna tempus sed. Sed ut mattis lacus. Suspendisse varius gravida finibus.</p>',
                ],
                'uz' => [
                    'title' => 'Страница' . $i . ' (узб)',
                    'text'  => '<p>Текст страницы' . $i . ' (узб)</p></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare neque magna, non ultricies diam lobortis ac. Morbi feugiat, ipsum at sagittis maximus, tortor sapien sodales velit, eget imperdiet nisl quam eu lacus. Nam consectetur, metus non sagittis tempor, enim velit condimentum dui, a sagittis dui sapien interdum tellus. Ut in lacus congue mi congue laoreet. Fusce iaculis odio id turpis tempus dictum. Nullam ultrices erat vitae turpis ullamcorper viverra. Vestibulum condimentum, nisl sit amet scelerisque tincidunt, diam erat tincidunt nunc, vitae eleifend arcu libero ut sem. Integer commodo semper sagittis. Donec ac purus eros. Maecenas sagittis dolor ac facilisis congue. Donec finibus aliquam metus, sed commodo odio dictum vel.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris faucibus blandit augue ac viverra. Donec lobortis porttitor odio quis luctus. Phasellus ac ante sodales, porttitor urna volutpat, vulputate diam. Ut finibus molestie lorem, at mattis magna tempus sed. Sed ut mattis lacus. Suspendisse varius gravida finibus.</p>',
                ],
                'en' => [
                    'title' => 'Страница' . $i . ' (англ)',
                    'text'  => '<p>Текст страницы' . $i . ' (англ)</p></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare neque magna, non ultricies diam lobortis ac. Morbi feugiat, ipsum at sagittis maximus, tortor sapien sodales velit, eget imperdiet nisl quam eu lacus. Nam consectetur, metus non sagittis tempor, enim velit condimentum dui, a sagittis dui sapien interdum tellus. Ut in lacus congue mi congue laoreet. Fusce iaculis odio id turpis tempus dictum. Nullam ultrices erat vitae turpis ullamcorper viverra. Vestibulum condimentum, nisl sit amet scelerisque tincidunt, diam erat tincidunt nunc, vitae eleifend arcu libero ut sem. Integer commodo semper sagittis. Donec ac purus eros. Maecenas sagittis dolor ac facilisis congue. Donec finibus aliquam metus, sed commodo odio dictum vel.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris faucibus blandit augue ac viverra. Donec lobortis porttitor odio quis luctus. Phasellus ac ante sodales, porttitor urna volutpat, vulputate diam. Ut finibus molestie lorem, at mattis magna tempus sed. Sed ut mattis lacus. Suspendisse varius gravida finibus.</p>',
                ],
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            Material::create([
                'type' => Material::TYPE_NEWS,
                'is_visible' => 1,
                'ru' => [
                    'title' => 'Новостной материал' . $i . ' (рус)',
                    'text'  => '<p>Текст новости' . $i . ' (рус)</p></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare neque magna, non ultricies diam lobortis ac. Morbi feugiat, ipsum at sagittis maximus, tortor sapien sodales velit, eget imperdiet nisl quam eu lacus. Nam consectetur, metus non sagittis tempor, enim velit condimentum dui, a sagittis dui sapien interdum tellus. Ut in lacus congue mi congue laoreet. Fusce iaculis odio id turpis tempus dictum. Nullam ultrices erat vitae turpis ullamcorper viverra. Vestibulum condimentum, nisl sit amet scelerisque tincidunt, diam erat tincidunt nunc, vitae eleifend arcu libero ut sem. Integer commodo semper sagittis. Donec ac purus eros. Maecenas sagittis dolor ac facilisis congue. Donec finibus aliquam metus, sed commodo odio dictum vel.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris faucibus blandit augue ac viverra. Donec lobortis porttitor odio quis luctus. Phasellus ac ante sodales, porttitor urna volutpat, vulputate diam. Ut finibus molestie lorem, at mattis magna tempus sed. Sed ut mattis lacus. Suspendisse varius gravida finibus.</p>',
                ],
                'uz' => [
                    'title' => 'Новостной материал' . $i . ' (узб)',
                    'text'  => '<p>Текст новости' . $i . ' (узб)</p></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare neque magna, non ultricies diam lobortis ac. Morbi feugiat, ipsum at sagittis maximus, tortor sapien sodales velit, eget imperdiet nisl quam eu lacus. Nam consectetur, metus non sagittis tempor, enim velit condimentum dui, a sagittis dui sapien interdum tellus. Ut in lacus congue mi congue laoreet. Fusce iaculis odio id turpis tempus dictum. Nullam ultrices erat vitae turpis ullamcorper viverra. Vestibulum condimentum, nisl sit amet scelerisque tincidunt, diam erat tincidunt nunc, vitae eleifend arcu libero ut sem. Integer commodo semper sagittis. Donec ac purus eros. Maecenas sagittis dolor ac facilisis congue. Donec finibus aliquam metus, sed commodo odio dictum vel.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris faucibus blandit augue ac viverra. Donec lobortis porttitor odio quis luctus. Phasellus ac ante sodales, porttitor urna volutpat, vulputate diam. Ut finibus molestie lorem, at mattis magna tempus sed. Sed ut mattis lacus. Suspendisse varius gravida finibus.</p>',
                ],
                'en' => [
                    'title' => 'Новостной материал' . $i . ' (англ)',
                    'text'  => '<p>Текст новости' . $i . ' (англ)</p></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ornare neque magna, non ultricies diam lobortis ac. Morbi feugiat, ipsum at sagittis maximus, tortor sapien sodales velit, eget imperdiet nisl quam eu lacus. Nam consectetur, metus non sagittis tempor, enim velit condimentum dui, a sagittis dui sapien interdum tellus. Ut in lacus congue mi congue laoreet. Fusce iaculis odio id turpis tempus dictum. Nullam ultrices erat vitae turpis ullamcorper viverra. Vestibulum condimentum, nisl sit amet scelerisque tincidunt, diam erat tincidunt nunc, vitae eleifend arcu libero ut sem. Integer commodo semper sagittis. Donec ac purus eros. Maecenas sagittis dolor ac facilisis congue. Donec finibus aliquam metus, sed commodo odio dictum vel.</p><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris faucibus blandit augue ac viverra. Donec lobortis porttitor odio quis luctus. Phasellus ac ante sodales, porttitor urna volutpat, vulputate diam. Ut finibus molestie lorem, at mattis magna tempus sed. Sed ut mattis lacus. Suspendisse varius gravida finibus.</p>',
                ],
            ]);
        }
	}

}
