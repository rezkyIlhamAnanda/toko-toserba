<div class="mt-4">
    <form action="{{ route('pesanan.updateStatus', $order->id) }}" method="POST" class="d-flex gap-2">
        @csrf
        @method('PUT')

        <select name="status" class="form-select w-auto">
            <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
