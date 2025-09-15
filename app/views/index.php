<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Make pagination green */
    .pagination .page-link {
      color: #198754; /* Bootstrap green */
    }

    .pagination .page-link:hover {
      background-color: #198754;
      color: #fff;
    }

    .pagination .active .page-link {
      background-color: #198754;
      border-color: #198754;
      color: #fff;
    }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4 text-center">Student Records</h2>

  <!-- Error & Message Section -->
  <div class="mb-3">
    <?php getErrors(); ?>
    <?php getMessage(); ?>
  </div>

  <!-- Search + Add Student -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <form action="<?= site_url('/'); ?>" method="get" class="d-flex col-sm-5">
      <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
      <input 
        class="form-control me-2" 
        name="q" 
        type="text" 
        placeholder="Search" 
        value="<?= html_escape($q); ?>">
      <button type="submit" class="btn btn-success">Search</button>
    </form>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Student</button>
  </div>

  <!-- Student Table -->
  <div class="card shadow">
    <div class="card-body">
      <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($all)): ?>
            <?php foreach ($all as $student): ?>
              <tr>
                <td><?= htmlspecialchars($student['student_id']); ?></td>
                <td><?= htmlspecialchars($student['first_name']); ?></td>
                <td><?= htmlspecialchars($student['last_name']); ?></td>
                <td><?= htmlspecialchars($student['course']); ?></td>
                <td>
                  <span class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $student['id']; ?>">Edit</span>
                  <span class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $student['id']; ?>">Delete</span>
                </td>
              </tr>

              <!-- Edit Modal -->
              <div class="modal fade" id="editModal<?= $student['id']; ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="/update-user/<?= $student['id']; ?>" method="POST">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $student['id']; ?>">
                        <div class="mb-3">
                          <label class="form-label">Student ID</label>
                          <input type="text" name="student_id" class="form-control" value="<?= $student['student_id']; ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">First Name</label>
                          <input type="text" name="first_name" class="form-control" value="<?= $student['first_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Last Name</label>
                          <input type="text" name="last_name" class="form-control" value="<?= $student['last_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Course</label>
                          <input type="text" name="course" class="form-control" value="<?= $student['course']; ?>" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Delete Modal -->
              <div class="modal fade" id="deleteModal<?= $student['id']; ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="/delete-user/<?= $student['id']; ?>" method="POST">
                      <div class="modal-header">
                        <h5 class="modal-title">Delete Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure you want to delete <strong><?= $student['first_name'] . " " . $student['last_name']; ?></strong>?</p>
                        <input type="hidden" name="id" value="<?= $student['id']; ?>">
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No students found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="d-flex justify-content-center mt-3">
        <?= $page; ?>
      </div>
    </div>
  </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/create-user" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Student ID</label>
            <input type="text" name="student_id" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Course</label>
            <input type="text" name="course" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL; ?>/public/js/alert.js"></script>
</body>
</html>
