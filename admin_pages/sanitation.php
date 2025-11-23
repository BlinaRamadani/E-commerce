<?php
include '../connection.php';

// Fetch only reports that have photos
$query = "SELECT m.*, m.reporter_name 
          FROM maintenance m 
          WHERE m.photo IS NOT NULL 
            AND m.photo != '' 
          ORDER BY m.created_at DESC";

$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>

<h3 class="mb-4">
    <i class="fas fa-images text-primary me-2"></i>
    Reports with Photos 
    <span class="badge bg-primary fs-6"><?= mysqli_num_rows($result) ?></span>
</h3>

<?php if (mysqli_num_rows($result) == 0): ?>
    <div class="text-center py-5 text-muted">
        <i class="fas fa-images fa-5x mb-4 opacity-25"></i>
        <p class="fs-5">No reports with photos yet</p>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 hover-shadow">
                    <a href="../<?= htmlspecialchars($row['photo']) ?>" 
                       data-lightbox="photo-gallery" 
                       data-title="<?= htmlspecialchars($row['description'] ?? 'Issue') ?>">
                        <img src="../<?= htmlspecialchars($row['photo']) ?>" 
                             class="card-img-top" 
                             alt="Report photo"
                             style="height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title text-truncate">
                            <?= htmlspecialchars($row['description'] ?? 'No description') ?>
                        </h6>
                        <div class="mt-auto">
                            <small class="text-muted">
                                <i class="fas fa-tag"></i> <?= ucfirst($row['issue_type'] ?? 'Other') ?>
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($row['created_at'])) ?>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center pb-3">
                        <a href="maintenance.php?id=<?= $row['id'] ?>" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> View Report
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<!-- Lightbox (beautiful full-screen photos) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<style>
.hover-shadow:hover { 
    transform: translateY(-4px); 
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important; 
    transition: all 0.3s ease;
}
</style>

<script>
lightbox.option({
    resizeDuration: 200,
    wrapAround: true,
    disableScrolling: false,
    albumLabel: "Photo %1 of %2"
});
</script>