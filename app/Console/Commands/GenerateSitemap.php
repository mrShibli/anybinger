<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

use App\Models\User;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:generate-sitemap';
    protected $signature = 'sitemap:generate';

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
        // Manually create sitemap
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add('/');
        $sitemap->add('/pages/about-us');
        $sitemap->add('/pages/anybringr-shop');
        $sitemap->add('/pages/help-questions');
        $sitemap->add('/pages/contact-us');
        $sitemap->add('/login');

        // Dynamic pages
        $users = User::all();
        foreach ($users as $user) {
            $sitemap->add("/users/{$user->id}");
        }
        
        $product = Product::all();
        
        foreach ($product as $product) {
            $sitemap->add("/product/{$product->slug}");
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
