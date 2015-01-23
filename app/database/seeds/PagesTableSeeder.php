<?php

use Structure\Page;
use Structure\PageTranslation;

class PagesTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        Page::truncate();
        PageTranslation::truncate();

        $page1 = with(new Page([
            'position' => 1,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 1,
            'is_visible' => true,
            'is_home' => true,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 1 (рус)',
                'keywords' => 'ключевые слова страницы 1 рус',
                'description' => 'Описание страницы 1 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 1 (узб)',
                'keywords' => 'ключевые слова страницы 1 узб',
                'description' => 'Описание страницы 1 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 1 (англ)',
                'keywords' => 'ключевые слова страницы 1 англ',
                'description' => 'Описание страницы 1 англ в meta-теге',
            ],
        ]))->setAsRoot();

        $page1_1 = with(new Page([
            'position' => 1,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 1,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 1-1 (рус)',
                'keywords' => 'ключевые слова страницы 1-1 рус',
                'description' => 'Описание страницы 1-1 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 1-1 (узб)',
                'keywords' => 'ключевые слова страницы 1-1 узб',
                'description' => 'Описание страницы 1-1 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 1-1 (англ)',
                'keywords' => 'ключевые слова страницы 1-1 англ',
                'description' => 'Описание страницы 1-1 англ в meta-теге',
            ],
        ]))->setChildOf($page1);

        $page1_2 = with(new Page([
            'position' => 2,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 1,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 1-2 (рус)',
                'keywords' => 'ключевые слова страницы 1-2 рус',
                'description' => 'Описание страницы 1-2 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 1-2 (узб)',
                'keywords' => 'ключевые слова страницы 1-2 узб',
                'description' => 'Описание страницы 1-2 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 1-2 (англ)',
                'keywords' => 'ключевые слова страницы 1-2 англ',
                'description' => 'Описание страницы 1-2 англ в meta-теге',
            ],
        ]))->setChildOf($page1);

        $page2 = with(new Page([
            'position' => 2,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 2,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 2 (рус)',
                'keywords' => 'ключевые слова страницы 2 рус',
                'description' => 'Описание страницы 2 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 2 (узб)',
                'keywords' => 'ключевые слова страницы 2 узб',
                'description' => 'Описание страницы 2 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 2 (англ)',
                'keywords' => 'ключевые слова страницы 2 англ',
                'description' => 'Описание страницы 2 англ в meta-теге',
            ],
        ]))->setAsRoot();

        $page3 = with(new Page([
            'position' => 3,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 3,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 3 (рус)',
                'keywords' => 'ключевые слова страницы 3 рус',
                'description' => 'Описание страницы 3 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 3 (узб)',
                'keywords' => 'ключевые слова страницы 3 узб',
                'description' => 'Описание страницы 3 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 3 (англ)',
                'keywords' => 'ключевые слова страницы 3 англ',
                'description' => 'Описание страницы 3 англ в meta-теге',
            ],
        ]))->setAsRoot();

        $page3_1 = with(new Page([
            'position' => 1,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 3,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 3-1 (рус)',
                'keywords' => 'ключевые слова страницы 3-1 рус',
                'description' => 'Описание страницы 3-1 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 3-1 (узб)',
                'keywords' => 'ключевые слова страницы 3-1 узб',
                'description' => 'Описание страницы 3-1 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 3-1 (англ)',
                'keywords' => 'ключевые слова страницы 3-1 англ',
                'description' => 'Описание страницы 3-1 англ в meta-теге',
            ],
        ]))->setChildOf($page3);

        $page3_2 = with(new Page([
            'position' => 2,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 3,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 3-2 (рус)',
                'keywords' => 'ключевые слова страницы 3-2 рус',
                'description' => 'Описание страницы 3-2 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 3-2 (узб)',
                'keywords' => 'ключевые слова страницы 3-2 узб',
                'description' => 'Описание страницы 3-2 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 3-2 (англ)',
                'keywords' => 'ключевые слова страницы 3-2 англ',
                'description' => 'Описание страницы 3-2 англ в meta-теге',
            ],
        ]))->setChildOf($page3);

        $page3_3 = with(new Page([
            'position' => 3,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 3,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 3-3 (рус)',
                'keywords' => 'ключевые слова страницы 3-3 рус',
                'description' => 'Описание страницы 3-3 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 3-3 (узб)',
                'keywords' => 'ключевые слова страницы 3-3 узб',
                'description' => 'Описание страницы 3-3 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 3-3 (англ)',
                'keywords' => 'ключевые слова страницы 3-3 англ',
                'description' => 'Описание страницы 3-3 англ в meta-теге',
            ],
        ]))->setChildOf($page3);

        $page4 = with(new Page([
            'position' => 4,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 4,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 4 (рус)',
                'keywords' => 'ключевые слова страницы 4 рус',
                'description' => 'Описание страницы 4 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 4 (узб)',
                'keywords' => 'ключевые слова страницы 4 узб',
                'description' => 'Описание страницы 4 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 4 (англ)',
                'keywords' => 'ключевые слова страницы 4 англ',
                'description' => 'Описание страницы 4 англ в meta-теге',
            ],
        ]))->setAsRoot();

        $page5 = with(new Page([
            'position' => 5,
            'content_type' => Page::CONTENT_TYPE_MATERIAL,
            'content' => 5,
            'is_visible' => true,
            'is_home' => false,
            'template' => 'client_wslider',
            'show_title' => Page::SHOW_TITLE_PAGE,
            'ru' => [
                'title' => 'Страница 5 (рус)',
                'keywords' => 'ключевые слова страницы 5 рус',
                'description' => 'Описание страницы 5 рус в meta-теге',
            ],
            'uz' => [
                'title' => 'Страница 5 (узб)',
                'keywords' => 'ключевые слова страницы 5 узб',
                'description' => 'Описание страницы 5 узб в meta-теге',
            ],
            'en' => [
                'title' => 'Страница 5 (англ)',
                'keywords' => 'ключевые слова страницы 5 англ',
                'description' => 'Описание страницы 5 англ в meta-теге',
            ],
        ]))->setAsRoot();

    }

}
