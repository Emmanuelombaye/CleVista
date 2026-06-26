<?php
/**
 * CleVista Group Limited - Estates CRUD Listing Manager
 * Provides direct database additions, edits, deletions, and photo file uploads.
 */
include_once __DIR__ . '/includes/header.php';

$success_msg = null;
$error_msg = null;

// Initialize form variables (for add/edit states)
$edit_id = null;
$title = '';
$type = 'Land';
$status = 'For Sale';
$price = '';
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
        $stmt = $pdo->prepare("SELECT image_url FROM properties WHERE id = ?");
        $stmt->execute([$delete_id]);
        $old_img = $stmt->fetchColumn();
        if ($old_img && file_exists('../uploads/' . $old_img)) {
            unlink('../uploads/' . $old_img);
        }
        
        $stmt = $pdo->prepare("DELETE FROM properties WHERE id = ?");
        $stmt->execute([$delete_id]);
        $success_msg = "Property listing deleted successfully.";
        
        // Invalidate Redis Cache
        require_once __DIR__ . '/../includes/redis.php';
        redis_set('featured_properties', null);
    } catch (PDOException $e) {
        $error_msg = "Error deleting record: " . $e->getMessage();
    }
}

// 2. Fetch specific listing for Editing
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM properties WHERE id = ?");
        $stmt->execute([$edit_id]);
        $prop = $stmt->fetch();
        if ($prop) {
            $title = $prop['title'];
            $type = $prop['type'];
            $status = $prop['status'];
            $price = $prop['price'];
            $location = $prop['location'];
            $features = $prop['features'];
            $desc_en = $prop['description_en'];
            $desc_sw = $prop['description_sw'];
            $desc_de = $prop['description_de'];
            $desc_it = $prop['description_it'];
            $desc_fr = $prop['description_fr'];
            $desc_pl = $prop['description_pl'];
            $existing_image = $prop['image_url'];
        }
    } catch (PDOException $e) {
        $error_msg = "Error fetching record: " . $e->getMessage();
    }
}

