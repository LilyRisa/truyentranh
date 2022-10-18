<?php

use Illuminate\Support\Facades\Request;

function getSchemaBreadCrumb($breadCrumb){
    $itemListElement = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Trang chủ',
            'item' => 'https://truyen.forextradingvn.top/'
        ]
    ];
    $i=2;
    if (!empty($breadCrumb)) foreach ($breadCrumb as $key => $item) {
        if ($item['schema']) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $i,
                'name' => $item['name'],
                'item' => str_replace('amp/', '', $item['item'])
            ];
            $i++;
        }
    }
    $schema = '<script type="application/ld+json">';
    $schema .= json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $itemListElement
    ]);
    $schema .= '</script>';
    return $schema;
}

function getSchemaLogo(){
    $schema = '<script type="application/ld+json">';
    $listItem = json_encode([
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "url" => Request::url()."/",
        "logo" => asset('images/logo.svg')
    ]);

    $schema .= $listItem.'</script>';
    return $schema;
}
function getSchemaArticle($post, $user){
    $schema = '<script type="application/ld+json">';
    $schema .= json_encode([
        "@context" => "https://schema.org",
        "@type" => "NewsArticle",
        "headline" => $post->meta_title,
        "description" => $post->meta_description,
        "image" => [
            "@type" => "ImageObject",
            "url" => url($post->thumbnail),
            "width" => 1200,
            "height" => 650
        ],
        "datePublished" => date('c', strtotime($post->displayed_time)),
        "dateModified" => date('c', strtotime($post->updated_time)),
        "author" => [
            "@type" => "Person",
            "name" => $user->fullname ?? 'forextradingvn',
            "url" => getUrlAuthor($user) ?? ''
        ],
        "publisher" => [
            "@type" => "Organization",
            "name" => 'forextradingvn',
            "logo" => [
                "@type" => "ImageObject",
                "url" => 'https://truyen.forextradingvn.top/images/logo.svg',
                "width" => 600,
                "height" => 60
            ]
        ],
        "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id" => getUrlPost($post)
        ]
    ]);
    $schema .= '</script>';

    return $schema;

}

function getLocalBusiness(){
    $schema = '<script type="application/ld+json">';
    $schema .= json_encode([
        "@context" => "https://schema.org",
        "@type" => "LocalBusiness",
        "name" => 'forextradingvn',
        "image" => 'https://forextradingvn.top/images/logo.svg',
        "@id" => "https://forextradingvn.top/",
        "url" => "https://forextradingvn.top/",
        "telephone" => "",
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => "Lai Xá",
            "addressLocality" => "xã Kinh Chung, huyện Hoài Đức, Hà Nội",
            "postalCode" => "100000",
            "addressCountry" => "VN"
        ],
        "openingHoursSpecification" => [
            "@type" => "OpeningHoursSpecification",
            "opens" => "08:00",
            "closes" => "17:00",
        ]

    ]);
    $schema .= '</script>';
    return $schema;

}
?>
