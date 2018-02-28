<div class="column is-one-fifth sidebar">
    <aside class="menu">
        <p class="menu-label"></p>
        <ul class="menu-list">
            <li>
                <a href="/account" class="{{ request()->path() == 'account' ? 'is-active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Account Overview <span class="sr-only">(current)</span>
                </a>
            </li>
            <li>
                <a href="/account/urls" class="{{ request()->path() == 'account/urls' ? 'is-active' : '' }}">
                    <i class="fas fa-list"></i> Urls
                </a>
            </li>
            <li>
                <a href="/account/settings" class="{{ request()->path() == 'account/settings' ? 'is-active' : '' }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>
        </ul>
    </aside>
</div>
