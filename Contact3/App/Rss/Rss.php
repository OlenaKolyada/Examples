<?php

declare(strict_types=1);

namespace App\Rss;

class Rss
{
    /**
     * Fetches RSS feed and returns an array of items
     * @param string $rssUrl
     * @return array
     */
    public function fetchRss(string $rssUrl): array
    {
        // Load the XML file and transform it to SimpleXMLElement object
        $xml = simplexml_load_file($rssUrl, null, LIBXML_NOCDATA);

        // Get the namespaces
        $namespaceArray = $xml->getNamespaces(true);

        // Initialize the array to store the RSS feed items
        $rssArray = [];

        // Loop through the items in the RSS feed
        foreach ($xml->channel->item as $item) {
            $title = (string)$item->title;

            $description = (string)$item->description;

            // Remove all tags except img tags
            $descriptionCleaned = preg_replace('/<(?!img\s|\/img\b)[^>]+>/', '', $description);

            // Shorten the description to 300 characters
            if (strlen($descriptionCleaned) > 300) {
                $descriptionCleaned = substr($descriptionCleaned, 0, 300) . '...';
            }

            $description = $descriptionCleaned;

            // Get the publication date and link
            $pubDate = (string)$item->pubDate;
            $link = (string)$item->link;

            // Initialize the image variable
            $image = '';

            // Check if the image is available in the enclosure tag, or in the media namespace
            if ($item->enclosure) {
                $image = (string)$item->enclosure['url'];
            } elseif (isset($namespaceArray['media']) && isset($item->children
                    ($namespaceArray['media'])->content)) {
                $image = (string)$item->children($namespaceArray['media'])
                    ->content->attributes()->url;
            }

            // Get the channel title and domain
            $channelTitle = (string)$xml->channel->title;
            $domain = parse_url($link, PHP_URL_HOST);

            // Add the item to the RSS array
            $rssArray[] = [
                'title' => $title,
                'description' => $description,
                'pubDate' => $pubDate,
                'link' => $link,
                'image' => $image,
                'channelTitle' => $channelTitle,
                'domain' => $domain
            ];
        }

        return $rssArray;
    }
}