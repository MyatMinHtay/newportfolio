@php
    $siteName = \App\Models\Setting::get('site_name', project('site_name', 'Myat Min Htay'));
    $pageTitle = trim($__env->yieldContent('title', \App\Models\Setting::get('site_title', $siteName . ' — Full Stack Website Developer')));
    $description = trim($__env->yieldContent('meta_description', \App\Models\Setting::get('meta_description', 'Portfolio of ' . $siteName . ' — Full Stack Website Developer specializing in Laravel, PHP, and modern web applications.')));
    $keywords = trim($__env->yieldContent('meta_keywords', \App\Models\Setting::get('meta_keywords', 'Web Developer, Laravel, PHP, MySQL, Portfolio, Myanmar')));
    $author = \App\Models\Setting::get('meta_author', $siteName);
    $robotsIndexing = \App\Models\Setting::get('robots_indexing', '1');
    $robots = ($robotsIndexing === '0') ? 'noindex, nofollow' : 'index, follow, max-image-preview:large';
    $canonicalUrl = url()->current();
    
    $ogTitle = trim($__env->yieldContent('og_title', $pageTitle));
    $ogDescription = trim($__env->yieldContent('og_description', $description));
    $ogType = trim($__env->yieldContent('og_type', 'website'));
    $ogImage = trim($__env->yieldContent('og_image', asset('assets/img/profile.png')));
    $twitterHandle = \App\Models\Setting::get('twitter_handle', '');
@endphp

<!-- Basic Meta Tags -->
<meta name="description" content="{{ $description }}">
@if($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif
@if($author)
<meta name="author" content="{{ $author }}">
@endif
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ $siteName }}">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $canonicalUrl }}">
<meta name="twitter:title" content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $ogDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">
@if($twitterHandle)
<meta name="twitter:site" content="{{ $twitterHandle }}">
<meta name="twitter:creator" content="{{ $twitterHandle }}">
@endif
