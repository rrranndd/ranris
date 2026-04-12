<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        $totalOrderHariIni = Order::whereDate('created_at', today())->count();

        $totalPendapatan = Order::whereDate('created_at', today())->sum('total');

        $recentOrders = Order::latest()->take(5)->get();

        $produkTerlaris = OrderItem::select('nama', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('nama')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        return view('admin.index', compact(
            'totalOrderHariIni',
            'totalPendapatan',
            'produkTerlaris',
            'recentOrders'
        ));
    }

    // 🔥 AUTO FORMAT NOMOR
    private function formatNomor($nomor)
    {
        $nomor = preg_replace('/[^0-9]/', '', $nomor); // hapus selain angka

        if (substr($nomor, 0, 1) == '0') {
            $nomor = '62' . substr($nomor, 1);
        }

        if (substr($nomor, 0, 2) != '62') {
            $nomor = '62' . $nomor;
        }

        return $nomor;
    }

    private function kirimWhatsApp($nomor, $pesan, $file = null)
    {
        $token = env('FONNTE_TOKEN');

        $data = [
            'target' => $nomor,
            'message' => $pesan,
        ];

        // 🔥 FIX KIRIM FILE
        if ($file) {
            $data['file'] = $file;
            $data['filename'] = 'invoice.pdf';
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function terima($id)
    {
        $order = Order::with('items')->findOrFail($id);

        $order->status = 'selesai';
        $order->save();

        $nomor = $this->formatNomor($order->telepon);

        // generate PDF
        $file = $this->generateInvoicePDF($order);

        // 🔥 pakai format pesan lengkap
        $pesan = $this->formatPesanTerima($order);

        // tambahkan info invoice
        $pesan .= "\n\nInvoice terlampir.";

        $this->kirimWhatsApp($nomor, $pesan, $file);

        return back();
    }

    public function tolak($id)
    {
        $order = Order::with('items')->findOrFail($id);

        $order->status = 'ditolak';
        $order->save();

        $nomor = $this->formatNomor($order->telepon);

        $pesan = $this->formatPesanTolak($order);

        $this->kirimWhatsApp($nomor, $pesan);

        return back();
    }

    public function pesanan(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();
        $status = $request->status;
        $search = $request->search;

        $query = Order::with('items');

        $query->whereDate('created_at', $tanggal);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('telepon', 'like', "%$search%");
            });
        }

        $orders = $query
            ->orderByRaw("
                CASE 
                    WHEN status = 'pending' THEN 1
                    WHEN status = 'selesai' THEN 2
                    WHEN status = 'ditolak' THEN 3
                END
            ")
            ->latest()
            ->get();

        $totalPending = Order::where('status', 'pending')->count();

        return view('admin.pesanan.index', compact(
            'orders',
            'tanggal',
            'status',
            'search',
            'totalPending'
        ));
    }

    public function laporan(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $query = Order::query();

        if ($dari && $sampai) {
            $query->whereBetween('created_at', [$dari, $sampai]);
        }

        $orders = $query->latest()->get();

        $totalPendapatan = (clone $query)->sum('total');
        $totalPesanan = (clone $query)->count();

        $produkTerlaris = OrderItem::select('nama', DB::raw('SUM(jumlah) as total_terjual'))
            ->whereIn('order_id', $orders->pluck('id'))
            ->groupBy('nama')
            ->orderByDesc('total_terjual')
            ->get();

        $grafik = Order::selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
            ->when($dari && $sampai, function ($q) use ($dari, $sampai) {
                $q->whereBetween('created_at', [$dari, $sampai]);
            })
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $maxPendapatan = Order::selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
            ->when($dari && $sampai, function ($q) use ($dari, $sampai) {
                $q->whereBetween('created_at', [$dari, $sampai]);
            })
            ->groupBy('tanggal')
            ->orderByDesc('total')
            ->first();

        $topProduk = $produkTerlaris->first();

        return view('admin.laporan.index', compact(
            'orders',
            'totalPendapatan',
            'totalPesanan',
            'produkTerlaris',
            'grafik',
            'maxPendapatan',
            'topProduk',
            'dari',
            'sampai'
        ));
    }

    public function getOrders(Request $request)
    {
        $query = Order::with('items');

        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('telepon', 'like', "%{$request->search}%");
            });
        }

        $orders = $query
            ->orderByRaw("
                CASE 
                    WHEN status = 'pending' THEN 1
                    WHEN status = 'selesai' THEN 2
                    WHEN status = 'ditolak' THEN 3
                END
            ")
            ->latest()
            ->get();

        return response()->json($orders);
    }

    private function formatPesanTerima($order)
    {
        $pesan = "Halo {$order->nama},\n\n";
        $pesan .= "Pesanan Anda telah DITERIMA.\n\n";

        $pesan .= "Detail Pesanan:\n";
        $pesan .= "-----------------------------\n";

        foreach ($order->items as $item) {
            $pesan .= "- {$item->nama} x{$item->jumlah}\n";
        }

        $pesan .= "-----------------------------\n";
        $pesan .= "Total: Rp " . number_format($order->total) . "\n\n";

        $pesan .= "Alamat Pengiriman:\n{$order->alamat}\n\n";

        $pesan .= "Pesanan sedang diproses.\n";
        $pesan .= "Terima kasih telah berbelanja di RANRIS STORE.";

        return $pesan;
    }

    private function formatPesanTolak($order)
    {
        $pesan = "Halo {$order->nama},\n\n";
        $pesan .= "Mohon maaf, pesanan Anda DITOLAK.\n\n";

        $pesan .= "Kemungkinan alasan:\n";
        $pesan .= "- Stok tidak tersedia\n";
        $pesan .= "- Area pengiriman tidak terjangkau\n\n";

        $pesan .= "Silakan hubungi admin untuk informasi lebih lanjut.\n\n";
        $pesan .= "RANRIS STORE";

        return $pesan;
    }

    private function formatInvoice($order)
    {
        $pesan = "INVOICE PESANAN\n";
        $pesan .= "RANRIS STORE\n";
        $pesan .= "=============================\n";

        $pesan .= "ID Pesanan : #" . $order->id . "\n";
        $pesan .= "Nama       : " . $order->nama . "\n";
        $pesan .= "Tanggal    : " . $order->created_at->format('d-m-Y') . "\n";
        $pesan .= "Alamat    : " . $order->alamat . "\n";
        $pesan .= str_repeat("-", 30) . "\n";
        $pesan .= "Catatan: Harap menunggu konfirmasi selanjutnya.\n";

        $pesan .= "-----------------------------\n";
        $pesan .= "Detail Pesanan:\n";

        foreach ($order->items as $item) {
            $pesan .= "- {$item->nama} x{$item->jumlah}\n";
        }

        $pesan .= "-----------------------------\n";
        $pesan .= "Total: Rp " . number_format($order->total) . "\n";
        $pesan .= "=============================\n";

        $pesan .= "Pesanan Anda telah diterima dan sedang diproses.\n";
        $pesan .= "Terima kasih telah berbelanja di RANRIS STORE.";

        return $pesan;
    }

    private function generateInvoicePDF($order)
    {
        $pdf = Pdf::loadView('admin.invoice_pdf', compact('order'));

        $filename = 'invoice_' . $order->id . '.pdf';
        $path = public_path('invoice/' . $filename);

        // pastikan folder ada
        if (!file_exists(public_path('invoice'))) {
            mkdir(public_path('invoice'), 0777, true);
        }

        $pdf->save($path);

        return asset('invoice/private' . $filename);
    }
}