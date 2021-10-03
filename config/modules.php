<?php

return [
    \App\Core\CoreModule::class,
    \App\ErrorPage\ErrorPageModule::class,
    \App\Common\Blog\BlogModule::class,
    \App\Common\Contact\ContactModule::class,
    \App\Common\AntiSpam\AntiSpamModule::class,
    \App\Language\LanguageModule::class,

    \App\AdminSecurity\AdminSecurityModule::class,
    \App\AdminDashboard\AdminDashboardModule::class,
    \App\AdminCache\AdminCacheModule::class,
    \App\AdminLanguage\AdminLanguageModule::class,
    \App\AdminCore\AdminCoreModule::class
];
