document.addEventListener("DOMContentLoaded", function () {

    document.addEventListener("click", function (e) {

        if (e.target.classList.contains("plus") || e.target.classList.contains("minus")) {

            const parent = e.target.closest(".qty-control");
            const id = parent.dataset.id;

            let jumlahEl = parent.querySelector('.jumlah');
            let jumlah = parseInt(jumlahEl.innerText);

            if (e.target.classList.contains("plus")) {
                jumlah++;
            } else {
                jumlah--;
            }

            if (jumlah <= 0) {
                parent.closest("tr").remove();
                updateCart(id, 0);
                updateTotal();
                return;
            }

            jumlahEl.innerText = jumlah;

            updateCart(id, jumlah);

            updateTotal();
        }

    });

    function updateCart(id, jumlah) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ id: id, jumlah: jumlah })
        });
    }

    function updateTotal() {
        let total = 0;

        document.querySelectorAll("table tr").forEach(row => {
            let hargaEl = row.children[1];
            let jumlahEl = row.querySelector(".jumlah");
            let totalEl = row.children[3];

            if (hargaEl && jumlahEl && totalEl) {
                let harga = parseInt(hargaEl.innerText.replace(/\D/g, ""));
                let jumlah = parseInt(jumlahEl.innerText);

                let subtotal = harga * jumlah;

                totalEl.innerText = "Rp " + subtotal.toLocaleString("id-ID");

                total += subtotal;
            }
        });

        document.getElementById("total-harga").innerText =
            total.toLocaleString("id-ID");
    }

});