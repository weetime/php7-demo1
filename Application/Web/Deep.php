<?php
/**
 * Created by PhpStorm.
 * User: fangyong
 * Date: 2018/8/11
 * Time: 16:50
 */

namespace Application\Web;

/**
 * Class Deep
 * @package Application\Web
 * 扫描层级10 只扫描本站的域名
 */
class Deep
{
    private CONST DEFAULT_LIMIT = 10;

    protected $domain;
    private $limitPage;

    public function scan($url, $tag)
    {
        $vac = new Hoover();
        $scan = $vac->getAttribute($url, 'href', $this->getDomain($url));
        $scan = array_unique($scan);
        foreach ($scan as $subSite)
        {
            yield from $vac->getTags($subSite, $tag);
        }
    }

    public function getDomain($url)
    {
        if(!$this->domain)
        {
            $this->domain = parse_url($url, PHP_URL_HOST);
        }

        return $this->domain;
    }

    public function scanImg($url, $attr = 'src')
    {
        $vac = new Hoover();
        $vac->setClearCache(true); // 深度扫描
        $scan = $vac->getAttribute($url, 'href', $this->getDomain($url));
        $scan = array_unique($scan);
        $scan = array_slice($scan, 0 ,$this->getLimitPage());
        foreach ($scan as $subSite)
        {
            yield from $vac->getAttribute($subSite, $attr);
        }
    }

    public function setLimitPage(int $size)
    {
        $size = ($size <= self::DEFAULT_LIMIT && $size > 0 ) ?? self::DEFAULT_LIMIT;
        $this->limitPage = $size;
    }

    private function getLimitPage() : int
    {
        return $this->limitPage ?? self::DEFAULT_LIMIT;
    }

}