<?php
declare(strict_types=1);

namespace PhPetra\Rep;

use FluentDOM;
use League\Csv\Writer;

/**
 * For all UUIDs, fetch the corresponding image from the website and save to a CSV
 */
final class ImageCollector
{
    /** @var string */
    private $siteUri = 'http://redeenportret.nl/portret/%s';

    /** @var string */
    private $fileToRead;

    /** @var string */
    private $fileToWrite;

    public function __construct(
        string $fileToRead,
        string $fileToWrite
    ) {
        $this->fileToRead = $fileToRead;
        $this->fileToWrite = $fileToWrite;
    }

    public function run() : void
    {
        $writer = Writer::createFromPath($this->fileToWrite, 'w+');
        $writer->insertOne(['uuid', 'image']);

        $document = FluentDOM::load(file_get_contents($this->fileToRead));
        foreach ($document('/records/record') as $entry) {
            $uuid = $entry('string(uuid)');

            $html = FluentDOM::load(
                $this->uri($uuid),
                'text/html',
                [FluentDOM\Loader\Options::ALLOW_FILE => TRUE]
            );

            foreach ($html('//head/meta[@property="og:image"]') as $a) {
                $image = $a['content'];
                $writer->insertOne([$uuid, $image]);
                print '.';
            }
        }

    }

    private function uri(string $uuid): string
    {
        return sprintf($this->siteUri, $uuid);
    }
}
