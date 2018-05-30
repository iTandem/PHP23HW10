<?php
    
    /* ==== Транспорт и автомобиль ==== */
    
    interface Colorable
    {
        public function getColor();
    }
    
    interface Paintable
    {
        public function paint($r, $g, $b);
    }
    
    class CityVehicle
    {
        const WHEEL_COUNT = 4;
        
        protected $speed = 0;
        
        protected static $maxSpeed;
        
        public function accelerator($time)
        {
            if ($this->speed < self::$maxSpeed) {
                $this->speed += $time;
            }
        }
        
        public function breakPedal($time)
        {
            if ($this->speed) {
                $this->speed = 3*$time;
            }
        }
        
        public static function setMaxSpeed($speed)
        {
            self::$maxSpeed = $speed;
        }
    }
    
    class Car extends CityVehicle implements Paintable, Colorable
    {
        private $wheelCount = parent::WHEEL_COUNT;
        private $color = [255, 255, 255];
        
        public function __construct($color)
        {
            $this->color = $color;
        }
        
        public function getWheelCount()
        {
            return $this->wheelCount;
        }
        
        public function getColor()
        {
            return $this->color;
        }
        
        public function getSpeed()
        {
            return $this->speed;
        }
        
        public function getMaxSpeed()
        {
            return self::$maxSpeed;
        }
        
        public function paint($r, $g, $b)
        {
            if (in_array($r, range(0,255)) or
                in_array($g, range(0,255)) or
                in_array($b, range(0,255))) {
                echo 'Все компоненты цвета должны быть в диапазоне от 0 до 255'.PHP_EOL;
            }
            else {
                $this->color = [$r, $g, $b];
            }
        }
        
        public function takeOffWheels($wheelCount)
        {
            if (!$this->wheelCount) {
                echo 'На машине не установлены колёса'.PHP_EOL;
            }
            elseif ($wheelCount > parent::WHEEL_COUNT) {
                echo 'У машины не бывает столько колёс'.PHP_EOL;
            }
            elseif ($wheelCount > $this->wheelCount) {
                echo 'Вы пытаетесь снять колёс больше, чем установлено на машине. Установлено: '.$this->wheelCount.PHP_EOL;
            }
            else {
                $this->wheelCount -= $wheelCount;
            }
        }
        
        public function takeOnWheels($wheelCount)
        {
            if ($this->wheelCount == parent::WHEEL_COUNT) {
                echo 'На машине установлены все колёса'.PHP_EOL;
            }
            elseif ($wheelCount + $this->wheelCount > parent::WHEEL_COUNT) {
                echo 'Вы пытаетесь установить колёс больше, чем может быть в машине. Установлено: '.$this->wheelCount.PHP_EOL;
            }
            else {
                $this->wheelCount += $wheelCount;
            }
        }
    }
    
    /* ==== Бытовая техника и телевизор ==== */
    
    interface Powerable
    {
        public function clickPower();
    }
    
    class Gadget implements Powerable
    {
        protected $serialNumber;
        protected $powerOn = false;
        
        public function __construct($number)
        {
            $this->serialNumber = $number;
        }
        
        public function getSerialNumber()
        {
            return $this->serialNumber;
        }
        
        public function getPowerOn()
        {
            return $this->powerOn;
        }
        
        public function clickPower()
        {
            $this->powerOn = !$this->powerOn;
        }
    }
    
    class TvSet extends Gadget
    {
        private $channels = ['Первый', 'Россия'];
        private $volume = 0;
        private $currentChannel = 0;
        
        public function __construct($number)
        {
            parent::__construct($number);
        }
        
        public function getChannels()
        {
            return $this->channels;
        }
        
        public function getVolume()
        {
            return $this->powerOn ? $this->volume : 0;
        }
        
        public function getCurrentChannel()
        {
            return $this->powerOn ? $this->currentChannel : null;
        }
        
        public function clickTune($channels)
        {
            if ($this->powerOn) {
                $this->channels = array_merge($this->channels, $channels);
            }
        }
        
        public function clickVolumePlus($time)
        {
            if ($this->powerOn) {
                $newVolume = $this->volume + $time;
                $this->volume = ($newVolume < 100) ? $newVolume : 100;
            }
        }
        
        public function clickVolumeMinus($time)
        {
            if ($this->powerOn) {
                $newVolume = $this->volume - $time;
                $this->volume = ($newVolume > 0) ? $newVolume : 0;
            }
        }
        
        public function clickChannelPlus()
        {
            if ($this->powerOn) {
                if ($this->currentChannel == count($this->channels) - 1) {
                    $this->currentChannel = 0;
                }
                else {
                    $this->currentChannel += 1;
                }
            }
        }
        
        public function clickChannelMinus()
        {
            if ($this->powerOn) {
                if ($this->currentChannel == 0) {
                    $this->currentChannel = count($this->channels) - 1;
                }
                else {
                    $this->currentChannel -= 1;
                }
            }
        }
    }
    
    /* ==== Письменные принадлежности и пишущая ручка ==== */
    
    class WritingItem implements Colorable
    {
        protected $color;
        
        public function __construct($color)
        {
            $this->color = $color;
        }
        
        public function getColor()
        {
            return $this->color;
        }
    }
    
    class Pen extends WritingItem
    {
        const PT_INK_RATE = 0.01;
        
        private $inkLevel = 100;
        
        public function __construct($color = [0, 0, 255])
        {
            parent::__construct($color);
        }
        
        public function getInkLevel()
        {
            return $this->inkLevel;
        }
        
        public function write($chars, $fontSize)
        {
            if ($this->inkLevel > 0) {
                $inkRate = self::PT_INK_RATE * $chars * $fontSize;
                
                if ($this->inkLevel > $inkRate) {
                    $this->inkLevel = round($this->inkLevel - $inkRate, 2); 
                }
                else {
                    $possibleChars = floor($this->inkLevel / self::PT_INK_RATE * $fontSize );
                    
                    echo "Невозможно написать $chars символов $fontSize-м шифтом оставшимся количеством чернил. Написано $possibleChars символов".PHP_EOL;
                }
            }
        }
        
        public function recharge()
        {
            $this->inkLevel = 100;
        }
    }

