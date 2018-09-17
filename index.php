<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP OOP</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php

// Book [$price $title $author $pages $publisher(видавець) $year $hardcover(тверда обкладинка) $genres:array(жанр у вигляді масиву даних) size:Size(width, height з класу Size) ||| Властивості: info():void | getPrice(float):float | reserve():void | getGenres():string(жанри)] - Похідний клас Book
// Magazine [$price $subscriptionPrice(ціна за виписку) $title $pages $publisher(видавець) $year $number(номер) $numsPerYear(номерів за рік) size:Size(width, height з класу Size) ||| Властивості: info():void | getPrice(float):float | getSubscriptionPrice(float):float(ціна за виписку) | reserve():void ] - Похідний клас Magazine
// Newspaper [$price $subscriptionPrice(ціна за виписку) $title $pages $publisher(видавець) $year $number(номер) $numsPerYear(номерів за рік) $isColor size:Size(width, height з класу Size) ||| Властивості: info():void | getPrice(float):float | getSubscriptionPrice(float):float(ціна за виписку)] - Похідний клас Newspaper
// Poster [$price $title size:Size(width, height з класу Size) $type $series ||| Властивості: info():void | getPrice(float):float | customize():void(налащтування) ] - Похідний клас Poster
// EBook [$price $title $author $pages $publisher $year $fileSize ||| Властивості: info():void | getPrice(float):float | preview():void() ] - Похідний клас EBook
// EMagazine [$price $subscriptionPrice(ціна за виписку) $title $pages $publisher $year $number(номер) $numsPerYear(номерів за рік) $fileSize ||| Властивості: info():void | getPrice(float):float | getSubscriptionPrice(float):float(ціна за виписку) | preview():void() ] - Похідний клас EMagazine
// Postcard [$price $title $country $series size:Size(width, height з класу Size) ||| Властивості: info():void | getPrice(float):float] - Похідний клас Postcard
// PostStamp [$price $title $country $denominator(дільник?) $series size:Size(width, height з класу Size) ||| Властивості: info():void | getPrice(float):float] - Похідний клас PostStamp
// Calendar [$price $title $year $type size:Size(width, height з класу Size) ||| Властивості: info():void | getPrice(float):float] - Похідний клас Calendar

// Size [$width $height] - клас Size

// базовий клас Literature
class Literature {
    private $price;
    public $title;

    // геттери
    public function getPriceValue()
    {
        return $this->price;
    }
    // сеттери
    public function setPrice($price)
    {
        $this->price = $price;
    }
    // конструктор
    public function __construct($price, $title)
    {
        //echo "Literature constructor called!<br>";
        $this->price = $price;
        $this->title = $title;
    }
    // деструктор
    public function __destruct()
    {
        //echo "Literature destructor called!<br>";
    }

    // функція info() - виводить інформацію про об'єкт класу у вигляді html-таблиці
    public function info() {
        echo "<br>The function <strong>info()</strong> is called:<br>";
        $info = array_reverse(get_object_vars($this));
        $changed = array_reverse($info);
        //array_splice($changed,2,0,array_shift($changed));
        $nameClassProp = get_class($this);
        $tableHeader = "<table class='table'><caption> Інформація про об'єкт класу: $nameClassProp </caption>" .
            "<thead><tr><th>Властивість</th><th>Значення</th></tr></thead>";
        $tableFooter = "</table>\n";
        $tableContent = "<br>";
        foreach ($changed as $key => $value) {
            if (!$value) continue;
            if (gettype($value) == "object") {
                foreach ($value as $properties => $val) {
                    $tableContent .= $this->tableInfo($properties, $val);
                }
            } elseif (gettype($value) == "array") {
                $tableContent .= $this->tableInfo($key, implode(", ", $value));
            } else {
                $tableContent .= $this->tableInfo($key, $value);
            }
        }
        echo $tableHeader . $tableContent . $tableFooter;
    }
    // функція виводу даних до таблиці
    public function tableInfo($key, $value) {
        return "<tbody><tr><td>$key</td><td>$value</td></tr></tbody>";
    }
    // функція getPrice(float):float - отримує розмір знижки (у%) і повертає суму з її урахуванням
    public function getPrice($discountValue) {
        $resultDiscount = ($this->price * $discountValue) / 100;
        return "The function <strong>getPrice($discountValue):float</strong> is called for class " . get_class($this) . ": " .  ($this->price - $resultDiscount). "<br>";
    }
    // функція reserve():void - метод-заглушка, виводить (через echo) рядок про те, що викликана
    public function reserve() {
        echo "The function <strong>reserve()</strong> is called for class " . get_class($this) . "!<br>";
    }
    // preview (): void - метод-заглушка, виводить (через echo) рядок про те, що викликана
    public function preview() {
        echo "The function <strong> preview (): void</strong> is called for class " . get_class($this) . "!<br>";
    }
}

