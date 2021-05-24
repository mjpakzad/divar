<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\City;
use App\Models\Commercial;
use App\Models\District;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    /**
     * Display list of commercials inside a category of city.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $citySlug
     * @param  $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request, $citySlug, $slug)
    {
        if($citySlug != 'all') {
            $city = City::whereSlug($citySlug)->firstOrFail();
        }
        else {
            $city = false;
        }
        
        $category           = Category::with('activeChildren', 'fields')->whereSlug($slug)->firstOrFail();
        $commercialsQuery   = Commercial::with([
            'district',
            'fields' => function ($query) {
                $query->price();
            },
        ]);
        if($city) {
            $commercialsQuery->whereCityId($city->id);
        }
        $commercialsQuery->accepted();
        if ($request->input('category')) {
            $commercialsQuery->where('category_id', $request->input('category'));
        } else {
            $categories = [$category->id];
            foreach ($category->activeChildren as $child) {
                $categories[] = $child->id;
                foreach ($child->activeChildren as $grand) {
                    $categories[] = $grand->id;
                }
            }
            $commercialsQuery->whereIn('category_id', $categories);
        }
        if($request->input('dynamicFields')) {
            $filters = $request->input('dynamicFields');
            $commercialsQuery->when(!empty($filters), function($q) use ($filters)
            {
                foreach ($filters as $fieldId => $value)
                {
                    $q->where(function ($query) {
                       $query->wherePivot('field_id', $filterId)
                           ->wherePivot('value', $value);
                    });
                }
            });
        }
        if($request->input('dynamicSwitches')) {
            $filters = $request->input('dynamicSwitches');
            $commercialsQuery->when(!empty($filters), function ($q) use($filters)
            {
                foreach ($filters as $fieldId) {
                    $q->where(function ($query) {
                        $query->wherePivot('field_id', $fieldId)
                        ->wherePivot('value', 1);
                    });
                }
            });
        }
        if ($request->district) {
            $commercialsQuery->where('district_id', $request->district);
        }
        if ($request->phrase) {
            $commercialsQuery->where('title', 'LIKE', "%$request->phrase%");
        }
        if ($request->hasImage) {
            $commercialsQuery->whereNotNull('image_id');
        }
        if ($request->isFeatured) {
            $featured_days = Setting::where('key', 'featured_days')->value('value');
            $commercialsQuery->whereNotNull('featured_at')
                ->where('featured_at', '>', Carbon::now()->subDays($featured_days));
        }
        $commercials = $commercialsQuery->latest('laddered_at')->paginate(16);
        if ($request->ajax()) {
            $view = view('frontend.partials.advertise', compact('commercials'))->render();
            return response()->json([
                'html' => $view
            ]);
        }
        return view('frontend.categories.show', compact('commercials', 'city', 'category', 'citySlug'));
    }

    /**
     * Display list of commercials inside a city.
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function show(Request $request, $slug)
    {
        $city               = City::whereSlug($slug)->firstOrFail();
        $commercialsQuery   = Commercial::with([
            'district',
            'fields' => function ($query) {
                $query->price();
            },
        ])
            ->whereCityId($city->id)
            ->accepted();
        if ($request->category) {
            $commercialsQuery->where('category_id', $request->category);
        }
        if ($request->district) {
            $commercialsQuery->where('district_id', $request->district);
        }
        if ($request->phrase) {
            $commercialsQuery->where('title', 'LIKE', "%$request->phrase%");
        }
        if ($request->hasImage) {
            $commercialsQuery->whereNotNull('image_id');
        }
        if ($request->isFeatured == 'true') {
            $featured_days = Setting::where('key', 'featured_days')->value('value');
            $commercialsQuery->whereNotNull('featured_at')
                            ->where('featured_at', '>', Carbon::now()->subDays($featured_days));
        }
        $commercials = $commercialsQuery->latest('laddered_at')->paginate(16);
        if ($request->ajax()) {
            $view = view('frontend.partials.advertise', compact('commercials'))->render();
            return response()->json([
                'html' => $view
            ]);
        }
        return view('frontend.cities.show', compact('commercials', 'city'));
    }

    public function districts(Request $request)
    {
        $city = $request->city;
        $term = $request->search ?? '';
        $districts = District::wherehas('city', function ($query) use($city) {
            $query->whereSlug($city);
        })->where('name', 'LIKE', "%$term%")->pluck('name', 'id');

        $data = [];
        foreach ($districts as $id => $name) {
            $data[] = [
                'id'    => $id,
                'text'  => $name,
            ];
        }

        return response()->json($data);
    }

    public function hasDistrict(Request $request)
    {
        if(!$request->city) {
            $message = [
                'status'    => 'danger',
                'body'      => "شهر را باید به درستی انتخاب کنید.",
            ];
            return response()->json($message);
        }

        $city = City::whereSlug($request->city)->first();
        if(!$city) {
            $message = [
                'status'    => 'danger',
                'body'      => "شهری که درخواست نموده‌اید، وجود ندارد..",
            ];
            return response()->json($message);
        }

        $hasDistrict = District::where('city_id', $city->id)->count();
        $message = [
            'status'        => 'success',
            'body'          => "نتایج با موفقیت یافت شدند.",
            'hasDistrict'   => $hasDistrict > 0 ? true : false,
            'latitude'      => $city->latitude,
            'longitude'     => $city->longitude,
        ];
        return response()->json($message);
    }
}