// 3. Handle Form Add/Update Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_property'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $type = $_POST['type'];
    $status = $_POST['status'];
    $price = htmlspecialchars(trim($_POST['price']));
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
    if (isset($_FILES['property_image']) && $_FILES['property_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['property_image']['tmp_name'];
        $file_name = $_FILES['property_image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($file_ext, $allowed_exts)) {
            // Ensure uploads directory exists
            if (!file_exists('../uploads')) {
                mkdir('../uploads', 0777, true);
            }
            
            // Unique filename to prevent overwriting
            $image_filename = 'prop_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
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
                $stmt = $pdo->prepare("UPDATE properties SET title = ?, type = ?, status = ?, price = ?, location = ?, description_en = ?, description_sw = ?, description_de = ?, description_it = ?, description_fr = ?, description_pl = ?, features = ?, image_url = ? WHERE id = ?");
                $stmt->execute([$title, $type, $status, $price, $location, $desc_en, $desc_sw, $desc_de, $desc_it, $desc_fr, $desc_pl, $features, $image_filename, $update_id]);
                $success_msg = "Property listing updated successfully.";
            } else {
                // Insert query
                $stmt = $pdo->prepare("INSERT INTO properties (title, type, status, price, location, description_en, description_sw, description_de, description_it, description_fr, description_pl, features, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $type, $status, $price, $location, $desc_en, $desc_sw, $desc_de, $desc_it, $desc_fr, $desc_pl, $features, $image_filename]);
                $success_msg = "New property listing added successfully.";
            }
            
            // Invalidate Redis Cache
            require_once __DIR__ . '/../includes/redis.php';
            redis_set('featured_properties', null);
            
            // Clear form parameters and redirect
            header("Location: estates.php?success=" . urlencode($success_msg));
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
$properties = [];
try {
    $properties = $pdo->query("SELECT * FROM properties ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    $error_msg = "Could not fetch properties list: " . $e->getMessage();
}
?>

<div class="admin-header">
    <div>
        <h1>Manage Properties</h1>
        <p style="color: var(--admin-text-muted);">View, create, and edit real estate listings</p>
    </div>
</div>

<?php if ($success_msg): ?>
    <div class="alert alert-success" style="border-radius: 6px; margin-bottom: 24px;"><?php echo $success_msg; ?></div>
<?php endif; ?>
<?php if ($error_msg): ?>
    <div class="alert alert-error" style="border-radius: 6px; margin-bottom: 24px;"><?php echo $error_msg; ?></div>
<?php endif; ?>

<div class="admin-form-grid" style="grid-template-columns: 1.2fr 0.8fr; align-items: start; gap: 32px;">
    
    <!-- Properties List Grid -->
    <div class="admin-card-panel" style="margin-bottom: 0;">
        <h2>Active Listings</h2>
        <div class="admin-table-container" style="margin-top: 20px;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title / Location</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($properties)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--admin-text-muted);">No property listings found. Create your first property on the right!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($properties as $prop): ?>
                            <tr>
                                <td>
                                    <?php 
                                    $img_src = 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=150&q=80';
                                    if (!empty($prop['image_url'])) {
                                        $img_src = '../uploads/' . $prop['image_url'];
                                    }
                                    ?>
                                    <img src="<?php echo $img_src; ?>" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid var(--admin-border);">
                                </td>
                                <td>
                                    <div style="font-weight: 600;"><?php echo htmlspecialchars($prop['title']); ?></div>
                                    <div style="font-size: 0.75rem; color: var(--admin-text-muted);"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($prop['location']); ?></div>
                                </td>
                                <td><span class="badge badge-gold" style="font-size: 0.7rem;"><?php echo $prop['type']; ?></span></td>
                                <td><span style="font-size: 0.85rem; font-weight:500;"><?php echo $prop['status']; ?></span></td>
                                <td style="font-family: 'Outfit'; font-weight:600; color: var(--admin-accent);"><?php echo htmlspecialchars($prop['price']); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="estates.php?edit=<?php echo $prop['id']; ?>" class="action-btn"><i class="fa-solid fa-pen"></i> Edit</a>
                                        <a href="estates.php?delete=<?php echo $prop['id']; ?>" class="action-btn action-btn-danger" onclick="return confirm('Are you sure you want to delete this listing?');"><i class="fa-solid fa-trash"></i> Delete</a>
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
        <h2><?php echo $edit_id ? 'Edit Property Listing' : 'Add New Property'; ?></h2>
        
        <form action="estates.php" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
            <?php if ($edit_id): ?>
                <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="title">Listing Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required placeholder="e.g. Diani Luxury Plot">
            </div>
            
            <div class="admin-form-grid" style="grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="type">Listing Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="Land" <?php echo ($type == 'Land') ? 'selected' : ''; ?>>Land / Plot</option>
                        <option value="Property" <?php echo ($type == 'Property') ? 'selected' : ''; ?>>Property / House</option>
                        <option value="Development" <?php echo ($type == 'Development') ? 'selected' : ''; ?>>Development Project</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="For Sale" <?php echo ($status == 'For Sale') ? 'selected' : ''; ?>>For Sale</option>
                        <option value="For Rent" <?php echo ($status == 'For Rent') ? 'selected' : ''; ?>>For Rent</option>
                        <option value="Invested" <?php echo ($status == 'Invested') ? 'selected' : ''; ?>>Invested</option>
                    </select>
                </div>
            </div>

            <div class="admin-form-grid" style="grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="price">Price Label</label>
                    <input type="text" name="price" id="price" class="form-control" value="<?php echo htmlspecialchars($price); ?>" required placeholder="e.g. KSh 12,000,000">
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" value="<?php echo htmlspecialchars($location); ?>" required placeholder="e.g. Diani Beach">
                </div>
            </div>

            <div class="form-group">
                <label for="features">Features (Comma separated)</label>
                <input type="text" name="features" id="features" class="form-control" value="<?php echo htmlspecialchars($features); ?>" placeholder="e.g. Beachfront, Ocean View, Gated">
            </div>

            <div class="form-group">
                <label for="property_image">Listing Image Photo</label>
                <input type="file" name="property_image" id="property_image" class="form-control" style="padding: 8px;">
                <?php if ($existing_image): ?>
                    <p style="font-size:0.75rem; margin-top: 4px; color: var(--admin-text-muted);">Current: <em><?php echo $existing_image; ?></em></p>
                <?php endif; ?>
            </div>

            <!-- Description Translators (6 Tabs/Fields) -->
            <div style="margin-top: 24px; border-top: 1px solid var(--admin-border); padding-top: 16px;">
                <h3 style="font-size: 1.05rem; margin-bottom: 12px; color: var(--admin-accent);"><i class="fa-solid fa-language"></i> Descriptions (Multilingual)</h3>
                
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
                <button type="submit" name="save_property" class="btn btn-primary" style="flex-grow:1;">Save Property Listing</button>
                <?php if ($edit_id): ?>
                    <a href="estates.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

</div>

</main>
</body>
</html>
