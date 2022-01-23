<?php

use App\Models\Category;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('parseEKatalog', function() {
    $url = 'https://www.e-katalog.ru/ek-list.php?search_=rtx+3080&katalog_from_search_=189';
    $data = file_get_contents($url);
    $dom = new DomDocument();
    @$dom->loadHTML($data); //@ - оператор, который позволяет проигнорировать возможные ошибки в стянутом коде, в основном используется при работе с loadHTML.

    $xpath = new DomXPath($dom);

    $totalProductsString = $xpath->query("//span[@class='t-g-q']")[0]->nodeValue ?? false;
    preg_match_all('/\d+/', $totalProductsString, $matches); // Поиск чисел в строке
    $totalProducts = (int) $matches[0][0];
   
    $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");
    $productsOnOnePage = $divs->length;

    $pages = ceil($totalProducts / $productsOnOnePage);

    $products = [];

    foreach ($divs as $div) {
       $a = $xpath->query("descendant::a[@class='model-short-title no-u']", $div);
       $name = $a[0]->nodeValue;
       
       $price = 'Нет в наличии';
       $ranges = $xpath->query("descendant::div[@class='model-price-range']", $div);
       if ($ranges->length == 1) {
           foreach ($ranges[0]->childNodes as $child) {
               if ($child->nodeName == 'a') {
                   $price = 'от ' . $child->nodeValue;
               }
           }
        }
       $ranges = $xpath->query("descendant::div[@class='pr31 ib']", $div);
       if ($ranges->length == 1) {
           $price = $ranges[0]->nodeValue;
       }
       $products [] = [
           'name' => $name,
           'price' => $price,
       ];
    }

    for ($i = 1; $i < $pages; $i++) {
        $nextUrl = "$url&page_=$i";

        $data = file_get_contents($nextUrl);
        $dom = new DomDocument();
        @$dom->loadHTML($data);

        $xpath = new DomXPath($dom);
        $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");

        foreach ($divs as $div) {
            $a = $xpath->query("descendant::a[@class='model-short-title no-u']", $div);
            $name = $a[0]->nodeValue;
            
            $price = 'Нет в наличии';
            $ranges = $xpath->query("descendant::div[@class='model-price-range']", $div);
            
            if ($ranges->length == 1) {
                
                foreach ($ranges[0]->childNodes as $child) {
                    
                    if ($child->nodeName == 'a') {
                        $price = 'от ' . $child->nodeValue;
                    }
                }
            }
            $ranges = $xpath->query("descendant::div[@class='pr31 ib']", $div);
            
            if ($ranges->length == 1) {
                $price = $ranges[0]->nodeValue;
            }
            $products [] = [
                'name' => $name,
                'price' => $price,
            ];
        }
    }
    dd($products);
});

Artisan::command('massCategoriesInsert', function () {
    $categories = [
        [
            'name' => 'Видеокарты', 
            'description' => 'Которых нигде нет :(',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'name' => 'Процессоры', 
            'description' => 'AMD, Intel и прочие.',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
    ];
    Category::insert($categories);
});

Artisan::command('updateCategory', function () {
    Category::where('id', 2)->update([
        'description' => 'Которых нигде нет, надеюсь, что это временно.'
    ]);
});

Artisan::command('deleteCategory', function () {
    Category::whereNotNull('id')->delete();
});

Artisan::command('createCategory', function() {
    $category = new Category([
        'name' => 'Видеокарты',
        'description' => 'Которых нигде нет :(',
    ]);
    $category->save();
});

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
