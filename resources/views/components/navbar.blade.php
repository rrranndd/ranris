<nav class="navbar">
    <div class="logo">RANRIS</div>

    <ul class="nav-links">
        <li>
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
        </li>
        <li>
            <a href="/produk" class="{{ request()->is('produk') ? 'active' : '' }}">Produk</a>
        </li>
    </ul>
</nav>