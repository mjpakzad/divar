<?php

namespace Modules\Compare\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;

class CompareController extends Controller
{
    /**
     * Adds an specific product to the cart
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add(Request $request, $id)
    {
        abort_unless($request->ajax(), 404);
        $id = (int) $id;

        $product = Product::where('status', 1)->where('id', $id)->first();
        if ($product)
        {
            if (!session()->has('compare.' . $id)) {
                session(['compare.'.$id =>  $id]);
            }

            session()->save();

            $message = [
                'status'            => 'success',
                'body'              => "محصول با موفقیت به بخش مقایسه اضافه گردید.",
                'itemsInCompare'    => session('compare') ? count(session('compare')) : 0
            ];
        }
        else
        {
            $message = [
                'status'    => 'danger',
                'body'      => "محصول مورد نظر شما وجود ندارد."
            ];
        }


        return response()->json($message);
    }

    /**
     * Adds an specific product to the cart
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function remove(Request $request, $id)
    {
        $id = (int) $id;

        Product::findOrFail($id);

        if (session()->has('compare.' . $id)) {

            session()->forget('compare.' . $id);
        }

//        session()->save();

        return redirect()->route('compare');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $products = [];
        if(session()->has('compare')) {
            $products = Product::find(session('compare'))->take(4);

            $attributes = [];

            foreach ($products as $product) {
                foreach ($product->attributes as $attribute)
                {
                    $attributes[$attribute->group->id]['group'] = $attribute->group->name;
                    $attributes[$attribute->group->id]['attributes'][$attribute->name][$product->id] = $attribute->pivot->value;
                }
            }
        }

        return view()->first(['frontend.compare', 'compare::index'], compact('products', 'attributes'));
    }
}
