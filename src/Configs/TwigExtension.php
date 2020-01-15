<?php

namespace Src\Configs;

use Src\Helpers\Cookie;
use Src\Helpers\Session;
use Src\Services\Filter\Filter;
use Src\Services\Pagination\Pagination;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            // Session
            new TwigFunction('sessionHas', function (string $key) {
                return Session::has($key);
            }),
            new TwigFunction('sessionGet', function (string $key, string $property = null) {
                return Session::get($key, $property);
            }),
            new TwigFunction('sessionFlash', function (string $key, string $property, bool $unset = true) {
                return Session::flash($key, $property, $unset);
            }),
            // Cookie
            new TwigFunction('cookieHas', function (string $key) {
                return Cookie::has($key);
            }),
            new TwigFunction('cookieGet', function (string $key) {
                return Cookie::get($key);
            }),
            new TwigFunction('cookieGetUnserialized', function (string $key, string $property = null) {
                return Cookie::getUnserialized($key, $property);
            }),
            // Filter
            new TwigFunction('isValueInFilter', function (string $value, array $filters) {
               return Filter::isValueInFilter($value, $filters);
            }),
            // Pagination
            new TwigFunction('isCurrentPaginationPage', function (int $page) {
                return Pagination::isCurrentPage($page);
            })
        ];
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            // JSON
            new TwigFilter('json_decode', function (string $json) {
                return json_decode($json);
            }),
        ];
    }
}