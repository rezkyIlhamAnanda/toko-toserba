<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Menampilkan semua transaksi
    public function index(Request $request)
    {
        $query = FinancialTransaction::with('order');

        // Filter berdasarkan type
        if ($request->has('type') && $request->type !== null) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('dashboard.transaction.index', compact('transactions'));
    }

    // Menampilkan form tambah transaksi
    public function create()
    {
        return view('dashboard.transaction.create');
    }

    // Simpan transaksi
    public function store(Request $request)
    {
        $request->validate([
            'type'     => 'required|in:income,expense',
            'order_id' => 'required|exists:orders,id',
            'tanggal'  => 'required|date',
        ]);

        FinancialTransaction::create([
            'type'     => $request->type,
            'order_id' => $request->order_id,
            'tanggal'  => $request->tanggal,
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    // Menampilkan detail transaksi
    public function show($id)
    {
        $transaction = FinancialTransaction::with('order')->findOrFail($id);

        return view('dashboard.transaction.show', compact('transaction'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $transaction = FinancialTransaction::findOrFail($id);

        return view('dashboard.transaction.edit', compact('transaction'));
    }

    // Update transaksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'type'     => 'required|in:income,expense',
            'order_id' => 'required|exists:orders,id',
            'tanggal'  => 'required|date',
        ]);

        $transaction = FinancialTransaction::findOrFail($id);

        $transaction->update([
            'type'     => $request->type,
            'order_id' => $request->order_id,
            'tanggal'  => $request->tanggal,
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Hapus transaksi
    public function destroy($id)
    {
        $transaction = FinancialTransaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
