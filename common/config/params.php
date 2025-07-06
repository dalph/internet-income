<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'siteTitle' => getenv('SITE_TITLE') ?: 'Название сайта',
    'showHeader' => getenv('SHOW_HEADER') !== false ? (bool)getenv('SHOW_HEADER') : true,
    'showFooter' => getenv('SHOW_FOOTER') !== false ? (bool)getenv('SHOW_FOOTER') : true,
    'showBanners' => getenv('SHOW_BANNERS') !== false ? (bool)getenv('SHOW_BANNERS') : true,
];
