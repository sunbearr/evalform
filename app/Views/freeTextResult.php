<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<main>
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Responses to "<?= esc($question['question_text']) ?>"</h2>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <?php foreach ($responses as $index => $response): ?>
                            <div class="card-body">
                                <h4 class="card-title">Response #<?= $index+1 ?></h4>
                                <p class="card-text"><?= esc($response['text']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

    
      <?= $this->endSection() ?>