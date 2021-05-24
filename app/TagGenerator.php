<?php

namespace App;

use \App\Models\Commercial;
use \App\Models\Tag;

class TagGenerator
{
    public static function generate($slug)
    {
        $pluckedTags = Tag::pluck('id', 'name')->toArray();
        $commercial = Commercial::with(['fields' => function ($q) {
            $q->where('is_tag', true);
        }, 'category' => function ($q) {
            $q->with('parent', 'fields');
        }])->whereSlug($slug)->firstOrFail();
        $tags[] = [
            'name'      => $commercial->category->name,
            'search'    => $commercial->category->name,
            'type'      => 0,
        ];
        if($commercial->category->parent_id) {
            $tags[] = [
                'name'      => $commercial->category->parent->name,
                'search'    => $commercial->category->parent->name,
                'type'      => 0,
            ];
        }
        if($commercial->category->buy != null && $commercial->category->sell != null) {
            $tags[] = [
                'name'      => $commercial->buy ? $commercial->category->buy : $commercial->category->sell,
                'search'    => $commercial->buy ? $commercial->category->sell : $commercial->category->buy,
                'type'      => 1,
            ];
        }
        foreach($commercial->fields as $field) {
            $tags[] = [
                'name'      => $field->pivot->value,
                'search'    => $field->pivot->value,
                'type'      => 2,
            ];
        }
        foreach($tags as $tag) {
            if(!in_array($tag['name'], $pluckedTags)) {
                $theTag = Tag::create($tag);
                $tagsId[] = $theTag->id;
            } else {
                $tagsId[] = $pluckedTags[$tag['name']];
            }
        }
        $commercial->tags()->sync($tagsId);
    }
}