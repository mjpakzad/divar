<?php

namespace App\Models;

use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commercial extends Model
{
    use SoftDeletes;
    
    public const STATUS_PENDING             = 0;
    public const STATUS_ACCEPTED            = 1;
    public const STATUS_REJECTED            = 2;
    public const SALE                       = 0;
    public const BUY                        = 1;
    public const FEATURED                   = true;
    public const IMMEDIATE                  = true;
    public const DELETE_KASHTIDARAN_SOLD    = 0;
    public const DELETE_ANOTHERWAY_SOLD     = 1;
    public const DELETE_NO_BUYERS           = 2;
    public const DELETE_CANCELD             = 3;
    public const DELETE_NO_RESULT           = 4;

    protected $fillable = [
        'user_id',
        'category_id',
        'city_id',
        'district_id',
        'registrar_id',
        'image_id',
        'type_id',
        'title',
        'slug',
        'content',
        'lat',
        'lng',
        'price',
        'meta_keywords',
        'meta_description',
        'expertise_checked',
        'status',
        'laddered_at',
        'featured_at',
        'reportage_at',
        'expire_at',
        'buy',
        'voice',
        'voice_mime',
        'aparat',
        'featured',
        'immediate',
        'delete_reason',
        'whatsapp',
    ];

    protected $dates = [
        'laddered_at',
        'featured_at',
        'reportage_at',
        'expire_at',
    ];
    
    protected $casts = ['immediate' => 'boolean', 'featured' => 'boolean'];
    
    public function views()
    {
        return $this->morphMany('App\Models\View', 'viewable');
    }
    
    public function clicks()
    {
        return $this->morphMany('App\Models\Click', 'clickable');
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function registrar()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class)->withPivot('value')->withTimestamps();
    }

    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePending($query)
    {
        return $query->whereStatus(self::STATUS_PENDING);
    }

    public function scopeAccepted($query)
    {
        return $query->whereStatus(self::STATUS_ACCEPTED);
    }

    public function scopeRejected($query)
    {
        return $query->whereStatus(self::STATUS_REJECTED);
    }
    
    public function scopeBuying($query)
    {
        return $query->whereBuy(self::BUY);
    }
    
    public function scopeSelling($query)
    {
        return $query->whereBuy(self::SALE);
    }

    public function scopeLaddered($query)
    {
        return $query->whereNotNull('laddered_at'); // TODO:: Change this query
    }

    public function scopeFeature($query)
    {
        return $query->where('featured', self::FEATURED);
    }
    
    public function scopeImmediated($query)
    {
        return $query->where('immediate', self::IMMEDIATE);
    }

    public function scopeReportage($query)
    {
        return $query->whereDate('reportage_at', '>', \Carbon\Carbon::now()->subYear());
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('expire_at', '<', \Carbon\Carbon::now());
    }

    public function scopeLive($query)
    {
        return $query->whereDate('expire_at', '>', \Carbon\Carbon::now());
    }

    public function scopeHasImage($query)
    {
        return $query->whereNotNull('image_id');
    }
    
    public function scopeExpertised($query)
    {
        return $query->where('expertise_checked', true);
    }

    public function delete()
    {
        if (!is_null($this->image_id)) {
            if(File::exists($this->image->name)) {
                unlink($this->image->name);
            }
        }
        foreach ($this->images as $image) {
            if(File::exists($image->name)) {
                unlink($image->name);
            }
        }
        return parent::delete();
    }
}
