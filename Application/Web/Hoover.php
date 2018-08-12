<?php
/**
 * Created by PhpStorm.
 * User: fangyong
 * Date: 2018/8/7
 * Time: 14:07
 */

namespace Application\Web;


use Couchbase\Document;

class Hoover
{
    private $content;
    private $clearCache = false;

    /**
     * @param $url
     * @return DOMDocument|null
     * nullable ¼´·µ»Ø DOMDocument|null
     */
    public function getContent($url) :? DOMDocument
    {
        if(!$this->content || $this->getClearCache())
        {
            if(stripos($url, 'http') !==0)
            {
                $url = "http://".$url;
            }
            $this->content = new \DOMDocument('1.0', 'utf-8');
            $this->content->preserveWhiteSpace = FALSE;
            @$this->content->loadHTMLFile($url);
        }

        return $this->content;
    }

    /**
     * @param $url
     * @param $tag
     * @return array
     */
    public function getTags($url, $tag) : array
    {
        $count = 0;
        $result = [];
        $elements = $this->getContent($url)->getElementsByTagName($tag);
        foreach ($elements as $node)
        {
            $result[$count]['value'] = trim(preg_replace('/\s+/', '', $node->nodeValue));
            if($node->hasAttributes())
            {
                foreach ($node->attributes as $name => $attr)
                {
                    $result[$count]['attributes'][$name] = $attr->value;
                }
            }
            $count++;
        }

        return $result;
    }

    /**
     * @param $url
     * @param $attr
     * @param null $domain
     * @return array
     */
    public function getAttribute($url, $attr, $domain = NULL) : array
    {
        $result = [];
        $elemets = $this->getContent($url)->getElementsByTagName('*');
        foreach ($elemets as $node)
        {
            if($node->hasAttribute($attr))
            {
                $value = $node->getAttribute($attr);
                if($domain)
                {
                    if(stripos($value, $domain) !== FALSE)
                    {
                        $result[] = $value;
                    }
                }
                else
                {
                    $result[] = $value;
                }
            }
        }

        return $result;
    }


    public function setClearCache(bool $clearCache = FALSE)
    {
        $this->clearCache = $clearCache;
    }


    private function getClearCache() : bool
    {
        return $this->clearCache ?? FALSE;
    }
}