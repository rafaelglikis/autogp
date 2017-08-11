<?php

namespace rafaelglikis\autogp\Scrapers\Interfaces;

interface Crawler
{
    public function getNextPageUrl(string $html): string;
    public function getPageEntries(string $html): array;
    public function getEntryContent(string $entry);
}