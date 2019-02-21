<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 21/02/2019
 * Time: 16:12
 */

namespace App\Services\Twig;


use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new \Twig_Filter('summary', function ($text) {
                $string = strip_tags($text);
                if (strlen($string) > 200) {
                    $stringCut = substr($string, 0, 200);
                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
                }
                return $string;
            }),
            new \Twig_Filter('summaryAdmin', function ($text) {
                $string = strip_tags($text);
                if (strlen($string) > 50) {
                    $stringCut = substr($string, 0, 50);
                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
                }
                return $string;
            })
        ];
    }
}