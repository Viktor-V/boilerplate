<?php

return [
    \App\Core\CoreModule::class,
    \App\ErrorPage\ErrorPageModule::class,
    \App\Common\Blog\BlogModule::class,
    \App\Contact\ContactModule::class,
    \App\AntiSpam\AntiSpamModule::class,
    \App\Language\LanguageModule::class,

    \App\AdminSecurity\AdminSecurityModule::class,
    \App\AdminDashboard\AdminDashboardModule::class,
    \App\AdminCache\AdminCacheModule::class,
    \App\AdminLanguage\AdminLanguageModule::class,
    \App\AdminCore\AdminCoreModule::class
];
