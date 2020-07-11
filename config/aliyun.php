<?php

return [
    'accessKeyId' => env('ALIYUN_ACCESS_KEY_ID'),
    'accessKeySecret' => env('ALIYUN_ACCESS_KEY_SECRET'),
    'smsCaptchaTemplateCode' => env('ALIYUN_SMS_CAPTCHA_TEMPLATE_CODE'),
    'smsSignName' => env('ALIYUN_SMS_SIGN_NAME'),
    'ttsAppKey' => env('ALIYUN_TTS_APP_KEY'),
    'oss' => [
        'endpoint' => env('ALIYUN_OSS_ENDPOINT'),
    ],
];