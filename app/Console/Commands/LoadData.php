<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductTag;
use App\Models\Variant;
use App\Models\VariantOption;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::transaction(function () {
            $xmlString = file_get_contents(public_path('baza.xml'));
            $xmlObject = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xmlObject);
            $phpArray = json_decode($json, true);

            foreach ($phpArray['product'] as $item) {

                $product_brand = $item['brand'];
                ProductBrand::insertOrIgnore([
                    ['name' => $product_brand, 'slug' => Str::slug($product_brand)],
                ]);
                $product_brand_id = ProductBrand::where('name', $product_brand)->first()->value('id');

                Product::insertOrIgnore([
                    'product_code' => $item['productCode'],
                    'barcode' => !is_array($item['barcode']) ? $item['barcode'] : null,
                    'active' => $item['active'],
                    'product_brand_id' => $product_brand_id,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'list_price' => $item['listPrice'],
                    'price' => $item['price'],
                    'tax' => $item['tax'],
                    'currency' => $item['currency'],
                    'quantity' => $item['quantity'],
                    'in_discount' => $item['in_discount'],
                    'detail' => !is_array($item['detail']) ? $item['detail'] : null,
                ]);
                $product_id = Product::where('product_code', $item['productCode'])->value('id');


                $main_category = $item['main_category'];
                $main_category_slug = Str::slug($main_category);
                Category::insertOrIgnore([
                    ['name' => $main_category, 'slug' => $main_category_slug],
                ]);
                $main_category_id = Category::where('slug', $main_category_slug)->value('id');

                $this->productCategory($product_id, $main_category_id);

                $top_category = $item['top_category'];
                if (isset($top_category) and !is_array($top_category)) {
                    Category::insertOrIgnore([
                        ['parent_id' => $main_category_id, 'name' => $top_category, 'slug' => Str::slug($top_category)],
                    ]);
                    $top_category_id = Category::where('slug', Str::slug($top_category))->value('id')??null;

                    $this->productCategory($product_id, $top_category_id);

                    $sub_category = $item['sub_category'];
                    if (isset($sub_category) and !is_array($sub_category)) {
                        Category::insertOrIgnore([
                            ['parent_id' => $top_category_id, 'name' => $sub_category, 'slug' => Str::slug($sub_category)],
                        ]);
                        $sub_category_id = Category::where('slug', Str::slug($sub_category))->value('id')??null;

                        $this->productCategory($product_id, $sub_category_id);
                    }
                }

                for ($i = 1; $i < 10; $i++) {
                    if (isset($item['image' . $i])) {
                        $link = $item['image' . $i];
                        Image::insertOrIgnore([
                            ['product_id' => $product_id, 'link' => $link],
                        ]);
                    } else break;
                }

                if (array_key_exists('variants', $item)) {
                    foreach ($item['variants']['variant'] as $variant) {
                        if (is_array($variant) and !empty($variant)) {
                            $variant_id = Variant::insertGetId([
                                'product_id' => $product_id,
                                'quantity' => $variant['quantity'],
                                'barcode' => !is_array($variant['barcode']) ? $variant['barcode'] : null,
                            ]);
                            $this->variantOption($variant_id, $variant['name1'], $variant['value1']);

                            if (!is_array($variant['name2']) and !is_array($variant['value2'])) {
                                $this->variantOption($variant_id, $variant['name2'], $variant['value2']);
                            }
                        }
                    }
                }
            }
        });
    }

    /**
     * Adding or ignoring new data to ProductCategory
     *
     * @param int $product_id
     * @param int $category_id
     * @return array|bool|string|void|null
     */
    private function productCategory(int $product_id, int $category_id)
    {
        ProductTag::insertOrIgnore([
            'product_id' => $product_id,
            'category_id' => $category_id
        ]);
    }

    /**
     * Adding or ignoring new data to Option
     *
     * @param string $name
     * @param string $value
     * @return array|bool|string|void|null
     */
    private function createOption(string $name, string $value)
    {
        Option::insertOrIgnore([
            'name' => $name,
            'value' => $value
        ]);
    }

    /**
     * Get id from Option by $value
     *
     * @param string $value
     * @return mixed
     */
    private function getOptionId(string $value)
    {
        return Option::where('value', $value)->first()->value('id');
    }

    /**
     * Insert Option and VariantOption
     *
     * @param int $variant_id
     * @param string $name
     * @param string $value
     * @return void
     */
    private function variantOption(int $variant_id, string $name, string $value)
    {
        $this->createOption($name, $value);
        $option_id = $this->getOptionId($value);
        VariantOption::insertOrIgnore([
            'variant_id' => $variant_id,
            'option_id' => $option_id
        ]);
    }
}
