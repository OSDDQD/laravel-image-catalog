@if (Menu::getCollection()->has('ClientSidebarMenu'))
{{ Menu::get('ClientSidebarMenu')->asUl(['class' => 'payment']); }}
@endif