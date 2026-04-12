document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.cart-control').forEach(el => {
        const id = el.dataset.id;

        if (typeof cartData !== "undefined" && cartData[id]) {
            let jumlah = cartData[id].jumlah;

            el.innerHTML = `
                <button class="minus">-</button>
                <span class="jumlah">${jumlah}</span>
                <button class="plus">+</button>
            `;
        }
    });

    document.addEventListener("click", function (e) {

        if (e.target.classList.contains("tambah-btn")) {
            const parent = e.target.parentElement;
            const id = parent.dataset.id;

            parent.innerHTML = `
                <button class="minus">-</button>
                <span class="jumlah">1</span>
                <button class="plus">+</button>
            `;

            updateCart(id, 1);
        }

        if (e.target.classList.contains("plus")) {
            const parent = e.target.parentElement;
            const id = parent.dataset.id;

            let jumlahEl = parent.querySelector('.jumlah');
            let jumlah = parseInt(jumlahEl.innerText) + 1;

            jumlahEl.innerText = jumlah;
            updateCart(id, jumlah);
        }

        if (e.target.classList.contains("minus")) {
            const parent = e.target.parentElement;
            const id = parent.dataset.id;

            let jumlahEl = parent.querySelector('.jumlah');
            let jumlah = parseInt(jumlahEl.innerText) - 1;

            if (jumlah <= 0) {
                parent.innerHTML = `<button class="btn tambah-btn">Tambah</button>`;
                updateCart(id, 0);
            } else {
                jumlahEl.innerText = jumlah;
                updateCart(id, jumlah);
            }
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

});