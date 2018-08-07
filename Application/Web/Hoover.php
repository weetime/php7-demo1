<?php
/**
 * Created by PhpStorm.
 * User: fangyong
 * Date: 2018/8/7
 * Time: 14:07
 */

namespace Application\Web;


class Hoover
{
    private $content;

    public function getContent($url)
    {
        if(!$this->content)
        {
            if(stripos($url, 'http') !==0)
            {
                $url = "http://".$url;
            }
            $this->content = new \DOMDocument('1.0', 'utf-8');
            $this->content->preserveWhiteSpace = FALSE;
            @$this->content->loadHTMLFile($url);
        }

        print_r($this->content);exit;
        return $this->content;
    }

    public function getTags($url, $tag)
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

    public function getAttributes($url, $attr, $domain = NULL)
    {
        $result = [];
        $elemets = $this->getContent($url)->getElementsByTagName('*');
        foreach ($elemets as $node)
        {
            if($node->hasArrtibule($attr))
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
}