<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap ScratchPad</title>
    <!-- This is the main stylesheet for Bootstrap. It includes all the CSS necessary for Bootstrap's components and utilities to work. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Include Bootstrap Icons -->
    <!-- This link imports the Bootstrap Icons library, which provides a wide range of SVG icons for use in your projects. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  
<body>
    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
          <div class="col-md-3 mb-2 mb-md-0">
            <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
              <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
              <span class="fs-4">EvalForm</span>
            </a>
          </div>
    
          <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
          <?php if (session()->get('isLoggedIn')): ?>
            <li><a href=<?= base_url(); ?> class="nav-link px-2 link">Home</a></li>
            <li><a href=<?= base_url('surveys/' . session()->get('userId')); ?> class="nav-link px-2">Surveys</a></li> <!-- direct to current signed in user's surveys -->
            <li><a href="<?=base_url('surveys/' . session()->get('userId') . '/addeditSurvey') ?>" class="nav-link px-2">Create</a></li>
            
              <?php if (session()->get('isAdmin')): ?>
                <li><a href=<?= base_url('admin'); ?> class="nav-link px-2">Admin Panel</a></li>
            <?php endif; ?>
            <?php endif; ?>
          </ul>
    
          <?php if (!session()->get('isLoggedIn')): ?>
              <div class="col-md-3 text-end">
                  <a href="<?= base_url("login"); ?>" class="btn btn-outline-primary me-2">Login</a>
              </div>
          <?php else: ?>
              <div class="col-md-3 text-end">
                  <span class="me-2">
                      <i class="bi bi-person me-1"></i><?= session()->get('username') ?>
                  </span>
                  <a href="<?= base_url("logout"); ?>" class="btn btn-outline-primary">Logout</a>
              </div>
          <?php endif; ?>


        </header>
      </div>

      <main>
         <?= $this->renderSection('content') ?> <!-- Placeholder for page content -->
     </main>

      <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                <p>&copy; <?= date('Y') ?> EvalForm </p> 
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline mt-2">
                        <li class="list-inline-item">
                            <a href="https://github.com/sunbearr" class="text-light" target="_blank" rel="noopener noreferrer">
                              <i class="bi bi-github"></i>
                            </a>
                          </li>
                    </ul>
                </div>
            </div>
         </div>
        </footer>
<body>