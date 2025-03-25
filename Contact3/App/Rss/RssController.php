<?php

declare(strict_types=1);

namespace App\Rss;

use App\View;

class RssController
{
    private Rss $rss;
    private RssView $rssView;
    private array $rssUrls;

    public function __construct()
    {
        $this->rss = new Rss();
        $this->rssView = new RssView();
        $this->rssUrls = require __DIR__ . '/../../config.php';
    }

    /**
     * Fetches the RSS feed and displays it
     * @param string $type
     * @return void
     */
    public function getRss(string $type): void
    {
        // Get the RSS URL for the specified type
        $rssUrl = $this->rssUrls['rssUrls'][$type] ?? '';

        // If the RSS URL is not found, display an error message
        if ($rssUrl === '') {
            echo "RSS URL for type '{$type}' not found.";
            return;
        }

        // Fetch the RSS feed and display it
        $rssArray = $this->rss->fetchRss($rssUrl);
        $this->rssView->displayRss($rssArray, $type);
    }

}
