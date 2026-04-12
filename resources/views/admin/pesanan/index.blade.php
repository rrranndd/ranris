@extends('layout.admin')

@section('content')

<h1>Kelola Pesanan</h1>

<form id="filterForm" class="filter-bar">

    <input type="text" name="search" placeholder="Cari nama / no HP"
        value="{{ $search }}" onkeyup="autoSubmit()">

    <input type="date" name="tanggal"
        value="{{ $tanggal }}" onchange="autoSubmit()">

    <select name="status" onchange="autoSubmit()">
        <option value="">Semua Status</option>
        <option value="pending" {{ $status=='pending' ? 'selected' : '' }}>Pending</option>
        <option value="selesai" {{ $status=='selesai' ? 'selected' : '' }}>Diterima</option>
        <option value="ditolak" {{ $status=='ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>

</form>

<div class="order-grid" id="orderContainer"></div>

<audio id="notifSound" src="https://www.soundjay.com/buttons/sounds/button-3.mp3"></audio>

<script>
let lastOrderCount = 0;

// FILTER
function autoSubmit() {
    const search = document.querySelector('[name=search]').value;
    const tanggal = document.querySelector('[name=tanggal]').value;
    const status = document.querySelector('[name=status]').value;

    window.location.href = `/admin/pesanan?search=${search}&tanggal=${tanggal}&status=${status}`;
}

function formatRupiah(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function fetchOrders() {
    const search = document.querySelector('[name=search]').value;
    const tanggal = document.querySelector('[name=tanggal]').value;
    const status = document.querySelector('[name=status]').value;

    fetch(`/admin/pesanan/data?search=${search}&tanggal=${tanggal}&status=${status}`)
    .then(res => res.json())
    .then(data => {

        const container = document.getElementById('orderContainer');

        if (data.length > lastOrderCount) {
            document.getElementById('notifSound').play();
        }

        lastOrderCount = data.length;

        container.innerHTML = '';

        if (data.length === 0) {
            container.innerHTML = `
                <div style="text-align:center; margin-top:50px; color:#999;">
                    <h3>Tidak ada pesanan</h3>
                </div>
            `;
            return;
        }

        data.forEach(order => {

            let items = '';
            order.items.forEach(item => {
                items += `
                    <div class="item">
                        <span>${item.nama}</span>
                        <span class="qty">x${item.jumlah}</span>
                    </div>
                `;
            });

            let actions = '';
            if (order.status === 'pending') {
                actions = `
                    <div class="actions">
                        <a href="/admin/order/${order.id}/terima" class="btn-terima btn-action">Terima</a>
                        <a href="/admin/order/${order.id}/tolak" class="btn-tolak btn-action">Tolak</a>
                    </div>
                `;
            }

            let statusLabel = order.status.toUpperCase();
            if (order.status === 'selesai') statusLabel = 'DITERIMA';

            container.innerHTML += `
                <div class="order-box ${order.status === 'pending' ? 'pending-box' : ''} new-order">

                    <!-- HEADER -->
                    <div class="order-header">
                        <div>
                            <h3>${order.nama}</h3>
                            <small>${new Date(order.created_at).toLocaleDateString('id-ID')}</small>
                        </div>

                        <span class="status ${order.status}">
                            ${statusLabel}
                        </span>
                    </div>

                    <!-- INFO -->
                    <div class="order-info">
                        <p><strong>No HP:</strong> ${order.telepon}</p>
                        <p><strong>Alamat:</strong> ${order.alamat}</p>
                    </div>

                    <!-- PRODUK -->
                    <div class="order-items">
                        ${items}
                    </div>

                    ${actions}

                    <!-- TOTAL -->
                    <div class="order-footer">
                        <strong>Rp ${formatRupiah(order.total)}</strong>
                    </div>

                </div>
            `;
        });

        document.querySelectorAll('.btn-action').forEach(btn => {
            btn.addEventListener('click', function() {
                this.innerHTML = 'Memproses...';
                this.style.opacity = '0.6';
                this.style.pointerEvents = 'none';
            });
        });

    });
}

setInterval(fetchOrders, 5000);
fetchOrders();
</script>

@endsection