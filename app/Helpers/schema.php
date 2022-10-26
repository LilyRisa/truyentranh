<?php

use Illuminate\Support\Facades\Request;

function getSchemaBreadCrumb($breadCrumb){
    $itemListElement = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Trang chủ',
            'item' => 'https://thichdammy.com/'
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
        "logo" => 'https://thichdammy.com/images/logo.png'
    ]);

    $schema .= $listItem.'</script>';
    return $schema;
}
function getSchemaStory($story){
    $schema = '<script type="application/ld+json">';
    $schema .= json_encode([
        "@context" => "https://schema.org",
        "@type" => "DataFeed",
        'dataFeedElement' => [
            "@context" => "https://schema.org",
            "@type" => "Book",
            "@id" => getUrlStory($story),
            "url" => getUrlStory($story),
            "name" => $story->title,
            "description" => $story->meta_description,
            "author" => [
                "@type" => "Person",
                "name" => "Thích Đam Mỹ"
            ],
            "image" => [
                "@type" => "ImageObject",
                "url" => url($story->thumbnail),
                "width" => 1200,
                "height" => 650
            ],
            "datePublished" => date('c', strtotime($story->created_at)),
            "dateModified" => date('c', strtotime($story->created_at)),
            "publisher" => [
                "@type" => "Organization",
                "name" => 'Thích Đam Mỹ',
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => 'https://thichdammy.com/images/logo.png',
                    "width" => 600,
                    "height" => 60
                ]
            ],
            "mainEntity" => [
                "@type" => "Book",
                "@id" => getUrlStory($story)
            ]
        ]
        
    ]);
    $schema .= '</script>';

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
            "name" => $user->fullname ?? 'Thích Đam Mỹ',
            "url" => getUrlAuthor($user) ?? ''
        ],
        "publisher" => [
            "@type" => "Organization",
            "name" => 'Thích Đam Mỹ',
            "logo" => [
                "@type" => "ImageObject",
                "url" => 'https://thichdammy.com/images/logo.png',
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
        "name" => 'Thích Đam Mỹ',
        "image" => 'https://thichdammy.com/images/logo.png',
        "@id" => "https://thichdammy.com/",
        "url" => "https://thichdammy.com/",
        "telephone" => "0334109351",
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => "35 P. Lý Thường Kiệt",
            "addressLocality" => "Hà Cầu, Hà Đông, Hà Nội, Việt Nam",
            "postalCode" => "100000",
            "addressCountry" => "VN"
        ],
        "openingHoursSpecification" => [
            "@type" => "OpeningHoursSpecification",
            "opens" => "08:00:00",
            "closes" => "17:00:00",
        ]

    ]);
    $schema .= '</script>';
    return $schema;

}
?>
