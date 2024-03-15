<?php

namespace App\Providers;
use App\Models\Userlanguage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {    // Composer global pour toutes les vues
            if (Auth::check()) { // Vérifie si l'utilisateur est connecté
                $user = Auth::user();
                $view->with('user', $user);
            }
        });

        View::composer('covers', function ($view) {// Composer spécifique pour la vue 'covers'
            $langs = Userlanguage::get(); // Récupère toutes les langues de l'utilisateur
            $view->with('langs', $langs); // Partage les langues de l'utilisateur avec la vue 'covers'
        });
    }
}
