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

namespace tantrum_elastic\Payload;

use Psr\Http\Message\StreamInterface;
use tantrum_elastic\Lib\Element;
use tantrum_elastic\Query;
use tantrum_elastic\Sort;
use tantrum_elastic\Exception\General;
use tantrum_elastic\Transport\Envelope;

/**
 * Base class for all payloads.
 * The StreamInterface code was largely copied from
 * @package tantrum_elastic\Payload
 */
abstract class Base extends Element implements StreamInterface
{
    const TYPE_SEARCH = 'SEARCH';

    /** @var resource $stream */
    private $stream;

    /** @var string $json */
    private $json;

    /** @var integer */
    private $size;

    /** @var array */
    private $streamMetadata;

    /**
     * Return the type of Payload
     *
     * @return string
     */
    abstract public function getType();

    /**
     * @inheritdoc
     * @return string
     */
    public function __toString()
    {
        return $this->getJson();
    }

    /**
     * @inheritdoc
     */
    public function close()
    {
       if($this->stream !== null) {
           fclose($this->stream);
           $this->detach();
       }
    }

    /**
     * @inheritdoc
     * @return null|resource
     */
    public function detach()
    {
        if (!isset($this->stream)) {
            return null;
        }
        $result = $this->stream;
        unset($this->stream);
        $this->size = 0;

        return $result;
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function isSeekable()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->seek(0);
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function isWritable()
    {
        return true;
    }

    /**
     * @inheritdoc
     * @param string $string
     * @return int
     */
    public function write($string)
    {
        return fwrite($this->getStream(), $string);
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function isReadable()
    {
        return true;
    }

    /**
     * @inheritdoc
     * @param int $length
     * @return string
     */
    public function read($length)
    {
        return fread($this->getStream(), $length);
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function getContents()
    {
        return $this->read($this->getSize() - $this->tell());
    }

    /**
     * @inheritdoc
     * @return int
     */
    public function getSize()
    {
        if ($this->size === null) {
            $pos = $this->tell();
            $this->size = mb_strlen((string) $this);
            $this->seek($pos);
        }

        return $this->size;
    }

    /**
     * @inheritdoc
     * @return int
     */
    public function tell()
    {
        $result = ftell($this->getStream());

        if ($result === false) {
            throw new \RuntimeException('Unable to determine stream position');
        }

        return $result;
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function eof()
    {
        return feof($this->getStream());
    }

    /**
     * @inheritdoc
     * @param int $offset
     * @param int $whence
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        $stream = $this->getStream();
        fseek($stream, $offset, $whence);
    }

    /**
     * @inheritdoc
     * @param null $key
     * @return array
     */
    public function getMetadata($key = null)
    {
        if($key !== null) {
            return $this->streamMetadata[$key];
        } else {
            return $this->streamMetadata;
        }
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function getJson()
    {
        if($this->json === null) {
            $this->json = $this->encode();
        }
        return $this->json;
    }

    /**
     * json_encode the request
     * @return string
     * @throws General
     * @throws \Exception
     */
    private function encode()
    {
        // The payload is set into a container object which will be responsible for
        // formatting the request. The request is responsible for formatting its elements and so on.
        $container = new Envelope($this);

        // This block catches any exceptions thrown in jsonSerialize
        // json_encode wraps all exceptions in an \Exception and rethrows
        // This can go down quite a few levels. We need to extract the original exception.
        // @Todo: Handle other errors such as character encoding etc. Probably move this into its own class at this point
        try {
            return json_encode($container);
        } catch(\Exception $ex) {
            while (!is_null($ex) && !($ex instanceof General)) {
                $ex = $ex->getPrevious();
            }
            throw $ex;
        }
    }

    /**
     * Get the stream resource. Create one if it does not yet exist
     * @return resource
     */
    private function getStream()
    {
        if($this->stream === null) {
            $this->stream = $this->createStream();
        }
        return $this->stream;
    }

    /**
     * Create a stream from the json string
     * @return resource
     */
    private function createStream()
    {
        $stream = fopen('php://temp', 'r');
        fwrite($stream, $this->getJson());
        fseek($stream, 0);
        $this->streamMetadata = stream_get_meta_data($stream);
        return $stream;
     }

    /**
     * Return the lower cased "type", as this will be used for serialization
     * @return string
     */
    public function getElementName()
    {
        return strtolower($this->getType());
    }
}
