<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale($lang)
    {
        $availableLocales = ['en', 'uz']; // Qo'llab-quvvatlanadigan tillar

        if (in_array($lang, $availableLocales)) {
            App::setLocale($lang);
            Session::put('locale', $lang);// Sessiyada tilni saqlash
        }

        // Foydalanuvchini qayta yo'naltirish
        return redirect()->back();  // Yoki foydalanuvchini kerakli sahifaga yo'naltirish
    }

    public function setPrefix($lang)
    {

        App::setLocale($lang);
        Session::put('locale', $lang);

        if ($lang === 'en') {
            $newUrl = url('/en'); // "http://127.0.0.1:8000/en"
        } elseif ($lang === 'uz') {
            $newUrl = url('/uz'); // "http://127.0.0.1:8000/uz"
        } 
        return redirect($newUrl);
    }



}