//==== Игрушки и утка ====
    
    interface Pressable
    {
        public function press();
    }
    
    class Toy implements Pressable
    {
        protected $color;
        protected $weight;
        
        public function __construct($color, $weight)
        {
            $this->color = $color;
            $this->weight = $weight;
        }
        
        public function getColor()
        {
            return $this->color;
        }
        
        public function getWeight()
        {
            return $this->weight;
        }
        
        public function press()
        {
            echo "Making sound!".PHP_EOL;
        }
    }
    
    class Duck extends Toy implements Pressable
    {
        
        public function __construct($color = [255, 255, 0], $weight = 100) // Standard yellow rubber duck
        {
            parent::__construct($color, $weight);
        }
        
        public function press()
        {
            echo "Quack!".PHP_EOL;
        }
    }
    
    /* ===== Вещь и товар ==== */
    
    interface Discountable
    {
        public function getDiscount();
        public function setDiscount($discount);
    }
    
    class Item
    {
        protected $name;
        protected $description;
        protected $category;
        
        public function __construct($name, $description, $category)
        {
            $this->name = $name;
            $this->description = $description;
            $this->category = $category;
        }
    }
    
    class Product extends Item implements Discountable
    {
        private $weight = 100; 
        private $price = 0;    
        private $discount = 0; 
        
        public function __construct(
            $name,
            $weight,
            $price,
            $description = "",
            $category = "Uncategorized",
            $discount = 0)
        {
            parent::__construct($name, $description, $category);
            
            $this->setWeight($weight);
            $this->setPrice($price);
            $this->setDiscount($discount);
        }
        
        public function getName()
        {
            return $this->name;
        }
        
        public function getDescription()
        {
            return $this->description;
        }
        
        public function getCategory()
        {
            return $this->category;
        }
        
        public function getWeight()
        {
            return $this->weight;
        }
        
        public function getPrice()
        {
            $price = round($this->price * (1 - 0.01 * ($this->discount)), 2);
            
            return $price;
        }
        
        public function getDiscount()
        {
            return $this->discount;
        }
        
        public function setDescription($description) {
            $this->description = $description;
        }
        
        public function setCategory($category) {
            $this->category = $category;
        }
        
        public function setPrice($price) {
            if ($price > 0) {
                $this->price = $price;
            }
            else {
                echo 'Цена не может быть отрицательной. Задана цена по умолчанию: '.$this->price.PHP_EOL;
            }
        }
        
        public function setDiscount($discount)
        {
            if ($discount >= 0 and $discount < 100) {
                $this->discount = $discount;
            }
            else {
                echo 'Скидка может быть в пределах от 0 до 100 (не включительно). Задана скидка по умолчанию: '.$this->discount.PHP_EOL;
            }
        }
        
        public function setWeight($weight)
        {
            if ($weight > 0) {
                $this->weight = $weight;
            }
            else {
                echo 'Вес не может быть отрицательным. Задан вес по умолчанию: '.$this->weight.PHP_EOL;
            }
        }
    }
    
    
    
    $silverCar = new Car([192, 192, 192]);
    $siennaCar = new Car([160, 82, 45]);
    
    $silverCar->setMaxSpeed(300);
    echo $silverCar->getMaxSpeed().PHP_EOL;
    
    $tvSet1 = new TvSet('TV00001');
    $tvSet2 = new TvSet('TV00002');
    
    $tvSet1->clickPower();
    $tvSet1->clickVolumePlus(3);
    $tvSet1->clickVolumeMinus(2);
    echo $tvSet1->getVolume().PHP_EOL;
    
    $bluePen = new Pen([0, 0, 255]);
    $greenPen = new Pen([0, 255, 0]);
    
    print_r($bluePen->getColor());
    
    $standardYellowDuck = new Duck([255, 255, 0], 2000);
    $hugeCyanDuck = new Duck([0, 255, 255], 3000);
    
    echo $hugeCyanDuck->getWeight().PHP_EOL;
    $hugeCyanDuck->press();
    
    $huawei = new Product('Huawei P20 Lite', 174, 19999, 'Самый доступный смартфон.', 'Смартфоны', 0);
    $ps4Pro = new Product('Playstation 4 Pro', 3300, 29999, 'Самая ожидаемая новинка.', 'Игровые приставки', 10);
    
    
    $huawei->setDiscount(25);
    echo $huawei->getPrice();
    
    
    /**
     * Created by PhpStorm.
     * User: konstantin
     * Date: 29.05.2018
     * Time: 22:25
     */