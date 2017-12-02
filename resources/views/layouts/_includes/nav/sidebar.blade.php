<div class="sidebar">
    <aside class="menu">
        <ul class="menu-list">
            <li><a class="{{ page_active('dashboard') }}" href="{{ route('dashboard') }}">Tableau de Bord</a></li>
        </ul>
        <p class="menu-label">
            Catégories
        </p>
        <ul class="menu-list">
            <li><a href="{{ route('categories.index') }}"
                   class="{{ page_active('categories.index') }}">Listes des Catégories</a></li>
            <li><a href="{{ route('categories.create') }}"
                   class="{{ page_active('categories.create') }}">Ajouter une Catégorie</a></li>
        </ul>
        <p class="menu-label">
            Producteurs
        </p>
        <ul class="menu-list">
            <li>
                <a class="{{ page_active('producteurs.create') }}" href="{{ route('producteurs.index') }}">
                    Comptes
                </a>
            </li>
            <li>
                <a href="{{ route('producteurs.create') }}" class="{{ page_active('producteurs.create') }}">
                    Créer un compte
                </a>
            </li>
        </ul>
    </aside>
</div>