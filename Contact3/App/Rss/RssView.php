<?php

declare(strict_types=1);

namespace App\Rss;

class RssView
{
    /**
     * Displays the RSS feed
     * @param array $rssArray
     * @param string $type
     * @return void
     */
    public function displayRss(array $rssArray, string $type): void
    {
        // Include the layout file
        $content = 'App/Rss/templates/rss_feed.html';

        // Make the type lowercase and capitalize the first letter
        $typeFormatted = ucfirst(strtolower($type));
        $pageTitle = "{$typeFormatted} News";

        // Include the layout file
        include 'templates/layout.html';
    }

}
