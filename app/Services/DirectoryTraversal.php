<?php
namespace App\Services;

use Directory;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;

class DirectoryTraversal
{
    /**
     * @param string $path
     *
     * @return array
     */
    public function traverse(string $path): array
    {
        $path = realpath($path);
        if (is_dir($path) === false) {
            throw new DirectoryNotFoundException('Directory `' . $path . '` does not exists.');
        }

        $items = [];

        /**
         * @var Directory $descriptor
         */
        $descriptor = dir($path);
        while (false !== ($entry = $descriptor->read())) {
            if ($entry != "." && $entry != "..") {
                $items[] = $entry;
            }
        }
        $descriptor->close();

        return $items;
    }
}
