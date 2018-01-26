<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('/sitemap/pages') }}</loc>
        <lastmod>{{ \Carbon\Carbon::today()->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @foreach($locations as $location)
    <sitemap>
        <loc>{{ url('/sitemap/' . $location->slug) }}</loc>
        <lastmod>{{ $location->updated_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    @endforeach
</sitemapindex>