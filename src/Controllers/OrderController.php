<?php

namespace KejvinGL\OrderTracker\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use KejvinGL\OrderTracker\Exports\OrderExport;
use KejvinGL\OrderTracker\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function dataTable()
    {
        $orders = Order::all();
        return DataTables::of($orders)
            ->editColumn('created_at', function ($order) {
                return Carbon::parse($order->created_at)->toDateTimeString();
            })
            ->editColumn('updated_at', function ($order) {
                return Carbon::parse($order->created_at)->toDateTimeString();
            })
            ->editColumn('error_message', function ($order) {
                return $order->error_message ?? "_";
            })
            ->toJson();
    }

    public function index()
    {
        return view('vendor.order-tracker.table');
    }

    public function createTransaction()
    {
        return view('vendor.order-tracker.api_payment');
    }

    public function processTransaction(Request $request)
    {
        try {
            $attr = $request->validate(['name' => config('order-tracker.validation.name'), 'email' => config('order-tracker.validation.email')]);
            $order = Order::create(['name' => $attr['name'],
                'email' => $attr['email'],
                'product' => config('order-tracker.product'),
                'price' => config('order-tracker.price'),
                'status' => 'Processing']);

            $response = ["id" => '3X4MPL3'];

            $order->update(['external_id' => $response['id']]);


            if (!isset($response['id'])  || $response['id'] == null) {            // redirect to approve href
                $order->update(['status' => 'Failed', 'error_message' => 'Something went wrong']);
                return redirect()
                    ->route('createTransaction')
                    ->with('error', 'Something went wrong.');
            } else {
                return redirect()->route('success.transaction')->with($response);
            }
        } catch (Exception $e) {
            return redirect()
                ->route('create.transaction')
                ->with('error', $e->getMessage());
        }
    }

    public function successTransaction(Request $request)
    {
        try {
            $order = Order::whereExternalId($request->response['id']);
            if ($request->response['id'] !== null){
                $order->update(['status' => 'Completed', 'error_message' => null]);
                return redirect()
                    ->route('create.transaction')
                    ->with('success', 'Transaction complete.');
            } else {
                $order->update(['status' => 'Failed', 'error_message' => $response['error']['message'] ?? 'Something went wrong.']);
                return redirect()
                    ->route('create.transaction')
                    ->with('error', $response['error']['message'] ?? 'Something went wrong.');
            }
        } catch (Exception $e) {
            return redirect()
                ->route('create.transaction')
                ->with('error', $e->getMessage());
        }
    }

    public function cancelTransaction(Request $request)
    {
        Order::find($request->order)->update(['status' => 'Cancelled']);
        return redirect()
            ->route('login')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    public function export()
    {
        return Excel::download(new OrderExport, 'orders_' . now()->format('d-m-y') . '.xlsx');
    }
}
