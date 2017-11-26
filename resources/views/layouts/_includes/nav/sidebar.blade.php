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
            <li><a>Listes des Producteurs</a></li>
            <li><a href="{{ route('producteurs.create') }}" class="{{ page_active('producteurs.create') }}">Ajouter un Producteur</a></li>
        </ul>
        <p class="menu-label">
            Administration
        </p>
        <ul class="menu-list">
            <li><a>Team Settings</a></li>
            <li><a>Invitations</a></li>
            <li><a>Authentication</a></li>
        </ul>
    </aside>
</div>