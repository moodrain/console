@php
$languages = request()->getLanguages();
foreach ($languages as $lang) {
    if (str_contains($lang, 'zh')) {
        break;
    }
    if (str_contains($lang, 'en')) {
        echo 'ELEMENT.locale(ELEMENT.lang.en)';
        break;
    }
}
@endphp