class Size {
    public $width, $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }
//    public function getRes() {
//        $this->res = new Size($this->width, $this->height);
//    }

}

// похідний клас Book від Literature
class Book extends Literature {
    // властивості
    public $author, $pages, $publisher, $year, $hardcover;
    public $genres = array();
    // конструктор
    public function __construct($price, $title, $author, $pages, $publisher, $year, $hardcover, $genres, Size $res)
    {
        // викликаємо батьківський конструктор
        parent::__construct($price, $title);
        $this->author = $author;
        $this->pages = $pages;
        $this->publisher = $publisher;
        $this->year = $year;
        $this->hardcover = $hardcover;
        $this->genres = array($genres);
        $this->res = $res;
        //var_dump($this->genres);
    }
    // функція getGenres():string - повертає вміст genres у вигляді рядка, значення розділені комою
    public function getGenres() {
        //$stringResult = explode("," , $this->genres . "<br>");

        $arrayResult = implode("," , $this->genres );
        return "The function <strong>getGenres()</strong> is called for class " . get_class($this) . ": " . $arrayResult. "<br>";
    }
//    public function getGenresVal() {
//        $arrayResult = implode("," , $this->genres );
//        return $arrayResult;
//    }
}

// похідний клас Magazine від Literature
class Magazine extends Literature {
    // властивості
    protected $subscriptionPrice;
    public $pages, $publisher, $year, $number, $numsPerYear;
    // геттери
    public function getSubscriptionPrice() {
        $this->subscriptionPrice;
    }
    // сеттери
    public function setSubscriptionPrice($subscriptionPrice) {
        $this->subscriptionPrice = $subscriptionPrice;
    }
    // конструктор
    public function __construct($price, $subscriptionPrice, $title, $pages, $publisher, $year, $number, $numsPerYear, Size $res)
    {
        // викликаємо батьківський конструктор
        parent::__construct($price, $title);
        $this->subscriptionPrice = $subscriptionPrice;
        $this->pages = $pages;
        $this->publisher = $publisher;
        $this->year = $year;
        $this->number = $number;
        $this->numsPerYear = $numsPerYear;
        $this->res = $res;
    }

    // функція getSubscriptionPrice(float):float - якщо subscriptionPrice не дорівнює нулю або null, то повернути її,
    // інакше розрахувати виходячи з ціни номера і періодичності виходу. В обох випадках враховувати знижку.
    public  function getSubscriptionPriceValue($discountValue) {
        if ($this->subscriptionPrice != 0 && $this->subscriptionPrice != null) {
            $res = ($this->subscriptionPrice - ($this->subscriptionPrice * $discountValue)/100);
            return "The function <strong>getSubscriptionPrice($discountValue):float()</strong> is called for class " . get_class($this) . ": " . $res . "<br>";
        } else {
            $resultDiscount = (($this->getPriceValue() * $this->numsPerYear) - ((($this->getPriceValue() * $this->numsPerYear) * $discountValue) / 100));
            return "The function <strong>getSubscriptionPrice($discountValue):float()</strong> is called for class " . get_class($this) . ": " . $resultDiscount . "<br>";
        }
    }
}

// похідний клас Newspaper від Magazine
class Newspaper extends Magazine {
    // властивості
    public $isColor;
    // конструктор
    public function __construct($price, $subscriptionPrice, $title, $pages, $publisher, $year, $number, $numsPerYear, $isColor, Size $res)
    {
        // викликаємо батьківський конструктор
        parent::__construct($price, $subscriptionPrice, $title, $pages, $publisher, $year, $number, $numsPerYear, $res);
        $this->isColor = $isColor;
        //$this->res = $res;
    }
}

// похідний клас Poster від Literature
class Poster extends Literature {
    // властивості
    public $type, $series;
    // конструктор
    public function __construct($price, $title, $type, $series, Size $res)
    {
        parent::__construct($price, $title);
        $this->type = $type;
        $this->series = $series;
        $this->res = $res;
    }
    // функція customize (): void - метод-заглушка, виводить (через echo) рядок про те, що викликана
    public function customize() {
        echo "The function <strong> customize (): void</strong> is called for class " . get_class($this) . "!<br>";
    }
}

// похідний клас EBook від Literature
class EBook extends Literature {
    // властивості
    public $author, $pages, $publisher, $year, $fileSize;
    // конструктор
    public function __construct($price, $title, $author, $pages, $publisher, $year, $fileSize)
    {
        parent::__construct($price, $title);
        $this->author = $author;
        $this->pages = $pages;
        $this->publisher = $publisher;
        $this->year = $year;
        $this->fileSize = $fileSize;
    }
}

// похідний клас EMagazine від Magazine
class EMagazine extends Magazine {
    // властивості
    public $fileSize;
    // конструктор
    public function __construct($price, $subscriptionPrice, $title, $pages, $publisher, $year, $number, $numsPerYear, Size $res, $fileSize)
    {
        parent::__construct($price, $subscriptionPrice, $title, $pages, $publisher, $year, $number, $numsPerYear, $res);
        $this->fileSize = $fileSize;
    }
}

