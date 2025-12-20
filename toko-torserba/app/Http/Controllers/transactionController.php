<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class TransactionController extends Controller
{
    // Menampilkan semua transaksi
    public function index(Request $request)
    {
        $query = Transaction::with('user');

        // Filter berdasarkan type
        if ($request->has('type') && $request->type !== null) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(10);

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
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date'
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    // Menampilkan detail transaksi
    public function show($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        return view('dashboard.transaction.show', compact('transaction'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);

        return view('dashboard.transaction.edit', compact('transaction'));
    }

    // Update transaksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date'
        ]);

        $transaction = Transaction::findOrFail($id);

        $transaction->update([
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Hapus transaksi
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
