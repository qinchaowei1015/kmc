<?php

// 作答请同样以 gist 方式提供

/**
 * 请实现一个函数，给定整数 n ，打印出所有小于 n 的质数。
 * 比如，当 n = 10，则打印出
 * 2 3 5 7
 */

function printPrimes($n)
{
    if ($n <= 2) {
        return;
    }

    $isPrime = array_fill(0, $n, true);
    $isPrime[0] = $isPrime[1] = false; // 0和1不是质数

    for ($i = 2; $i * $i < $n; $i++) {
        if ($isPrime[$i]) {
            for ($j = $i * $i; $j < $n; $j += $i) {
                $isPrime[$j] = false;
            }
        }
    }

    for ($i = 2; $i < $n; $i++) {
        if ($isPrime[$i]) {
            echo $i . " ";
        }
    }
}

// 测试函数
$n = 10;
printPrimes($n);

/**
 * 请实现一个函数，抓取 https://php.net/manual/zh 页面的菜单信息（从“版权信息”到“附录”），
 * 将其存为 markdown文件，保留缩进及超链接。
 * 前三行示例
 * - [版权信息](https://www.php.net/manual/zh/copyright.php)
 * - [PHP 手册](https://www.php.net/manual/zh/manual.php)
 *   - [序言](https://www.php.net/manual/zh/preface.php)
 */

function fetchMenuItems($url)
{
    // 使用cURL获取网页内容，并处理重定向
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // 自动跟随重定向
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 禁用SSL验证

    $html = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        return;
    }
    curl_close($ch);

    if (empty($html)) {
        echo "Failed to retrieve HTML content\n";
        return;
    }

    $doc = new DOMDocument();
    @$doc->loadHTML($html);

    $xpath = new DOMXPath($doc);

    $menuItemsText = $xpath->query("//*[@id='index']/ul/li/a");
    $menuItemsLinks = $xpath->query("//*[@id='index']/ul/li/a/@href");

    if ($menuItemsText->length === 0 || $menuItemsLinks->length === 0) {
        echo "No menu items found\n";
        return;
    }

    $markdown = "";
    for ($i = 0; $i < $menuItemsText->length; $i++) {
        $text = $menuItemsText->item($i)->nodeValue;
        $link = $menuItemsLinks->item($i)->nodeValue;
        $link_url = $url . '/' . $link;
        $markdown .= "- [{$text}]({$link_url})\n";
    }

    file_put_contents("menu.md", $markdown);

    echo "菜单信息已保存为 menu.md 文件\n";

}

$url = "https://php.net/manual/zh";
fetchMenuItems($url);

/**
 * 最引以为傲的一段代码（如有必要请说明代码实现了什么功能）
 */
// 交集数组变量
function _handleIntersectWhere(&$where, $key, $data, $condition)
{
    if (isset($where[$key])) {
        if (is_array($where[$key]['data'])) {
            $where[$key]['data'] = array_intersect($where[$key]['data'], $data);
        } else {
            $where[$key]['data'] = $data;
        }
    } else {
        $where[$key]['data'] = $data;
    }
    $where[$key]['condition'] = $condition;

    return $where;
}
/**
 * 经常浏览的技术网站，以及最近学习到的新知识
 */
// github  gitee 官方文档 CSDN B站等等
