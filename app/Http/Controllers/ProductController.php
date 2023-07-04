<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Likes;
use App\Models\Carts;
use Illuminate\Http\Request;
use App\Http\Requests\makeProductRequest;
use App\Models\Categories;
use App\Models\Star;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public static string $categories;

    public function typeProduct(Request $request,$id)
    {
        // dd($name);
        $products = Products::where('category_id',$id)->paginate(10);
        if (Auth::user()) {
            $likes = Likes::UserLikes()->get();
        } else {
            $likes = $request->session()->get('likes', []);
        }


        $famous = Products::FamousProducts();
        $typeProduct = Categories::where('id',$id)->first()->name;
        return view('drugstore.product.type', compact('products','likes','famous','typeProduct'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::paginate(20);
        return view('drugstore.admin.product.allProduct', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        // $data['create'] = true;
        // dd($user);
        return view('drugstore.admin.product.creatProduct', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(makeProductRequest $request, Products $product)
    {
        $data = $request->validated();
        // $data['create'] = true;
        // dd($data);
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/product_img'), $filename);
            $data['image'] = $filename;
        }
        // dd($data['sale_off']);
        Products::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'producer_id' => $data['producer_id'] ?? $user->id,
            'price' => $data['price'],
            'sale_off' => $data['sale_off'],
            'description' => $data['description'],
            'image' => $data['image'] ?? '',
        ]);
        $text = 'Product created successfully';
        // dd($product);
        if (Auth::user()->permission_id == 1) {
            return redirect()->route('product.index')->with('success', $text);
        } else {
            return redirect()->route('producer.showProduct')->with('success', $text);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $page = $request->page;      
        // dd($request->page);  
        $product = Products::find($id);
        $user = Auth::user();
        $like = Likes::where('user_id', $user->id)->where('product_id', $id)->first();
        // $starnumber = Star::where('product_id',$id)->count('user_id');
        // dd($starnumber);
        if (Auth::user()->permission_id == 2) {
            // dd($product->producer_id);
            if(Gate::denies('producerProduct',$product)) {
                return redirect()->route('homepage');
            }
        }
        if (!empty($request->type)) {
            $typeId = Categories::where('name',$request->type)->first()->id; 
            return view('drugstore.admin.product.oneProduct', compact('page', 'product', 'like','typeId'));
        } else {
            return view('drugstore.admin.product.oneProduct', compact('page', 'product', 'like'));
        }
    }

    public function showUser(Request $request, $id)
    {
        
        $data = Products::find($id);
        $user = Auth::user();
        if ($user) {
            $like = Likes::UserLikeProduct($id)->first();
        } else {
            $like = '';
        }
        if (!empty($request->type)) {
            $typeId = Categories::where('name',$request->type)->first()->id; 
            return view('drugstore.product.view', compact('data', 'user', 'like','typeId'));
        } else {
            return view('drugstore.product.view', compact('data', 'user', 'like'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $product = Products::find($id);
        $user = Auth::user();
        if (Auth::user()->permission_id == 2) {
            if(Gate::denies('producerProduct',$product)) {
                return redirect()->route('homepage');
            }
        }
        return view('drugstore.admin.product.editProduct', compact('product', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(makeProductRequest $request, $id)
    {
        $product = Products::where('id',$id)->first();
        // $data['create'] = false;
        $data = $request->validated();
        $oldImg = $product->image;
        if ($request->hasFile('image') && $oldImg) {
            $oldImagePath = public_path('img/product_img/' . $oldImg);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->producer_id = $request->input('producer_id');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->sale_off = $request->input('sale_off');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/product_img'), $filename);
            $product->image = $filename;
        }
        $product->save();
        $text = 'Product id' . $product->id . ' updated successfully';
        if (Auth::user()->permission_id == 1) {
            return redirect()->route('product.show', ['product' => $product->id])->with('success', $text);
        } else {
            return redirect()->route('producer.productShow', ['id' => $product->id])->with('success', $text);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $product = Products::find($id);
        if (Auth::user()->permission_id == 2) {
            if(Gate::denies('producer-product',$product)) {
                return redirect()->route('homepage');
            }
        }
        $text = 'Product id ' . $id . ' deleted successfully';
        $product->delete();
        if (Auth::user()->permission_id == 1) {
            return redirect()->route('product.index')->with('success', $text);
        } else {
            return redirect()->route('producer.showProduct')->with('success', $text);
        }
    }

    public function like(Request $request)
    {
        $product_id = $request->input('id');
        $is_like = $request->input('isLike') === 'true';
        $user = Auth::user();

        if ($user) {
            // Tìm bản ghi trong database dựa trên user_id và product_id
            $like = Likes::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->first();

            if ($is_like) {
                // Nếu is_like là true và bản ghi không tồn tại, tạo mới bản ghi
                // dd('true');
                if (!$like) {
                    Likes::create([
                        'user_id' => $user->id,
                        'product_id' => $product_id,
                        'like' => true
                    ]);
                }
            } else {
                // Nếu is_like là false và bản ghi tồn tại, xóa bản ghi
                if ($like) {
                    $like->delete();
                }
            }
        } else {
            $likes = $request->session()->get('likes', []);
            $likes[$product_id] = $is_like;
            $request->session()->put('likes', $likes);
        }

        // Lưu trạng thái like vào session nếu người dùng chưa đăng nhập


       /*  DB::statement('UPDATE products
    SET like_count = (
        SELECT COUNT(product_id) FROM likes WHERE likes.product_id = products.id )'); */
        Products::updateLike();
        return null;
    }

    public function addStar(Request $request)
    {
        $user = Auth::user();
        $product_id = $request->input('id');
        $star_number = $request->star;
        // dd($star, $id);
        if ($user) {
            // Tìm bản ghi trong database dựa trên user_id và product_id
            $star = Star::where('user_id', $user->id)
                ->where('product_id', $product_id)
                ->first();

            // Nếu bản ghi không tồn tại, tạo mới bản ghi
            if (!$star) {
                Star::create([
                    'user_id' => $user->id,
                    'product_id' => $product_id,
                    'star_number' => $star_number
                ]);
            } else {
                Star::UserStarProduct($product_id)->update(['star_number' => $star_number]);
            }
        }
        /* DB::statement('UPDATE products
                        SET star = IFNULL((SELECT AVG(star_number) FROM stars WHERE stars.product_id = products.id),0)'); */
        
        Products::updateStar();
        return null;
    }

    public function addCart(Request $request)
    {
        // dd($request); 
        $id = $request->input('id');
        $product = Products::find($id);
        $quantity = $request->input('quantity');

        if ($product !== null) {
            $oldCart = Session('cart') ? Session('cart') : null;
            $newCart = new Carts($oldCart);
            $newCart->addCart($product, $id, $quantity);

            $request->session()->put('cart', $newCart);
            // dd(Session('cart'));
        }
        return view('drugstore.item.cart'/* ,compact('newCart','quantity') */);
    }

    public function deleteCart(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');

        $oldCart = Session('cart') ? Session('cart') : null;
        $newCart = new Carts($oldCart);
        $newCart->deleteItemCart($id);
        if (Count($newCart->products) > 0) {
            $request->session()->put('cart', $newCart);
        } else {
            $request->session()->forget('cart');
        }
        return view('drugstore.item.cart'/* ,compact('newCart','quantity') */);
    }

    /* producer */
    public function showMyProduct(Request $request)
    {
        $products = Products::where('producer_id',Auth::user()->id)->paginate(16);
        return view('drugstore.admin.product.allProduct', compact('products'));
    }
}
