<?php

namespace Wenkang124\HasSlug\;

use Packages\ProductSlug\Models\Slug;

trait HasSlug
{

    protected static function boot()
    {
        parent::boot();
        self::saved(function ($model) {
            $model->generateSlug($model::SLUGNAME);
        });
    }


    public function slugs()
    {
        return $this->morphMany(Slug::class, Slug::MORPHABLE);
    }

    public function slug($slug)
    {
        return $this->whereValue($slug);
    }


    public function checkSlugExist($slug)
    {
        return $this->slugs()->whereValue($slug)->doesntExist();
    }

    public function getLatestSlug()
    {
        return $this->slugs()->latest()->first()->value;
    }

    public function generateSlug($column)
    {
        $name = mb_ereg_replace('/', '', $this->{$column});
        $slug = mb_strtolower(trim(mb_ereg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

        $unique = false;
        $counter = 0;

        while (!$unique) {
            $checkSlug = $this->checkSlugExist($slug);
            if ($checkSlug) {
                $unique = true;
            } else {
                $uniqueness = "";

                if ($counter > 0) {
                    $uniqueness = "-$counter";
                }

                $slug = mb_strtolower(trim(mb_ereg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-')) . $uniqueness;
            }
            $counter++;
        }

        return $this->slugs()->create(['value' => $slug]);
    }
}
