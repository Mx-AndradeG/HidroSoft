<?php

namespace App\Observers;

use App\Models\Categories\Category;
use App\Models\Log\Log;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $data   = "Nombre: " . $category->name . ", Descripción: " . $category->description;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Creación',
            'module' => 'Categorias',
            'action' => " Se creó una categoria con los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        $data   = "Nombre: " . $category->name . ", Descripción: " . $category->description;

        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Actualización',
            'module' => 'Categorias',
            'action' => " Se modifico una categoria ahora tiene los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $data   = "Nombre: " . $category->name . ", Descripción: " . $category->description . ", ID:  " . $category->id;
        
        Log::create([
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
            'type' => 'Eliminación',
            'module' => 'Categorias',
            'action' => " Se elimino una categoria que tenia los siguientes datos : " . $data,
        ]);
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
