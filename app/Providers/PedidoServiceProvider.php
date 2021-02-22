<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PedidoInterface;
use App\Repositories\EloquentPedido;
use App\Repositories\PedidoDetalleInterface;
use App\Repositories\EloquentPedidoDetalle;
use App\Repositories\CajaChicaInterface;
use App\Repositories\EloquentCajaChica;
class PedidoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(PedidoInterface::Class,EloquentPedido::Class);
        $this->app->bind(PedidoDetalleInterface::Class,EloquentPedidoDetalle::Class);
        $this->app->bind(CajaChicaInterface::Class,EloquentCajaChica::Class);
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
