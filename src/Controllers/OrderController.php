<?php

namespace KejvinGL\OrderTracker\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use KejvinGL\OrderTracker\Exports\OrderExport;
use KejvinGL\OrderTracker\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelPdf\Facades\Pdf;
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

    public function exportAsExcel()
    {
        return Excel::download(new OrderExport, 'orders_' . now()->format('d-m-y') . '.xlsx');
    }
    public function exportAsPDF()
    {
        try {
            return Pdf::view('pdf.users-pdf', ['users'=> Order::latest()->get()])
                ->format('a4')
                ->save('orders.pdf');
        } catch (Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
