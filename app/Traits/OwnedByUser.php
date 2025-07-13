<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait OwnedByUser
{
    public static function bootOwnedByUser()
    {
        // Saat membuat record, isi created_by otomatis
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        // Global scope: hanya ambil data milik user login
        static::addGlobalScope('owned', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where($builder->getModel()->getTable() . '.created_by', Auth::id());
            }
        });
    }

    // Local scope kalau kamu mau pakai secara manual
    public function scopeOwned(Builder $query)
    {
        return $query->where($this->getTable() . '.created_by', Auth::id());
    }
}
