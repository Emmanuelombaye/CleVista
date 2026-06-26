<?php
/**
 * CleVista Group Limited - Hospitality CRUD Listings Manager
 * Provides direct database additions, edits, deletions, and photo file uploads for short-term villas.
 */
include_once __DIR__ . '/includes/header.php';

$success_msg = null;
$error_msg = null;

// Initialize form variables (for add/edit states)
$edit_id = null;
$title = '';
$price_per_night = '';
$capacity = '';
$location = 'Diani';
$features = '';
$desc_en = '';
$desc_sw = '';
$desc_de = '';
$desc_it = '';
$desc_fr = '';
$desc_pl = '';
$existing_image = '';

// 1. Handle Deletions
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    try {
        // Fetch old image to delete file from uploads directory
        $stmt = $pdo->prepare("SELECT image_url FROM villas WHERE id = ?");
        $stmt->execute([$delete_id]);
        $old_img = $stmt->fetchColumn();
        if ($old_img && file_exists('../uploads/' . $old_img)) {
            unlink('../uploads/' . $old_img);
        }
        
        $stmt = $pdo->prepare("DELETE FROM villas WHERE id = ?");
        $stmt->execute([$delete_id]);
        $success_msg = "Villa listing deleted successfully.";
        
        // Invalidate Redis Cache
        require_once __DIR__ . '/../includes/redis.php';
        redis_set('hospitality_villas', null);
    } catch (PDOException $e) {
        $error_msg = "Error deleting record: " . $e->getMessage();
    }
}

// 2. Fetch specific listing for Editing
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM villas WHERE id = ?");
        $stmt->execute([$edit_id]);
        $villa = $stmt->fetch();
        if ($villa) {
            $title = $villa['title'];
            $price_per_night = $villa['price_per_night'];
            $capacity = $villa['capacity'];
            $location = $villa['location'];
            $features = $villa['features'];
            $desc_en = $villa['description_en'];
            $desc_sw = $villa['description_sw'];
            $desc_de = $villa['description_de'];
            $desc_it = $villa['description_it'];
            $desc_fr = $villa['description_fr'];
            $desc_pl = $villa['description_pl'];
            $existing_image = $villa['image_url'];
        }
    } catch (PDOException $e) {
        $error_msg = "Error fetching record: " . $e->getMessage();
    }
}

