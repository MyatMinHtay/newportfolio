@php
    $siteName = \App\Models\Setting::get('site_name', project('site_name', 'Myat Min Htay'));
    $pageTitle = trim($__env->yieldContent('title', \App\Models\Setting::get('site_title', $siteName . ' — Full Stack Website Developer')));
    $description = trim($__env->yieldContent('meta_description', \App\Models\Setting::get('meta_description', 'Portfolio of ' . $siteName . ' — Full Stack Website Developer specializing in Laravel, PHP, n8n Automation, Telegram Bots, MMQR Payment Gateways, and Production Cloud Deployment.')));
    
    $defaultKeywords = 'Myat Min Htay, Jerry M2, Full Stack Developer Myanmar, Laravel Developer Myanmar, PHP Developer, Web Developer Mandalay, Web Developer Yangon, Website Development Myanmar, Freelance Web Developer Myanmar, n8n Automation Service, Workflow Automation Myanmar, Telegram Bot Developer, Telegram Bot Integration, API Integration, REST API Myanmar, MMQR Payment Integration, KBZPay Integration, WavePay Integration, MyanMyanPay, Payment Gateway Myanmar, Website Deploy Service, VPS Setup, Linux Server Management, Cloudflare SSL, SEO Service Myanmar, Search Engine Optimization, Website Speed Optimization, Custom CMS Development, Web Application Developer, Responsive Web Design, Bootstrap 5, MySQL Database, E-commerce Website Myanmar';
    $keywords = trim($__env->yieldContent('meta_keywords', \App\Models\Setting::get('meta_keywords', $defaultKeywords)));
    if ($keywords === '') {
        $keywords = $defaultKeywords;
    }
    
    $author = \App\Models\Setting::get('meta_author', $siteName);
    $robotsIndexing = \App\Models\Setting::get('robots_indexing', '1');
    $robots = ($robotsIndexing === '0') ? 'noindex, nofollow' : 'index, follow, max-image-preview:large';
    $canonicalUrl = url()->current();
    
    $ogTitle = trim($__env->yieldContent('og_title', $pageTitle));
    $ogDescription = trim($__env->yieldContent('og_description', $description));
    $ogType = trim($__env->yieldContent('og_type', 'website'));
    
    $rawOgImage = trim($__env->yieldContent('og_image', asset('assets/img/profile.png')));
    $ogImage = (! str_starts_with($rawOgImage, 'http://') && ! str_starts_with($rawOgImage, 'https://'))
        ? url($rawOgImage)
        : $rawOgImage;
        
    $ogImageSecure = str_starts_with($ogImage, 'http://')
        ? 'https://' . substr($ogImage, 7)
        : $ogImage;
        
    $ext = strtolower(pathinfo(parse_url($ogImage, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
    $ogImageType = match($ext) {
        'jpg', 'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        default => 'image/png',
    };
    
    $ogImageWidth = '1200';
    $ogImageHeight = '630';
    $twitterHandle = \App\Models\Setting::get('twitter_handle', '@myatminhtay');
@endphp

<!-- Basic SEO Meta Tags -->
<meta name="description" content="{{ $description }}">
@if($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif
@if($author)
<meta name="author" content="{{ $author }}">
@endif
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Schema.org Microdata (Google / Fallback Crawlers) -->
<meta itemprop="name" content="{{ $ogTitle }}">
<meta itemprop="description" content="{{ $ogDescription }}">
<meta itemprop="image" content="{{ $ogImage }}">

<!-- Open Graph / Facebook / Messenger / Telegram / WhatsApp / LinkedIn -->
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:secure_url" content="{{ $ogImageSecure }}">
<meta property="og:image:type" content="{{ $ogImageType }}">
<meta property="og:image:width" content="{{ $ogImageWidth }}">
<meta property="og:image:height" content="{{ $ogImageHeight }}">
<meta property="og:image:alt" content="{{ $ogTitle }}">
<meta property="og:locale" content="en_US">

<!-- Twitter / X Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $canonicalUrl }}">
<meta name="twitter:title" content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $ogDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">
<meta name="twitter:image:alt" content="{{ $ogTitle }}">
@if($twitterHandle)
<meta name="twitter:site" content="{{ $twitterHandle }}">
<meta name="twitter:creator" content="{{ $twitterHandle }}">
@endif

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Person",
  "name": "{{ $siteName }}",
  "url": "{{ url('/') }}",
  "image": "{{ $ogImage }}",
  "jobTitle": "Full Stack Website Developer",
  "description": "{{ $description }}",
  "knowsAbout": [
    "Laravel",
    "PHP",
    "MySQL",
    "n8n Automation",
    "Telegram Bot Development",
    "MMQR Payment Gateway Integration",
    "REST API Development",
    "SEO Optimization",
    "Linux Server Deployment"
  ],
  "sameAs": [
    "https://t.me/myatminhtay",
    "https://www.facebook.com/jerrym2mmh"
  ]
}
</script>
