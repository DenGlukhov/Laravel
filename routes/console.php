<?php

use App\Models\Category;
use App\Models\User;
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

Artisan::command('importCategoriesFromFile', function() {
    
    $file = fopen('categories.csv', 'r');

    $i = 0;
    $insert = [];
    while ($row = fgetcsv($file, 1000, ';')) {
       
        if ($i++ == 0) {
            $bom = pack('H*', 'EFBBBF'); //Создает запись "невидимого символа", который создает Excel.
            $row = preg_replace("/^$bom/", '', $row); //С помощью регулярного выражения ищет "символ" и заменяте его на пустое значение, после чего записывает результат в $row.

            $columns = $row;
            continue;
        }

        $data = array_combine($columns, $row);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $insert [] = $data;
    }

    Category::insert($insert);
});

Artisan::command('parseEKatalog', function() {

    $pageCounter = 0;
    do {
        $url = 'https://www.e-katalog.ru/ek-list.php?search_=rtx+3090&katalog_from_search_=189' . "&page_=$pageCounter";
        $data = file_get_contents($url);
        $dom = new DomDocument();
        @$dom->loadHTML($data); //@ - оператор, который позволяет проигнорировать возможные ошибки в стянутом коде, в основном используется при работе с loadHTML.

        $xpath = new DomXPath($dom);
        $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");

        if ($pageCounter == 0) {
            
            $totalProductsString = $xpath->query("//span[@class='t-g-q']")[0]->nodeValue ?? false; //Строка в которой содержится указание о найденном количество товаров.
            preg_match_all('/\d+/', $totalProductsString, $matches); //Поиск чисел в строке
            $totalProducts = (int) $matches[0][0];
            $productsOnOnePage = $divs->length;
            $pages = ceil($totalProducts / $productsOnOnePage);

            $products = [];
        }

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
            $singlePrice = $xpath->query("descendant::div[@class='pr31 ib']", $div);
            
            if ($singlePrice->length == 1) {
                $price = $singlePrice[0]->nodeValue;
            }
            $products[] = [
                'name' => $name,
                'price' => $price,
            ];
        }
        $pageCounter++;
    } while ($pageCounter < $pages);
    dump($products);

    $file = fopen('videocards.csv', 'w');

    foreach ($products as $product) {
        fputcsv($file, $product, ';');
    }
    fclose($file);
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
        'description' => 'Которых нигде нет, и стоят они как космолет.'
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

Artisan::command('testfile', function () {
    $name = User::where('email', 'a454s@gmail.com')->first();
    echo $name;
});