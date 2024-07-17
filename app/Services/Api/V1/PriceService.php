<?php

namespace App\Services\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\Api\V1\ResponderTrait;
use Exception;
use Goutte\Client;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class PriceService extends Controller
{
    use ResponderTrait;

    private readonly Client $client;
    private readonly Crawler $crawler;
    private string $url;
    private int|false $isDigikala;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->client = new Client();
        $this->crawler = $this->client->request('GET', $url);
        $this->isDigikala = preg_match('/dkp-\d+/', $url);
    }

    public function getDigikala()
    {
        try {
            if ($this->isDigikala) {
                $pattern = '/dkp-(\d+)/';
                preg_match($pattern, $this->url, $matches);
                if (isset($matches[1])) {
                    $number = $matches[1];
                    $response = Http::get("https://api.digikala.com/v2/product/{$number}/")->json();
                    return [
                        'name' => $response['data']['product']['title_fa'],
                        'description' => $response['data']['seo']['description'],
                        'link' => $this->url,
                        'price' => $response['data']['product']['default_variant']['price']['selling_price'],
                        'image' => $response['data']['product']['images']['main']['url'][0]
                    ];
                }

                return null;
            }
        } catch (Exception) {
            return null;
        }
    }

    public function getSchema(): array|null
    {
        try {
            $schemas = [];

            $this->crawler->filter('script[type="application/ld+json"]')->each(static function ($node) use (&$schemas) {
                $schemas[] = json_decode(html_entity_decode($node->text(), ENT_QUOTES, 'UTF-8'), true);
            });

            if (empty($schemas)) {
                return null;
            }

            $product = collect($this->findArrayByType($schemas, 'Product'));

            if (count($product) === 0) {
                return null;
            }

            $offer = $this->findOffer($schemas);

            $searchAttributes = ['name', 'description', 'url', 'price', 'lowPrice', 'highPrice', 'image'];

            $product = $product->merge($offer)
                ->only($searchAttributes)
                ->map(static fn($value, $key) => ($key === 'image' && is_array($value)) ? ($value[0]['url'] ?? $value[0]) : $value)->toArray();

            $product['price'] = isset($product['price']) && $product['price'] > 0 ? $product['price'] : $product['lowPrice'] ?? null;
            $product['link'] = $this->url;

            return $product;
        } catch (Exception $e) {
            return null;
        }
    }

    public function getMeta(): array|null
    {
        try {
            $metaTags = $this->crawler->filter('meta')->each(static function ($node) {
                return [
                    'name' => $node->attr('name') ?? $node->attr('property'), 'content' => $node->attr('content')
                ];
            });

            $product = [];

            foreach ($metaTags as $metaTag) {
                $name = $metaTag['name'];
                $content = $metaTag['content'];

                $product['name'] = $name === 'og:title' ? $content : ($product['name'] ?? '');
                $product['description'] = in_array($name,
                    ['og:description', 'twitter:description']) ? $content : ($product['description'] ?? '');
                $product['link'] = $name === 'og:url' ? $content : ($product['link'] ?? '');
                $product['image'] = in_array($name,
                    ['og:image', 'twitter:image', 'og:image:secure_url']) ? $content : ($product['image'] ?? '');
                $product['price'] = in_array($name, [
                    'product:price:amount', 'twitter:data1'
                ]) ? $this->extractFirstInt($content) : ($product['price'] ?? '');
            }

            $product['link'] = $this->url;

            return array_filter($product);
        } catch (Exception $e) {
            return null;
        }
    }


    private function extractFirstInt($str)
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $englishText = str_replace($persianNumbers, $englishNumbers, $str);
        $englishText = str_replace($persianNumbers, $englishNumbers, $str);
        $englishText = str_replace(',', '', $englishText);
        preg_match('/\d+/', $englishText, $matches);

        if (count($matches) > 0) {
            return (int) $matches[0];
        }

        return null;
    }

    public function findArrayByType($array, $type)
    {
        if (is_array($array)) {
            if (isset($array['@type']) && $array['@type'] === $type) {
                return $array;
            }

            foreach ($array as $value) {
                $result = $this->findArrayByType($value, $type);
                if ($result !== null) {
                    return $result;
                }
            }
        }

        return null;
    }

    public function findOffer($array)
    {
        $offerTypes = [
            'http://schema.org/Offer', 'Offer', 'AggregateOffer'
        ];

        if (is_array($array)) {
            if (isset($array['@type']) && in_array($array['@type'], $offerTypes, true)) {
                return $array;
            }

            foreach ($array as $value) {
                $result = $this->findOffer($value);
                if ($result !== null) {
                    return $result;
                }
            }
        }

        return null;
    }


    public function getPrice()
    {
        if ($this->isDigikala) {
            return $this->getDigikala();
        }
        return $this->getSchema() ?? $this->getMeta();
    }

}
