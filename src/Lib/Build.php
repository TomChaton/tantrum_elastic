<?php
/**
 * This file is part of tantrum_elastic.
 *
 *  tantrum_elastic is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  tantrum_elastic is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with tatrum_elastic.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace tantrum_elastic\Lib;
use Opis\Closure\SerializableClosure;
use Interop\Container\ContainerInterface;

/**
 * Contains methods required to set up the library
 */
class Build
{
    /**
     * @var string $filename Filename of the serialized container
     */
    private static $filename = 'container.bin';

    /**
     * @var array Whitelist of directories to process
     */
    protected static $targetDirectories = [
        'Query',
        'Document',
        'Request',
        'Response',
        'Sort',
        'Transport',
    ];

    /**
     * Create, seialize and store the container
     */
    public static function initialiseContainer()
    {
        file_put_contents(sprintf('%s/%s', self::getCacheDir(), self::$filename), serialize(self::buildContainer()));
    }

    /**
     * Get the container
     * @throws \RuntimeException
     * @return ContainerInterface
     */
    public static function getContainer()
    {
        if($serialized = file_get_contents(sprintf('%s/%s', self::getCacheDir(), self::$filename))) {
            return unserialize($serialized);
        } else {
            throw new \RuntimeException('No container found. Have you run composer install?');
        }
    }

    /**
     * Iterate over each directory, extracting classes which take the container as a single constructor argument.
     * Create a closure provider for the class within the container
     * @return ContainerInterface
     */
    protected static function buildContainer()
    {
        $container = new Container();
        foreach(self::$targetDirectories as $directory) {
            $targetDirectory = sprintf('%s/%s', self::getSrcDir(), $directory);
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($targetDirectory, \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS));
            foreach ($iterator as $path => $fileInfo) {
                if($fileInfo->getExtension() === 'php') {
                    $relativePath = substr($path, strpos($path, 'tantrum_elastic'), strlen($path));
                    $relativePathWithoutExtension = substr($relativePath, 0, -4);
                    $namespace = str_replace('/', '\\', str_replace('/src/', '\\', $relativePathWithoutExtension));
                    $reflectionClass = new \ReflectionClass($namespace);
                    if($reflectionClass->isInstantiable()) {
                        $constructor = $reflectionClass->getConstructor();
                        $params = $constructor->getParameters();
                        // W're only interested in objects we can inject the container into
                        if (count($params) === 1 && $params[0]->getClass()->name === 'Interop\Container\ContainerInterface') {
                            $closure = function () use ($namespace, $container) {
                                return new $namespace($container);
                            };
                            $wrapper = new SerializableClosure($closure);
                            $container->addProvider($namespace, $wrapper);
                        }
                    }
                }
            }
        }
        return $container;
    }

    /**
     * Location of the src directory
     * @return string
     */
    protected static function getSrcDir()
    {
        return realpath(__DIR__.'/../');
    }

    /**
     * Location of the cache directory
     * @return string
     */
    protected static function getCacheDir()
    {
        return realpath(__DIR__.'/../../build/cache');
    }
}
