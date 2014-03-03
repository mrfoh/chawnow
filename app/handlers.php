<?php

/*
|--------------------------------------------------------------------------
| Application Event Handlers
|--------------------------------------------------------------------------
|
*/

Event::listen('user.registered', 'UserListener@registered');

Event::listen('order.placed', 'OrderListener@placed');
Event::listen('order.verified', 'OrderListener@verified');
Event::listen('order.confirm', 'OrderListener@confirm');