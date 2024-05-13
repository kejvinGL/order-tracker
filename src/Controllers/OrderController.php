<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use KejvinGL\OrderTracker\Exports\OrderExport;
use KejvinGL\OrderTracker\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware(config('order-tracker.middleware', []));
    }

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

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('success.transaction', ['name' => $attr['name'], 'email' => $attr['email']]),
                    "cancel_url" => route('cancel.transaction', ['order' => $order]),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => "3.14"
                        ]
                    ]
                ]
            ]);

            $order->update(['external_id' => $response['id'],]);

            if (isset($response['id']) && $response['id'] != null) {            // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                $order->update(['status' => 'failed', 'error_message' => 'Something went wrong']);

                return redirect()
                    ->route('createTransaction')
                    ->with('error', 'Something went wrong.');
            } else {
                $order->update(['status' => 'failed', 'error_message' => $response['error']['message']]);

                return redirect()
                    ->route('createTransaction')
                    ->with('error', $response['error']['message'] ?? 'Something went wrong.');
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
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);
            $order = Order::whereExternalId($response['id']);
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
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
