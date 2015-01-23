<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('log in as regular user');
$I->amOnPage('/login');
$I->fillField('login', 'admin');
$I->fillField('password', 'admin');
$I->click('Войти');
$I->amOnPage('/login');
$I->see('Главная');
