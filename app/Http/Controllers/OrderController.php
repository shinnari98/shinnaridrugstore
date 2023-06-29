<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Requests\CheckPaymentRequest;
use App\Models\Orders_fails;
use App\Models\Products;
use App\Models\Star;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function payment(Request $request)
    {

        $request->session()->forget('status_payment');
        $cart = session()->get('cart');
        $user = Auth::user();
        return view('drugstore.order.payment', compact('cart', 'user'));
    }

    public function payNow(Request $request)
    {
        $data = $request->all();
        return redirect()->route('payNow.index', compact('data'));
    }

    public function payNowIndex(Request $request)
    {
        $request->session()->forget('status_payment');
        $data = $request->data;
        $user = Auth::user();
        return view('drugstore.order.payNow', compact('user', 'data'));
    }

    public function orderSend(CheckPaymentRequest $request)
    {
        if ($request->pay == 'card') {
            $card['card_number'] = $request->card_number;
            $card['expiration_date'] = $request->expiration_date;
            $card['cvv'] = $request->cvv;
            $request->session()->put('card', $card);
        }
        $data = $request->validated();
        $user = Auth::user();
        $cart = session()->get('cart');

        $request->session()->put('back.phone', $request->phone);
        $request->session()->put('back.email', $request->email);
        $request->session()->put('back.address', $request->address);
        $request->session()->put('back.deli_time', $request->deli_time);
        $request->session()->put('back.pay', $request->pay);
        $request->session()->put('back.card_number', $request->card_number);
        $request->session()->put('back.expiration_date', $request->expiration_date);
        $request->session()->put('back.cvv', $request->cvv);

        return view('drugstore.order.paymentConfirm', compact('data', 'user', 'cart'));
    }

    public function payNowSend(CheckPaymentRequest $request)
    {
        if ($request->pay == 'card') {
            $card['card_number'] = $request->card_number;
            $card['expiration_date'] = $request->expiration_date;
            $card['cvv'] = $request->cvv;
            $request->session()->put('card', $card);
        }
        $user = Auth::user();
        $data = $request->validated();
        // dd($data);
        $request->session()->put('back.id', $request->id);
        $request->session()->put('back.name', $request->name);
        $request->session()->put('back.quantity', $request->quantity);
        $request->session()->put('back.price', $request->price);

        $request->session()->put('back.phone', $request->phone);
        $request->session()->put('back.email', $request->email);
        $request->session()->put('back.address', $request->address);
        $request->session()->put('back.deli_time', $request->deli_time);
        $request->session()->put('back.pay', $request->pay);
        $request->session()->put('back.card_number', $request->card_number);
        $request->session()->put('back.expiration_date', $request->expiration_date);
        $request->session()->put('back.cvv', $request->cvv);


        return view('drugstore.order.payNowConfirm', compact('data', 'user'));
    }

    public function orderComplete(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart');
        foreach ($cart->products as $item) {
            Orders::create([
                'product_id' => $item['productInfo']->id,
                'user_id' => $user->id,
                'quantity' => $item['quantity'],
                'to_address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'pay_by' => $request->pay,
                'deli_time' => $request->deli_time,
                'total_money' => $item['price'] * 1.1,
            ]);
        }
        /* DB::statement('UPDATE products
                        SET sold = IFNULL((SELECT SUM(quantity) FROM orders WHERE orders.product_id = products.id), 0)'); */
        Products::UpdateSold();
        return redirect()->route('paymentComplete', compact('user'));
    }

    public function payNowComplete(Request $request)
    {
        $user = Auth::user();
        Orders::create([
            'product_id' => $request->product_id,
            'user_id' => $user->id,
            'quantity' => $request->quantity,
            'to_address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'pay_by' => $request->pay,
            'deli_time' => $request->deli_time,
            'total_money' => $request->total_money,
        ]);
        /* DB::statement('UPDATE products
                        SET sold = IFNULL((SELECT SUM(quantity) FROM orders WHERE orders.product_id = products.id), 0)'); */
        Products::UpdateSold();
        return redirect()->route('paymentComplete', compact('user'));
    }

    public function paymentComplete(Request $request)
    {
        $request->session()->forget('back');
        $request->session()->forget('card');
        $request->session()->forget('back.name');
        $request->session()->forget('back.id');
        $request->session()->forget('back.quantity');
        $request->session()->forget('back.price');
        $request->session()->forget('back.phone');
        $request->session()->forget('back.email');
        $request->session()->forget('back.address');
        $request->session()->forget('back.deli_time');
        $request->session()->forget('back.pay');
        $request->session()->forget('back.card_number');
        $request->session()->forget('back.expiration_date');
        $request->session()->forget('back.cvv');
        $request->session()->forget('cart');

        $request->session()->put('status_payment', true);
        $user = Auth::user();
        return view('drugstore.order.paymentComplete', compact('user'));
    }

    public function showMyOrder(Request $request)
    {
        $user = Auth::user();
        $orderList = Orders::where('user_id', $user->id)->where('del_flg', 0)->paginate(5);
        $stars = Star::where('user_id', $user->id)->get();
        // dd($stars);
        return view('drugstore.user.orderHistory.show', compact('orderList', 'user', 'stars'));
    }

    public function editMyOrder(Orders $order, $id)
    {
        $order = Orders::where('id', $id)->first();
        // dd($order);
        return view("drugstore.user.orderHistory.edit", compact('order'));
    }

    public function updateMyOrder(CheckPaymentRequest $request)
    {
        $id = $request->id;
        $order = Orders::where('id', $id)->first();
        $order->to_address = $request->input('address');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');

        $order->save();

        $text = '注文 id' . $order->id . ' 編集しました。';
        return redirect()->route('user.showOrder')->with('success', $text);
    }

    public function index()
    {
        $orders = Orders::paginate(20);
        return view('drugstore.admin.order.allOrder', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$id)
    {
        $order = Orders::where('id', $id)->first();

        return view("drugstore.admin.order.oneOrder", compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders, $id)
    {
        $order = Orders::where('id', $id)->first();
        return view("drugstore.admin.order.editOrder", compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CheckPaymentRequest $request, $id)
    {
        $order = Orders::where('id',$id)->first();
        $order->deli_status = $request->input('deli_status');
        $order->to_address = $request->input('address');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');

        $order->save();

        $text = 'Order id' . $order->id . ' updated successfully';
        if (Auth::user()->permission_id == 1) {
            return redirect()->route('order.show', ['order' => $order->id])->with('success', $text);
        } else {
            return redirect()->route('producer.orderShow', ['id' => $order->id])->with('success', $text);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders, $id)
    {
        $order = Orders::find($id);
        $text = 'order id' . $id . ' deleted successfully';
        $order->delete();
        return redirect()->route('order.index')->with('success', $text);
    }

    public function reason(Request $request,$id)
    {
        $request->session()->put('status_orderFail', true);
        $order = Orders::find($id);
        return view('drugstore.user.orderHistory.cancel', compact('order'));
    }

    public function orderFailCreat(Request $request)
    {
        $request->session()->put('status_orderFail', true);
        Orders_fails::create([
            'cancel_reason' => $request->cancel_reason,
            'order_id' => $request->order_id,
            'cancel_from_id' => $request->cancel_from_id
        ]);
        $order = Orders::where('id', $request->order_id)->first();
        // dd($order);
        $order->del_flg = 1;
        $order->save();

        $text = '注文 id' . $request->order_id . ' キャンセルしました。';
        if (Auth::user()->permission_id == 3) {
            return redirect()->route('user.showOrder')->with('success', $text);
        } else {
            return redirect()->route('producer.order')->with('success', $text);
        }
    }

    /* producer */
    public function showProducerAll(Request $request)
    {
        $products = Products::where('producer_id',Auth::user()->id)->get();
        $productsId = $products->pluck('id');
        $orders = Orders::whereIn('product_id', $productsId)->where('del_flg',0)->orderByDesc('created_at')->paginate(20);
        return view('drugstore.admin.order.allOrder', compact('orders'));
    }

}