// 3. Handle Form Add/Update Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_villa'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $price_per_night = htmlspecialchars(trim($_POST['price_per_night']));
    $capacity = htmlspecialchars(trim($_POST['capacity']));
    $location = htmlspecialchars(trim($_POST['location']));
    $features = htmlspecialchars(trim($_POST['features']));
    $desc_en = htmlspecialchars(trim($_POST['desc_en']));
    $desc_sw = htmlspecialchars(trim($_POST['desc_sw']));
    $desc_de = htmlspecialchars(trim($_POST['desc_de']));
    $desc_it = htmlspecialchars(trim($_POST['desc_it']));
    $desc_fr = htmlspecialchars(trim($_POST['desc_fr']));
    $desc_pl = htmlspecialchars(trim($_POST['desc_pl']));
    $update_id = isset($_POST['edit_id']) ? intval($_POST['edit_id']) : null;
    
    // Default image source
    $image_filename = $existing_image;
    
    // Check if new image is uploaded
    if (isset($_FILES['villa_image']) && $_FILES['villa_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['villa_image']['tmp_name'];
        $file_name = $_FILES['villa_image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($file_ext, $allowed_exts)) {
            // Ensure uploads directory exists
            if (!file_exists('../uploads')) {
                mkdir('../uploads', 0777, true);
            }
            
            // Unique filename
            $image_filename = 'villa_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
            $dest_path = '../uploads/' . $image_filename;
            
            if (move_uploaded_file($file_tmp, $dest_path)) {
                // Delete older image file if updating
                if ($update_id && $existing_image && file_exists('../uploads/' . $existing_image)) {
                    unlink('../uploads/' . $existing_image);
                }
            } else {
                $error_msg = "Error moving uploaded file.";
            }
        } else {
            $error_msg = "Invalid file type. Only JPG, PNG, and WEBP files are allowed.";
        }
    }
    
    // Save to DB if no validation issues
    if ($error_msg === null) {
        try {
            if ($update_id) {
                // Update query
                $stmt = $pdo->prepare("UPDATE villas SET title = ?, price_per_night = ?, capacity = ?, location = ?, description_en = ?, description_sw = ?, description_de = ?, description_it = ?, description_fr = ?, description_pl = ?, features = ?, image_url = ? WHERE id = ?");
                $stmt->execute([$title, $price_per_night, $capacity, $location, $desc_en, $desc_sw, $desc_de, $desc_it, $desc_fr, $desc_pl, $features, $image_filename, $update_id]);
                $success_msg = "Villa listing updated successfully.";
            } else {
                // Insert query
                $stmt = $pdo->prepare("INSERT INTO villas (title, price_per_night, capacity, location, description_en, description_sw, description_de, description_it, description_fr, description_pl, features, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $price_per_night, $capacity, $location, $desc_en, $desc_sw, $desc_de, $desc_it, $desc_fr, $desc_pl, $features, $image_filename]);
                $success_msg = "New villa listing added successfully.";
            }
            
            // Invalidate Redis Cache
            require_once __DIR__ . '/../includes/redis.php';
            redis_set('hospitality_villas', null);
            
            // Clear form parameters and redirect
            header("Location: hospitality.php?success=" . urlencode($success_msg));
            exit();
        } catch (PDOException $e) {
            $error_msg = "Database Error: " . $e->getMessage();
        }
    }
}

// Fetch success redirects
if (isset($_GET['success'])) {
    $success_msg = htmlspecialchars($_GET['success']);
}

// Fetch Listings
$villas = [];
try {
    $villas = $pdo->query("SELECT * FROM villas ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    $error_msg = "Could not fetch villas list: " . $e->getMessage();
}
?>

<div class="admin-header">
    <div>
        <h1>Manage Villa Stays</h1>
        <p style="color: var(--admin-text-muted);">View, create, and edit short-term accommodation listings</p>
    </div>
</div>

<?php if ($success_msg): ?>
    <div class="alert alert-success" style="border-radius: 6px; margin-bottom: 24px;"><?php echo $success_msg; ?></div>
<?php endif; ?>
<?php if ($error_msg): ?>
    <div class="alert alert-error" style="border-radius: 6px; margin-bottom: 24px;"><?php echo $error_msg; ?></div>
<?php endif; ?>

<div class="admin-form-grid" style="grid-template-columns: 1.2fr 0.8fr; align-items: start; gap: 32px;">
    
    <!-- Villas List Grid -->
    <div class="admin-card-panel" style="margin-bottom: 0;">
        <h2>Active Accommodations</h2>
        <div class="admin-table-container" style="margin-top: 20px;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title / Location</th>
                        <th>Capacity</th>
                        <th>Price/Night</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($villas)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--admin-text-muted);">No villa listings found. Create your first holiday stay on the right!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($villas as $vil): ?>
                            <tr>
                                <td>
                                    <?php 
                                    $img_src = 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=150&q=80';
                                    if (!empty($vil['image_url'])) {
                                        $img_src = '../uploads/' . $vil['image_url'];
                                    }
                                    ?>
                                    <img src="<?php echo $img_src; ?>" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                                </td>
                                <td>
                                    <div style="font-weight: 600;"><?php echo htmlspecialchars($vil['title']); ?></div>
                                    <div style="font-size: 0.75rem; color: var(--admin-text-muted);"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($vil['location']); ?></div>
                                </td>
                                <td><span style="font-size:0.85rem; color: var(--admin-text-muted);"><?php echo htmlspecialchars($vil['capacity']); ?></span></td>
                                <td style="font-family: 'Outfit'; font-weight:600; color: var(--admin-accent-teal);"><?php echo htmlspecialchars($vil['price_per_night']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="hospitality.php?edit=<?php echo $vil['id']; ?>" class="action-btn"><i class="fa-solid fa-pen"></i> Edit</a>
                                        <a href="hospitality.php?delete=<?php echo $vil['id']; ?>" class="action-btn action-btn-danger" onclick="return confirm('Are you sure you want to delete this villa stay?');"><i class="fa-solid fa-trash"></i> Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit/Add Form -->
    <div class="admin-card-panel" style="margin-bottom: 0;">
        <h2><?php echo $edit_id ? 'Edit Villa Stay' : 'Add New Accommodation'; ?></h2>
        
        <form action="hospitality.php" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
            <?php if ($edit_id): ?>
                <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="title">Villa Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required placeholder="e.g. Swahili Gold Villa">
            </div>
            
            <div class="admin-form-grid" style="grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="price_per_night">Price per Night</label>
                    <input type="text" name="price_per_night" id="price_per_night" class="form-control" value="<?php echo htmlspecialchars($price_per_night); ?>" required placeholder="e.g. KSh 35,000">
                </div>
                <div class="form-group">
                    <label for="capacity">Guest Capacity</label>
                    <input type="text" name="capacity" id="capacity" class="form-control" value="<?php echo htmlspecialchars($capacity); ?>" required placeholder="e.g. 8 Guests (4 Bedrooms)">
                </div>
            </div>

            <div class="admin-form-grid" style="grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="location">Location / Area</label>
                    <input type="text" name="location" id="location" class="form-control" value="<?php echo htmlspecialchars($location); ?>" required placeholder="e.g. Galu Beach, Diani">
                </div>
                <div class="form-group">
                    <label for="villa_image">Villa Photo</label>
                    <input type="file" name="villa_image" id="villa_image" class="form-control" style="padding: 8px;">
                    <?php if ($existing_image): ?>
                        <p style="font-size:0.75rem; margin-top: 4px; color: var(--admin-text-muted);">Current: <em><?php echo $existing_image; ?></em></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="features">Features (Comma separated)</label>
                <input type="text" name="features" id="features" class="form-control" value="<?php echo htmlspecialchars($features); ?>" placeholder="e.g. Private Pool, Chef, WiFi, Ocean Access">
            </div>

            <!-- Description Translators (6 Tabs/Fields) -->
            <div style="margin-top: 24px; border-top: 1px solid var(--admin-border); padding-top: 16px;">
                <h3 style="font-size: 1.05rem; margin-bottom: 12px; color: var(--admin-accent-teal);"><i class="fa-solid fa-language"></i> Descriptions (Multilingual)</h3>
                
                <div class="form-group">
                    <label for="desc_en">English Description</label>
                    <textarea name="desc_en" id="desc_en" class="form-control" required placeholder="Description in English..."><?php echo htmlspecialchars($desc_en); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="desc_sw">Swahili Description (Optional)</label>
                    <textarea name="desc_sw" id="desc_sw" class="form-control" placeholder="Maelezo kwa Kiswahili..."><?php echo htmlspecialchars($desc_sw); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="desc_de">German Description (Optional)</label>
                    <textarea name="desc_de" id="desc_de" class="form-control" placeholder="Beschreibung auf Deutsch..."><?php echo htmlspecialchars($desc_de); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="desc_it">Italian Description (Optional)</label>
                    <textarea name="desc_it" id="desc_it" class="form-control" placeholder="Descrizione in Italiano..."><?php echo htmlspecialchars($desc_it); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="desc_fr">French Description (Optional)</label>
                    <textarea name="desc_fr" id="desc_fr" class="form-control" placeholder="Description en Français..."><?php echo htmlspecialchars($desc_fr); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="desc_pl">Polish Description (Optional)</label>
                    <textarea name="desc_pl" id="desc_pl" class="form-control" placeholder="Opis po Polsku..."><?php echo htmlspecialchars($desc_pl); ?></textarea>
                </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" name="save_villa" class="btn btn-teal" style="flex-grow:1;">Save Accommodation</button>
                <?php if ($edit_id): ?>
                    <a href="hospitality.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

</div>

</main>
</body>
</html>
