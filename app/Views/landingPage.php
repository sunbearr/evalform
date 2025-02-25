<?= $this->extend('template') ?>
<?= $this->section('content') ?>

      <main>
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="display-4">Create, Share, and Analyse Your Own Custom Surveys.</h1>
                        <p class="lead">EvalForm makes creating your own online surveys a breeze. </p>
                        
                        <a href="<?= !session()->get('isLoggedIn') ? base_url("login") : base_url('surveys/' . session()->get('userId') . '/addeditSurvey') ?>" class="btn btn-primary btn-lg mb-3 mb-lg-0">Get Started</a>

                      
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
            <div class="col d-flex align-items-start px-3 mb-4">
                <div class="d-inline-flex align-items-center justify-content-center me-3">
                  <i class="bi bi-clipboard fs-4 text-body-emphasis"></i>
                </div>
                <div>
                  <h3 class="fs-2 text-body-emphasis">Create Surveys</h3>
                  <p>Create single page surveys with any combination of multiple choice and free text questions.</p>
                </div>
              </div>
              <div class="col d-flex align-items-start px-3 mb-4">
                <div class="d-inline-flex align-items-center justify-content-center me-3">
                  <i class="bi bi-qr-code fs-4 text-body-emphasis"></i>
                </div>
                <div>
                  <h3 class="fs-2 text-body-emphasis">Share</h3>
                  <p>Share your surveys using generated QR codes or by distributing the link.</p>
                </div>
              </div>
              <div class="col d-flex align-items-start px-3 mb-4">
                <div class="d-inline-flex align-items-center justify-content-center me-3">
                  <i class="bi bi-file-bar-graph fs-4 text-body-emphasis"></i>
                </div>
                <div>
                  <h3 class="fs-2 text-body-emphasis">Analyse the Results</h3>
                  <p>Analyse and interpret the results of your surveys with a variety of data visualizations.</p>
                </div>
              </div>
              <div class="col d-flex align-items-start px-3">
                <div class="d-inline-flex align-items-center justify-content-center me-3">
                  <i class="bi bi-robot fs-4 text-body-emphasis"></i>
                </div>
                <div>
                  <h3 class="fs-2 text-body-emphasis">AI Analysis</h3>
                  <p>AI will analyse the free-text responses to your survey questions and summarise the observed trends and themes of the responses to help your analysis.</p>
                </div>
              </div>
            </div>
        </section>    

      </main>
    
<?= $this->endSection() ?>