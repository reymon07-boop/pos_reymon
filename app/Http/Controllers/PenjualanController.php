<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $user = Auth::user();
        $keyword = $request->search;

        $sales = Penjualan::with('user')

            ->when($user->role->name === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })

            ->when($keyword, function ($query) use ($keyword) {

                $query->whereHas('user', function ($q) use ($keyword) {

                    $q->where(
                        'name',
                        'like',
                        "%{$keyword}%"
                    );

                });

            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'penjualan.index',
            compact('sales')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(SearchRequest $request)
    {
        $sale = Penjualan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status' => 'OPEN'
            ],
            [
                'total_pembayaran' => 0,
                'metode_pembayaran' => 'CASH'
            ]
        );

        $keyword = $request->search;

        $products = Produk::when(
            $keyword,
            function ($query) use ($keyword) {

                $query->where(
                    'nama',
                    'like',
                    "%{$keyword}%"
                );

            }
        )
        ->orderBy('nama')
        ->get();

        $mode = 'create';

        return view(
            'penjualan.pos',
            compact(
                'sale',
                'products',
                'mode'
            )
        );
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
    public function show(Penjualan $penjualan)
    {
        /*
        |--------------------------------------------------------------------------
        | LOAD DATA TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | Kita load:
        | - user
        | - itemPenjualan
        | - produk dari setiap item
        |
        */

        $penjualan->load([
            'user',
            'itemPenjualan.produk'
        ]);

        $sale = $penjualan;

        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL
        |--------------------------------------------------------------------------
        |
        | Kalau total_pembayaran di database 0 tetapi
        | ternyata ada item transaksi, hitung dari subtotal.
        |
        */

        $totalItem = $sale->itemPenjualan->sum(
            'subtotal'
        );

        if (
            (float) $sale->total_pembayaran <= 0
            && $totalItem > 0
        ) {

            $sale->total_pembayaran = $totalItem;

        }


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        $products = Produk::orderBy('nama')->get();

        $mode = 'view';


        return view(
            'penjualan.detail',
            compact(
                'sale',
                'products',
                'mode'
            )
        );
    }


    /**
     * Laporan penjualan.
     */
    public function laporan()
    {
        $sales = Penjualan::with([
            'user',
            'itemPenjualan.produk'
        ])
        ->where('status', 'COMPLETED')
        ->latest()
        ->get();

        return view(
            'penjualan.laporan',
            compact('sales')
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;

        abort_if(
            $sale->status === 'COMPLETED',
            403
        );

        $sale->load([
            'user',
            'itemPenjualan.produk'
        ]);

        $products = Produk::orderBy('nama')->get();

        $mode = 'edit';

        return view(
            'penjualan.pos',
            compact(
                'sale',
                'products',
                'mode'
            )
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        Penjualan $penjualan
    ) {

        $request->validate([
            'payment_method' => 'required|in:CASH,QRIS'
        ]);


        if ($penjualan->status !== 'OPEN') {

            return back()->with(
                'errors',
                'Transaksi sudah diproses'
            );

        }


        if (
            $penjualan
                ->itemPenjualan()
                ->count() == 0
        ) {

            return back()->with(
                'errors',
                'Keranjang masih kosong'
            );

        }


        DB::transaction(function () use (
            $penjualan,
            $request
        ) {

            /*
            | Hitung total berdasarkan item
            */

            $total = $penjualan
                ->itemPenjualan()
                ->sum('subtotal');


            $penjualan->update([

                'metode_pembayaran'
                    => $request->payment_method,

                'total_pembayaran'
                    => $total,

                'status'
                    => 'COMPLETED'

            ]);

        });


        return redirect()
            ->route('penjualan.index')
            ->with(
                'success',
                'Transaksi berhasil diselesaikan'
            );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        /*
        |--------------------------------------------------------------------------
        | AUTHORIZATION
        |--------------------------------------------------------------------------
        */

        $this->authorize(
            'delete',
            $penjualan
        );


        DB::transaction(function () use (
            $penjualan
        ) {

            /*
            |--------------------------------------------------------------------------
            | Ambil semua item transaksi
            |--------------------------------------------------------------------------
            */

            $items = $penjualan
                ->itemPenjualan()
                ->with('produk')
                ->get();


            /*
            |--------------------------------------------------------------------------
            | Kalau transaksi OPEN
            |--------------------------------------------------------------------------
            |
            | Stok sebelumnya masih berada dalam proses transaksi.
            | Maka stok dikembalikan.
            |
            */

            if ($penjualan->status === 'OPEN') {

                foreach ($items as $item) {

                    if ($item->produk) {

                        $item->produk->increment(
                            'stok',
                            $item->kuantitas
                        );

                    }

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Hapus item transaksi
            |--------------------------------------------------------------------------
            */

            $penjualan
                ->itemPenjualan()
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | Hapus transaksi
            |--------------------------------------------------------------------------
            */

            $penjualan->delete();

        });


        return redirect()
            ->route('penjualan.index')
            ->with(
                'success',
                'Transaksi berhasil dihapus'
            );
    }
}