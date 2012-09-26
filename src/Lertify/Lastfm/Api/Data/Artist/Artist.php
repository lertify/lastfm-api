<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Artist;

class Artist
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $mbid;

    /**
     * @var string
     */
    private $url;

    /**
     * @param string $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $mbid
     */
    public function setMbid( $mbid )
    {
        $this->mbid = $mbid;
    }

    /**
     * @return string
     */
    public function getMbid()
    {
        return $this->mbid;
    }

    /**
     * @param string $url
     */
    public function setUrl( $url )
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
