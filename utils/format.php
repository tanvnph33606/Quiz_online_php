<?php
class Format
{
    static function formatDate($date)
    {
        return date('F j, Y, g:i a', strtotime($date));
    }

    static function formatCurrency($amount)
    {
        $formattedAmount = number_format($amount, 0, ',', ',') . 'đ';
        return $formattedAmount;
    }

    static function formatNumber($number)
    {
        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . 'B';
        } elseif ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        } else {
            return $number;
        }
    }

    static function calculateOriginalPrice($Price, $discount)
    {
        if ($discount < 0 || $discount > 100) {
            return $originalPrice = 0;
        }
        $originalPrice = $Price / (1 - ($discount / 100));
        $originalPrice = number_format($originalPrice, 0, ',', ',') . 'đ';

        return $originalPrice;
    }

    static function renderStars($number)
    {
        $filledStars = round($number);
        $starArray = array();

        for ($index = 0; $index < 5; $index++) {
            if ($index < $filledStars) {
                $starArray[] = '<i class="fas fa-star"></i>';
            } else {
                $starArray[] = '<i class="far fa-star"></i>';
            }
        }
        return implode(' ', $starArray);
    }


    static function textShorten($text, $limit = 400)
    {
        $text = $text . " ";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text . ".....";
        return $text;
    }

    static function validation($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    static function title()
    {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');

        // Handle special cases
        $special_titles = [
            'index' => 'home',
            'contact' => 'contact',
        ];

        return isset($special_titles[$title]) ? ucfirst($special_titles[$title]) : ucfirst($title);
    }

    static function createSlug($string)
    {
        $string = str_replace(' ', '-', $string);
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9-]/', '', $string);
        $string = preg_replace('/-+/', '-', $string);
        $string = trim($string, '-');
        $random = rand(1, 10000);

        return $string . $random;
    }

    static function isStrongPassword($password)
    {
        if (strlen($password) < 8) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
            return false;
        }

        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }
        return true;
    }

    static function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    static function autoLoadFiles($directory)
    {
        if (is_dir($directory)) {
            $files = scandir($directory);
            foreach ($files as $file) {
                if (is_file($directory . '/' . $file)) {
                    require_once($directory . '/' . $file);
                }
            }
        }
    }
}
