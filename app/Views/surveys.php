<?= $this->extend('template') ?>
<?= $this->section('content') ?>
  
      <main>
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="display-4"><?= esc($user['username']) ?>'s Surveys</h1>
                    </div>
                </div>
            </div>
        </section>

        <section>
        <?php foreach ($surveys as $survey): ?>
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-body">
                        <a href="#" class="text-decoration-none text-reset">
                            <h4 class="card-title"><?= esc($survey['title']) ?></h4>
                        </a>
                        
                        <p>
                        <?= esc($survey['description']) ?>
                        </p>
                        
                    </div>
                    <div class="position-absolute top-0 end-0 px-1">
                        <a href="<?= base_url('surveys/' . $survey['user_id'] . '/results/'.$survey['survey_id']);?>" class="me-4 text-info"><i class="bi bi-eye-fill" style="font-size:1.5rem;"></i></a>
                        <a class="me-4 text-dark copyBtn" data-url="<?= base_url('surveyResponse/' . esc($survey['survey_id'])) ?>"><i class="bi bi-clipboard" style="font-size:1.5rem;"></i></a>
                        <a class="me-4 text-dark qrBtn" data-url="<?= base_url('surveyResponse/' . esc($survey['survey_id'])) ?>" data-id="qrCode<?= $survey['survey_id'] ?>"><i class="bi bi-qr-code" style="font-size:1.5rem;"></i></a>
                        <a href="<?= base_url('surveys/' . $survey['user_id'] . '/addeditSurvey/' . $survey['survey_id']);?>" class="me-4 text-body-emphasis"><i class="bi bi-pencil-square" style="font-size:1.5rem;"></i></a>
                        <a href="<?= base_url('surveys/' . $survey['user_id'] . '/delete/' . $survey['survey_id']);?>" class="me-4 text-danger"><i class="bi bi-trash" style="font-size:1.5rem;"></i></a>
                        
                    </div>
                    <div id="qrCode<?= $survey['survey_id'] ?>" style="display: none;"></div>
                </div>
            </div>
        <?php endforeach; ?>

            <!-- Include jQuery (required for Bootstrap) -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <!-- Include Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
            <script>
                // javascript handling copying survey link to clipboard
                $(document).ready(function() {
                $(".copyBtn").click(function() {
                    var url = $(this).data('url');
                    navigator.clipboard.writeText(url).then(function() {
                    alert("URL copied to clipboard: " + url);
                    }, function(err) {
                    console.error('Could not copy text: ', err);
                    });
                });
                });
            </script>

            <script>
                // javascript handling downloading qrcodes for each survey link.
                   $(".qrBtn").click(function() {
                    var url = $(this).data('url');
                    var qrCode = new QRCode(document.getElementById($(this).data('id')), {
                        text: url,
                        width: 1000,
                        height: 1000,
                        correctLevel: QRCode.CorrectLevel.H
                    });
                    var canvas = document.getElementById($(this).data('id')).querySelector('canvas');
                    if(canvas){
                        var qrCodeURL = canvas.toDataURL('image/png');
                        var a = document.createElement('a');
                        a.href = qrCodeURL;
                        a.download = 'qrcode.png';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    } else {
                        console.error('Canvas element not found');
                    }
                });
            </script>

        </section>    

      </main>
 
<?= $this->endSection() ?>