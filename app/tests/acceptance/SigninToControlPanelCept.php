<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('sign in to control panel');
$I->amOnPage('/login');
$I->fillField('login', 'admin');
$I->fillField('password', 'admin');
$I->click('Войти');
$I->amOnPage('/manager');
$I->see('Панель управления');
