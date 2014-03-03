<?php

/*
|--------------------------------------------------------------------------
| Application Event Handlers
|--------------------------------------------------------------------------
|
*/

//User Events
Event::listen('user.registered', 'UserListener@registered');

//Order Events
Event::listen('order.placed', 'OrderListener@placed');
Event::listen('order.verified', 'OrderListener@verified');
Event::listen('order.confirm', 'OrderListener@confirm');