// похідний клас Postcard від Literature
class Postcard extends Literature {
    // властивості
    public $country, $series;
    // конструктор
    public function __construct($price, $title, $country, $series, Size $res)
    {
        parent::__construct($price, $title);
        $this->country = $country;
        $this->series = $series;
        $this->res = $res;
    }
}

// похідний клас PostStamp від Literature
class PostStamp extends Literature {
    // властивості
    public $country, $denomination, $series;
    // конструктор
    public function __construct($price, $title, $country, $denomination, $series, Size $res)
    {
        parent::__construct($price, $title);
        $this->country = $country;
        $this->denomination = $denomination;
        $this->series = $series;
        $this->res = $res;
    }
}

// похідний клас Calendar від Literature
class Calendar extends Literature {
    // властивості
    public $year, $type;
    // конструктор
    public function __construct($price, $title, $year, $type, Size $res)
    {
        parent::__construct($price, $title);
        $this->year = $year;
        $this->type = $type;
        $this->res = $res;
    }
}

// створюємо об'єкт класу Literature
//$objectLiterature = new Literature(5000, "Література");
//echo $objectLiterature->info();

// створюємо об'єкт класу Book
$objectBook = new Book(400, "Біле ікло", "Джек Лондон", 132, "Британія", 1987, true, "Новела, Роман, Балада", new Size(100,80));
echo $objectBook->info();
echo $objectBook->getPrice(50);
echo $objectBook->reserve();
echo $objectBook->getGenres();
//echo $objectBook->getRes();
//$objectBook->res = new Size(40, 20);
//echo $objectBook->getGenresArrayResult();
//$objectBook = Book::getSizeParams("15", 25);
//echo $objectBook->size() . "<br>";

// створюємо об'єкт класу Magazine
$objectMagazine = new Magazine(10, 2000, "Форбс", 35, "London", 2018, 35, 200, new Size(86,92));
$objectMagazine1 = new Magazine(10, 0, "Times", 27, "Norwich", 2017, 16, 200, new Size(86,92));
echo $objectMagazine->info();
echo $objectMagazine->getPrice(10);
echo $objectMagazine->reserve();
echo $objectMagazine->getSubscriptionPriceValue(10);
echo $objectMagazine1->getSubscriptionPriceValue(10);

// створюємо об'єкт класу Newspaper
$objectNewspaper = new Newspaper(7, 1600, "Факти", 26, "Київ", 2018, 13, 124,"Сірий", new Size(89,95));
$objectNewspaper1 = new Newspaper(7, 0, "Вісник", 35, "Харків", 2018, 18, 124,"Білий", new Size(89,95));
echo $objectNewspaper->info();
echo $objectNewspaper->getPrice(25);
echo $objectNewspaper->getSubscriptionPriceValue(17);
echo $objectNewspaper1->getSubscriptionPriceValue(50);

// створюємо об'єкт класу Poster
$objectPoster = new Poster(17, "Космос","Соціальний", 14, new Size(180, 200));
echo $objectPoster->info();
echo $objectPoster->getPrice(7);
echo $objectPoster->customize();

// створюємо об'єкт класу EBook
$objectEBook = new EBook(250, "Останній дюйм","Джек Лондон", 285, "Британія", 1988, 2.5);
echo $objectEBook->info();
echo $objectEBook->getPrice(18);
echo $objectPoster->preview();

// створюємо об'єкт класу EMagazine
$objectEMagazine = new EMagazine(130, 2800, "Times", 38, "Bristol", 1900, 40, 90, new Size(45,25), 45);
$objectEMagazine1 = new EMagazine(130, 0, "Times", 38, "Bristol", 1900, 40, 90, new Size(45,25) , 45);
echo $objectEMagazine->info();
echo $objectEMagazine->getPrice(25);
echo $objectEMagazine->getSubscriptionPriceValue(15);
echo $objectEMagazine1->getSubscriptionPriceValue(45);
echo $objectEMagazine->preview();

// створюємо об'єкт класу Postcard
$objectPostcard = new Postcard(23, "Запрошення","Фінляндія", 28, new Size(28,30));
echo $objectPostcard->info();
echo $objectPostcard->getPrice(40);

// створюємо об'єкт класу PostStamp
$objectPostStamp = new PostStamp(45, "Марка","Іспанія", "Міжнародна", "44", new Size(10,10));
echo $objectPostStamp->info();
echo $objectPostStamp->getPrice(14);

// створюємо об'єкт класу Calendar
$objectCalendar = new Calendar(32, "Квлендар", 2018, "Космічний", new Size(15,20));
echo $objectCalendar->info();
echo $objectCalendar->getPrice(20);

?>

</body>
</html>
