<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\SubCategory;
use App\Models\TopCategory;
use App\Models\Variant;
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
//                print_r($item);
                $main_category = $item['main_category'];
                $main_category_slug = Str::slug($main_category);
                MainCategory::insertOrIgnore([
                    ['name' => $main_category, 'slug' => $main_category_slug],
                ]);
                $main_category_id = MainCategory::where('slug', $main_category_slug)->first();


                $top_category = $item['top_category'];
                if (isset($top_category) and !is_array($top_category)) {
                    TopCategory::insertOrIgnore([
                        ['main_category_id' => $main_category_id->id, 'name' => $top_category, 'slug' => Str::slug($top_category)],
                    ]);
                    $top_category_id = TopCategory::where('name', $top_category)->first();

                    $sub_category = $item['sub_category'];
                    if (isset($sub_category) and !is_array($sub_category)) {
                        SubCategory::insertOrIgnore([
                            ['top_category_id' => $top_category_id->id, 'name' => $sub_category, 'slug' => Str::slug($sub_category)],
                        ]);
                        $sub_category_id = SubCategory::where('name', $sub_category)->first();
                    }
                }

                $product_brand = $item['brand'];
                ProductBrand::insertOrIgnore([
                    ['name' => $product_brand, 'slug' => Str::slug($product_brand)],
                ]);
                $product_brand_id = ProductBrand::where('name', $product_brand)->first()->value('id');

                Product::insertOrIgnore([
                    'product_code' => $item['productCode'],
                    'barcode' => !is_array($item['barcode'])?$item['barcode']:null,
                    'main_category_id' => $main_category_id->id,
                    'top_category_id' => $top_category_id->id??null,
                    'sub_category_id' => $sub_category_id->id??null,
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
                    'detail' => is_array($item['detail'])?join('', $item['detail']):$item['detail'],
                ]);
                $product_id = Product::where('product_code', $item['productCode'])->first()??null;

                for ($i=1; $i<10; $i++) {
                    if (isset($item['image'.$i])) {
                        $link = $item['image'.$i];
                        Image::insertOrIgnore([
                            ['product_id' => $product_id->id, 'link' => $link],
                        ]);
                    } else break;
                }

                if  (array_key_exists('variants', $item))
                foreach ($item['variants']['variant'] as $variant) {
//                    print_r($variant);
                    if (is_array($variant) and !empty($variant))
                    Variant::insertOrIgnore([
                            'product_id' => $product_id->id,
                            'name1' => $variant['name1'],
                            'value1' => $variant['value1'],
                            'name2' => !is_array($variant['name2'])?$variant['name2']:null,
                            'value2' => !is_array($variant['value2'])?$variant['value2']:null,
                            'quantity' => $variant['quantity'],
                            'barcode' => !is_array($variant['barcode']) ? $variant['barcode'] : null,
                    ]);
                }

            }

//            print_r(MainCategory::where('name', $phpArray['product'][0]['main_category'])->first()->value('id'));
//            print_r($phpArray['product'][0]['variants']['variant'][0]);
//            foreach ($phpArray['product'] as $item) {
//                if(is_array($item['detail'])){
//                    echo $item['productCode'].' --- ';
//                }
//            }
//            print_r($phpArray['product'][200]['detail']);
        });
    }
}
