<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ItemInventarioInterface;
use App\Repositories\EloquentItemInventario;
use App\Repositories\ProductoInterface;
use App\Repositories\EloquentProducto;
use App\Repositories\ProductoDetalleInterface;
use App\Repositories\EloquentProductoDetalle;
class AlmacenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(ItemInventarioInterface::Class,EloquentItemInventario::Class);
        $this->app->bind(ProductoInterface::Class,EloquentProducto::Class);
        $this->app->bind(ProductoDetalleInterface::Class,EloquentProductoDetalle::Class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
