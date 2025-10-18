<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Account Banned Notice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .modal-content {
      text-align: center;
      padding: 2rem;
    }
    .warning-img {
      width: 100px;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

  <!-- Modal -->
  <div class="modal show d-block" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Account Banned</h5>
        </div>
        <div class="modal-body">
          <img src="https://cdn-icons-png.flaticon.com/512/463/463612.png" alt="Warning" class="warning-img">
          <p class="fs-5 text-danger fw-bold">Your account has been permanently banned due to violations of our website policies.</p>
          <p class="text-muted">If you believe this was a mistake, please contact our support team for further assistance.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" onclick="window.location.href='/'">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>