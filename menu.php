<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container-fluid px-lg-2">
        <a class="navbar-brand" href="index.php">Dhio Patty Alexander</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#portfolioNav" aria-controls="portfolioNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="portfolioNav">
            <ul class="navbar-nav ms-auto gap-lg-1">
                <li class="nav-item"><a class="nav-link <?= $page === 'home' ? 'active' : '' ?>" href="index.php?page=home">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $page === 'about' ? 'active' : '' ?>" href="index.php?page=about">About</a></li>
                <li class="nav-item"><a class="nav-link <?= $page === 'contact' ? 'active' : '' ?>" href="index.php?page=contact">Contact</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= in_array($page, ['level', 'studies'], true) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">My Studies</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item <?= $page === 'level' ? 'active' : '' ?>" href="index.php?page=level">Level</a></li>
                            <li><a class="dropdown-item <?= $page === 'studies' ? 'active' : '' ?>" href="index.php?page=studies">Studies</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="d-flex align-items-center gap-2 flex-column flex-lg-row ms-lg-3 mt-3 mt-lg-0">
                <?php if (!isset($_SESSION['user'])): ?>
                    <a class="btn btn-outline-light btn-sm" href="index.php?page=login">Login</a>
                <?php else: ?>
                    <div class="text-light small">
                        <div class="fw-600"><?= e($_SESSION['user']) ?></div>
                        <div class="opacity-75" style="font-size: 0.85rem;"><?= e($_SESSION['role']) ?></div>
                    </div>
                    <a class="btn btn-warning btn-sm" href="logout.php">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>