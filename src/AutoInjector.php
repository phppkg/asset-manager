<?php
/**
 * Created by PhpStorm.
 * User: Inhere
 * Date: 2017/11/18 0018
 * Time: 19:04
 */

namespace Inhere\Asset;

/**
 * Class AutoInjector
 * - 自动注入到HTML中指定位置
 * @package Inhere\Asset
 */
class AutoInjector
{
    const POS_HEAD = 1;       # 在解析视图数据时放到</head>之前的位置
    const POS_BODY = 2;       # 在解析视图数据时放到<body>之后的位置
    const POS_END = 3;       # 在解析视图数据时放到</body>之前的位置

    protected $headNode = '</head>';
    protected $bodyNode = '<body>';
    protected $endNode = '</body>';

    /**
     * 自动注入资源到指定的位置
     * - 在渲染好html后,输出html字符之前调用此方法
     * `$html = $manager->injectAssets($html);`
     * @param string|null $html html document string
     * @return mixed|string [type]
     */
    public function inject($html)
    {
        $html = trim($html);

        if (!($assets = $this->assets)) {
            return $html;
        }

        if (!empty($assets[self::POS_BODY])) {
            $assetBody = $this->bodyNode . implode('', $assets[self::POS_BODY]);
            $bodyNode = str_replace('/', '\/', $this->bodyNode);
            $html = preg_replace("/$bodyNode/i", $assetBody, $html, 1, $count);

            // 没找到节点，注入失败时，直接加入开始位置
            if ($count === 0) {
                $html = $assetBody . $html;
            }
        }

        if (!empty($assets[self::POS_HEAD])) {
            $assetHead = implode('', $assets[self::POS_HEAD]) . $this->headNode;
            $headNode = str_replace('/', '\/', $this->headNode);
            $html = preg_replace("/$headNode/i", $assetHead, $html, 1, $count);

            if ($count === 0) {
                $html = $assetHead . $html;
            }
        }

        if (!empty($assets[self::POS_END])) {
            $assetEnd = implode('', $assets[self::POS_END]) . $this->endNode;
            $endNode = str_replace('/', '\/', $this->endNode);
            $html = preg_replace("/$endNode/i", $assetEnd, $html, 1, $count);

            // 没找到节点，注入失败时，直接加入末尾位置
            if ($count === 0) {
                $html .= $assetEnd;
            }
        }

        unset($bodyNode, $headNode, $endNode, $assetHead, $assetBody, $assetEnd, $count);
        return $html;
    }
}
