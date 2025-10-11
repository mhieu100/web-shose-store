<?php

namespace Database\Seeders;

use App\Filament\Resources\Shop\Orders\OrderResource;
use App\Models\Address;
use App\Models\Blog\Author;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Blog\Link;
use App\Models\Blog\Post;
use App\Models\Comment;
use App\Models\Shop\Brand;
use App\Models\Shop\Category as ShopCategory;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\User;
use Closure;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::raw('SET time_zone=\'+00:00\'');

        // Clear images
        Storage::deleteDirectory('public');

        // Create roles and users with proper relationships
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // Shop
        $this->command->warn(PHP_EOL . 'Creating shop brands...');
        $brands = $this->withProgressBar(1, fn () => Brand::factory()->count(5)
            ->has(Address::factory()->count(1))
            ->create());
        Brand::query()->update(['sort' => new Expression('id')]);
        $this->command->info('Shop brands created.');

        $this->command->warn(PHP_EOL . 'Creating shop categories...');
        $categories = $this->withProgressBar(1, fn () => ShopCategory::factory()->count(5)->create());
        $this->command->info('Shop categories created.');

        $this->command->warn(PHP_EOL . 'Creating shop customers...');
        $customers = $this->withProgressBar(1, fn () => Customer::factory()->count(5)
            ->has(Address::factory()->count(1))
            ->create());
        $this->command->info('Shop customers created.');

        $this->command->warn(PHP_EOL . 'Creating shop products...');
        $products = $this->withProgressBar(1, fn () => Product::factory()->count(5)
            ->sequence(fn ($sequence) => ['shop_brand_id' => $brands->random(1)->first()->id])
            ->hasAttached($categories->random(rand(1, 2)), ['created_at' => now(), 'updated_at' => now()])
            ->has(
                Comment::factory()->count(rand(2, 5))
                    ->state(fn (array $attributes, Product $product) => ['customer_id' => $customers->random(1)->first()->id]),
            )
            ->create());
        $this->command->info('Shop products created.');

        $this->command->warn(PHP_EOL . 'Creating orders...');
        $orders = $this->withProgressBar(1, fn () => Order::factory()->count(5)
            ->sequence(fn ($sequence) => ['shop_customer_id' => $customers->random(1)->first()->id])
            ->has(Payment::factory()->count(1))
            ->has(
                OrderItem::factory()->count(rand(1, 3))
                    ->state(fn (array $attributes, Order $order) => ['shop_product_id' => $products->random(1)->first()->id]),
                'items'
            )
            ->create());

        // Get admin user for notifications
        $adminUser = User::whereHas('role', function($q) {
            $q->where('name', 'admin');
        })->first();
        
        foreach ($orders->random(rand(2, 3)) as $order) {
            Notification::make()
                ->title('Đơn hàng mới')
                ->icon('heroicon-o-shopping-bag')
                ->body("{$order->customer->name} ordered {$order->items->count()} products.")
                ->actions([
                    Action::make('View')
                        ->url(OrderResource::getUrl('edit', ['record' => $order])),
                ])
                ->sendToDatabase($adminUser);
        }
        $this->command->info('Shop orders created.');

        // Blog
        $this->command->warn(PHP_EOL . 'Creating blog categories...');
        $blogCategories = $this->withProgressBar(1, fn () => BlogCategory::factory()
            ->count(5)
            ->create());
        $this->command->info('Blog categories created.');

        $this->command->warn(PHP_EOL . 'Creating blog authors and posts...');
        $this->withProgressBar(1, fn () => Author::factory()->count(5)
            ->has(
                Post::factory()->count(2)
                    ->has(
                        Comment::factory()->count(rand(2, 5))
                            ->state(fn (array $attributes, Post $post) => ['customer_id' => $customers->random(1)->first()->id]),
                    )
                    ->state(fn (array $attributes, Author $author) => ['blog_category_id' => $blogCategories->random(1)->first()->id]),
                'posts'
            )
            ->create());
        $this->command->info('Blog authors and posts created.');

        $this->command->warn(PHP_EOL . 'Creating blog links...');
        $this->withProgressBar(1, fn () => Link::factory()
            ->count(5)
            ->create());
        $this->command->info('Blog links created.');

        // Commission system
        $this->command->warn(PHP_EOL . 'Creating commission data...');
        $this->call([
            CommissionSeeder::class,
        ]);
        $this->command->info('Commission data created.');
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection;

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
